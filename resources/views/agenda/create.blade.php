<!DOCTYPE html>
<html>
<head>
    <title>Tambah Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h3>Buat Rencana Baru</h3>
    
    <form action="{{ route('agenda.store') }}" method="POST">
        @csrf <div class="mb-3">
            <label>Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control" placeholder="Misal: Jogging Pagi" required>
        </div>

        <div class="mb-3">
            <label>Lokasi (Kota)</label>
            <select name="lokasi_kota" class="form-control">
                <option value="Bandung">Bandung</option>
                <option value="Jakarta">Jakarta</option>
                <option value="Yogyakarta">Yogyakarta</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Waktu Mulai</label>
            <input type="datetime-local" name="waktu_mulai" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan & Cek Cuaca</button>
        <a href="{{ route('agenda.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

</body>
</html>