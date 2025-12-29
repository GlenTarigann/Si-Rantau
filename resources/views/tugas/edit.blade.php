@extends('layouts.app')

@section('content')
<div class="container-fluid px-5">
    <div class="card shadow-sm rounded-4 border-0 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-4">Edit Tugas</h6>

            <form action="{{ route('tugas.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="small fw-bold">Nama Tugas</label>
                        <input type="text" name="task_name" class="form-control" value="{{ $task->task_name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold">Kategori</label>
                        <select name="task_category" class="form-select" required>
                            <option value="Akademik" {{ $task->task_category == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="Organisasi" {{ $task->task_category == 'Organisasi' ? 'selected' : '' }}>Organisasi</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold">Waktu Deadline</label>
                        <input type="datetime-local" name="deadline" class="form-control" 
                               value="{{ date('Y-m-d\TH:i', strtotime($task->deadline)) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold">Status</label>
                        <select name="progres_status" class="form-select" required>
                            <option value="Belum Selesai" {{ $task->progres_status == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                            <option value="Sedang Dikerjakan" {{ $task->progres_status == 'Sedang Dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                            <option value="Selesai" {{ $task->progres_status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="small fw-bold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ $task->catatan }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">Perbarui Tugas</button>
                    <a href="{{ route('tugas.index') }}" class="btn btn-light px-4">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection