<style>
    .navbar .user-blue,
    .navbar .user-blue i {
        color: #1A237E !important;
        font-weight: 600;
    }

    .navbar .user-blue:hover,
    .navbar .user-blue:focus {
        color: #1A237E !important;
    }

    .navbar .nav-link.active {
        color: #1A237E !important;
        font-weight: 600;
        border-bottom: 2px solid #1A237E;
    }

    .navbar .nav-link:hover {
        color: #1A237E !important;
    }
</style>

<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container-fluid px-4">

        <!-- Brand -->
        <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">
            Personal Assistant Mahasiswa Rantau
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- CENTER MENU -->
            <ul class="navbar-nav mx-auto nav-underline">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::is('dashboard', '/') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('tugas*') ? 'active' : '' }}"
                        href="{{ route('tugas.index') }}">Manajemen Tugas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('agenda*') ? 'active' : '' }}"
                        href="{{ route('agenda.index') }}">Agenda Outdoor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('meal-plan*') ? 'active' : '' }}"
                        href="{{ route('mealplan.index') }}">Meal Plan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('spiritual*') ? 'active' : '' }}"
                        href="{{ route('spiritual.index') }}">Spiritual</a>
                </li>
            </ul>

            <!-- USER -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-blue d-flex align-items-center gap-1"
                        href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        {{ ucwords(strtolower(Auth::user()->name)) }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
{{-- ================= END NAVBAR ================= --}}