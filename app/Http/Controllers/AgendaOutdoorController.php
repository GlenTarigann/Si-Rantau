<?php

namespace App\Http\Controllers;

use App\Models\AgendaOutdoor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AgendaOutdoorController extends Controller
{
    // ====================================================================
    // BASE URL untuk API Wilayah Indonesia (emsifa – data Kemendagri)
    // ====================================================================
    private const WILAYAH_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    // ====================================================================
    // Build kode adm4 BMKG dari kecamatan emsifa ID + kabupaten ID
    //
    // Penjelasan konversi:
    //   emsifa kecamatan ID: "3273020"  (7 digit: prov[2]+kab[2]+kec[3])
    //   BMKG adm3: "32.73.02"           (6 digit dengan titik: prov.kab.kec)
    //   Kecamatan digit ke-5 & ke-6 dari ID = kode kecamatan BMKG (2 digit)
    //
    //   Kota (urban):    kode kab bagian kedua >= 71  → suffix "1001"
    //   Kabupaten (rural): kode kab bagian kedua < 71 → suffix "2001"
    //
    // Contoh:
    //   kecId=3273020, kabId=3273 → kabCode=73 (>=71) → "32.73.02.1001" ✓
    //   kecId=3204170, kabId=3204 → kabCode=4  (<71)  → "32.04.17.2001" ✓
    // ====================================================================
    private function buildProbeAdm4(string $kecId, string $kabId): string
    {
        $kecId = str_pad($kecId, 7, '0', STR_PAD_LEFT);
        $kabId = str_pad($kabId, 4, '0', STR_PAD_LEFT);

        // Bangun adm3 dari 6 digit pertama kecamatan ID
        $adm3 = sprintf('%s.%s.%s',
            substr($kecId, 0, 2),
            substr($kecId, 2, 2),
            substr($kecId, 4, 2)
        );

        // Deteksi Kota (kode >= 71) vs Kabupaten (kode < 71)
        $kabCode = (int) substr($kabId, 2, 2);
        $suffix  = $kabCode >= 71 ? '1001' : '2001';

        return "{$adm3}.{$suffix}";
    }

    // ====================================================================
    // AJAX – Daftar Provinsi
    // GET /wilayah/provinsi
    // ====================================================================
    public function getProvinsi()
    {
        try {
            $resp = Http::withOptions(['verify' => false])
                        ->timeout(10)
                        ->get(self::WILAYAH_BASE . '/provinces.json');
            return response()->json($resp->json());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Wilayah API provinsi: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data provinsi'], 500);
        }
    }

    // ====================================================================
    // AJAX – Daftar Kabupaten/Kota
    // GET /wilayah/kabupaten/{prov}
    // ====================================================================
    public function getKabupaten($provId)
    {
        try {
            $resp = Http::withOptions(['verify' => false])
                        ->timeout(10)
                        ->get(self::WILAYAH_BASE . "/regencies/{$provId}.json");
            return response()->json($resp->json());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Wilayah API kabupaten: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data kabupaten'], 500);
        }
    }

    // ====================================================================
    // AJAX – Daftar Kecamatan
    // GET /wilayah/kecamatan/{kab}
    // ====================================================================
    public function getKecamatan($kabId)
    {
        try {
            $resp = Http::withOptions(['verify' => false])
                        ->timeout(10)
                        ->get(self::WILAYAH_BASE . "/districts/{$kabId}.json");
            return response()->json($resp->json());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Wilayah API kecamatan: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data kecamatan'], 500);
        }
    }

    // ====================================================================
    // AJAX – Daftar Kelurahan/Desa
    // GET /wilayah/kelurahan/{kec}
    // ====================================================================
    public function getKelurahan($kecId)
    {
        try {
            $resp = Http::withOptions(['verify' => false])
                        ->timeout(10)
                        ->get(self::WILAYAH_BASE . "/villages/{$kecId}.json");
            return response()->json($resp->json());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Wilayah API kelurahan: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data kelurahan'], 500);
        }
    }

    // ====================================================================
    // INDEX
    // ====================================================================
    public function index()
    {
        $agendas = AgendaOutdoor::where('user_id', Auth::id())
                    ->orderBy('waktu_mulai', 'asc')
                    ->get();

        $currentWeather = $this->getCuacaSaatIni('32.73.02.1001');

        return view('agenda.index', compact('agendas', 'currentWeather'));
    }

    // ====================================================================
    // STORE
    // ====================================================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'kec_id'        => 'required|string',   // emsifa kecamatan ID
            'kab_id'        => 'required|string',   // emsifa kabupaten ID
            'lokasi_label'  => 'required|string|max:500',
            'waktu_mulai'   => 'required|date',
        ]);

        // Build kode adm4 BMKG dari kecamatan + kabupaten (lebih reliable dari konversi kelurahan)
        $adm4 = $this->buildProbeAdm4($validated['kec_id'], $validated['kab_id']);

        // Ambil prediksi cuaca
        $hasilCuaca = $this->getCuacaByAdm4($adm4, $validated['waktu_mulai']);

        AgendaOutdoor::create([
            'user_id'         => Auth::id(),
            'nama_kegiatan'   => $validated['nama_kegiatan'],
            'lokasi_kota'     => $validated['lokasi_label'],
            'waktu_mulai'     => $validated['waktu_mulai'],
            'prediksi_cuaca'  => $hasilCuaca,
            'status_kegiatan' => 'Scheduled',
        ]);

        $isBadWeather = str_contains(strtolower($hasilCuaca), 'hujan') ||
                        str_contains(strtolower($hasilCuaca), 'petir');

        if ($isBadWeather) {
            return redirect()->route('agenda.index')
                ->with('warning', "Rencana disimpan. ⚠️ Cuaca diprediksi '$hasilCuaca'. Siapkan payung!");
        }

        return redirect()->route('agenda.index')
            ->with('success', "Rencana berhasil disimpan! Cuaca: $hasilCuaca.");
    }

    // ====================================================================
    // EDIT
    // ====================================================================
    public function edit($id)
    {
        $agendaEdit = AgendaOutdoor::where('user_id', Auth::id())->findOrFail($id);
        $agendas    = AgendaOutdoor::where('user_id', Auth::id())->orderBy('waktu_mulai', 'asc')->get();
        return view('agenda.edit', compact('agendaEdit', 'agendas'));
    }

    // ====================================================================
    // UPDATE
    // ====================================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'lokasi_kota'   => 'required|string',
            'waktu_mulai'   => 'required|date',
        ]);

        // Cek apakah update menggunakan sistem baru (kec_id) atau lama
        if ($request->filled('kec_id') && $request->filled('kab_id')) {
            $adm4       = $this->buildProbeAdm4($request->kec_id, $request->kab_id);
            $lokasiLabel = $request->filled('lokasi_label') ? $request->lokasi_label : $request->lokasi_kota;
        } else {
            // Backward compat: gunakan kode lama hardcoded
            $adm4       = $this->legacyKotaToAdm4($request->lokasi_kota);
            $lokasiLabel = $request->lokasi_kota;
        }

        $hasilCuaca = $this->getCuacaByAdm4($adm4, $request->waktu_mulai);

        $agenda = AgendaOutdoor::where('user_id', Auth::id())->findOrFail($id);
        $agenda->update([
            'nama_kegiatan'  => $request->nama_kegiatan,
            'lokasi_kota'    => $lokasiLabel,
            'waktu_mulai'    => $request->waktu_mulai,
            'prediksi_cuaca' => $hasilCuaca,
        ]);

        $isBadWeather = str_contains(strtolower($hasilCuaca), 'hujan') ||
                        str_contains(strtolower($hasilCuaca), 'petir');

        if ($isBadWeather) {
            return redirect()->route('agenda.index')
                ->with('warning', "Update berhasil. ⚠️ Waspada cuaca '$hasilCuaca'!");
        }

        return redirect()->route('agenda.index')->with('success', 'Update berhasil.');
    }

    // ====================================================================
    // DESTROY
    // ====================================================================
    public function destroy($id)
    {
        AgendaOutdoor::where('user_id', Auth::id())->findOrFail($id)->delete();
        return redirect()->route('agenda.index')->with('success', 'Rencana dihapus.');
    }

    // ====================================================================
    // CETAK PDF
    // ====================================================================
    public function cetakPdf()
    {
        $agendas = AgendaOutdoor::where('user_id', Auth::id())
                    ->orderBy('waktu_mulai', 'asc')
                    ->get();

        $pdf = Pdf::loadView('agenda.cetak_pdf', compact('agendas'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Itinerary_Kegiatan_Outdoor.pdf');
    }

    // ====================================================================
    // SHOW (redirect)
    // ====================================================================
    public function show($id)
    {
        return redirect()->route('agenda.index');
    }

    // ====================================================================
    // PRIVATE – Ambil cuaca berdasarkan kode adm4 BMKG
    // ====================================================================
    private function getCuacaByAdm4(string $adm4, string $waktuInput): string
    {
        // Validasi format adm4 sebelum memanggil API
        if (empty($adm4) || !preg_match('/^\d{2}\.\d{2}\.\d{2}\.\d{4}$/', $adm4)) {
            \Illuminate\Support\Facades\Log::warning("Invalid adm4 format: {$adm4}");
            return 'Lokasi Tidak Valid';
        }

        try {
            $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4}";
            \Illuminate\Support\Facades\Log::info("BMKG Request: {$url}");

            $response = Http::withOptions(['verify' => false])
                            ->timeout(15)
                            ->get($url);

            if ($response->status() === 404) {
                // Coba suffix alternatif: kalau 1001 gagal coba 2001, dan sebaliknya
                $alt = str_replace('.1001', '.2001', $adm4);
                if ($alt === $adm4) {
                    $alt = str_replace('.2001', '.1001', $adm4);
                }

                \Illuminate\Support\Facades\Log::info("BMKG 404, retrying with: {$alt}");
                $response = Http::withOptions(['verify' => false])
                                ->timeout(15)
                                ->get("https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$alt}");
            }

            if ($response->failed()) {
                return "Cuaca Tidak Tersedia ({$response->status()})";
            }

            $data = $response->json();

            if (!isset($data['data'][0]['cuaca'])) {
                return 'Data Cuaca Kosong';
            }

            return $this->findClosestWeather($data['data'][0]['cuaca'], $waktuInput);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            \Illuminate\Support\Facades\Log::error("BMKG ConnectionException: " . $e->getMessage());
            return 'Timeout – Cek Koneksi';
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("BMKG Error: " . $e->getMessage());
            return 'Gangguan Koneksi API';
        }
    }

    // ====================================================================
    // PRIVATE – Backward compat: mapping nama kota lama ke adm4 BMKG
    // ====================================================================
    private function legacyKotaToAdm4(string $kota): string
    {
        $map = [
            'Bandung'    => '32.73.02.1001',
            'Jakarta'    => '31.71.01.1001',
            'Yogyakarta' => '34.71.03.1001',
            'Surabaya'   => '35.78.13.1001',
        ];
        return $map[$kota] ?? '32.73.02.1001';
    }

    // ====================================================================
    // PRIVATE – Cari data cuaca terdekat dengan waktu input
    // ====================================================================
    private function findClosestWeather(array $kelompokCuaca, string $waktuInput): string
    {
        $cuacaTerpilih   = 'Tidak Ada Data';
        $selisihTerkecil = PHP_INT_MAX;
        $carbonInput     = Carbon::parse($waktuInput, 'Asia/Jakarta');

        foreach ($kelompokCuaca as $hari) {
            foreach ($hari as $item) {
                if (isset($item['local_datetime'])) {
                    $carbonBMKG = Carbon::parse($item['local_datetime'], 'Asia/Jakarta');
                    $selisih    = abs($carbonInput->diffInMinutes($carbonBMKG));

                    if ($selisih < $selisihTerkecil) {
                        $selisihTerkecil = $selisih;
                        $cuacaTerpilih   = $item['weather_desc'] ?? 'Data Error';
                    }
                }
            }
        }

        return $cuacaTerpilih;
    }

    // ====================================================================
    // PRIVATE – Cuaca saat ini (widget header)
    // ====================================================================
    private function getCuacaSaatIni(string $kodeWilayah): ?array
    {
        try {
            $url      = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$kodeWilayah}";
            $response = Http::withOptions(['verify' => false])->timeout(8)->get($url);
            $data     = $response->json();

            if (!isset($data['data'][0]['cuaca'])) return null;

            $now     = Carbon::now('Asia/Jakarta');
            $closest = null;
            $minDiff = PHP_INT_MAX;

            foreach ($data['data'][0]['cuaca'] as $hari) {
                foreach ($hari as $item) {
                    if (isset($item['local_datetime'])) {
                        $diff = abs($now->diffInMinutes(
                            Carbon::parse($item['local_datetime'], 'Asia/Jakarta')
                        ));
                        if ($diff < $minDiff) {
                            $minDiff = $diff;
                            $closest = $item;
                        }
                    }
                }
            }
            return $closest;
        } catch (\Exception $e) {
            return null;
        }
    }
}