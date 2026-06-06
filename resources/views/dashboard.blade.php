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
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
        }

        /* ======= HERO BANNER ======= */
        .hero-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-mid) 60%, #3949AB 100%);
            border-radius: var(--radius);
            padding: 2rem 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(26, 35, 126, 0.25);
            margin-bottom: 2rem;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            bottom: -40px;
            right: 120px;
            width: 140px;
            height: 140px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .hero-greeting {
            font-size: 0.85rem;
            font-weight: 400;
            opacity: 0.8;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .hero-name {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            line-height: 1.2;
        }

        .hero-date {
            font-size: 0.9rem;
            opacity: 0.75;
            font-weight: 400;
        }

        .hero-stats {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-stat-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: 1rem 1.4rem;
            flex: 1;
            min-width: 120px;
            text-align: center;
            transition: background 0.2s;
        }

        .hero-stat-card:hover {
            background: rgba(255,255,255,0.18);
        }

        .hero-stat-card .stat-icon {
            font-size: 1.6rem;
            margin-bottom: 0.3rem;
            display: block;
        }

        .hero-stat-card .stat-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
            line-height: 1;
            margin-bottom: 0.15rem;
        }

        .hero-stat-card .stat-label {
            font-size: 0.7rem;
            opacity: 0.75;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .weather-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 50px;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.75rem;
        }

        .weather-temp {
            font-size: 1rem;
            font-weight: 700;
        }

        /* ======= INTERACTIVE CLOCK ======= */
        .interactive-clock {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--radius);
            padding: 1.5rem 2.5rem;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease, background 0.4s ease;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .interactive-clock:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .clock-time {
            font-family: 'Courier New', monospace;
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            letter-spacing: 3px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.3);
            margin-bottom: 0.5rem;
        }

        .clock-date-info {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ======= CARDS ======= */
        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            height: 100%;
            background: var(--surface);
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

        /* Pulse animation for weather icon */
        @keyframes pulse-soft {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }
        .weather-icon-anim {
            animation: pulse-soft 3s ease-in-out infinite;
            display: inline-block;
        }
    </style>
</head>

<body>

    @include('layouts.navbar')

    <div class="container my-4">

        {{-- ===== HERO BANNER ===== --}}
        <div class="hero-banner">
            <div class="row align-items-center g-3">

                {{-- Kiri: Sapaan & Tanggal --}}
                <div class="col-md-5">
                    <p class="hero-greeting">Selamat datang kembali 👋</p>
                    <h2 class="hero-name">{{ Auth::user()->name }}</h2>
                    
                    <div class="interactive-clock" id="dashboard-clock">
                        <div class="clock-time" id="clock-time-display">{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i:s') }}</div>
                        <div class="clock-date-info">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}
                            &nbsp;|&nbsp; WIB
                        </div>
                    </div>

                    @if($currentWeather)
                    @php
                        $desc = strtolower($currentWeather['weather_desc'] ?? '');
                        $weatherEmoji = '☀️';
                        if (str_contains($desc, 'hujan lebat') || str_contains($desc, 'petir')) $weatherEmoji = '⛈️';
                        elseif (str_contains($desc, 'hujan')) $weatherEmoji = '🌧️';
                        elseif (str_contains($desc, 'mendung') || str_contains($desc, 'berawan')) $weatherEmoji = '☁️';
                        elseif (str_contains($desc, 'kabut')) $weatherEmoji = '🌫️';
                        elseif (str_contains($desc, 'cerah berawan')) $weatherEmoji = '⛅';
                    @endphp
                    <div class="weather-badge">
                        <span class="weather-icon-anim">{{ $weatherEmoji }}</span>
                        <span>{{ $currentWeather['weather_desc'] }}</span>
                        <span class="weather-temp">{{ $currentWeather['t'] }}°C</span>
                        <span style="opacity:0.6;">·</span>
                        <span style="font-size:0.75rem; opacity:0.8;">Bandung</span>
                    </div>
                    @endif
                </div>

                {{-- Kanan: Stat Cards --}}
                <div class="col-md-7">
                    <div class="hero-stats">
                        <div class="hero-stat-card">
                            <span class="stat-icon">📋</span>
                            <div class="stat-value">{{ $tasks->count() }}</div>
                            <div class="stat-label">Tugas Aktif</div>
                        </div>
                        <div class="hero-stat-card">
                            <span class="stat-icon">🏕️</span>
                            <div class="stat-value">{{ $agendas->count() }}</div>
                            <div class="stat-label">Agenda Outdoor</div>
                        </div>
                        <div class="hero-stat-card">
                            <span class="stat-icon">🍽️</span>
                            <div class="stat-value">{{ $meals->count() }}</div>
                            <div class="stat-label">Meal Plan</div>
                        </div>
                        <div class="hero-stat-card">
                            <span class="stat-icon">🙏</span>
                            <div class="stat-value">{{ $AktivitasIbadah->count() }}</div>
                            <div class="stat-label">Target Ibadah</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- ===== END HERO BANNER ===== --}}

        <div class="row g-4">

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
                                <tr class="border-bottom">
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
                    <div class="alert alert-warning d-flex align-items-center mt-3 mb-0 rounded-3 border-0 shadow-sm p-3" style="background-color: #FFF3E0; color: #E65100;">
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
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            
            const clockDisplay = document.getElementById('clock-time-display');
            if(clockDisplay) {
                clockDisplay.textContent = timeString;
            }
        }
        
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>

</html>