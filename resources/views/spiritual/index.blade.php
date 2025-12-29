@extends('layouts.app')

@section('content')
<style>
    .table-scroll::-webkit-scrollbar { width: 6px; }
    .table-scroll::-webkit-scrollbar-thumb { background-color: #ccc; border-radius: 4px; }

    .widget-sholat span { font-size: 0.85rem; font-weight: 600; }
    .widget-sholat h4 { font-size: 1.25rem; }
</style>

<div class="container py-4">

    <div class="row align-items-center mb-4">
        <div class="col-6">
            <h4 class="fw-bold mb-1" style="color: var(--primary-blue);">Spiritual Tracker</h4>
            <p class="text-muted mb-0 small">Jaga keseimbangan duniamu dengan ibadah.</p>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('spiritual.cetak') }}" target="_blank" class="btn btn-danger btn-sm me-1">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
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
                “{{ $dataSpiritual['ayat']['content'] }}”
            </p>

            <small class="opacity-75">
                {{ $dataSpiritual['ayat']['book']['name'] }}
                {{ $dataSpiritual['ayat']['chapter'] }}:{{ $dataSpiritual['ayat']['verses'][0]['verse'] }}
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
                        <th>Target</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataIbadah as $item)
                    <tr>
                        {{-- STATUS --}}
                        <td class="ps-4">
                            <form action="{{ route('spiritual.update', $item->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" name="status"
                                        value="{{ $item->status == 'pending' ? 'terlaksana' : 'pending' }}"
                                        class="btn {{ $item->status == 'pending' ? 'btn-outline-secondary' : 'btn-success' }}
                                               btn-sm rounded-circle"
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
                                <form action="{{ route('spiritual.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-light btn-sm text-danger"
                                            onclick="return confirm('Hapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light py-2">
                                    <h6 class="modal-title fw-bold">Edit Target</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('spiritual.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <input type="text" name="prayer_name"
                                               class="form-control form-control-sm mb-2"
                                               value="{{ $item->prayer_name }}">

                                        <div class="row g-2 mb-2">
                                            <div class="col-6">
                                                <input type="number" name="target_count"
                                                       class="form-control form-control-sm"
                                                       value="{{ $item->target_count }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target_unit"
                                                       class="form-control form-control-sm"
                                                       value="{{ $item->target_unit }}">
                                            </div>
                                        </div>

                                        <textarea name="notes" rows="2"
                                                  class="form-control form-control-sm">{{ $item->notes }}</textarea>
                                    </div>
                                    <div class="modal-footer py-2">
                                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button class="btn btn-primary btn-sm">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                    <input type="text"
                           name="prayer_name"
                           class="form-control form-control-sm mb-2"
                           placeholder="Nama kegiatan"
                           required>

                    <input type="date"
                           name="date"
                           class="form-control form-control-sm mb-2"
                           value="{{ date('Y-m-d') }}"
                           required>

                    <input type="time"
                           name="time"
                           class="form-control form-control-sm mb-2"
                           required>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <input type="number"
                                name="target_count"
                                class="form-control form-control-sm"
                                placeholder="Jumlah (opsional)">
                        </div>
                        <div class="col-6">
                            <input type="text"
                                name="target_unit"
                                class="form-control form-control-sm"
                                placeholder="Satuan (opsional)">
                        </div>
                    </div>

                    <select name="kategori" class="form-select form-select-sm mb-2" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="wajib">Wajib</option>
                        <option value="sunnah">Sunnah</option>
                        <option value="lainnya">Lainnya</option>
                    </select>

                    <select name="frequency" class="form-select form-select-sm mb-2" required>
                        <option value="setiap hari">Setiap Hari</option>
                        <option value="hanya sekali">Hanya Sekali</option>
                        <option value="mingguan">Mingguan</option>
                    </select>

                    <textarea name="notes"
                              class="form-control form-control-sm"
                              rows="2"
                              placeholder="Catatan (opsional)"></textarea>
                </div>

                <div class="modal-footer py-2">
                    <button type="button"
                            class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-primary btn-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
