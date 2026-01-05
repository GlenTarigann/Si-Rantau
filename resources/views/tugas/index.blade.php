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
        body { 
            background-color: #f8f9fa; 
            font-family: 'Poppins', sans-serif; 
        }
       
        .alert-holiday {
            background-color: #f8d7da;
            border: 1px solid #f1aeae;
            border-radius: 10px;
            color: #2d3436;
            font-weight: 500;
        }

        .card { border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }
        .form-label { font-weight: 600; font-size: 0.8rem; margin-bottom: 0.4rem; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #d1d5db; padding: 0.5rem 0.8rem; font-size: 0.85rem; }
        
        .table-container { border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background: white; }
        .table thead th { font-size: 0.7rem; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; padding: 12px; border-bottom: 1px solid #dee2e6; }
        .table tbody td { border-bottom: 1px solid #f0f0f0; }
        .table-danger { background-color: #fee2e2 !important; }
        .btn-primary { background-color: #1e3a8a; border: none; font-weight: 500; }
        .btn-dark { background-color: #1f2937; border: none; }

        .modal-content { border-radius: 12px; border: none; }
        .modal-header { border-bottom: 1px solid #e5e7eb; }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <div class="container-fluid px-5 py-4">
        
        <div class="alert alert-holiday d-flex align-items-center mb-4 shadow-sm p-3">
            <i class="bi bi-calendar-event me-3 fs-4"></i>
            <div>
                @php
                    \Carbon\Carbon::setLocale('id');
                    $now = \Carbon\Carbon::now('Asia/Jakarta');
                @endphp
                <span>Hari libur: <strong>{{ $now->translatedFormat('d F Y') }}</strong> pukul <strong>{{ $now->format('H:i') }} WIB</strong></span>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-body p-4">
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

        <div class="table-container shadow-sm">
            <div class="px-4 py-3 border-bottom bg-white">
                <h6 class="fw-bold mb-0">Daftar Tugas</h6>
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