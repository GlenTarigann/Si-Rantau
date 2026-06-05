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
    // Konversi ID emsifa → kode adm4 BMKG
    // Contoh: "3273020001"  →  "32.73.02.0001"
    // Contoh: "327302"      →  "32.73.02"
    // ====================================================================
    private function toAdm4(string $id): string
    {
        $id = str_pad($id, 10, '0', STR_PAD_LEFT);
        return implode('.', [
            substr($id, 0, 2),
            substr($id, 2, 2),
            substr($id, 4, 2),
            substr($id, 6, 4),
        ]);
    }

    private function toAdm3(string $id): string
    {
        $id = str_pad($id, 7, '0', STR_PAD_LEFT);
        return implode('.', [
            substr($id, 0, 2),
            substr($id, 2, 2),
            substr($id, 4, 2),
        ]);
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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ====================================================================
    // AJAX – Daftar Kabupaten/Kota berdasarkan ID Provinsi
    // GET /wilayah/kabupaten/{prov}   e.g. prov = "32"
    // ====================================================================
    public function getKabupaten($provId)
    {
        try {
            $resp = Http::withOptions(['verify' => false])
                        ->timeout(10)
                        ->get(self::WILAYAH_BASE . "/regencies/{$provId}.json");
            return response()->json($resp->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ====================================================================
    // AJAX – Daftar Kecamatan berdasarkan ID Kabupaten
    // GET /wilayah/kecamatan/{kab}   e.g. kab = "3273"
    // ====================================================================
    public function getKecamatan($kabId)
    {
        try {
            $resp = Http::withOptions(['verify' => false])
                        ->timeout(10)
                        ->get(self::WILAYAH_BASE . "/districts/{$kabId}.json");
            return response()->json($resp->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ====================================================================
    // AJAX – Daftar Kelurahan/Desa berdasarkan ID Kecamatan
    // GET /wilayah/kelurahan/{kec}   e.g. kec = "3273020"
    // ====================================================================
    public function getKelurahan($kecId)
    {
        try {
            $resp = Http::withOptions(['verify' => false])
                        ->timeout(10)
                        ->get(self::WILAYAH_BASE . "/villages/{$kecId}.json");
            return response()->json($resp->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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

        $currentWeather = $this->getCuacaSaatIni('32.73.02.1005');

        return view('agenda.index', compact('agendas', 'currentWeather'));
    }

    // ====================================================================
    // STORE
    // ====================================================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'adm4_code'     => 'required|string',   // kode BMKG adm4
            'lokasi_label'  => 'required|string',   // label lengkap yang tampil
            'waktu_mulai'   => 'required|date',
        ]);

        $hasilCuaca = $this->getCuacaByAdm4($request->adm4_code, $request->waktu_mulai);

        AgendaOutdoor::create([
            'user_id'         => Auth::id(),
            'nama_kegiatan'   => $request->nama_kegiatan,
            'lokasi_kota'     => $request->lokasi_label,
            'waktu_mulai'     => $request->waktu_mulai,
            'prediksi_cuaca'  => $hasilCuaca,
            'status_kegiatan' => 'Scheduled',
        ]);

        $isBadWeather = str_contains(strtolower($hasilCuaca), 'hujan') ||
                        str_contains(strtolower($hasilCuaca), 'petir');

        if ($isBadWeather) {
            return redirect()->route('agenda.index')
                ->with('warning', "Rencana disimpan. PERINGATAN: Cuaca diprediksi '$hasilCuaca'. Siapkan payung!");
        }

        return redirect()->route('agenda.index')
            ->with('success', "Rencana disimpan. Cuaca aman: $hasilCuaca.");
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

        // Cek apakah pakai sistem baru (adm4_code) atau lama (lokasi_kota langsung)
        if ($request->filled('adm4_code')) {
            $hasilCuaca = $this->getCuacaByAdm4($request->adm4_code, $request->waktu_mulai);
            $lokasiLabel = $request->lokasi_label ?? $request->lokasi_kota;
        } else {
            $hasilCuaca  = $this->getCuacaBaruJson($request->lokasi_kota, $request->waktu_mulai);
            $lokasiLabel = $request->lokasi_kota;
        }

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
                ->with('warning', "Update berhasil. Waspada cuaca '$hasilCuaca'!");
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
    // PRIVATE – Ambil cuaca berdasarkan kode adm4 BMKG (baru)
    // ====================================================================
    private function getCuacaByAdm4(string $adm4, string $waktuInput): string
    {
        try {
            $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4}";
            \Illuminate\Support\Facades\Log::info("BMKG adm4 Request: {$url}");

            $response = Http::withOptions(['verify' => false])->timeout(15)->get($url);

            if ($response->failed()) {
                return "Gagal API ({$response->status()})";
            }

            $data = $response->json();

            if (!isset($data['data'][0]['cuaca'])) {
                return "Data Cuaca Tidak Tersedia";
            }

            return $this->findClosestWeather($data['data'][0]['cuaca'], $waktuInput);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("BMKG Error: " . $e->getMessage());
            return "Gangguan Koneksi API";
        }
    }

    // ====================================================================
    // PRIVATE – Ambil cuaca berdasarkan nama kota (lama – backward compat)
    // ====================================================================
    private function getCuacaBaruJson(string $kota, string $waktuInput): string
    {
        $map = [
            'Bandung'    => '32.73.02.1005',
            'Jakarta'    => '31.71.01.1001',
            'Yogyakarta' => '34.71.03.1004',
            'Surabaya'   => '35.78.13.1002',
        ];

        $adm4 = $map[$kota] ?? null;
        if (!$adm4) return "Lokasi Tidak Dikenal";

        return $this->getCuacaByAdm4($adm4, $waktuInput);
    }

    // ====================================================================
    // PRIVATE – Cari data cuaca terdekat dengan waktu input
    // ====================================================================
    private function findClosestWeather(array $kelompokCuaca, string $waktuInput): string
    {
        $cuacaTerpilih  = "Tidak Ada Data";
        $selisihTerkecil = PHP_INT_MAX;
        $carbonInput    = Carbon::parse($waktuInput, 'Asia/Jakarta');

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
    // PRIVATE – Cuaca saat ini (untuk widget di header)
    // ====================================================================
    private function getCuacaSaatIni(string $kodeWilayah): ?array
    {
        try {
            $url      = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$kodeWilayah}";
            $response = Http::withOptions(['verify' => false])->timeout(10)->get($url);
            $data     = $response->json();

            if (!isset($data['data'][0]['cuaca'])) return null;

            $now     = Carbon::now('Asia/Jakarta');
            $closest = null;
            $minDiff = PHP_INT_MAX;

            foreach ($data['data'][0]['cuaca'] as $hari) {
                foreach ($hari as $item) {
                    if (isset($item['local_datetime'])) {
                        $diff = abs($now->diffInMinutes(Carbon::parse($item['local_datetime'], 'Asia/Jakarta')));
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