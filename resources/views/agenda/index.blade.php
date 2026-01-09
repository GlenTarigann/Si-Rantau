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

        .form-label { font-weight: 600; font-size: 0.85rem; color: #555; }
        .form-control, .form-select, .flatpickr-input {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #eee;
            background-color: #fafafa;
        }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { font-size: 0.75rem; color: #dc3545; font-weight: 500; }

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

        .alert-warning-custom {
            background-color: var(--warning-bg);
            color: #e65100;
            border: 1px solid #fff59d;
            border-radius: 10px;
            padding: 15px;
            font-size: 0.9rem;
        }

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
        
        <div class="card widget-card mb-4 p-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold mb-1 text-primary">Agenda Outdoor</h4>
                    <small class="text-muted">Pantau kegiatan dan cuaca real-time</small>
                </div>

                <div class="d-flex align-items-center gap-4">
                    <div class="text-end lh-1">
                        <div id="digital-clock" class="fw-bold fs-4 text-dark" style="font-family: 'Courier New', monospace;">
                            {{ date('H:i:s') }}
                        </div>
                        <div class="small text-muted fw-bold">
                            {{ date('d M Y') }} <span class="badge bg-light text-dark border ms-1">WIB</span>
                        </div>
                    </div>
                    
                    <div class="vr mx-2"></div>

                    <div class="d-flex align-items-center">
                        @if(isset($currentWeather))
                            <img src="{{ $currentWeather['image'] }}" alt="Icon" width="50" height="50" class="me-2">
                            <div class="lh-1">
                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                    {{ $currentWeather['weather_desc'] }}
                                </div>
                                <div class="small text-primary fw-bold">
                                    {{ $currentWeather['t'] }}°C
                                </div>
                            </div>
                        @else
                            <div class="text-muted small fst-italic">
                                <i class="bi bi-cloud-slash me-1"></i> Data Offline
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(session('warning'))
            <div class="alert alert-warning d-flex align-items-center mb-4 rounded-3 border-0 shadow-sm" role="alert" style="background-color: #FFF3E0; color: #E65100;">
                <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                <div>{{ session('warning') }}</div>
            </div>
        @elseif(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4 rounded-3 border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <div class="row g-4">
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header-custom">
                        <h5 class="card-title">Input Rencana</h5>
                        <i class="bi bi-plus-circle-fill text-primary fs-5"></i>
                    </div>
                    
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
                            <label class="form-label">Lokasi</label>
                            <select name="lokasi_kota" class="form-select @error('lokasi_kota') is-invalid @enderror">
                                <option value="" disabled selected>-- Pilih Lokasi --</option>
                                <option value="Bandung">Bandung</option>
                                <option value="Jakarta">Jakarta</option>
                                <option value="Yogyakarta">Yogyakarta</option>
                                <option value="Surabaya">Surabaya</option>
                            </select>
                            @error('lokasi_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Waktu <span class="badge bg-light text-secondary border ms-1">WIB</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                                <input type="text" name="waktu_mulai" id="waktu_picker"
                                       class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                       placeholder="Pilih Tanggal & Jam...">
                            </div>
                            @error('waktu_mulai')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-save me-2"></i> Simpan Rencana
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header-custom border-bottom pb-3 mb-3">
                        <h5 class="card-title">Daftar Rencana Kegiatan</h5>
                        
                        <a href="{{ route('agenda.cetak') }}" target="_blank" class="btn btn-outline-pdf">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th>Lokasi & Waktu</th>
                                    <th>Prediksi Cuaca</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agendas as $agenda)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $agenda->nama_kegiatan }}</td>
                                    <td>
                                        <div class="text-primary fw-semibold">{{ $agenda->lokasi_kota }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('d M, H:i') }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $cuaca = strtolower($agenda->prediksi_cuaca);
                                            $bad = str_contains($cuaca, 'hujan') || str_contains($cuaca, 'petir');
                                        @endphp
                                        @if($bad)
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3 py-2">
                                                <i class="bi bi-cloud-lightning-rain me-1"></i> {{ $agenda->prediksi_cuaca }}
                                            </span>
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2">
                                                <i class="bi bi-sun me-1"></i> {{ $agenda->prediksi_cuaca }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('agenda.edit', $agenda->id_agenda) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('agenda.destroy', $agenda->id_agenda) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus rencana ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i>
                                            Belum ada rencana kegiatan. <br> Mulai tambahkan di formulir sebelah kiri.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
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
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const el = document.getElementById('digital-clock');
            if(el) el.textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);

        flatpickr("#waktu_picker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today",
            defaultHour: 8,
            altInput: true,
            altFormat: "j F Y, H:i"
        });
    </script>
</body>
</html>