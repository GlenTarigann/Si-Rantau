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