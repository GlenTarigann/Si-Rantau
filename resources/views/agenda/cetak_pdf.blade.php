<!DOCTYPE html>
<html>
<head>
    <title>Itinerary Kegiatan Outdoor</title>
    <style>
        /* CSS Manual Sederhana untuk PDF */
        body { font-family: sans-serif; font-size: 11pt; color: #333; }
        
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1A237E; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #1A237E; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 9pt; color: #666; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: top; }
        
        th { background-color: #f2f2f2; color: #1A237E; font-weight: bold; }
        
        /* Styling status cuaca biar berwarna dikit */
        .cuaca-buruk { color: #D32F2F; font-weight: bold; }
        .cuaca-baik { color: #388E3C; font-weight: bold; }

        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; color: #aaa; padding: 10px; border-top: 1px solid #eee; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Itinerary Kegiatan Outdoor</h2>
        <p>Personal Assistant Mahasiswa Rantau - Kelompok 9 WAD</p>
        <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 30%">Nama Kegiatan</th>
                <th style="width: 25%">Lokasi & Waktu</th>
                <th style="width: 25%">Prediksi Cuaca</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agendas as $index => $agenda)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $agenda->nama_kegiatan }}</strong>
                </td>
                <td>
                    {{ $agenda->lokasi_kota }}<br>
                    <small style="color: #555;">
                        {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('d M Y') }}<br>
                        Pukul {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }}
                    </small>
                </td>
                <td>
                    @php
                        $cuacaKecil = strtolower($agenda->prediksi_cuaca);
                        $isBuruk = str_contains($cuacaKecil, 'hujan') || str_contains($cuacaKecil, 'petir');
                    @endphp

                    @if($isBuruk)
                        <span class="cuaca-buruk">{{ $agenda->prediksi_cuaca }}</span><br>
                        <small style="font-style: italic;">*Sedia payung</small>
                    @else
                        <span class="cuaca-baik">{{ $agenda->prediksi_cuaca }}</span>
                    @endif
                </td>
                <td>
                    {{ $agenda->status_kegiatan }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">
                    Belum ada rencana kegiatan yang disusun.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        &copy; 2025 Personal Assistant Mahasiswa Rantau. Data Cuaca didukung oleh BMKG.
    </div>

</body>
</html>