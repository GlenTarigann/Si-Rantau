@extends('layouts.app')

@section('content')
<div class="container-fluid px-5">

    <div class="alert alert-holiday d-flex align-items-center mb-4 shadow-sm">
        <i class="bi bi-calendar-event me-3 fs-4"></i>
        <div>
            <span class="text-holiday">
                @php
                    \Carbon\Carbon::setLocale('id');
                    $dt = \Carbon\Carbon::parse($currentTime);
                @endphp
                
                Hari libur: 
                <strong>{{ $dt->translatedFormat('d F Y') }}</strong> 
                pukul 
                <strong>{{ $dt->format('H:i') }} WIB</strong>

                @if($dt->format('m-d') == '12-25')
                    <span class="badge bg-danger ms-2">Hari Natal</span>
                @endif
            </span>
        </div>
    </div>

    <div class="card shadow-sm rounded-4 border-0 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-4">Form Input Tugas</h6>

            <form action="{{ route('tugas.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="small fw-bold">Nama Tugas</label>
                        <input type="text" name="task_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold">Kategori</label>
                        <select name="task_category" class="form-select" required>
                            <option value="">Pilih...</option>
                            <option value="Akademik">Akademik</option>
                            <option value="Organisasi">Organisasi</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold">Waktu Deadline</label>
                        <input type="datetime-local" name="deadline" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold">Status</label>
                        <select name="progres_status" class="form-select" required>
                            <option value="">Pilih...</option>
                            <option value="Belum Selesai">Belum Selesai</option>
                            <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="small fw-bold">Catatan (Optional)</label>
                        <textarea name="catatan" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">Tambah Tugas</button>
                    <a href="{{ route('tugas.export') }}" class="btn btn-dark px-4 fw-bold shadow-sm" target="_blank">
                        <i class="bi bi-printer me-2"></i>Cetak Rekapitulasi
                    </a>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body p-0">
            <h6 class="fw-bold px-4 pt-4 pb-3 mb-0">Daftar Tugas</h6>
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light text-center small">
                        <tr>
                            <th>ID</th>
                            <th>Nama Tugas</th>
                            <th>Kategori</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($tasks as $task)
                        <tr class="{{ $task->progres_status == 'Belum Selesai' ? 'table-danger' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">{{ $task->task_name }}</td>
                            <td>{{ $task->task_category }}</td>
                            <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y H:i') }}</td>
                            <td>{{ $task->progres_status }}</td>
                            <td class="small text-muted text-start">{{ $task->catatan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('tugas.edit', $task->id) }}" class="btn btn-sm text-primary">
                                    <i class="bi bi-pencil-square"></i></a>
                                
                                <form action="{{ route('tugas.destroy', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-danger border-0 bg-transparent" onclick="return confirm('Hapus tugas?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-4 text-muted">Belum ada tugas. Tetap produktif!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection