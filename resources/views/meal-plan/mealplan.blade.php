<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Plan - Personal Assistant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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

        .card-main {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            background: var(--surface);
            padding: 30px;
        }

        .table thead th {
            border: none;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px;
            border-bottom: 2px solid var(--border);
        }

        .table tbody td {
            border-top: 1px solid var(--border);
            padding: 15px;
            font-size: 0.9rem;
        }

        .btn-tambah {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-mid) 100%);
            border: none;
            border-radius: var(--radius-sm);
            padding: 10px 20px;
            font-weight: 600;
            transition: transform .2s, box-shadow .2s;
            color: white;
            box-shadow: 0 4px 14px rgba(26,35,126,0.3);
        }

        .btn-tambah:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26,35,126,0.35);
            color: white;
        }

        .btn-lihat-resep {
            background-color: #E8F5E9;
            color: #2E7D32;
            border: none;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-lihat-resep:hover {
            background-color: #C8E6C9;
            color: #1B5E20;
            transform: translateY(-1px);
        }

        .btn-itinerary {
            background: linear-gradient(135deg, var(--accent) 0%, #E65100 100%);
            border: none;
            border-radius: var(--radius-sm);
            color: white;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(245,127,23,0.3);
            transition: transform .2s, box-shadow .2s;
        }
        
        .btn-itinerary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245,127,23,0.4);
            color: white;
        }

        .recipe-card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            transition: 0.3s;
            background: var(--surface);
            box-shadow: var(--shadow-sm);
        }

        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .btn-pilih-menu {
            background-color: var(--primary);
            color: #f6f9fc;
            border: none;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .modal-content {
            border-radius: var(--radius);
            border: none;
            padding: 10px;
        }

        .form-control,
        .form-select {
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border);
            padding: 12px;
            background-color: #fafbff;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,35,126,0.10);
            background: #fff;
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
                        <i class="bi bi-egg-fried me-2"></i>Meal Plan
                    </h1>
                    <p class="hero-subtitle">Rencanakan menu harian dan cek resep dengan mudah</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5" style="margin-top: -2rem !important; position: relative; z-index: 10;">

        @if(session('success'))
        <div id="success-alert" class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="card-main">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Menu</th>
                            <th>Catatan</th>
                            <th>Resep</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($meals as $m)
                        <tr class="text-center">
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td class="fw-medium text-dark">{{ \Carbon\Carbon::parse($m->planned_date)->translatedFormat('d F Y') }}</td>
                            <td><span class="badge bg-light text-primary p-2 px-3 rounded-pill">{{ $m->meal_time }}</span></td>
                            <td class="fw-semibold">{{ $m->recipe_name }}</td>
                            <td class="text-muted small">{{ $m->notes ?? '-' }}</td>
                            <td>
                                @if($m->recipe_api_id)
                                <button type="button" class="btn-lihat-resep btn-detail-resep" data-id="{{ $m->recipe_api_id }}">
                                    Lihat Resep
                                </button>
                                @else
                                <span class="text-muted small">Tanpa Resep</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm btn-outline-primary border-0" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $m->id }}"><i class="bi bi-pencil-fill"></i></button>

                                    <form action="{{ route('mealplan.destroy', $m->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus Meal Plan?')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $m->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="fw-bold mt-2 ms-2">Edit Meal Plan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('mealplan.update', $m->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body px-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small">Tanggal</label>
                                                <input type="date" name="planned_date" class="form-control py-2"
                                                    style="border-radius: 10px;" value="{{ $m->planned_date }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold small">Waktu</label>
                                                <select name="meal_time" class="form-select py-2" style="border-radius: 10px;">
                                                    <option value="Pagi" {{ $m->meal_time == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                                                    <option value="Siang" {{ $m->meal_time == 'Siang' ? 'selected' : '' }}>Siang</option>
                                                    <option value="Malam" {{ $m->meal_time == 'Malam' ? 'selected' : '' }}>Malam</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 position-relative">
                                                <label class="form-label fw-bold small">Menu</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;">
                                                        <i class="bi bi-search text-muted"></i>
                                                    </span>
                                                    <input type="text"
                                                        class="form-control border-start-0 menu-search-input py-2"
                                                        style="border-radius: 0 10px 10px 0;"
                                                        placeholder="Pilih resep di bawah..."
                                                        value="{{ $m->recipe_name }}"
                                                        autocomplete="off">
                                                </div>

                                                <input type="hidden" name="recipe_name" class="menu-name-field" value="{{ $m->recipe_name }}">
                                                <input type="hidden" name="recipe_api_id" class="api-id-field" value="{{ $m->recipe_api_id }}">

                                                <div class="search-results-container list-group position-absolute w-100 shadow-lg d-none"
                                                    style="z-index: 9999; max-height: 200px; overflow-y: auto; top: 100%;">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold small">Catatan</label>
                                                <textarea name="notes" class="form-control" rows="3"
                                                    style="border-radius: 10px;"
                                                    placeholder="Contoh: Tanpa pedas">{{ $m->notes }}</textarea>
                                            </div>

                                            <div class="text-end">
                                                <button type="button" class="btn btn-link btn-sm text-danger text-decoration-none p-0"
                                                    onclick="if(confirm('Hapus plan ini?')) document.getElementById('delete-form-{{ $m->id }}').submit();">
                                                    Hapus Plan
                                                </button>
                                            </div>
                                        </div>

                                        <div class="modal-footer border-0 px-4 pb-4">
                                            <button type="submit" class="btn w-100 py-3 fw-bold text-white"
                                                style="background-color: #1a237e; border-radius: 12px;">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>

                                    <form id="delete-form-{{ $m->id }}" action="{{ route('mealplan.destroy', $m->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada Meal Plan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button class="btn btn-tambah text-white" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Meal Plan</button>
                <button type="button" class="btn btn-itinerary px-4" data-bs-toggle="modal" data-bs-target="#modalFilterCetak">
                    <i class="bi bi-printer me-2"></i> Cetak Planning
                </button>

                <div class="modal fade" id="modalFilterCetak" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-0">
                                <h5 class="fw-bold">Pilih Rentang Tanggal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('mealplan.cetak') }}" method="GET" target="_blank">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="small fw-bold mb-2">Dari Tanggal</label>
                                            <input type="date" name="start_date" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="small fw-bold mb-2">Sampai Tanggal</label>
                                            <input type="date" name="end_date" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn text-white w-100 py-2 fw-bold" style="background-color: #1A237E;" style="border-radius: 10px;">
                                        Mulai Cetak PDF
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 ms-2">
            <form action="{{ route('mealplan.index') }}" method="GET" class="mb-4" style="max-width: 400px;">
                <div class="input-group shadow-sm rounded-3 overflow-hidden border">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-0" placeholder="Cari resep..." value="{{ request('search') }}">
                </div>
            </form>

            <div class="row g-3 mt-4">
                @foreach($recipes as $recipe)
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="card recipe-card h-100 shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                        <img src="{{ $recipe['thumb'] }}" class="card-img-top" style="height: 130px; object-fit: cover;">
                        <div class="card-body p-2">
                            <h6 class="fw-bold small mb-3 text-truncate" title="{{ $recipe['title'] }}">{{ $recipe['title'] }}</h6>

                            <div class="d-grid gap-2">
                                <button type="button"
                                    class="btn btn-success btn-sm btn-detail-resep"
                                    style="font-size: 0.7rem; font-weight: 600;"
                                    data-id="{{ $recipe['key'] }}">
                                    Lihat Resep
                                </button>

                                <button type="button"
                                    class="btn btn-primary btn-pilih-menu"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalTambah"
                                    data-title="{{ $recipe['title'] }}"
                                    data-id="{{ $recipe['key'] }}">
                                    Pilih Menu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('mealplan.store') }}" method="POST" class="modal-content">
                @csrf
                <input type="hidden" name="recipe_api_id" id="api_id_field">

                <div class="modal-header border-0">
                    <h5 class="fw-bold">Tambah Meal Plan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="small fw-bold mb-2">Tanggal</label><input type="date" name="planned_date" class="form-control shadow-sm" required></div>
                    <div class="mb-3"><label class="small fw-bold mb-2">Waktu</label>
                        <select name="meal_time" class="form-select shadow-sm">
                            <option value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Malam">Malam</option>
                        </select>
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label fw-bold">Menu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0 menu-search-input"
                                placeholder="Pilih resep di bawah..." autocomplete="off">
                        </div>

                        <div class="search-results-container list-group position-absolute w-100 shadow-lg d-none"
                            style="z-index: 9999; max-height: 250px; overflow-y: auto; top: 100%;">
                        </div>

                        <input type="hidden" name="recipe_name" class="menu-name-field">
                        <input type="hidden" name="recipe_api_id_alt" class="api-id-field">
                    </div>
                    <div class="mb-3"><label class="small fw-bold mb-2">Catatan</label><textarea name="notes" class="form-control shadow-sm" rows="3" placeholder="Contoh: Tanpa pedas"></textarea></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-tambah text-white w-100 py-3">Tambah Meal Plan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalResep" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0">
                    <h5 class="fw-bold">
                        <i class="bi bi-chevron-left me-2" data-bs-dismiss="modal" style="cursor:pointer"></i>
                        <span id="modal-title">Resep</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="loading-state" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted">Menerjemahkan resep...</p>
                    </div>

                    <div id="content-resep" class="row d-none">
                        <div class="col-md-6 mb-3">
                            <img id="modal-img" src="" class="img-fluid rounded-4 shadow-sm mb-3" style="width: 100%; height: 250px; object-fit: cover;">

                            <h6 class="fw-bold mb-2 mt-3">Langkah Memasak</h6>
                            <p id="modal-instructions" class="small text-muted" style="white-space: pre-line; line-height: 1.6; text-align: justify;"></p>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-4">
                                <h6 class="fw-bold mb-3">Bahan Masakan</h6>
                                <ul id="modal-ingredients" class="ps-3 small text-muted mb-0" style="line-height: 1.8;">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2025 Personal Assistant Mahasiswa Rantau - Kelompok 9 WAD
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. INISIALISASI MODAL ---
            const modalResep = new bootstrap.Modal(document.getElementById('modalResep'));
            const modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));

            // --- 2. FUNGSI TRANSLATE (REUSABLE) ---
            async function translateText(text) {
                if (!text || text.trim() === "") return "";
                try {
                    const res = await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=id&dt=t&q=${encodeURIComponent(text)}`);
                    const data = await res.json();
                    return data[0].map(item => item[0]).join('');
                } catch (error) {
                    console.error("Gagal translate:", error);
                    return text; // Fallback ke teks asli jika gagal
                }
            }

            // --- 3. AUTO-HIDE ALERT ---
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }

            // --- 4. HANDLING TOMBOL PILIH (ISI MODAL TAMBAH) ---
            // Diperbaiki: Menyesuaikan class dan atribut agar form terisi otomatis
            document.addEventListener('click', function(e) {
                // Mencari tombol dengan class .btn-pilih-menu
                const btnPilih = e.target.closest('.btn-pilih-menu');

                if (btnPilih) {
                    const nama = btnPilih.getAttribute('data-title');
                    const key = btnPilih.getAttribute('data-id');

                    // Target Modal Tambah
                    const modalEl = document.getElementById('modalTambah');

                    // Isi Input Visible (Pencarian)
                    const searchInput = modalEl.querySelector('.menu-search-input');
                    if (searchInput) searchInput.value = nama;

                    // Isi Hidden Input (Nama Resep)
                    const nameField = modalEl.querySelector('.menu-name-field');
                    if (nameField) nameField.value = nama;

                    // Isi Hidden Input (API ID - ID Utama)
                    const apiIdMain = document.getElementById('api_id_field');
                    if (apiIdMain) apiIdMain.value = key;

                    // Isi Hidden Input (API ID - Backup di dalam input group)
                    const apiIdClass = modalEl.querySelector('.api-id-field');
                    if (apiIdClass) apiIdClass.value = key;
                }
            });

            // --- 5. DETAIL RESEP & TRANSLASI ---
            document.querySelectorAll('.btn-detail-resep').forEach(button => {
                button.addEventListener('click', async function() {
                    const mealId = this.getAttribute('data-id');

                    // State Loading
                    document.getElementById('loading-state').classList.remove('d-none');
                    document.getElementById('content-resep').classList.add('d-none');
                    modalResep.show();

                    try {
                        const response = await fetch(`https://www.themealdb.com/api/json/v1/1/lookup.php?i=${mealId}`);
                        const data = await response.json();
                        const meal = data.meals[0];

                        // Terjemahkan Judul & Instruksi
                        const instruksiIndo = await translateText(meal.strInstructions);

                        document.getElementById('modal-title').innerText = meal.strMeal;
                        document.getElementById('modal-img').src = meal.strMealThumb;
                        document.getElementById('modal-instructions').innerText = instruksiIndo;

                        // Olah Ingredients & Measure
                        let ingredientsHtml = '';
                        for (let i = 1; i <= 20; i++) {
                            const ing = meal[`strIngredient${i}`];
                            const measure = meal[`strMeasure${i}`];
                            if (ing && ing.trim() !== "") {
                                // Translasi bahan satu per satu
                                const ingIndo = await translateText(ing);
                                ingredientsHtml += `<li><strong>${measure}</strong> ${ingIndo}</li>`;
                            }
                        }
                        document.getElementById('modal-ingredients').innerHTML = ingredientsHtml;

                        // Switch State
                        document.getElementById('loading-state').classList.add('d-none');
                        document.getElementById('content-resep').classList.remove('d-none');

                    } catch (error) {
                        console.error("Error API:", error);
                        alert("Gagal memuat resep.");
                        modalResep.hide();
                    }
                });
            });

            // --- 6. LIVE SEARCH MEAL ---
            document.querySelectorAll('.menu-search-input').forEach(input => {
                const container = input.closest('.mb-3') || input.parentElement;
                const resultsDiv = container.querySelector('.search-results-container');
                const nameField = container.querySelector('.menu-name-field');
                const idField = container.querySelector('.api-id-field');

                // Tambahan: Juga cari input hidden utama jika tidak ketemu di container
                const mainIdField = document.getElementById('api_id_field');

                input.addEventListener('input', async function() {
                    const query = this.value.trim();
                    if (query.length < 2) {
                        resultsDiv.classList.add('d-none');
                        return;
                    }

                    try {
                        const response = await fetch(`https://www.themealdb.com/api/json/v1/1/search.php?s=${encodeURIComponent(query)}`);
                        const data = await response.json();
                        resultsDiv.innerHTML = '';

                        if (data.meals) {
                            resultsDiv.classList.remove('d-none');
                            data.meals.forEach(meal => {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = 'list-group-item list-group-item-action d-flex align-items-center gap-3 py-2';
                                btn.innerHTML = `
                                <img src="${meal.strMealThumb}" style="width: 35px; height: 35px; object-fit: cover;" class="rounded">
                                <div class="text-start">
                                    <div class="small fw-bold text-dark">${meal.strMeal}</div>
                                    <div class="text-muted" style="font-size: 0.65rem;">${meal.strCategory}</div>
                                </div>`;

                                btn.addEventListener('click', () => {
                                    input.value = meal.strMeal;
                                    if (nameField) nameField.value = meal.strMeal;
                                    if (idField) idField.value = meal.idMeal;
                                    if (mainIdField) mainIdField.value = meal.idMeal; // Isi hidden field utama
                                    resultsDiv.classList.add('d-none');
                                });
                                resultsDiv.appendChild(btn);
                            });
                        } else {
                            resultsDiv.classList.remove('d-none');
                            resultsDiv.innerHTML = '<div class="list-group-item small text-center">Resep tidak ditemukan</div>';
                        }
                    } catch (err) {
                        console.log("Error Search");
                    }
                });
            });

            // Tutup search result jika klik di luar
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.menu-search-input')) {
                    document.querySelectorAll('.search-results-container').forEach(c => c.classList.add('d-none'));
                }
            });
        });
    </script>

</body>

</html>