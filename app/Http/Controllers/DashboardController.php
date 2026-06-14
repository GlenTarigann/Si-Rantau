<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\AgendaOutdoor;
use App\Models\Meal;
use App\Models\Tugas;
use App\Models\Ibadah;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $userId = $user->id;
        $userId = Auth::id();
        $user = Auth::user();
        $today = date('Y-m-d');
        $userAgama = $user->agama;

        $currentWeather = $this->getCuacaSaatIni('32.73.02.1005');

        $agendas = [];
        try {
            $agendas = AgendaOutdoor::where('user_id', $userId)
                ->where('waktu_mulai', '>=', now())
                ->orderBy('waktu_mulai', 'asc')->take(5)->get();
        } catch (\Exception $e) {
        }

        $today = Carbon::now()->format('Y-m-d');
        $meals = \App\Models\Meal::where('user_id', $userId)
            ->orderBy('planned_date', 'asc')
            ->take(5)
            ->get();

        $today = date('Y-m-d');

        $tasks = Tugas::where('user_id', $userId)->get();

        $cacheKey = "spiritual_data_{$userId}_{$today}";
        $dataSpiritual = Cache::remember($cacheKey, 720, function () use ($userAgama) {
            if (strcasecmp($userAgama, 'Islam') === 0) {
                try {
                    $response = Http::withoutVerifying()->timeout(10)->get("https://api.myquran.com/v2/sholat/jadwal/1219/" . date('Y/m/d'));
                    return $response->successful() ? ['type' => 'muslim', 'jadwal' => $response->json()['data']['jadwal']] : null;
                } catch (\Exception $e) {
                    return null;
                }
            } else {
                // LOGIKA UNTUK KRISTEN
                try {
                    $url = "https://api-alkitab.vercel.app/api/passage?passage=Yohanes&num=1";
                    $response = Http::withoutVerifying()->timeout(10)->get($url);
                    if ($response->successful()) {
                        $hasil = $response->json();
                        return [
                            'type' => 'kristen',
                            'ayat' => [
                                'content' => $hasil['verses'][0]['content'],
                                'book' => $hasil['book']['name'],
                                'chapter' => $hasil['chapter']
                            ]
                        ];
                    }
                } catch (\Exception $e) {
                    return null;
                }
            }
            return null;
        });

        // Tampilkan 5 target ibadah terbaru (hari ini + mendatang),
        // jika tidak ada hari ini, tampilkan dari semua yang ada
        $AktivitasIbadah = Ibadah::where('user_id', $userId)
            ->where('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->take(5)
            ->get();

        // Jika kurang dari 5, tambah dari data lampau
        if ($AktivitasIbadah->count() < 5) {
            $extra = Ibadah::where('user_id', $userId)
                ->where('date', '<', $today)
                ->orderBy('date', 'desc')
                ->orderBy('time', 'asc')
                ->take(5 - $AktivitasIbadah->count())
                ->get();
            $AktivitasIbadah = $AktivitasIbadah->merge($extra);
        }

        return view('dashboard', compact('agendas', 'meals', 'tasks', 'dataSpiritual', 'AktivitasIbadah', 'currentWeather'));
    }

    private function getCuacaSaatIni($kodeWilayah)
    {
        try {
            $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$kodeWilayah}";
            $response = Http::withOptions(['verify' => false])->get($url);
            $data = $response->json();

            if (!isset($data['data'][0]['cuaca'])) return null;

            $listCuaca = $data['data'][0]['cuaca'];
            $now = Carbon::now('Asia/Jakarta');

            $closestData = null;
            $minDiff = 999999;

            foreach ($listCuaca as $hari) {
                foreach ($hari as $item) {
                    if (isset($item['local_datetime'])) {
                        $cuacaTime = Carbon::parse($item['local_datetime'], 'Asia/Jakarta');
                        $diff = abs($now->diffInMinutes($cuacaTime));

                        if ($diff < $minDiff) {
                            $minDiff = $diff;
                            $closestData = $item;
                        }
                    }
                }
            }
            return $closestData;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getJadwalSpiritual($userId, $userAgama, $today)
    {
        $cacheKey = "spiritual_data_{$userId}_{$today}";
        return Cache::remember($cacheKey, 720, function () use ($userAgama) {
            if (strcasecmp($userAgama, 'Islam') === 0) {
                try {
                    $year = date('Y');
                    $month = date('m');
                    $day = date('d');
                    $response = Http::withoutVerifying()->timeout(10)->get("https://api.myquran.com/v2/sholat/jadwal/1219/{$year}/{$month}/{$day}");
                    return $response->successful() ? ['type' => 'muslim', 'jadwal' => $response->json()['data']['jadwal']] : null;
                } catch (\Exception $e) {
                    return null;
                }
            } else {
                // Logika Kristen sesuai IbadahController Anda
                try {
                    $response = Http::withoutVerifying()->timeout(10)->get("https://api-alkitab.vercel.app/api/passage?passage=Yohanes&num=1");
                    if ($response->successful()) {
                        $hasil = $response->json();
                        return ['type' => 'kristen', 'ayat' => [
                            'content' => $hasil['verses'][0]['content'],
                            'book' => ['name' => $hasil['book']['name']],
                            'chapter' => $hasil['chapter'],
                            'verses' => [['verse' => 1]]
                        ]];
                    }
                } catch (\Exception $e) {
                    return null;
                }
            }
            return null;
        });
    }
}
