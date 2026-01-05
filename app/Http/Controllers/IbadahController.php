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
        
        $userId = Auth::id(); 
        $user = Auth::user();
        
        $showModalAgama = !$user->agama;
        
        $userAgama = $user->agama;
        $today = date('Y-m-d');
        $currentDayName = date('l'); 

        $this->generateTasks($userId, $today, $currentDayName);

        $cacheKey = "spiritual_data_{$userId}_{$today}";
        $dataSpiritual = Cache::remember($cacheKey, 720, function () use ($userAgama) {
            if (strcasecmp($userAgama, 'Islam') === 0) {
                try {
                    $year = date('Y'); 
                    $month = date('m'); 
                    $day = date('d');
                   $response = Http::withoutVerifying()->timeout(10)->get("https://api.myquran.com/v2/sholat/jadwal/1219/{$year}/{$month}/{$day}");
                    
                    return $response->successful() 
                        ? ['type' => 'muslim', 'jadwal' => $response->json()['data']['jadwal']] 
                        : null;
                } catch (\Exception $e) { 
                    return null; 
                }
            } else {
                try {
                    $url = "https://api-alkitab.vercel.app/api/passage?passage=Yohanes&num=1";
                    $response = $response = Http::withoutVerifying()->timeout(10)->get($url);
                    
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
                } catch (\Exception $e) { 
                    return null; 
                }
            }
            return null;
        });

        if (!$dataSpiritual) {
            $dataSpiritual = strcasecmp($userAgama, 'Islam') === 0
                ? ['type' => 'muslim', 'jadwal' => array_fill_keys(['subuh','dzuhur','ashar','maghrib','isya'], '-')] 
                : ['type' => 'kristen', 'ayat' => ['content' => 'Tuhan adalah gembalaku.', 'book' => ['name' => 'Mazmur'], 'chapter' => 23, 'verses' => [['verse' => 1]]]];
        }

        $dataIbadah = Ibadah::where('user_id', $userId)->orderBy('date', 'desc')->take(100)->get();
        
        return view('spiritual.index', compact('dataIbadah', 'dataSpiritual', 'userAgama', 'showModalAgama'));
    }

    public function setAgama(Request $request)
    {
        $request->validate([
            'agama' => 'required|in:Islam,Kristen'
        ]);

        $user = Auth::user();
        $user->agama = $request->agama;
        $user->save();

        Cache::forget("spiritual_data_{$user->id}_" . date('Y-m-d'));

        return redirect()->route('spiritual.index')->with('success', 'Pengaturan agama berhasil disimpan!');
    }

    public function simpanAgama(Request $request)
    {
        return $this->setAgama($request);
    }

    private function generateTasks($userId, $today, $currentDayName)
    {
        $tasks = Ibadah::where('user_id', $userId)
            ->whereIn('frequency', ['setiap hari', 'hanya sekali', 'mingguan'])
            ->get()
            ->unique('prayer_name');
            
        foreach($tasks as $task) {
            $taskDayName = Carbon::parse($task->date)->format('l');
            if ($task->frequency == 'setiap hari' || ($task->frequency == 'mingguan' && $taskDayName == $currentDayName)) {
                $exists = Ibadah::where('user_id', $userId)
                    ->where('prayer_name', $task->prayer_name)
                    ->where('date', $today)
                    ->exists();
                    
                if (!$exists) {
                    $this->createTask($userId, $task, $today, $task->frequency);
                }
            }
        }
    }

    private function createTask($userId, $task, $date, $freq)
    {
        Ibadah::create([
            'user_id' => $userId, 
            'prayer_name' => $task->prayer_name, 
            'date' => $date, 
            'time' => $task->time,
            'kategori' => $task->kategori, 
            'target_count' => $task->target_count, 
            'target_unit' => $task->target_unit,
            'notes' => $task->notes, 
            'status' => 'pending', 
            'frequency' => $freq
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prayer_name' => 'required|string|max:100|min:3',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'kategori' => 'required|in:wajib,sunnah,lainnya',
            'frequency' => 'required|in:setiap hari,hanya sekali,mingguan',
            'target_count' => 'nullable|integer|min:1|max:1000',
            'target_unit' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500'
        ], [
            'prayer_name.required' => 'Nama kegiatan wajib diisi',
            'prayer_name.min' => 'Nama kegiatan minimal 3 karakter',
            'prayer_name.max' => 'Nama kegiatan maksimal 100 karakter',
            'date.required' => 'Tanggal wajib diisi',
            'date.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini',
            'time.required' => 'Waktu wajib diisi',
            'time.date_format' => 'Format waktu tidak valid',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori tidak valid',
            'frequency.required' => 'Frekuensi wajib dipilih',
            'target_count.integer' => 'Target harus berupa angka',
            'target_count.min' => 'Target minimal 1',
            'target_count.max' => 'Target maksimal 1000',
            'target_unit.max' => 'Satuan maksimal 50 karakter',
            'notes.max' => 'Catatan maksimal 500 karakter'
        ]);

        $userId = Auth::id() ?? 2;
        
        $cekDuplikat = Ibadah::where('user_id', $userId)
            ->where('prayer_name', $validated['prayer_name'])
            ->where('date', $validated['date'])
            ->first();
            
        if ($cekDuplikat) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kegiatan sudah tercatat pada tanggal tersebut!');
        }

        Ibadah::create(array_merge($validated, [
            'user_id' => $userId, 
            'status' => 'pending'
        ]));
        
        return redirect()->back()->with('success', 'Target berhasil dicatat!');
    }

    public function update(Request $request, $id)
    {
        $ibadah = Ibadah::findOrFail($id);
        
        if ($request->has('status') && !$request->has('prayer_name')) {
            $request->validate([
                'status' => 'required|in:pending,terlaksana'
            ]);
            
            $ibadah->update(['status' => $request->status]);
            return redirect()->back()->with('success', 'Status berhasil diperbarui!');
        }
        
        $validated = $request->validate([
            'prayer_name' => 'required|string|max:100|min:3',
            'target_count' => 'nullable|integer|min:1|max:1000',
            'target_unit' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500'
        ], [
            'prayer_name.required' => 'Nama kegiatan wajib diisi',
            'prayer_name.min' => 'Nama kegiatan minimal 3 karakter',
            'prayer_name.max' => 'Nama kegiatan maksimal 100 karakter',
            'target_count.integer' => 'Target harus berupa angka',
            'target_count.min' => 'Target minimal 1',
            'target_count.max' => 'Target maksimal 1000',
            'target_unit.max' => 'Satuan maksimal 50 karakter',
            'notes.max' => 'Catatan maksimal 500 karakter'
        ]);
        
        $ibadah->update($validated);
        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Ibadah::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Catatan dihapus.');
    }

    public function cetakPdf()
    {
        $userId = Auth::id() ?? 2;
        $dataIbadah = Ibadah::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();
            
        return view('spiritual.cetak_pdf', compact('dataIbadah'));
    }
}