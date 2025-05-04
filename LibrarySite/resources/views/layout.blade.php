<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kütüphane Otomasyonu')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
    <style>
        .header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 2rem;
        }

        .notification-card {
            position: fixed;
            top: 20px;
            right: -400px;
            width: 350px;
            z-index: 1000;
            transition: right 0.5s ease-in-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .notification-card.show {
            right: 20px;
        }
    </style>
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
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="/adminpanel">Yönetim Paneli</a>
                            </li>
                        @endif
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
        @if(session('success'))
            <div class="notification-card card bg-success text-white" id="successCard">
                <div class="card-body">
                    <h5 class="card-title">Başarılı!</h5>
                    <p class="card-text">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="notification-card card bg-danger text-white" id="errorCard">
                <div class="card-body">
                    <h5 class="card-title">Hata!</h5>
                    <p class="card-text text-white">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        @if(session('info'))
            <div class="notification-card card bg-info text-white" id="infoCard">
                <div class="card-body">
                    <h5 class="card-title">Bilgi</h5>
                    <p class="card-text text-white">{{ session('info') }}</p>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Kütüphane Otomasyonu. Tüm hakları saklıdır.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successCard = document.getElementById('successCard');
            const errorCard = document.getElementById('errorCard');

            function showNotification(element) {
                if (element) {
                    setTimeout(() => {
                        element.classList.add('show');
                        setTimeout(() => {
                            element.classList.remove('show');
                            setTimeout(() => {
                                element.remove();
                            }, 500);
                        }, 3000);
                    }, 100);
                }
            }

            showNotification(successCard);
            showNotification(errorCard);
            showNotification(infoCard);
        });
    </script>
    @yield('js')
</body>
</html>