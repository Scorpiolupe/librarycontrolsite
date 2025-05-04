<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kütüphane Otomasyonu')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

        .notifications-wrapper {
            position: relative !important;
        }

        .notifications-container {
            position: absolute;
            top: 100% !important;
            right: 0;
            width: 300px;
            max-height: 400px;
            overflow-y: auto;
            background: white;
            border: 1px solid rgba(0,0,0,.15);
            border-radius: 4px;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
            z-index: 9999;
            display: none;
        }

        .notifications-container.show {
            display: block;
        }

        .notification-item {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            background: white;
            color: #333;
            cursor: pointer;
            transition: background-color 0.2s;
            opacity: 0.8;
        }

        .notification-item.unread {
            background-color: #f0f8ff;
            opacity: 1;
            font-weight: 500;
        }

        /* Toast Bildirimleri için Stiller */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast-notification {
            padding: 12px 24px;
            border-radius: 4px;
            margin-bottom: 10px;
            color: white;
            font-size: 14px;
            opacity: 0;
            transform: translateX(100%);
            animation: slideIn 0.3s ease forwards, fadeOut 0.5s ease 2.5s forwards;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateY(100%);
            }
        }
        
        .toast-success { background-color: #28a745; }
        .toast-error { background-color: #dc3545; }
        .toast-info { background-color: #17a2b8; }
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
                        <li class="nav-item notifications-wrapper dropdown">
                            <a class="nav-link position-relative" href="{{ route('notifications.markAllAsRead') }}" id="notificationBtn" role="button">
                                <i class="fas fa-bell"></i>
                                @if(auth()->user()->notifications()->where('read', false)->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ auth()->user()->notifications()->where('read', false)->count() }}
                                    </span>
                                @endif
                            </a>
                            <div class="notifications-container">
                                @if(auth()->user()->notifications()->count() > 0)
                                    @foreach(auth()->user()->notifications()->orderBy('created_at', 'desc')->get() as $notification)
                                    <div class="notification-item {{ !$notification->read ? 'unread' : '' }}" data-notification-id="{{ $notification->id }}">
                                        {{ $notification->message }}
                                    </div>
                                    @endforeach
                                @else
                                    <div class="notification-item text-muted">
                                        Bildiriminiz bulunmamaktadır.
                                    </div>
                                @endif
                            </div>
                        </li>
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
        <div class="toast-container">
            @if(session('success'))
                <div class="toast-notification toast-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="toast-notification toast-error">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="toast-notification toast-info">
                    {{ session('info') }}
                </div>
            @endif
        </div>
        
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
            const notificationBtn = document.getElementById('notificationBtn');
            const notificationsContainer = notificationBtn.nextElementSibling;

            // CSRF Token'ı ayarla
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if(notificationBtn && notificationsContainer) {
                // Bildirim tıklama olayını ekle
                notificationsContainer.addEventListener('click', function(e) {
                    const notificationItem = e.target.closest('.notification-item');
                    if (notificationItem && notificationItem.dataset.notificationId) {
                        fetch(`/notifications/${notificationItem.dataset.notificationId}/mark-as-read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                notificationItem.classList.remove('unread');
                                // Bildirim sayısını güncelle
                                const badge = notificationBtn.querySelector('.badge');
                                if (badge) {
                                    const currentCount = parseInt(badge.textContent);
                                    if (currentCount > 1) {
                                        badge.textContent = currentCount - 1;
                                    } else {
                                        badge.remove();
                                    }
                                }
                            }
                        });
                    }
                });

                notificationBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Okunmamış bildirimleri okundu olarak işaretle
                    fetch('/notifications/mark-all-as-read', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Tüm unread class'larını kaldır
                            document.querySelectorAll('.notification-item.unread').forEach(item => {
                                item.classList.remove('unread');
                            });
                            
                            // Bildirim rozetini kaldır
                            const badge = notificationBtn.querySelector('.badge');
                            if (badge) {
                                badge.remove();
                            }
                        }
                    });

                    const isVisible = notificationsContainer.classList.contains('show');
                    
                    // Tüm açık dropdownları kapat
                    document.querySelectorAll('.notifications-container.show').forEach(container => {
                        if(container !== notificationsContainer) {
                            container.classList.remove('show');
                        }
                    });
                    
                    notificationsContainer.classList.toggle('show');
                });

                // Dışarı tıklandığında kapat
                document.addEventListener('click', function(e) {
                    if (!notificationsContainer.contains(e.target) && !notificationBtn.contains(e.target)) {
                        notificationsContainer.classList.remove('show');
                    }
                });
            }

            // Toast bildirimleri için otomatik silme
            const toasts = document.querySelectorAll('.toast-notification');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.addEventListener('animationend', function(e) {
                        if (e.animationName === 'fadeOut') {
                            toast.remove();
                        }
                    });
                }, 100);
            });
        });
    </script>
    @yield('js')
</body>
</html>