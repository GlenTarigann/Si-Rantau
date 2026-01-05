@php
    date_default_timezone_set('Asia/Jakarta');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Riwayat Ibadah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            padding: 40px 20px;
            color: #333;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 50px 60px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 25px;
            border-bottom: 2px solid #1A237E;
        }

        .header h1 {
            color: #1A237E;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .sub-header {
            font-size: 13px;
            color: #7d7d7d;
            line-height: 1.6;
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 35px;
            gap: 15px;
        }

        .stat-box {
            flex: 1;
            background: #fafafa;
            padding: 25px 20px;
            border-radius: 6px;
            text-align: center;
            border: 1px solid #e8e8e8;
        }

        .stat-label {
            font-size: 11px;
            color: #9e9e9e;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1A237E;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #fafafa;
            border-top: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            padding: 15px 12px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #616161;
        }

        th:first-child {
            text-align: center;
            width: 5%;
        }

        td {
            padding: 18px 12px;
            font-size: 13px;
            border-bottom: 1px solid #f5f5f5;
        }

        td:first-child {
            text-align: center;
            color: #bdbdbd;
            font-weight: 500;
            font-size: 12px;
        }

        tbody tr:hover {
            background-color: #fafafa;
        }

        tbody tr:last-child td {
            border-bottom: 1px solid #e0e0e0;
        }

        .date-text {
            font-weight: 600;
            color: #1A237E;
            font-size: 13px;
            margin-bottom: 3px;
        }

        .time-text {
            color: #9e9e9e;
            font-size: 11px;
        }

        .activity-name {
            font-weight: 600;
            color: #424242;
            margin-bottom: 4px;
        }

        .frequency-badge {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .category-badge {
            display: inline-block;
            background: #f3e5f5;
            color: #7b1fa2;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 14px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-terlaksana {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-pending {
            background-color: #fff8e1;
            color: #f57c00;
        }

        .notes-text {
            color: #757575;
            font-size: 12px;
            line-height: 1.5;
        }

        .target-text {
            color: #9e9e9e;
            font-size: 10px;
            margin-top: 4px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            font-size: 11px;
            color: #9e9e9e;
        }

        .footer-left strong {
            color: #616161;
        }

        .footer-right {
            text-align: right;
            font-size: 11px;
            color: #9e9e9e;
        }

        .footer-right strong {
            color: #616161;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #bdbdbd;
            font-size: 13px;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 30px;
            }

            @page {
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN RIWAYAT IBADAH</h1>
            <div class="sub-header">
                Personal Assistant Mahasiswa Rantau<br>
                Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y - H:i') }} WIB
            </div>
        </div>

        <!-- Statistics -->
        @php
            $totalData = $dataIbadah->count();
            $terlaksana = $dataIbadah->where('status', 'terlaksana')->count();
            $pending = $dataIbadah->where('status', 'pending')->count();
            $persentase = $totalData > 0 ? round(($terlaksana / $totalData) * 100) : 0;
        @endphp

        <div class="stats-container">
            <div class="stat-box">
                <div class="stat-label">Total Kegiatan</div>
                <div class="stat-value">{{ $totalData }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Terlaksana</div>
                <div class="stat-value">{{ $terlaksana }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Pending</div>
                <div class="stat-value">{{ $pending }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Pencapaian</div>
                <div class="stat-value">{{ $persentase }}%</div>
            </div>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>TANGGAL & WAKTU</th>
                    <th>KEGIATAN</th>
                    <th>KATEGORI</th>
                    <th>STATUS</th>
                    <th>CATATAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataIbadah as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="date-text">
                            {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}
                        </div>
                        <div class="time-text">
                            {{ $item->time ?? '-' }}
                        </div>
                    </td>
                    <td>
                        <div class="activity-name">{{ $item->prayer_name }}</div>
                        <span class="frequency-badge">{{ $item->frequency }}</span>
                    </td>
                    <td>
                        <span class="category-badge">
                            {{ ucfirst(str_replace('_', ' ', $item->kategori)) }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge {{ $item->status == 'terlaksana' ? 'status-terlaksana' : 'status-pending' }}">
                            {{ strtoupper($item->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="notes-text">{{ $item->notes ?? '-' }}</div>
                        @if($item->target_count)
                            <div class="target-text">Target: {{ $item->target_count }} {{ $item->target_unit }}</div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="no-data">
                        Belum ada data riwayat ibadah
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-left">
                <strong>Personal Assistant Mahasiswa Rantau</strong><br>
                Spiritual Tracker © {{ date('Y') }}
            </div>
            <div class="footer-right">
                User: <strong>{{ Auth::user()->name ?? 'Islamic Halaman' }}</strong><br>
                Halaman 1/1
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>