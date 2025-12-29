<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Ibadah</title>
    <style>
        body { font-family: sans-serif; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1A237E; padding-bottom: 10px; }
        h2 { margin: 0; color: #1A237E; text-transform: uppercase; }
        .sub-header { font-size: 0.9rem; color: #666; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 10px; text-align: left; font-size: 10pt; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        tr:nth-child(even) { background-color: #fafafa; }
        .text-pending { color: #d32f2f; font-weight: bold; }
        .text-terlaksana { color: #2e7d32; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 0.8rem; color: #999; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>Laporan Riwayat Ibadah</h2>
        <div class="sub-header">Dicetak pada: {{ date('d-m-Y H:i') }} WIB</div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 30%;">Kegiatan</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 35%;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataIbadah as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                <td>{{ $item->prayer_name }}</td>
                <td style="text-align: center;">
                    <span class="{{ $item->status == 'terlaksana' ? 'text-terlaksana' : 'text-pending' }}">
                        {{ strtoupper($item->status) }}
                    </span>
                </td>
                <td>{{ $item->notes ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align: center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">Dicetak otomatis oleh Personal Assistant</div>
</body>
</html>