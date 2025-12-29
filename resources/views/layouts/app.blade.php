<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Assistant Mahasiswa Rantau</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            color: #334155;
        }

        .navbar-custom {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 2.5rem; 
        }

        .brand-text {
            font-weight: 800;
            color: #1e3a8a;
            font-size: 1.15rem;
            letter-spacing: -0.025em;
        }

        .nav-link-custom {
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.5rem 1.25rem !important;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link-custom:hover {
            color: #1e3a8a;
        }

        .nav-link-custom.active {
            color: #1e3a8a !important;
        }

        .nav-link-custom.active::after {
            content: "";
            position: absolute;
            bottom: -1.2rem; 
            left: 20%;
            width: 60%;
            height: 3.5px;
            background: #1e3a8a;
            border-radius: 10px 10px 0 0;
        }

        .user-profile {
            font-weight: 700;
            color: #1e3a8a;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .alert-holiday {
            background-color: #f8d7da !important; 
            border: 1px solid #f1aeae !important;
            border-radius: 12px;
            padding: 1rem 1.5rem;
        }

        .card {
            border-radius: 15px;
            border: none;
        }

        .form-control, .form-select, .btn {
            font-size: 0.85rem;
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }

        .btn-primary { background-color: #1e3a8a; border: none; }
        .btn-primary:hover { background-color: #172554; }

        .table thead th {
            background-color: #f8fafc;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 1rem;
            border-top: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand brand-text" href="#">Personal Assistant</a>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav gap-2">
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom active" href="#">Manajemen Tugas</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="#">Agenda Outdoor</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="#">Meal Plan</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="#">Spiritual</a></li>
                </ul>
            </div>

            <div class="dropdown">
                <a class="dropdown-toggle text-decoration-none user-profile" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-2 fs-5"></i>
                    <span>{{ Auth::user()->name ?? 'AMRIN' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2">
                    <li><a class="dropdown-item text-danger fw-bold small rounded-2" href="#">
                        <i class="bi bi-box-arrow-right me-2"></i>KELUAR</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>