<!DOCTYPE html>
<html>
<head>
    <title>Laporan Manajemen Tugas</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; margin: 30px; font-size: 12px; }
        .header-title { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 5px; }
        .line-divider { border-bottom: 1px solid #000; border-top: 3px solid #000; height: 2px; margin-bottom: 20px; }
        .info-section { margin-bottom: 25px; line-height: 1.5; }
        .blue-underline { color: #0056b3; text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f2f2f2; border: 1px solid #000; padding: 10px; text-align: left; font-weight: bold; }
        td { border: 1px solid #000; padding: 10px; vertical-align: top; }
        .footer { position: fixed; bottom: -30px; left: 0px; right: 0px; height: 30px; text-align: center; font-style: italic; font-size: 11px; }
    </style>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>
    <div class="header-title">Laporan Manajemen Tugas - Personal Assistant Mahasiswa Rantau</div>
    <div class="line-divider"></div>

    <div class="info-section">
        @php
        $now = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta');
        @endphp
        <p>Nama Mahasiswa: 
            <span class="blue-underline">
                {{ strtoupper($user->name) }} 
            </span>
        </p>
        <p>Tanggal Cetak: <span class="blue-underline">{{ $now->translatedFormat('d F Y, H:i') }} WIB</span></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="20%">Nama Tugas</th>
                <th width="15%">Kategori</th>
                <th width="20%">Deadline</th>
                <th width="15%">Status</th>
                <th width="30%">Catatan</th> 
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->task_name }}</td>
                <td>{{ $task->task_category }}</td>
                <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y H:i') }}</td>
                <td>{{ $task->progres_status }}</td>
                <td>{{ $task->catatan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Tetap Semangat di Perantauan!</div>
</body>
</html>