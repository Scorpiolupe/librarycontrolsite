<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kütüphane Otomasyonu')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Kütüphane</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/books">Kitaplar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/discover">Keşfet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/friends">Arkadaşlar</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/profile">Profilim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Çıkış</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/auth">Giriş</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/auth">Kayıt</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Kütüphane Otomasyonu. Tüm hakları saklıdır<a style="text-decoration: none; color: white" href="/adminpanel">.</a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js')
</body>
</html>