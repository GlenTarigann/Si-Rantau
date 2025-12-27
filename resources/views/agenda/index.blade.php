<!DOCTYPE html>
<html>
<head>
    <title>Agenda Outdoor - Mahasiswa Rantau</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>📅 Agenda Outdoor Saya</h2>
    <a href="{{ route('agenda.create') }}" class="btn btn-primary mb-3">+ Tambah Rencana</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kegiatan</th>
                <th>Lokasi</th>
                <th>Waktu</th>
                <th>Prediksi Cuaca (API)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agendas as $agenda)
            <tr>
                <td>{{ $agenda->nama_kegiatan }}</td>
                <td>{{ $agenda->lokasi_kota }}</td>
                <td>{{ $agenda->waktu_mulai }}</td>
                <td>
                    {{ $agenda->prediksi_cuaca }}
                </td>
                <td><span class="badge bg-info">{{ $agenda->status_kegiatan }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>