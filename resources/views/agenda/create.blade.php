<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Agenda - Personal Assistant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --primary-blue: #1A237E; --bg-light: #f4f7fe; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-light); }
        .navbar { background-color: white; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); padding: 0.8rem 2rem; }
        .navbar-brand { font-weight: 700; color: #333; }
        .nav-link.active { color: var(--primary-blue) !important; font-weight: 600; border-bottom: 3px solid var(--primary-blue); }
        
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); padding: 2rem; background: white; }
        
        .form-label { font-weight: 600; font-size: 0.9rem; color: #555; }
        .form-control, .form-select { border-radius: 10px; padding: 10px 15px; border: 1px solid #ddd; }
        .form-control:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 0.2rem rgba(26, 35, 126, 0.15); }
        
        .btn-save { background-color: var(--primary-blue); color: white; padding: 10px 30px; border-radius: 10px; font-weight: 600; border: none; }
        .btn-save:hover { background-color: #101655; color: white;}
        .btn-cancel { background-color: #f1f3f5; color: #333; padding: 10px 30px; border-radius: 10px; font-weight: 600; text-decoration: none; border: none; }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Personal Assistant Mahasiswa Rantau</a>
             <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto" style="font-size: 0.8rem;">
                    <li class="nav-item"><a class="nav-link px-2" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active px-2" href="#">Agenda Outdoor</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h4 class="fw-bold mb-4" style="color: var(--primary-blue);">Buat Rencana Baru</h4>
                    
                    <form action="{{ route('agenda.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label">Nama Kegiatan</label>
                                <input type="text" name="nama_kegiatan" class="form-control" placeholder="Contoh: Jogging Pagi di Gasibu" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Lokasi / Kota Tujuan</label>
                                <select name="lokasi_kota" class="form-select">
                                    <option value="Bandung">Bandung</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Semarang">Semarang</option>
                                </select>
                                <div class="form-text text-muted small">*Data cuaca akan diambil berdasarkan kota ini.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Waktu Pelaksanaan</label>
                                <input type="datetime-local" name="waktu_mulai" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-5 d-flex gap-2">
                            <button type="submit" class="btn btn-save">Simpan Rencana</button>
                            <a href="{{ route('agenda.index') }}" class="btn btn-cancel">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>