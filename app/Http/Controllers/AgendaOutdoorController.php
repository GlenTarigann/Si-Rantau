<?php

namespace App\Http\Controllers;

use App\Models\AgendaOutdoor; // Panggil Model yang tadi dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Untuk nembak API nanti

class AgendaOutdoorController extends Controller
{
    // 1. Menampilkan Daftar Agenda
    public function index()
    {
        $agendas = AgendaOutdoor::all();
        
        return view('agenda.index', compact('agendas'));
    }

    // 2. Menampilkan Form Tambah
    public function create()
    {
        return view('agenda.create');
    }

    // 3. Menyimpan Data (Disini Logika API bekerja)
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'lokasi_kota' => 'required',
            'waktu_mulai' => 'required|date',
        ]);

        // (NANTI) Disini kita akan masukkan codingan nembak API BMKG
        // Untuk sementara kita set default dulu biar CRUD jalan
        $cuaca_saat_ini = "Belum dicek (Menunggu API)"; 

        // C. Simpan ke Database
        AgendaOutdoor::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'lokasi_kota' => $request->lokasi_kota,
            'waktu_mulai' => $request->waktu_mulai,
            'prediksi_cuaca' => $cuaca_saat_ini, // Nanti ini dari API
            'status_kegiatan' => 'Scheduled',
        ]);

        // D. Balik ke halaman utama
        return redirect()->route('agenda.index')
                         ->with('success', 'Agenda berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
