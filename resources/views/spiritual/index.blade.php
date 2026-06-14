<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spiritual Tracker - Personal Assistant Mahasiswa Rantau</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:       #1A237E;
            --primary-mid:   #283593;
            --primary-light: #E8EAF6;
            --accent:        #F57F17;
            --accent-light:  #FFF3E0;
            --teal:          #00897B;
            --teal-light:    #E0F2F1;
            --danger:        #C62828;
            --bg:            #f4f7fe;
            --surface:       #ffffff;
            --text-main:     #1a1a2e;
            --text-muted:    #6c757d;
            --border:        #e8eaf0;
            --shadow-sm:     0 2px 8px rgba(26,35,126,0.06);
            --shadow-md:     0 6px 24px rgba(26,35,126,0.10);
            --shadow-lg:     0 12px 40px rgba(26,35,126,0.14);
            --radius:        16px;
            --radius-sm:     10px;
        }

        body {
            background-color: var(--bg);
            font-family: 'Poppins', sans-serif;
            color: var(--text-main);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .page-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-mid) 60%, #3949AB 100%);
            padding: 2rem 0 3.5rem;
            position: relative;
            overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .page-hero::after {
            content: '';
            position: absolute;
            bottom: -60px; left: 10%;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .page-hero .hero-title {
            font-size: 1.9rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 0.2rem;
        }
        .page-hero .hero-subtitle {
            color: rgba(255,255,255,0.7);
            font-size: 0.88rem;
            font-weight: 400;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            background: var(--surface);
        }

        .table-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        .widget-sholat span {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .widget-sholat h4 {
            font-size: 1.25rem;
        }

        footer {
            padding: 2rem;
            color: #888;
            font-size: 0.85rem;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>

<body>
    @include('layouts.navbar')

    {{-- ===== HERO HEADER ===== --}}
    <div class="page-hero">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="fade-up">
                    <p class="hero-subtitle mb-1">
                        <i class="bi bi-compass me-1"></i> Personal Assistant Mahasiswa Rantau
                    </p>
                    <h1 class="hero-title mb-1">
                        <i class="bi bi-heart-pulse me-2"></i>Spiritual Tracker
                    </h1>
                    <p class="hero-subtitle">Jaga keseimbangan duniamu dengan ibadah</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5" style="margin-top: -2rem !important; position: relative; z-index: 10;">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <strong><i class="bi bi-exclamation-circle-fill me-2"></i>Terdapat kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="container py-4">
            <div class="row align-items-center mb-4">
                <div class="col-12 text-end">
                    <a href="{{ route('spiritual.cetak') }}" target="_blank" class="btn btn-danger btn-sm me-1" style="border-radius: var(--radius-sm); font-weight: 600;">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                    <button class="btn btn-sm text-white"
                        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-mid) 100%); border: none; border-radius: var(--radius-sm); font-weight: 600; box-shadow: 0 4px 14px rgba(26,35,126,0.3);" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg"></i> Catat Target
                    </button>
                </div>
            </div>

            @if(isset($dataSpiritual['type']) && $dataSpiritual['type'] == 'muslim')
            <div class="card border-0 shadow-sm mb-4 text-white"
                style="background: linear-gradient(135deg, #1A237E, #283593);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <h5 class="fw-bold mb-0">Jadwal Sholat</h5>
                            <small class="opacity-75">Bandung, {{ date('d M Y') }}</small>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex justify-content-between text-center gap-1">
                                @foreach(['subuh','dzuhur','ashar','maghrib','isya'] as $w)
                                <div class="bg-white bg-opacity-10 rounded p-2 flex-fill">
                                    <small class="d-block text-capitalize">{{ $w }}</small>
                                    <h5 class="fw-bold mb-0">{{ $dataSpiritual['jadwal'][$w] ?? '-' }}</h5>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(isset($dataSpiritual['type']) && $dataSpiritual['type'] == 'kristen')
            <div class="card border-0 shadow-sm mb-4 text-white"
                style="background: linear-gradient(135deg, #1A237E, #283593);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">Ayat Hari Ini</h5>
                    <p class="fst-italic mb-2">
                        "{{ $dataSpiritual['ayat']['content'] ?? '' }}"
                    </p>
                    <small class="opacity-75">
                        {{ $dataSpiritual['ayat']['book']['name'] ?? '' }}
                        {{ $dataSpiritual['ayat']['chapter'] ?? '' }}:{{ $dataSpiritual['ayat']['verses'][0]['verse'] ?? '' }}
                    </small>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="table-scroll" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="ps-4">Status</th>
                                <th>Waktu</th>
                                <th>Kegiatan</th>
                                <th>Kategori</th>
                                <th>Catatan</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataIbadah ?? [] as $item)
                            <tr>
                                <td class="ps-4">
                                    <form action="{{ route('spiritual.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="status"
                                            value="{{ $item->status == 'pending' ? 'terlaksana' : 'pending' }}"
                                            class="btn {{ $item->status == 'pending' ? 'btn-outline-secondary' : 'btn-success' }} btn-sm rounded-circle"
                                            style="width:28px;height:28px;">
                                            <i class="bi bi-check-lg small"></i>
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <div class="fw-bold small">
                                        {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}
                                    </div>
                                    <small class="text-muted">{{ $item->time ?? '-' }}</small>
                                </td>

                                <td>
                                    <span class="fw-bold small">{{ $item->prayer_name }}</span>
                                    <span class="badge bg-light text-muted border ms-1" style="font-size: 0.6rem;">
                                        {{ ucfirst($item->frequency) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge border border-primary text-primary small">
                                        {{ ucfirst(str_replace('_',' ',$item->kategori)) }}
                                    </span>
                                </td>

                                <td class="small text-muted">
                                    {{ $item->notes ?? '-' }}
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button class="btn btn-light btn-sm text-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('spiritual.destroy', $item->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-light btn-sm text-danger"
                                                onclick="return confirm('Hapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted small">
                                    Belum ada data ibadah.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL EDIT (diletakkan di luar tabel agar tidak merusak struktur HTML) ===== --}}
    @foreach($dataIbadah ?? [] as $item)
    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h6 class="modal-title fw-bold" id="modalEditLabel{{ $item->id }}">Edit Target</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('spiritual.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text"
                                name="prayer_name"
                                class="form-control form-control-sm"
                                value="{{ $item->prayer_name }}"
                                minlength="3"
                                maxlength="100"
                                required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold small">Jumlah Target</label>
                                <input type="number"
                                    name="target_count"
                                    class="form-control form-control-sm"
                                    value="{{ $item->target_count }}"
                                    min="1"
                                    max="1000">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small">Satuan</label>
                                <input type="text"
                                    name="target_unit"
                                    class="form-control form-control-sm"
                                    value="{{ $item->target_unit }}"
                                    maxlength="50">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Catatan</label>
                            <textarea name="notes"
                                rows="2"
                                class="form-control form-control-sm"
                                maxlength="500">{{ $item->notes }}</textarea>
                            <small class="text-muted">Maksimal 500 karakter</small>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm text-white"
                            style="background-color: #1a237e !important; border: none;">
                            <i class="bi bi-check-lg me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h6 class="modal-title fw-bold">Catat Target Ibadah</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('spiritual.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text"
                                name="prayer_name"
                                class="form-control form-control-sm @error('prayer_name') is-invalid @enderror"
                                placeholder="Contoh: Sedekah"
                                value="{{ old('prayer_name') }}"
                                minlength="3"
                                maxlength="100"
                                required>
                            @error('prayer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Tanggal <span class="text-danger">*</span></label>
                            <input type="date"
                                name="date"
                                class="form-control form-control-sm @error('date') is-invalid @enderror"
                                value="{{ old('date', date('Y-m-d')) }}"
                                min="{{ date('Y-m-d') }}"
                                required>
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Waktu <span class="text-danger">*</span></label>
                            <input type="time"
                                name="time"
                                class="form-control form-control-sm @error('time') is-invalid @enderror"
                                value="{{ old('time') }}"
                                required>
                            @error('time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold small">Jumlah Target</label>
                                <input type="number"
                                    name="target_count"
                                    class="form-control form-control-sm @error('target_count') is-invalid @enderror"
                                    placeholder="Contoh: 5"
                                    value="{{ old('target_count') }}"
                                    min="1"
                                    max="1000">
                                @error('target_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small">Satuan</label>
                                <input type="text"
                                    name="target_unit"
                                    class="form-control form-control-sm @error('target_unit') is-invalid @enderror"
                                    placeholder="Contoh: Ayat/Rakaat"
                                    value="{{ old('target_unit') }}"
                                    maxlength="50">
                                @error('target_unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori"
                                class="form-select form-select-sm @error('kategori') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="wajib" {{ old('kategori') == 'wajib' ? 'selected' : '' }}>Wajib</option>
                                <option value="sunnah" {{ old('kategori') == 'sunnah' ? 'selected' : '' }}>Sunnah</option>
                                <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Frekuensi <span class="text-danger">*</span></label>
                            <select name="frequency"
                                class="form-select form-select-sm @error('frequency') is-invalid @enderror"
                                required>
                                <option value="setiap hari" {{ old('frequency') == 'setiap hari' ? 'selected' : '' }}>Setiap Hari</option>
                                <option value="hanya sekali" {{ old('frequency') == 'hanya sekali' ? 'selected' : '' }}>Hanya Sekali</option>
                                <option value="mingguan" {{ old('frequency') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                            </select>
                            @error('frequency')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Catatan</label>
                            <textarea name="notes"
                                class="form-control form-control-sm @error('notes') is-invalid @enderror"
                                rows="2"
                                placeholder="Catatan tambahan (opsional)"
                                maxlength="500">{{ old('notes') }}</textarea>
                            <small class="text-muted">Maksimal 500 karakter</small>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer py-2">
                        <button type="button"
                            class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-sm text-white"
                            style="background-color: #1a237e !important; border: none;">
                            <i class="bi bi-check-lg me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--  Pilih Agama (First Time Only) -->
    @if($showModalAgama ?? false)
    <div class="modal fade" id="modalPilihAgama" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <i class="bi bi-book text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Selamat Datang di Spiritual Tracker</h4>
                    <p class="text-muted mb-4">Untuk memberikan pengalaman terbaik, silakan pilih agama Anda</p>

                    <form action="{{ route('spiritual.setAgama') }}" method="POST">
                        @csrf
                        <div class="d-grid gap-3">
                            <button type="submit" name="agama" value="Islam"
                                class="btn btn-lg btn-outline-primary py-3 fw-bold"
                                style="border-radius: 15px; border-width: 2px;">
                                Islam
                            </button>

                            <button type="submit" name="agama" value="Kristen"
                                class="btn btn-lg btn-outline-primary py-3 fw-bold"
                                style="border-radius: 15px; border-width: 2px;">
                                Kristen
                            </button>
                        </div>
                    </form>

                    <p class="text-muted small mt-4 mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Pengaturan ini hanya ditanyakan sekali
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk auto-show modal -->
    @if($showModalAgama ?? false)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalAgama = new bootstrap.Modal(document.getElementById('modalPilihAgama'));
            modalAgama.show();
        });
    </script>
    @endif

    <!-- Script untuk re-open modal jika ada error -->
    @if($errors->any() && old('_token'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
            modalTambah.show();
        });
    </script>
    @endif

    <!-- Script auto-hide alert -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000); // Auto close after 5 seconds
        });
    </script>

    <footer>
        &copy; 2025 Personal Assistant Mahasiswa Rantau - Kelompok 9 WAD
    </footer>
</body>

</html>