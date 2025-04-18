@extends('layout')

@section('title', 'Ana Sayfa - Kütüphane')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section text-center py-5 mb-4">
        <h1>Hoş Geldiniz</h1>
        <p class="lead">Kitapları keşfedin, arkadaşlarınızla paylaşın ve okuma deneyiminizi zenginleştirin.</p>
        <div class="mt-4">
            <a href="/books" class="btn btn-primary me-2">Kitaplara Göz At</a>
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
        @foreach($featuredBooks as $book)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <img src="{{ $book->book_cover ?? 'https://via.placeholder.com/350x200' }}" class="card-img-top" alt="{{ $book->book_name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->book_name }}</h5>
                    <p class="card-text">{{ $book->author }}</p>
                    <div class="text-warning mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($book->ratings_avg_rating))
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                        ({{ number_format($book->ratings_avg_rating, 1) }})
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Activities Section -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Son Aktiviteler</h3>
        </div>
        <div class="col-md-8">
            <div class="list-group">
                @forelse($recentActivities as $activity)
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{ $activity->user ? $activity->user->name : 'Silinmiş Kullanıcı' }} {{ $activity->activity_type }}</h6>
                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">{{ $activity->activity_description }}</p>
                </div>
                @empty
                <div class="list-group-item">
                    <p class="mb-1">Henüz aktivite bulunmuyor</p>
                </div>
                @endforelse
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