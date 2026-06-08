<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tugas - Personal Assistant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        .alert-holiday {
            background-color: #f8d7da;
            border: 1px solid #f1aeae;
            border-radius: 10px;
            color: #2d3436;
            font-weight: 500;
        }

        .section-card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .section-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
        }

        .section-card-header h5 {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .section-card-body { padding: 1.5rem; }

        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: .4rem;
        }

        .form-control,
        .form-select {
            border-radius: var(--radius-sm);
            padding: 0.65rem 1rem;
            border: 1.5px solid var(--border);
            background-color: #fafbff;
            font-size: 0.88rem;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,35,126,0.10);
            background: #fff;
        }

        .table-container {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            background: var(--surface);
            box-shadow: var(--shadow-sm);
        }

        .table thead th {
            background: #f8f9ff;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 2px solid var(--border);
            padding: 0.85rem 1rem;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 0.9rem 1rem;
            border-bottom: 1px solid var(--border);
        }

        .table-danger {
            background-color: #fee2e2 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-mid) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 14px rgba(26,35,126,0.3);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26,35,126,0.35);
            color: white;
        }

        .btn-dark {
            background: linear-gradient(135deg, var(--accent) 0%, #E65100 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 3px 10px rgba(245,127,23,0.3);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-dark:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245,127,23,0.4);
            color: white;
        }

        .modal-content {
            border-radius: var(--radius);
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid var(--border);
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
                        <i class="bi bi-list-task me-2"></i>Manajemen Tugas
                    </h1>
                    <p class="hero-subtitle">Kelola tugas kuliah dan organisasimu dengan mudah</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-5" style="margin-top: -2rem; position: relative; z-index: 10;">

        @php
            $sisa = $closestTask ? \Carbon\Carbon::parse($closestTask->deadline)->diffInDays(\Carbon\Carbon::now('Asia/Jakarta')) : null;
            $isUrgent = $sisa !== null && $sisa <= 2;
        @endphp

        <div class="alert alert-holiday d-flex align-items-center mb-4 shadow-sm p-3 {{ $isUrgent ? 'border-danger border-2' : '' }}" style="{{ $isUrgent ? 'background-color: #fee2e2; border-color: #ef4444 !important;' : '' }}">
            <i class="bi {{ $closestTask ? ($isUrgent ? 'bi-alarm-fill text-danger' : 'bi-bell-fill text-warning') : 'bi-check-circle-fill text-success' }} me-3 fs-4"></i>
            <div>
                @if($closestTask)
                    @if($isUrgent)
                        <strong class="text-danger">⚠️ Deadline Mendekat!</strong>
                    @else
                        <strong>🔔 Pengingat Tugas Terdekat:</strong>
                    @endif
                    <strong>{{ $closestTask->task_name }}</strong> —
                    Batas Waktu:
                    <strong>{{ \Carbon\Carbon::parse($closestTask->deadline)->translatedFormat('d F Y') }}</strong>
                    pukul <strong>{{ \Carbon\Carbon::parse($closestTask->deadline)->format('H:i') }} WIB</strong>
                    @if($isUrgent)
                        <span class="badge bg-danger ms-2">{{ $sisa == 0 ? 'Hari ini!' : ($sisa == 1 ? 'Besok!' : $sisa . ' hari lagi') }}</span>
                    @endif
                @else
                    <strong class="text-success">✅ Semua tugas aktif sudah selesai atau tidak ada deadline yang mendekat. Tetap produktif!</strong>
                @endif
            </div>
        </div>

        <div class="section-card mb-4">
            <div class="section-card-header">
                <h6 class="fw-bold mb-4">Form Input Tugas</h6>
                <form action="{{ route('tugas.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Tugas</label>
                            <input type="text" name="task_name" class="form-control" placeholder="Masukkan nama tugas" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="task_category" class="form-select" required>
                                <option value="">Pilih...</option>
                                <option value="Akademik">Akademik</option>
                                <option value="Organisasi">Organisasi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="progres_status" class="form-select" required>
                                <option value="">Pilih...</option>
                                <option value="Belum Selesai">Belum Selesai</option>
                                <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Catatan (Optional)</label>
                            <textarea name="catatan" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">Tambah Tugas</button>
                        <a href="{{ route('tugas.export') }}" class="btn btn-dark px-4 fw-bold shadow-sm">
                            <i class="bi bi-printer me-2"></i>Cetak Rekapitulasi
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-container shadow-sm mb-5">
            <div class="section-card-header bg-white">
                <h5 class="mb-0">
                    <span class="header-icon"><i class="bi bi-list-check" style="background: var(--primary-light); color: var(--primary); padding: 5px; border-radius: 5px;"></i></span>
                    Daftar Tugas
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Nama Tugas</th>
                            <th>Kategori</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr class="text-center {{ $task->progres_status == 'Belum Selesai' ? 'table-danger' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start ps-3">{{ $task->task_name }}</td>
                            <td>{{ $task->task_category }}</td>
                            <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y H:i') }}</td>
                            <td>{{ $task->progres_status }}</td>
                            <td class="text-start small px-3 text-muted">{{ $task->catatan ?? '-' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-3">

                                    <button type="button" class="border-0 bg-transparent text-primary p-0 fs-5"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $task->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>


                                    <form action="{{ route('tugas.destroy', $task->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent text-danger p-0 fs-5" onclick="return confirm('Hapus tugas ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal{{ $task->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $task->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="editModalLabel{{ $task->id }}">Edit Tugas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('tugas.update', $task->id) }}" method="POST" id="editForm{{ $task->id }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nama Tugas</label>
                                                    <input type="text" name="task_name" class="form-control" value="{{ $task->task_name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kategori</label>
                                                    <select name="task_category" class="form-select" required>
                                                        <option value="Akademik" {{ $task->task_category == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                                        <option value="Organisasi" {{ $task->task_category == 'Organisasi' ? 'selected' : '' }}>Organisasi</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Waktu Deadline</label>
                                                    <input type="datetime-local" name="deadline" class="form-control"
                                                        value="{{ date('Y-m-d\TH:i', strtotime($task->deadline)) }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Status</label>
                                                    <select name="progres_status" class="form-select" required>
                                                        <option value="Belum Selesai" {{ $task->progres_status == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                                                        <option value="Sedang Dikerjakan" {{ $task->progres_status == 'Sedang Dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                                        <option value="Selesai" {{ $task->progres_status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Catatan (Optional)</label>
                                                    <textarea name="catatan" class="form-control" rows="3">{{ $task->catatan }}</textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" form="editForm{{ $task->id }}" class="btn btn-primary">Perbarui Tugas</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada tugas. Tetap produktif!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>