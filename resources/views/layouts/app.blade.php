<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    Kelompok 4
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if(auth()->user()->role === 'bendahara')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('bendahara/dashboard') ? 'active' : '' }}"
                                        href="{{ route('bendahara.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('bendahara/mahasiswa*') ? 'active' : '' }}"
                                        href="{{ route('bendahara.mahasiswa.index') }}">Mahasiswa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('bendahara/kas-bulanan*') ? 'active' : '' }}"
                                        href="{{ route('bendahara.kas-bulanan.index') }}">Kas Bulanan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('bendahara/pembayaran*') ? 'active' : '' }}"
                                        href="{{ route('bendahara.pembayaran.index') }}">Pembayaran</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('bendahara/pengeluaran*') ? 'active' : '' }}"
                                        href="{{ route('bendahara.pengeluaran.index') }}">Pengeluaran</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('bendahara/laporan*') ? 'active' : '' }}"
                                        href="{{ route('bendahara.laporan.index') }}">Laporan</a>
                                </li>
                            @elseif(auth()->user()->role === 'anggota')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('anggota/dashboard') ? 'active' : '' }}"
                                        href="{{ route('anggota.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('anggota/status-kas') ? 'active' : '' }}"
                                        href="{{ route('anggota.status-kas') }}">Status Kas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('anggota/riwayat') ? 'active' : '' }}"
                                        href="{{ route('anggota.riwayat') }}">Riwayat Saya</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('anggota/transparansi') ? 'active' : '' }}"
                                        href="{{ route('anggota.transparansi') }}">Transparansi</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login') && !request()->is('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.password.edit') }}">
                                        <i class="bi bi-key me-2"></i> Ganti Password
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>