<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Outdoor - Personal Assistant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        :root {
            --primary-blue: #1A237E;
            --bg-light: #f4f7fe;
            --warning-bg: #fff9c4;
            --warning-text: #f57f17;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Card & Layout */
        .main-container { flex: 1; }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            height: 100%;
            background: white;
            padding: 1.5rem;
        }
        .card-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        /* Form Inputs */
        .form-label { font-weight: 600; font-size: 0.85rem; color: #555; }
        /* Style khusus untuk input Flatpickr agar background putih */
        .form-control, .form-select, .flatpickr-input {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #eee;
            background-color: #fafafa;
        }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { font-size: 0.75rem; color: #dc3545; font-weight: 500; }

        /* Buttons */
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

        .btn-cetak {
            background-color: #1A237E; 
            color: white;
            font-weight: 600;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            width: 100%;
            display: block;
            text-align: center;
            text-decoration: none;
        }
        .btn-cetak:hover { background-color: #1A237E; color: white; }

        /* Alert */
        .alert-warning-custom {
            background-color: var(--warning-bg);
            color: #e65100;
            border: 1px solid #fff59d;
            border-radius: 10px;
            padding: 15px;
            font-size: 0.9rem;
        }

        /* Table */
        .table thead th {
            background-color: #f8f9fa;
            font-size: 0.85rem;
            color: #666;
            font-weight: 600;
            border-bottom: 2px solid #eee;
        }
        .table td { vertical-align: middle; font-size: 0.9rem; }

        footer { padding: 2rem; color: #888; font-size: 0.85rem; text-align: center; margin-top: auto; }
    </style>
</head>

<body>

    @include('layouts.navbar')

    <div class="container my-5 main-container">
        
        <h4 class="fw-bold mb-4" style="color: #333;">Agenda Outdoor</h4>

        @if(session('warning'))
            <div class="alert alert-warning-custom d-flex align-items-center mb-4">
                <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                <div>{{ session('warning') }}</div>
            </div>
        @elseif(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm">
                <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @else
            <div class="alert alert-warning-custom d-flex align-items-center mb-4">
                <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                <div>
                    <strong>Peringatan Dini:</strong> Sistem akan otomatis mengecek cuaca saat Anda menyimpan rencana.
                </div>
            </div>
        @endif

        <div class="row g-4">
            
            <div class="col-md-5">
                <div class="card">
                    <h5 class="card-title">Input Rencana Kegiatan</h5>
                    
                    <form action="{{ route('agenda.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" 
                                   class="form-control @error('nama_kegiatan') is-invalid @enderror" 
                                   value="{{ old('nama_kegiatan') }}" 
                                   placeholder="Contoh: Rapat Divisi">
                            @error('nama_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi (Kota/Kabupaten)</label>
                            <select name="lokasi_kota" class="form-select @error('lokasi_kota') is-invalid @enderror">
                                <option value="" disabled selected>-- Pilih Lokasi --</option>
                                <option value="Bandung" {{ old('lokasi_kota') == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                                <option value="Jakarta" {{ old('lokasi_kota') == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                                <option value="Yogyakarta" {{ old('lokasi_kota') == 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                                <option value="Surabaya" {{ old('lokasi_kota') == 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                            </select>
                            @error('lokasi_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Waktu Pelaksanaan <span class="badge bg-secondary ms-1">WIB (24 Jam)</span></label>
                            <input type="text" name="waktu_mulai" id="waktu_picker"
                                   class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   value="{{ old('waktu_mulai') }}" 
                                   placeholder="Pilih Tanggal & Jam...">
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary-custom">
                            Simpan Rencana
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card">
                    <h5 class="card-title">Daftar Rencana Kegiatan</h5>
                    
                    <div class="table-responsive mb-3">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th>Lokasi & Waktu</th>
                                    <th>Prediksi Cuaca</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agendas as $agenda)
                                <tr>
                                    <td class="fw-bold">{{ $agenda->nama_kegiatan }}</td>
                                    <td>
                                        <div>{{ $agenda->lokasi_kota }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('d M, H:i') }}</small>
                                    </td>
                                    <td>
                                        @if(str_contains(strtolower($agenda->prediksi_cuaca), 'hujan') || str_contains(strtolower($agenda->prediksi_cuaca), 'petir'))
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">
                                                {{ $agenda->prediksi_cuaca }}
                                            </span>
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                                {{ $agenda->prediksi_cuaca }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('agenda.edit', $agenda->id_agenda) }}" class="btn btn-sm btn-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('agenda.destroy', $agenda->id_agenda) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus rencana ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Belum ada rencana kegiatan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('agenda.cetak') }}" target="_blank" class="btn btn-cetak mt-auto">
                        <i class="bi bi-printer me-2"></i> Cetak Itinerary
                    </a>

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
        // Inisialisasi Flatpickr pada input dengan ID "waktu_picker"
        flatpickr("#waktu_picker", {
            enableTime: true,       // Aktifkan pilihan jam
            dateFormat: "Y-m-d H:i", // Format yang dikirim ke database
            time_24hr: true,        // WAJIB: Paksa format 24 jam (Tanpa AM/PM)
            minDate: "today",       // Tidak boleh pilih tanggal lampau
            defaultHour: 8,         // Jam default saat dibuka
            altInput: true,         // Tampilan untuk user lebih cantik
            altFormat: "j F Y, H:i" // Contoh tampilan: 28 Desember 2025, 14:00
        });
    </script>
</body>
</html>