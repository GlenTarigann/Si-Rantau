<?php

namespace App\Http\Controllers;

use App\Models\AgendaOutdoor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AgendaOutdoorController extends Controller
{
    public function index()
    {
        $agendas = AgendaOutdoor::orderBy('waktu_mulai', 'asc')->get();
        
        
        $currentWeather = $this->getCuacaSaatIni('32.73.02.1005');

        return view('agenda.index', compact('agendas', 'currentWeather'));
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
        } catch (\Exception $e) { return null; }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'lokasi_kota'   => 'required',
            'waktu_mulai'   => 'required|date',
        ]);

        // Panggil Fungsi API Baru (JSON)
        $hasilCuaca = $this->getCuacaBaruJson($request->lokasi_kota, $request->waktu_mulai);

        AgendaOutdoor::create([
            'nama_kegiatan'   => $request->nama_kegiatan,
            'lokasi_kota'     => $request->lokasi_kota,
            'waktu_mulai'     => $request->waktu_mulai,
            'prediksi_cuaca'  => $hasilCuaca,
            'status_kegiatan' => 'Scheduled',
        ]);

        $isBadWeather = str_contains(strtolower($hasilCuaca), 'hujan') || str_contains(strtolower($hasilCuaca), 'petir');

        if ($isBadWeather) {
            return redirect()->route('agenda.index')
                ->with('warning', "Rencana disimpan. PERINGATAN: Cuaca diprediksi '$hasilCuaca'. Siapkan payung!");
        }

        return redirect()->route('agenda.index')
            ->with('success', "Rencana disimpan. Cuaca aman: $hasilCuaca.");
    }

    public function edit($id)
    {
        $agendaEdit = AgendaOutdoor::findOrFail($id);
        $agendas = AgendaOutdoor::orderBy('waktu_mulai', 'asc')->get();
        return view('agenda.edit', compact('agendaEdit', 'agendas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'lokasi_kota'   => 'required',
            'waktu_mulai'   => 'required|date',
        ]);

        $hasilCuaca = $this->getCuacaBaruJson($request->lokasi_kota, $request->waktu_mulai);

        $agenda = AgendaOutdoor::findOrFail($id);
        $agenda->update([
            'nama_kegiatan'   => $request->nama_kegiatan,
            'lokasi_kota'     => $request->lokasi_kota,
            'waktu_mulai'     => $request->waktu_mulai,
            'prediksi_cuaca'  => $hasilCuaca,
        ]);

        $isBadWeather = str_contains(strtolower($hasilCuaca), 'hujan') || str_contains(strtolower($hasilCuaca), 'petir');
        
        if ($isBadWeather) {
            return redirect()->route('agenda.index')->with('warning', "Update: Waspada cuaca '$hasilCuaca'.");
        }

        return redirect()->route('agenda.index')->with('success', 'Update berhasil.');
    }

    public function destroy($id)
    {
        AgendaOutdoor::findOrFail($id)->delete();
        return redirect()->route('agenda.index')->with('success', 'Rencana dihapus.');
    }

    public function cetakPdf()
    {
        $agendas = AgendaOutdoor::orderBy('waktu_mulai', 'asc')->get();

        $pdf = Pdf::loadView('agenda.cetak_pdf', compact('agendas'));
        
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Itinerary_Kegiatan_Outdoor.pdf');
    }

    private function getCuacaBaruJson($kota, $waktuInput)
    {
        try {
            $adm4 = '';

            if ($kota == 'Bandung') {
                $adm4 = '32.73.02.1005'; 
            } elseif ($kota == 'Jakarta') {
                $adm4 = '31.71.01.1001'; 
            } elseif ($kota == 'Yogyakarta') {
                $adm4 = '34.71.03.1004'; 
            } elseif ($kota == 'Surabaya') {
                $adm4 = '35.78.13.1002'; 
            } else {
                return "Lokasi Tidak Dikenal";
            }

            $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4}";
            
            \Illuminate\Support\Facades\Log::info("Requesting BMKG URL: " . $url);

            $response = Http::withOptions(['verify' => false])->get($url);
            
            if ($response->failed()) {
                $status = $response->status(); 
                return "Gagal API ($status). Cek Kode Wilayah.";
            }

            $data = $response->json();

            if (!isset($data['data'][0]['cuaca'])) {
                return "Data Cuaca Kosong (Struktur Berubah)";
            }
            
            $kelompokCuacaPerHari = $data['data'][0]['cuaca'];

            $cuacaTerpilih = "Tidak Ada Data";
            $selisihTerkecil = 999999999;
            
            $carbonInput = Carbon::parse($waktuInput, 'Asia/Jakarta');
            
            foreach ($kelompokCuacaPerHari as $hari) {
                foreach ($hari as $item) {
                    if (isset($item['local_datetime'])) {
                        $carbonBMKG = Carbon::parse($item['local_datetime'], 'Asia/Jakarta');
                        $selisih = abs($carbonInput->diffInMinutes($carbonBMKG));

                        if ($selisih < $selisihTerkecil) {
                            $selisihTerkecil = $selisih;
                            $cuacaTerpilih = $item['weather_desc'] ?? 'Data Error';
                        }
                    }
                }
            }

            return $cuacaTerpilih;

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("API Error: " . $e->getMessage());

            return "Gangguan Koneksi API"; 
        }
    }

    public function show($id)
    {
        return redirect()->route('agenda.index');
    }
}