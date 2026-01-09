<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Personal Assistant Mahasiswa Rantau</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #1A237E;
            --bg-light: #f4f7fe;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            height: 100%;
            background: white;
        }

        .card-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
        }

        .alert-holiday {
            background-color: #ffebee;
            color: #c62828;
            border: none;
            border-radius: 10px;
        }

        .alert-warning-custom {
            background-color: #fff3e0;
            color: #e65100;
            border: none;
            border-radius: 10px;
        }

        .btn-recipe {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 8px;
        }

        .btn-recipe:hover {
            background-color: #c8e6c9;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        footer {
            padding: 2rem;
            color: #888;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>

    @include('layouts.navbar')

    <div class="container my-5">
        <div class="row g-4">

            @if($currentWeather)
            <div class="alert alert-danger" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <div class="d-flex align-items-center">
                    <span style="margin-right: 10px;">📅</span>
                    <strong>Hari ini: {{ \Carbon\Carbon::now()->format('d F Y') }} pukul {{ \Carbon\Carbon::now()->format('H:i') }} WIB</strong>
                    <span style="margin-left: 20px;">
                        ☁️ Kondisi: {{ $currentWeather['weather_desc'] }} ({{ $currentWeather['t'] }}°C)
                    </span>
                </div>
            </div>
            @endif

            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title mb-0">Manajemen Tugas</h3>
                        <a href="{{ route('tugas.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 0.75rem;">
                            Lihat Semua
                        </a>
                    </div>

                    <table class="table">
                        @forelse($tasks as $task)
                        <tr>
                            <td>{{ $task->task_name ?? $task->title }}</td>
                            <td class="text-end text-muted">
                                {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Tidak ada tugas mendesak.</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title mb-0">Agenda Outdoor</h3>
                        <a href="{{ route('agenda.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 0.75rem;">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                @forelse($agendas as $agenda)
                                <tr class="border-bottom last:border-0">
                                    <td class="ps-0 py-3">
                                        <div class="fw-bold text-dark mb-1">{{ $agenda->nama_kegiatan }}</div>
                                        <div class="text-muted small">
                                            <i class="bi bi-geo-alt-fill text-primary me-1"></i> {{ $agenda->lokasi_kota }}
                                            <span class="mx-1">•</span>
                                            <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('d M, H:i') }}
                                        </div>
                                    </td>
                                    <td class="text-end pe-0 py-3">
                                        @php
                                        $cuaca = strtolower($agenda->prediksi_cuaca);
                                        $isBad = str_contains($cuaca, 'hujan') || str_contains($cuaca, 'petir');
                                        @endphp

                                        @if($isBad)
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3 py-2">
                                            {{ $agenda->prediksi_cuaca }}
                                        </span>
                                        @else
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2">
                                            {{ $agenda->prediksi_cuaca }}
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center py-5 text-muted">
                                        <div class="mb-2"><i class="bi bi-calendar-x fs-3 opacity-50"></i></div>
                                        <small>Belum ada agenda mendatang.</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(isset($agendas) && $agendas->count() > 0)
                    @php $agendaPertama = $agendas->first(); @endphp
                    @if(str_contains(strtolower($agendaPertama->prediksi_cuaca), 'hujan') || str_contains(strtolower($agendaPertama->prediksi_cuaca), 'petir'))
                    <div class="alert alert-warning d-flex align-items-center mt-auto mb-0 rounded-3 border-0 shadow-sm p-3" style="background-color: #FFF3E0; color: #E65100;">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                        <div style="font-size: 0.85rem; line-height: 1.4;">
                            <strong>Waspada:</strong> Agenda terdekat diprediksi <u>{{ $agendaPertama->prediksi_cuaca }}</u>. Siapkan payung!
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title mb-0">Jadwal Ibadah</h3>
                        <a href="{{ route('spiritual.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 0.75rem;">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2" style="font-size: 0.8rem; text-transform: uppercase;">Jadwal / Renungan</h6>
                        <table class="table table-sm border-0">
                            @if(isset($dataSpiritual['type']) && $dataSpiritual['type'] == 'muslim')
                            <tr>
                                <td class="border-0">Subuh</td>
                                <td class="text-end fw-bold border-0">{{ $dataSpiritual['jadwal']['subuh'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border-0">Dzuhur</td>
                                <td class="text-end fw-bold border-0">{{ $dataSpiritual['jadwal']['dzuhur'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border-0">Ashar</td>
                                <td class="text-end fw-bold border-0">{{ $dataSpiritual['jadwal']['ashar'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border-0">Maghrib</td>
                                <td class="text-end fw-bold border-0">{{ $dataSpiritual['jadwal']['maghrib'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border-0">Isya</td>
                                <td class="text-end fw-bold border-0">{{ $dataSpiritual['jadwal']['isya'] ?? '-' }}</td>
                            </tr>
                            @elseif(isset($dataSpiritual['type']) && $dataSpiritual['type'] == 'kristen')
                            <tr>
                                <td colspan="2" class="fst-italic border-0 p-3 bg-light rounded">
                                    "{{ $dataSpiritual['ayat']['content'] }}" <br>
                                    <small class="fw-bold">— {{ $dataSpiritual['ayat']['book']['name'] }} {{ $dataSpiritual['ayat']['chapter'] }}</small>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="2" class="text-center text-muted">Data jadwal tidak tersedia.</td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    <hr>

                    <div>
                        <h6 class="text-muted mb-3" style="font-size: 0.8rem; text-transform: uppercase;">Target Ibadah Kamu</h6>
                        <div class="list-group list-group-flush">
                            @forelse($AktivitasIbadah as $item)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 mb-2">
                                <div class="d-flex align-items-start">
                                    <form action="{{ route('spiritual.update', $item->id) }}" method="POST" class="me-3">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="{{ $item->status == 'pending' ? 'terlaksana' : 'pending' }}">
                                        <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer; line-height: 1;">
                                            @if($item->status == 'terlaksana')
                                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                            @else
                                            <i class="bi bi-circle text-muted fs-5"></i>
                                            @endif
                                        </button>
                                    </form>

                                    <div>
                                        <p class="mb-0 fw-bold {{ $item->status == 'terlaksana' ? 'text-decoration-line-through text-muted' : 'text-dark' }}" style="font-size: 1.1rem;">
                                            {{ $item->prayer_name }}
                                        </p>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}
                                        </small>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <span class="badge rounded-pill px-3 py-2" style="background-color: #00d4ff; color: black; font-weight: bold;">
                                        {{ \Carbon\Carbon::parse($item->time)->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-muted small my-3">Belum ada target khusus hari ini.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title mb-0">Meal Plan</h3>
                        <a href="{{ route('mealplan.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 0.75rem;">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <tbody>
                                @forelse($meals as $meal)
                                <tr>
                                <tr>
                                    <td>
                                        <div style="width: 120px;" class="fw-bold text-dark">
                                            {{ \Carbon\Carbon::parse($meal->planned_date)->format('d M Y') }}
                                        </div>
                                    </td>

                                    <td>
                                        <div style="width: 100px;" class="text-muted text-center">{{ $meal->meal_time }}</div>
                                    </td>
                                    <td>
                                        <div class="flex-grow-1 ps-4 fw-medium text-dark">{{ $meal->recipe_name }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Belum ada rencana makan hari ini.
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

    <footer class="text-center">
        &copy; 2025 Personal Assistant Mahasiswa Rantau - Kelompok 9 WAD
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>