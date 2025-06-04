<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Movie - @yield('title', 'Homepage')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-success navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">MovieApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link  {{ request()->is('/') ? 'active' : '' }}" aria-current="page"
                            href="/">Home</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('movie/create') ? 'active' : '' }}"
                                href="/movie/create">Input Movie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  {{ request()->is('admin.movies.list') ? 'active' : '' }}"
                                href="admin/movies">List Movie</a>
                        </li>
                    @endauth


                    <!-- Tombol Login / Logout -->
                    @auth
                        <div class="d-flex align-items-center text-white me-2">
                            Hello, {{ explode(' ', auth()->user()->name)[0] ?? auth()->user()->email }}
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light">Logout</button>
                        </form>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
                    @endguest
                </ul>

               <form class="d-flex me-3" action="{{ route('movies.search') }}" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Search by title" aria-label="Search" value="{{ request()->query('query') }}">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-success text-white text-center py-3">
        &copy; 2025 Developed by Zhahira Herina Syofa
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
