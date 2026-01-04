
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

            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="card-title">Manajemen Tugas</h3>
                    <div class="alert alert-holiday mb-3 d-flex align-items-center">
                        <i class="bi bi-calendar-event me-2"></i>
                        <span>Hari Libur: 25 Desember 2025 (Hari Natal)</span>
                    </div>
                    <table class="table">
                        <tr>
                            <td>Kerjakan Proposal WAD</td>
                            <td class="text-end text-danger fw-bold">Hari ini</td>
                        </tr>
                        <tr>
                            <td>Presentasi Tubes APSI</td>
                            <td class="text-end text-muted">29 Desember 2025</td>
                        </tr>
                        <tr>
                            <td>Responsi Statistika Industri</td>
                            <td class="text-end text-muted">29 Desember 2025</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="card-title">Agenda Outdoor</h3>
                    <table class="table mb-3">
                        <tr>
                            <td>Rapat Divisi</td>
                            <td class="text-end text-muted small">2023-11-15 10:00</td>
                        </tr>
                        <tr>
                            <td>Jogging Pagi</td>
                            <td class="text-end text-muted small">2023-11-16 06:00</td>
                        </tr>
                    </table>
                    <div class="alert alert-warning-custom small">
                        <strong>Peringatan:</strong> Cuaca diprediksi Hujan Petir pada jam tersebut. Disarankan membawa jas hujan atau menjadwalkan ulang.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="card-title">Jadwal Ibadah</h3>
                    <table class="table mb-3">
                        <tr>
                            <td>Subuh</td>
                            <td class="text-end fw-bold">04:45</td>
                        </tr>
                        <tr>
                            <td>Dzuhur</td>
                            <td class="text-end fw-bold">11:58</td>
                        </tr>
                        <tr>
                            <td>Ashar</td>
                            <td class="text-end fw-bold">15:20</td>
                        </tr>
                        <tr>
                            <td>Maghrib</td>
                            <td class="text-end fw-bold">17:55</td>
                        </tr>
                        <tr>
                            <td>Isya</td>
                            <td class="text-end fw-bold">19:10</td>
                        </tr>
                    </table>
                    <div class="bg-light p-3 rounded-pill d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span class="small">Catatan Ibadah Anda: <strong>3 dari 5 Tepat Waktu</strong></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="card-title">Meal Plan</h3>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <tbody>
                                <tr>
                                    <td class="small">Senin, 22 Des</td>
                                    <td class="fw-bold">Pagi</td>
                                    <td>Nasi Goreng</td>
                                    <td class="text-end"><button class="btn btn-recipe">Resep</button></td>
                                </tr>
                                <tr>
                                    <td class="small">Senin, 22 Des</td>
                                    <td class="fw-bold">Siang</td>
                                    <td>Oseng Kangkung</td>
                                    <td class="text-end"><button class="btn btn-recipe">Resep</button></td>
                                </tr>
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