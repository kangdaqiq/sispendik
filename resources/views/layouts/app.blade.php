<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SISPENDIK') - Sistem Informasi Pendidikan</title>

    <!-- Google Fonts -->
    <link href="{{ asset('fonts/sourcesanspro.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <!-- AdminLTE 3 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }

        .brand-text {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .nav-sidebar .nav-link p {
            font-size: 0.9rem;
        }

        /* ===== Compatibility layer: old custom CSS classes → Bootstrap 4 ===== */
        .table-wrap {
            overflow-x: auto;
        }

        .table-wrap table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .table-wrap table thead tr {
            background: #f4f6f9;
        }

        .table-wrap table th,
        .table-wrap table td {
            padding: 10px 12px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .table-wrap table tbody tr:hover {
            background: #f8f9fa;
        }

        .table-wrap table th {
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #6c757d;
        }

        .search-row {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .search-input {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .search-input i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .search-input input {
            width: 100%;
            padding: 6px 12px 6px 32px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .flex {
            display: flex !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border: 1px solid #6c757d;
            border-radius: 4px;
            color: #6c757d;
            background: transparent;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-outline:hover {
            background: #6c757d;
            color: #fff;
        }

        .pagination-wrap {
            margin-top: 1rem;
        }

        .pagination-wrap .pagination {
            justify-content: flex-end;
        }

        .card-header h2 {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Form helpers */
        .form-section {
            margin-bottom: 1.5rem;
        }

        .form-section-title {
            font-size: 1rem;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard') }}" class="nav-link font-weight-bold text-dark">
                        @yield('page-title', 'Dashboard')
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @php $ta = \App\Models\TahunAjaran::aktif(); @endphp
                @if($ta)
                    <li class="nav-item d-none d-sm-flex align-items-center mr-2">
                        <span class="text-muted" style="font-size:0.85rem;">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ $ta->nama }} &mdash; {{ ucfirst($ta->semester) }}
                        </span>
                    </li>
                @endif

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" href="#">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-2"
                            style="width:32px;height:32px;background:linear-gradient(135deg,#007bff,#17a2b8);color:#fff;font-weight:700;font-size:0.85rem;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" class="mb-0">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- ============================================================ SIDEBAR -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <span class="brand-image img-circle elevation-3"
                    style="width:33px;height:33px;background:linear-gradient(135deg,#007bff,#17a2b8);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;">
                    <i class="fas fa-graduation-cap"></i>
                </span>
                <span class="brand-text font-weight-bold ml-2">SISPENDIK</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <div class="rounded-circle"
                            style="width:34px;height:34px;background:linear-gradient(135deg,#007bff,#17a2b8);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                    <div class="info">
                        <a href="{{ route('profile.edit') }}" class="d-block text-truncate" style="max-width:155px;">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </a>
                        <small class="text-muted">{{ ucfirst(auth()->user()->role ?? 'admin') }}</small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <!-- Umum -->
                        <li class="nav-header">UMUM</li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Data Master -->
                        <li class="nav-header">DATA MASTER</li>
                        <li class="nav-item">
                            <a href="{{ route('tahun-ajaran.index') }}"
                                class="nav-link {{ request()->routeIs('tahun-ajaran.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Tahun Ajaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jurusan.index') }}"
                                class="nav-link {{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-code-branch"></i>
                                <p>Jurusan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kelas.index') }}"
                                class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-door-open"></i>
                                <p>Kelas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('siswa.index') }}"
                                class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.index') }}"
                                class="nav-link {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>Guru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mata-pelajaran.index') }}"
                                class="nav-link {{ request()->routeIs('mata-pelajaran.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Mata Pelajaran</p>
                            </a>
                        </li>

                        <!-- Akademik -->
                        <li class="nav-header">AKADEMIK</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pendaftaran.index') }}"
                                class="nav-link {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Pendaftaran Baru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.referral-link.index') }}"
                                class="nav-link {{ request()->routeIs('admin.referral-link.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-link"></i>
                                <p>Referral Link</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jadwal.index') }}"
                                class="nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>Jadwal Pelajaran</p>
                            </a>
                        </li>
                        <!-- Kehadiran & Penilaian sections removed -->

                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- ============================================================ END SIDEBAR -->

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('page-title', 'Dashboard')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')

                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <strong>© {{ date('Y') }} <a href="#">SISPENDIK</a>.</strong> Sistem Informasi Pendidikan.
            <div class="float-right d-none d-sm-inline-block">
                <b>AdminLTE</b> 3
            </div>
        </footer>

        <!-- Control sidebar (needed for layout-fixed) -->
        <aside class="control-sidebar control-sidebar-dark"></aside>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE 3 -->
    <script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}"></script>

    @stack('scripts')
</body>

</html>