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
    <title>Dashboard - Personal Assistant Mahasiswa Rantau</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-blue: #1A237E; --bg-light: #f4f7fe; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-light); padding-top: 20px; }
        .navbar { background-color: white; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); padding: 0.8rem 2rem; }
        .navbar-brand { font-weight: 700; color: #333; font-size: 1rem; }
        .nav-link { font-weight: 500; color: #666; margin: 0 10px; transition: all 0.3s; font-size: 0.8rem; }
        .nav-link.active { color: var(--primary-blue) !important; font-weight: 600; border-bottom: 3px solid var(--primary-blue); }
        .user-name { color: var(--primary-blue) !important; font-weight: 600; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); background: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top py-2">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#" style="font-size: 1rem;">Personal Assistant Mahasiswa Rantau</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto" style="font-size: 0.8rem;">
                <li class="nav-item"><a class="nav-link px-2" href="#">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link px-2" href="#">Manajemen Tugas</a></li>
                <li class="nav-item"><a class="nav-link px-2" href="#">Agenda Outdoor</a></li>
                <li class="nav-item"><a class="nav-link px-2" href="#">Meal Plan</a></li>
                <li class="nav-item"><a class="nav-link active px-2" href="#">Spiritual</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center user-name" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.75rem;">
                        <i class="bi bi-person-circle me-2" style="font-size: 0.9rem;"></i>
                        <span class="text-uppercase fw-bold">{{ strtoupper(Auth::user()->name ?? 'syalfa') }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                        <li>
                            <form action="" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-box-arrow-right me-2"></i> KELUAR
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!DOCTYPE html>
<html lang="id">
<head>
    <style>
        :root {
            --primary-blue: #1A237E;
            --bg-light: #f4f7fe;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            padding-top: 70px; 
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 2rem;
        }

        .nav-link.active {
            color: var(--primary-blue) !important;
            font-weight: 600;
            border-bottom: 3px solid var(--primary-blue);
        }

        .user-name {
            color: var(--primary-blue) !important;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top py-2">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#" style="font-size: 1rem;">Personal Assistant Mahasiswa Rantau</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto" style="font-size: 0.8rem;">
                    <li class="nav-item"><a class="nav-link px-2" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Manajemen Tugas</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Agenda Outdoor</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Meal Plan</a></li>
                    <li class="nav-item"><a class="nav-link active px-2" href="#">Spiritual</a></li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center user-name" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.75rem;">
                            <i class="bi bi-person-circle me-2" style="font-size: 0.9rem;"></i>
                            <span class="text-uppercase fw-bold">{{ strtoupper(Auth::user()->name ?? 'syalfa') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                            <li>
                                <form action="" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-box-arrow-right me-2"></i> KELUAR
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container pb-5">
        @if(session('success')) 
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div> 
        @endif
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>