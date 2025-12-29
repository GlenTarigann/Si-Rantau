<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Agenda - Personal Assistant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        :root {
            --primary-blue: #1A237E;
            --bg-light: #f4f7fe;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar { background-color: white; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); padding: 0.8rem 2rem; }
        .navbar-brand { font-weight: 700; color: #333; }
        .nav-link { font-weight: 500; color: #666; margin: 0 10px; }
        .nav-link.active { color: var(--primary-blue) !important; font-weight: 600; border-bottom: 3px solid var(--primary-blue); }
        .user-name { color: var(--primary-blue) !important; font-weight: 600; }

        /* Card Styling */
        .main-container { flex: 1; }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            height: 100%;
            background: white;
            padding: 1.5rem;
        }
        .card-title { font-weight: 700; color: #333; margin-bottom: 1.5rem; font-size: 1.1rem; }

        /* Form & Inputs */
        .form-label { font-weight: 600; font-size: 0.85rem; color: #555; }
        .form-control, .form-select, .flatpickr-input {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #eee;
            background-color: #fafafa;
        }
        .btn-primary-custom {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
        }
        .btn-primary-custom:hover { background-color: #101655; color: white; }

        .table thead th { background-color: #f8f9fa; font-size: 0.85rem; color: #666; font-weight: 600; }
        .table td { font-size: 0.9rem; vertical-align: middle; }
        
        .editing-row {
            background-color: #e8eaf6 !important;
            border-left: 4px solid var(--primary-blue);
        }

        footer { padding: 2rem; color: #888; font-size: 0.85rem; text-align: center; margin-top: auto; }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg sticky-top py-2">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Personal Assistant Mahasiswa Rantau</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto" style="font-size: 0.8rem;">
                    <li class="nav-item"><a class="nav-link px-2" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Manajemen Tugas</a></li>
                    <li class="nav-item"><a class="nav-link active px-2" href="{{ route('agenda.index') }}">Agenda Outdoor</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Meal Plan</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Spiritual</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5 main-container">
        
        <h4 class="fw-bold mb-4" style="color: #333;">Edit Rencana Kegiatan</h4>

        <div class="row g-4">
            
            <div class="col-md-5">
                <div class="card border border-primary shadow">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0 text-primary">Form Edit Data</h5>
                        <span class="badge bg-primary">Mode Edit</span>
                    </div>
                    
                    <form action="{{ route('agenda.update', $agendaEdit->id_agenda) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" 
                                   class="form-control @error('nama_kegiatan') is-invalid @enderror" 
                                   value="{{ old('nama_kegiatan', $agendaEdit->nama_kegiatan) }}" required>
                            @error('nama_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi (Kota/Kabupaten)</label>
                            <select name="lokasi_kota" class="form-select @error('lokasi_kota') is-invalid @enderror">
                                <option value="Bandung" {{ old('lokasi_kota', $agendaEdit->lokasi_kota) == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                                <option value="Jakarta" {{ old('lokasi_kota', $agendaEdit->lokasi_kota) == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                                <option value="Yogyakarta" {{ old('lokasi_kota', $agendaEdit->lokasi_kota) == 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                                <option value="Surabaya" {{ old('lokasi_kota', $agendaEdit->lokasi_kota) == 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                            </select>
                            @error('lokasi_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Waktu Pelaksanaan <span class="badge bg-secondary ms-1">WIB</span></label>
                            <input type="text" name="waktu_mulai" id="waktu_picker_edit"
                                   class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   value="{{ old('waktu_mulai', $agendaEdit->waktu_mulai) }}">
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary-custom">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('agenda.index') }}" class="btn btn-light border text-muted">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card" style="opacity: 0.8; background-color: #fcfcfc;">
                    <h5 class="card-title text-muted">Daftar Rencana (Referensi)</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th>Lokasi</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agendas as $agenda)
                                <tr class="{{ $agenda->id_agenda == $agendaEdit->id_agenda ? 'editing-row' : '' }}">
                                    <td class="fw-bold">{{ $agenda->nama_kegiatan }}</td>
                                    <td>{{ $agenda->lokasi_kota }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('d M, H:i') }}
                                        @if($agenda->id_agenda == $agendaEdit->id_agenda)
                                            <span class="badge bg-warning text-dark ms-2">Sedang Diedit</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2025 Personal Assistant Mahasiswa Rantau - Kelompok 9 WAD
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#waktu_picker_edit", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today",
            altInput: true,
            altFormat: "j F Y, H:i",
            defaultDate: "{{ $agendaEdit->waktu_mulai }}" 
        });
    </script>
</body>
</html>