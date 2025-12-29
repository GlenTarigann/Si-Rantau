<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Ibadah;
use Carbon\Carbon;

class IbadahController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $userId = Auth::id() ?? 2; 
        $userAgama = Auth::check() ? Auth::user()->agama : 'Kristen';
        $today = date('Y-m-d');
        $currentDayName = date('l'); 

        $this->generateTasks($userId, $today, $currentDayName);

        $cacheKey = "spiritual_data_{$userId}_{$today}";
        $dataSpiritual = Cache::remember($cacheKey, 720, function () use ($userAgama) {
            if ($userAgama == 'Islam') {
                try {
                    $year = date('Y'); $month = date('m'); $day = date('d');
                    $response = Http::timeout(5)->get("https://api.myquran.com/v2/sholat/jadwal/1219/{$year}/{$month}/{$day}");
                    return $response->successful() ? ['type' => 'muslim', 'jadwal' => $response->json()['data']['jadwal']] : null;
                } catch (\Exception $e) { return null; }
            } else {
                try {
                    $url = "https://api-alkitab.vercel.app/api/passage?passage=Yohanes&num=1";
                    $response = Http::timeout(5)->get($url);
                    if ($response->successful()) {
                        $hasil = $response->json();
                        return [
                            'type' => 'kristen', 
                            'ayat' => [
                                'content' => $hasil['verses'][0]['content'], 
                                'book' => ['name' => $hasil['book']['name']], 
                                'chapter' => $hasil['chapter'], 
                                'verses' => [['verse' => 1]]
                            ]
                        ];
                    }
                } catch (\Exception $e) { return null; }
            }
            return null;
        });

        if (!$dataSpiritual) {
            $dataSpiritual = $userAgama == 'Islam' 
                ? ['type' => 'muslim', 'jadwal' => array_fill_keys(['subuh','dzuhur','ashar','maghrib','isya'], '-')] 
                : ['type' => 'kristen', 'ayat' => ['content' => 'Tuhan adalah gembalaku.', 'book' => ['name' => 'Mazmur'], 'chapter' => 23, 'verses' => [['verse' => 1]]]];
        }

        $dataIbadah = Ibadah::where('user_id', $userId)->orderBy('date', 'desc')->take(100)->get();
        return view('spiritual.index', compact('dataIbadah', 'dataSpiritual', 'userAgama'));
    }

    private function generateTasks($userId, $today, $currentDayName)
    {
        $tasks = Ibadah::where('user_id', $userId)->whereIn('frequency', ['setiap hari', 'hanya sekali', 'mingguan'])->get()->unique('prayer_name');
        foreach($tasks as $task) {
            $taskDayName = Carbon::parse($task->date)->format('l');
            if ($task->frequency == 'setiap hari' || ($task->frequency == 'mingguan' && $taskDayName == $currentDayName)) {
                $exists = Ibadah::where('user_id', $userId)->where('prayer_name', $task->prayer_name)->where('date', $today)->exists();
                if (!$exists) {
                    $this->createTask($userId, $task, $today, $task->frequency);
                }
            }
        }
    }

    private function createTask($userId, $task, $date, $freq)
    {
        Ibadah::create([
            'user_id' => $userId, 'prayer_name' => $task->prayer_name, 'date' => $date, 'time' => $task->time,
            'kategori' => $task->kategori, 'target_count' => $task->target_count, 'target_unit' => $task->target_unit,
            'notes' => $task->notes, 'status' => 'pending', 'frequency' => $freq
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::id() ?? 2;
        $cekDuplikat = Ibadah::where('user_id', $userId)->where('prayer_name', $request->prayer_name)->where('date', $request->date)->first();
        if ($cekDuplikat) return redirect()->back()->with('error', 'Kegiatan sudah tercatat!');

        Ibadah::create(array_merge($request->all(), ['user_id' => $userId, 'status' => 'pending']));
        return redirect()->back()->with('success', 'Target berhasil dicatat!');
    }

    public function update(Request $request, $id)
    {
        $ibadah = Ibadah::findOrFail($id);
        $ibadah->update($request->has('status') && !$request->has('prayer_name') ? ['status' => $request->status] : $request->all());
        return redirect()->back()->with('success', 'Data diperbarui!');
    }

    public function destroy($id)
    {
        Ibadah::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Catatan dihapus.');
    }

    public function cetakPdf()
    {
        $userId = Auth::id() ?? 2;
        $dataIbadah = Ibadah::where('user_id', $userId)->orderBy('date', 'desc')->get();
        return view('spiritual.cetak_pdf', compact('dataIbadah'));
    }
}