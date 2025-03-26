@extends('layout')

@section('title', 'Ana Sayfa - Kütüphane')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section text-center py-5 mb-4">
        <h1>Hoş Geldiniz</h1>
        <p class="lead">Kitapları keşfedin, arkadaşlarınızla paylaşın ve okuma deneyiminizi zenginleştirin.</p>
        <div class="mt-4">
            <a href="/kesfet" class="btn btn-primary me-2">Kitaplara Göz At</a>
            @if (auth()->check())
                <a href="/profile" class="btn btn-outline-primary">Profilim</a>
            @else
            <a href="/auth" class="btn btn-outline-primary">Giriş Yap</a>
            @endif
        </div>
    </div>

    <!-- Featured Books Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">Öne Çıkan Kitaplar</h3>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Kitap 1">
                <div class="card-body">
                    <h5 class="card-title">Suç ve Ceza</h5>
                    <p class="card-text">Dostoyevski'nin ünlü klasiği, suç ve vicdan arasındaki çatışmayı ele alır.</p>
                    <div class="text-warning mb-2">⭐⭐⭐⭐⭐</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Kitap 2">
                <div class="card-body">
                    <h5 class="card-title">1984</h5>
                    <p class="card-text">George Orwell'in distopik başyapıtı, totaliter bir dünyayı anlatır.</p>
                    <div class="text-warning mb-2">⭐⭐⭐⭐</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Kitap 3">
                <div class="card-body">
                    <h5 class="card-title">Küçük Prens</h5>
                    <p class="card-text">Saint-Exupéry'nin zamansız klasiği, tüm yaşlar için bir başyapıt.</p>
                    <div class="text-warning mb-2">⭐⭐⭐⭐⭐</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Son Aktiviteler</h3>
        </div>
        <div class="col-md-8">
            <div class="list-group">
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Ahmet yeni bir kitap ekledi</h6>
                        <small class="text-muted">3 saat önce</small>
                    </div>
                    <p class="mb-1">Yüzüklerin Efendisi: Yüzük Kardeşliği</p>
                </div>
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Ayşe bir yorum yaptı</h6>
                        <small class="text-muted">5 saat önce</small>
                    </div>
                    <p class="mb-1">"Harika bir kitaptı, kesinlikle tavsiye ederim!"</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .hero-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 40px 20px;
    }
    .card {
        transition: transform 0.2s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
</style>
@endsection