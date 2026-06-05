<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Outdoor - Personal Assistant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* ===== DESIGN SYSTEM =====
         * Triangle Color Rule dari #1A237E (Primary Blue)
         * Primary   : #1A237E  (biru tua)
         * Analogous : #283593  (biru medium)
         * Accent    : #F57F17  (amber — 120° triadic)
         * Complement: #7E1A1A  (merah marun — 180°, digunakan sangat tipis)
         * Neutral BG: #f4f7fe
         */
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

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: var(--text-main);
        }

        .main-container { flex: 1; }

        /* ===== HERO HEADER STRIP ===== */
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

        /* ===== CLOCK WIDGET ===== */
        .clock-widget {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(8px);
            border-radius: 14px;
            padding: 0.75rem 1.25rem;
            text-align: right;
        }
        #digital-clock {
            font-family: 'Courier New', monospace;
            font-size: 1.7rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 2px;
            line-height: 1;
        }
        .clock-date {
            color: rgba(255,255,255,0.75);
            font-size: 0.78rem;
            margin-top: 2px;
        }

        /* ===== WEATHER CHIP ===== */
        .weather-chip {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(8px);
            border-radius: 50px;
            padding: 0.5rem 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #fff;
        }
        .weather-chip img { filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); }
        .weather-chip .temp { font-size: 1.1rem; font-weight: 700; }
        .weather-chip .desc { font-size: 0.8rem; opacity: 0.85; }

        /* ===== STATS STRIP ===== */
        .stats-strip {
            margin-top: -2rem;
            position: relative;
            z-index: 10;
        }
        .stat-card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            padding: 1.1rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid var(--border);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .stat-icon.blue  { background: var(--primary-light); color: var(--primary); }
        .stat-icon.amber { background: var(--accent-light);  color: var(--accent); }
        .stat-icon.teal  { background: var(--teal-light);    color: var(--teal); }
        .stat-label { font-size: 0.72rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase; letter-spacing: .5px; }
        .stat-value { font-size: 1.4rem; font-weight: 700; color: var(--text-main); line-height: 1.1; }

        /* ===== CARD ===== */
        .section-card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            overflow: hidden;
            height: 100%;
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
        .section-card-header h5 .header-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.95rem;
        }
        .section-card-body { padding: 1.5rem; }

        /* ===== FORM ELEMENTS ===== */
        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: .4rem;
        }
        .form-control, .form-select {
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
        .input-group-text {
            border-radius: var(--radius-sm) 0 0 var(--radius-sm) !important;
            border: 1.5px solid var(--border);
            background: var(--primary-light);
            color: var(--primary);
            border-right: none;
        }
        .input-group .form-control {
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0 !important;
        }
        .is-invalid { border-color: var(--danger) !important; }
        .invalid-feedback { font-size: 0.75rem; color: var(--danger); font-weight: 500; }

        /* ===== BUTTONS ===== */
        .btn-save {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-mid) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            width: 100%;
            transition: transform .2s, box-shadow .2s, opacity .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            box-shadow: 0 4px 14px rgba(26,35,126,0.3);
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26,35,126,0.35);
            color: white;
        }
        .btn-save:active { transform: translateY(0); }

        .btn-export {
            background: linear-gradient(135deg, var(--accent) 0%, #E65100 100%);
            color: white;
            border: none;
            padding: 0.45rem 1rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            text-decoration: none;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 3px 10px rgba(245,127,23,0.3);
        }
        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245,127,23,0.4);
            color: white;
        }

        /* ===== INFO BOX ===== */
        .info-box {
            background: var(--primary-light);
            border-left: 3px solid var(--primary);
            border-radius: 8px;
            padding: .75rem 1rem;
            font-size: 0.8rem;
            color: var(--primary);
            display: flex;
            align-items: flex-start;
            gap: .5rem;
            margin-bottom: 1.25rem;
        }

        /* ===== TABLE ===== */
        .table {
            font-size: 0.865rem;
            margin: 0;
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
        .table tbody tr {
            transition: background .15s;
        }
        .table tbody tr:hover { background: #f8f9ff; }
        .table td {
            vertical-align: middle;
            padding: 0.9rem 1rem;
            border-bottom: 1px solid var(--border);
        }
        .table tbody tr:last-child td { border-bottom: none; }

        /* ===== BADGES ===== */
        .badge-weather-bad {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: #FFEBEE;
            color: #C62828;
            border: 1px solid #FFCDD2;
            border-radius: 50px;
            padding: .3rem .75rem;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .badge-weather-good {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: var(--teal-light);
            color: var(--teal);
            border: 1px solid #B2DFDB;
            border-radius: 50px;
            padding: .3rem .75rem;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .badge-location {
            display: inline-flex;
            align-items: center;
            gap: .25rem;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 50px;
            padding: .2rem .6rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* ===== ACTION BUTTONS IN TABLE ===== */
        .btn-tbl-edit {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            border: none;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
            text-decoration: none;
            transition: background .2s, transform .2s;
        }
        .btn-tbl-edit:hover { background: var(--primary); color: #fff; transform: scale(1.1); }

        .btn-tbl-del {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: #FFEBEE;
            color: var(--danger);
            border: none;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background .2s, transform .2s;
        }
        .btn-tbl-del:hover { background: var(--danger); color: #fff; transform: scale(1.1); }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        .empty-state-icon {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: var(--primary-light);
            color: var(--primary);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .empty-state h6 { font-weight: 700; color: var(--text-main); margin-bottom: .4rem; }
        .empty-state p { font-size: 0.83rem; color: var(--text-muted); margin: 0; }

        /* ===== ALERTS ===== */
        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            font-size: 0.88rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.25rem;
        }
        .alert-custom.success { background: #E8F5E9; color: #2E7D32; }
        .alert-custom.warning { background: var(--accent-light); color: #BF360C; }
        .alert-custom .alert-icon { font-size: 1.25rem; flex-shrink: 0; }

        /* ===== DIVIDER ===== */
        .form-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.25rem 0;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 500;
        }
        .form-divider::before, .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ===== FOOTER ===== */
        footer {
            padding: 1.5rem;
            color: var(--text-muted);
            font-size: 0.8rem;
            text-align: center;
            border-top: 1px solid var(--border);
            margin-top: 2rem;
            background: var(--surface);
        }

        /* ===== UTILITY ===== */
        .text-primary-app { color: var(--primary) !important; }
        .fw-name { font-weight: 600; color: var(--text-main); }
        .time-small { font-size: 0.78rem; color: var(--text-muted); }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .45s ease both; }
        .delay-1 { animation-delay: .08s; }
        .delay-2 { animation-delay: .16s; }
        .delay-3 { animation-delay: .24s; }

        /* ===== CASCADING DROPDOWN ===== */
        .wilayah-step {
            position: relative;
        }
        .wilayah-step .form-select:disabled {
            background-color: #f0f2f8;
            cursor: not-allowed;
            opacity: 0.65;
        }
        .loading-select {
            position: relative;
        }
        .loading-select::after {
            content: '';
            position: absolute;
            right: 2.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            border: 2px solid var(--primary-light);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin .6s linear infinite;
            pointer-events: none;
        }
        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }
        .location-preview {
            background: var(--primary-light);
            border: 1px dashed var(--primary);
            border-radius: 8px;
            padding: .6rem .9rem;
            font-size: 0.8rem;
            color: var(--primary);
            margin-top: .5rem;
            display: none;
        }
        .location-preview.show { display: flex; align-items: center; gap: .4rem; }
        .step-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px; height: 20px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            margin-right: 4px;
            flex-shrink: 0;
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
                        <i class="bi bi-calendar-week me-2"></i>Agenda Outdoor
                    </h1>
                    <p class="hero-subtitle">Pantau kegiatan dan cuaca real-time</p>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap fade-up delay-1">
                    {{-- Weather --}}
                    @if(isset($currentWeather))
                        <div class="weather-chip">
                            <img src="{{ $currentWeather['image'] }}" alt="cuaca" width="36" height="36">
                            <div>
                                <div class="desc">{{ $currentWeather['weather_desc'] }}</div>
                                <div class="temp">{{ $currentWeather['t'] }}°C</div>
                            </div>
                        </div>
                    @else
                        <div class="weather-chip">
                            <i class="bi bi-cloud-slash fs-5"></i>
                            <div class="desc">Data Offline</div>
                        </div>
                    @endif

                    {{-- Clock --}}
                    <div class="clock-widget">
                        <div id="digital-clock">{{ date('H:i:s') }}</div>
                        <div class="clock-date">
                            {{ date('d M Y') }} &nbsp;|&nbsp; WIB
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-container" style="padding-top: 0; padding-bottom: 2rem;">

        {{-- ===== STATS STRIP ===== --}}
        @php
            $totalAgenda = $agendas->count();
            $amanCount   = $agendas->filter(fn($a) => !str_contains(strtolower($a->prediksi_cuaca), 'hujan') && !str_contains(strtolower($a->prediksi_cuaca), 'petir'))->count();
            $risikoCount = $totalAgenda - $amanCount;
        @endphp
        <div class="stats-strip mb-4">
            <div class="row g-3">
                <div class="col-md-4 fade-up delay-1">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <div class="stat-label">Total Rencana</div>
                            <div class="stat-value">{{ $totalAgenda }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 fade-up delay-2">
                    <div class="stat-card">
                        <div class="stat-icon teal">
                            <i class="bi bi-sun"></i>
                        </div>
                        <div>
                            <div class="stat-label">Cuaca Aman</div>
                            <div class="stat-value">{{ $amanCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 fade-up delay-3">
                    <div class="stat-card">
                        <div class="stat-icon amber">
                            <i class="bi bi-cloud-lightning-rain"></i>
                        </div>
                        <div>
                            <div class="stat-label">Risiko Cuaca</div>
                            <div class="stat-value">{{ $risikoCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== ALERTS ===== --}}
        @if(session('warning'))
            <div class="alert-custom warning fade-up">
                <span class="alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></span>
                <div>{{ session('warning') }}</div>
            </div>
        @elseif(session('success'))
            <div class="alert-custom success fade-up">
                <span class="alert-icon"><i class="bi bi-check-circle-fill"></i></span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- ===== MAIN GRID ===== --}}
        <div class="row g-4 align-items-start">

            {{-- ========== FORM PANEL ========== --}}
            <div class="col-lg-4">
                <div class="section-card fade-up delay-1">
                    <div class="section-card-header">
                        <h5>
                            <span class="header-icon"><i class="bi bi-plus-lg"></i></span>
                            Input Rencana
                        </h5>
                    </div>
                    <div class="section-card-body">

                        <div class="info-box">
                            <i class="bi bi-info-circle-fill mt-1 flex-shrink-0"></i>
                            <span>Prediksi cuaca akan otomatis ditampilkan berdasarkan lokasi &amp; waktu yang dipilih.</span>
                        </div>

                        <form action="{{ route('agenda.store') }}" method="POST">
                            @csrf

                            {{-- Nama Kegiatan --}}
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

                            {{-- Lokasi: Cascading Dropdown 4 level --}}
                            {{-- Hidden fields yang akan dikirim ke server --}}
                            <input type="hidden" name="adm4_code"    id="adm4_code">
                            <input type="hidden" name="lokasi_label" id="lokasi_label">

                            <div class="mb-2 wilayah-step">
                                <label class="form-label">
                                    <span class="step-badge">1</span> Provinsi
                                </label>
                                <select id="sel-provinsi" class="form-select @error('adm4_code') is-invalid @enderror">
                                    <option value="">-- Memuat daftar provinsi... --</option>
                                </select>
                            </div>

                            <div class="mb-2 wilayah-step">
                                <label class="form-label">
                                    <span class="step-badge">2</span> Kabupaten / Kota
                                </label>
                                <select id="sel-kabupaten" class="form-select" disabled>
                                    <option value="">-- Pilih provinsi dulu --</option>
                                </select>
                            </div>

                            <div class="mb-2 wilayah-step">
                                <label class="form-label">
                                    <span class="step-badge">3</span> Kecamatan
                                </label>
                                <select id="sel-kecamatan" class="form-select" disabled>
                                    <option value="">-- Pilih kab/kota dulu --</option>
                                </select>
                            </div>

                            <div class="mb-3 wilayah-step">
                                <label class="form-label">
                                    <span class="step-badge">4</span> Kelurahan / Desa
                                </label>
                                <select id="sel-kelurahan" class="form-select" disabled>
                                    <option value="">-- Pilih kecamatan dulu --</option>
                                </select>
                                @error('adm4_code')
                                    <div class="invalid-feedback d-block">Lokasi wajib dipilih hingga kelurahan/desa.</div>
                                @enderror

                                {{-- Preview lokasi terpilih --}}
                                <div class="location-preview" id="location-preview">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span id="location-preview-text"></span>
                                </div>
                            </div>

                            {{-- Waktu --}}
                            <div class="mb-4">
                                <label class="form-label">
                                    Waktu &nbsp;<span style="font-size:.7rem;font-weight:400;color:var(--text-muted);text-transform:none;letter-spacing:0;">WIB</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    <input type="text" name="waktu_mulai" id="waktu_picker"
                                           class="form-control @error('waktu_mulai') is-invalid @enderror"
                                           placeholder="Pilih Tanggal &amp; Jam...">
                                </div>
                                @error('waktu_mulai')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn-save">
                                <i class="bi bi-save2-fill"></i> Simpan Rencana
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ========== TABLE PANEL ========== --}}
            <div class="col-lg-8">
                <div class="section-card fade-up delay-2">
                    <div class="section-card-header">
                        <h5>
                            <span class="header-icon"><i class="bi bi-list-check"></i></span>
                            Daftar Rencana Kegiatan
                        </h5>
                        <a href="{{ route('agenda.cetak') }}" target="_blank" class="btn-export">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width:30%">Nama Kegiatan</th>
                                    <th style="width:27%">Lokasi &amp; Waktu</th>
                                    <th style="width:28%">Prediksi Cuaca</th>
                                    <th style="width:15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agendas as $agenda)
                                <tr>
                                    <td>
                                        <div class="fw-name">{{ $agenda->nama_kegiatan }}</div>
                                    </td>
                                    <td>
                                        <span class="badge-location">
                                            <i class="bi bi-geo-alt-fill"></i> {{ $agenda->lokasi_kota }}
                                        </span>
                                        <div class="time-small mt-1">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('d M Y, H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $cuaca = strtolower($agenda->prediksi_cuaca);
                                            $bad = str_contains($cuaca, 'hujan') || str_contains($cuaca, 'petir');
                                        @endphp
                                        @if($bad)
                                            <span class="badge-weather-bad">
                                                <i class="bi bi-cloud-lightning-rain-fill"></i>
                                                {{ $agenda->prediksi_cuaca }}
                                            </span>
                                        @else
                                            <span class="badge-weather-good">
                                                <i class="bi bi-sun-fill"></i>
                                                {{ $agenda->prediksi_cuaca }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <a href="{{ route('agenda.edit', $agenda->id_agenda) }}" class="btn-tbl-edit" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('agenda.destroy', $agenda->id_agenda) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus rencana ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-tbl-del" title="Hapus">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="bi bi-calendar-x"></i>
                                            </div>
                                            <h6>Belum Ada Rencana</h6>
                                            <p>Tambahkan rencana kegiatan outdoor<br>melalui formulir di sebelah kiri.</p>
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
        &copy; 2025 Personal Assistant Mahasiswa Rantau &mdash; Kelompok 9 WAD
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // ================================================================
        // Live clock
        // ================================================================
        function updateClock() {
            const now = new Date();
            const pad = n => String(n).padStart(2, '0');
            const el = document.getElementById('digital-clock');
            if (el) el.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
        }
        setInterval(updateClock, 1000);

        // ================================================================
        // Flatpickr
        // ================================================================
        flatpickr("#waktu_picker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today",
            defaultHour: 8,
            altInput: true,
            altFormat: "j F Y, H:i"
        });

        // ================================================================
        // CASCADING DROPDOWN – Provinsi → Kab/Kota → Kecamatan → Kelurahan
        // ================================================================
        const ROUTES = {
            provinsi:  "{{ route('wilayah.provinsi') }}",
            kabupaten: "{{ url('wilayah/kabupaten') }}/",
            kecamatan: "{{ url('wilayah/kecamatan') }}/",
            kelurahan: "{{ url('wilayah/kelurahan') }}/",
        };

        const selProv = document.getElementById('sel-provinsi');
        const selKab  = document.getElementById('sel-kabupaten');
        const selKec  = document.getElementById('sel-kecamatan');
        const selKel  = document.getElementById('sel-kelurahan');
        const hidAdm4  = document.getElementById('adm4_code');
        const hidLabel = document.getElementById('lokasi_label');
        const preview  = document.getElementById('location-preview');
        const prevText = document.getElementById('location-preview-text');

        // Helper: Convert emsifa ID → BMKG adm4 format
        // e.g. "3273020001" → "32.73.02.0001"
        function toAdm4(id) {
            const s = String(id).padStart(10, '0');
            return `${s.slice(0,2)}.${s.slice(2,4)}.${s.slice(4,6)}.${s.slice(6,10)}`;
        }

        // Helper: Set loading state on a select
        function setLoading(sel, isLoading) {
            const wrap = sel.closest('.wilayah-step');
            if (isLoading) {
                wrap.classList.add('loading-select');
                sel.disabled = true;
            } else {
                wrap.classList.remove('loading-select');
            }
        }

        // Helper: Reset a select to placeholder
        function resetSelect(sel, placeholder) {
            sel.innerHTML = `<option value="">${placeholder}</option>`;
            sel.disabled = true;
        }

        // Helper: Fetch wilayah and populate select
        async function loadWilayah(url, sel, placeholder) {
            setLoading(sel, true);
            try {
                const res  = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await res.json();
                sel.innerHTML = `<option value="">${placeholder}</option>`;
                data.forEach(item => {
                    const opt  = document.createElement('option');
                    opt.value  = item.id;
                    opt.textContent = toTitleCase(item.name);
                    sel.appendChild(opt);
                });
                sel.disabled = false;
            } catch (err) {
                sel.innerHTML = `<option value="">Gagal memuat data</option>`;
                sel.disabled = false;
                console.error('Wilayah API error:', err);
            } finally {
                setLoading(sel, false);
            }
        }

        function toTitleCase(str) {
            return str.replace(/\w\S*/g, txt => txt.charAt(0).toUpperCase() + txt.slice(1).toLowerCase());
        }

        function updatePreview() {
            const prov = selProv.options[selProv.selectedIndex];
            const kab  = selKab.options[selKab.selectedIndex];
            const kec  = selKec.options[selKec.selectedIndex];
            const kel  = selKel.options[selKel.selectedIndex];

            if (selKel.value && kel) {
                const label = `${kel.textContent}, ${kec?.textContent ?? ''}, ${kab?.textContent ?? ''}, ${prov?.textContent ?? ''}`;
                prevText.textContent = label;
                preview.classList.add('show');
                hidLabel.value = label;

                // Build adm4 from kelurahan id
                hidAdm4.value = toAdm4(selKel.value);
            } else {
                preview.classList.remove('show');
                hidLabel.value = '';
                hidAdm4.value  = '';
            }
        }

        // ---- Event Listeners ----

        // 1. Provinsi changed → load kabupaten
        selProv.addEventListener('change', () => {
            resetSelect(selKab, '-- Pilih kabupaten/kota --');
            resetSelect(selKec, '-- Pilih kecamatan --');
            resetSelect(selKel, '-- Pilih kelurahan/desa --');
            hidAdm4.value  = '';
            hidLabel.value = '';
            preview.classList.remove('show');

            if (selProv.value) {
                loadWilayah(ROUTES.kabupaten + selProv.value, selKab, '-- Pilih kabupaten/kota --');
            }
        });

        // 2. Kabupaten changed → load kecamatan
        selKab.addEventListener('change', () => {
            resetSelect(selKec, '-- Pilih kecamatan --');
            resetSelect(selKel, '-- Pilih kelurahan/desa --');
            hidAdm4.value  = '';
            hidLabel.value = '';
            preview.classList.remove('show');

            if (selKab.value) {
                loadWilayah(ROUTES.kecamatan + selKab.value, selKec, '-- Pilih kecamatan --');
            }
        });

        // 3. Kecamatan changed → load kelurahan
        selKec.addEventListener('change', () => {
            resetSelect(selKel, '-- Pilih kelurahan/desa --');
            hidAdm4.value  = '';
            hidLabel.value = '';
            preview.classList.remove('show');

            if (selKec.value) {
                loadWilayah(ROUTES.kelurahan + selKec.value, selKel, '-- Pilih kelurahan/desa --');
            }
        });

        // 4. Kelurahan changed → update hidden fields
        selKel.addEventListener('change', updatePreview);

        // ---- Initial load: fetch provinces on page load ----
        loadWilayah(ROUTES.provinsi, selProv, '-- Pilih provinsi --');

    </script>
</body>
</html>