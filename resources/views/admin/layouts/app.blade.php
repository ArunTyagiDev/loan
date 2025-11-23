<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | Loan Solutions')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #eef2f7;
        }
        .sidebar {
            min-height: 100vh;
            background: #0b1d3a;
            color: #fff;
        }
        .sidebar a {
            color: #cbd5f5;
            text-decoration: none;
        }
        .sidebar a.active,
        .sidebar a:hover {
            color: #fff;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <div class="sidebar p-4">
            <h4 class="fw-bold mb-4">Loan Admin</h4>
            <nav class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.loan-applications.index') }}" class="nav-link {{ request()->routeIs('admin.loan-applications.*') ? 'active' : '' }}">
                    Loan Applications
                </a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-4">
                @csrf
                <button class="btn btn-outline-light btn-sm w-100" type="submit">Sign out</button>
            </form>
        </div>

        <div class="flex-grow-1">
            <header class="bg-white shadow-sm py-3">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">@yield('header', 'Dashboard')</h5>
                    </div>
                    <div class="text-secondary small">
                        Logged in as: {{ auth('admin')->user()->name ?? 'Admin' }}
                    </div>
                </div>
            </header>

            <main class="container-fluid py-4">
                @if (session('status'))
                    <div class="container">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

