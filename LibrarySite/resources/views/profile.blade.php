@extends('layout')

@section('title', 'Profilim')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sol Kolon - Profil Bilgileri -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block mb-4">
                        <img src="{{ asset('avatars/' . ($user->avatar ?? 'default-avatar.png')) }}" 
                             class="rounded-circle mb-3 shadow" 
                             alt="Profil Resmi" 
                             width="150" height="150"
                             style="object-fit: cover;">
                        <label for="avatar" class="position-absolute bottom-0 end-0 translate-middle p-2 bg-primary rounded-circle shadow-sm" style="cursor: pointer;">
                            <i class="bi bi-pencil text-white"></i>
                        </label>
                    </div>
                    <form action="/profile/avatar" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" class="form-control" name="avatar" id="avatar" required onchange="this.form.submit()">
                    </form>
                    
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">Üye ID: {{ $user->id }}</p>
                    
                    <div class="border-top pt-3">
                        <div class="row text-center">
                            <div class="col">
                                <h5>{{ $user->borrowings->count() }}</h5>
                                <small class="text-muted">Ödünç Alınan</small>
                            </div>
                            <div class="col">
                                <h5>{{ $user->ratings->count() }}</h5>
                                <small class="text-muted">Değerlendirme</small>
                            </div>
                            <div class="col">
                                <h5>{{ $user->reviews->count() }}</h5>
                                <small class="text-muted">Yorum</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body border-top">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item bg-transparent">
                            <small class="text-muted d-block">E-posta</small>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="list-group-item bg-transparent">
                            <small class="text-muted d-block">Telefon</small>
                            <span>{{ $user->tel }}</span>
                        </div>
                        <div class="list-group-item bg-transparent">
                            <small class="text-muted d-block">Üyelik Tarihi</small>
                            <span>{{ $user->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sağ Kolon - Sekmeli İçerik -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#borrowed">Ödünç Alınanlar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#ratings">Değerlendirmeler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#reviews">Yorumlar</a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Ödünç Alınan Kitaplar -->
                        <div class="tab-pane fade show active" id="borrowed">
                            @forelse($user->borrowings->sortByDesc('created_at') as $borrow)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <img src="{{ asset('storage/' . $borrow->copy->book->image) }}" 
                                                     alt="Kitap Kapağı"
                                                     class="rounded"
                                                     width="60" height="90"
                                                     style="object-fit: cover;">
                                            </div>
                                            <div class="col">
                                                <h6 class="mb-1">{{ $borrow->copy->book->book_name }}</h6>
                                                <p class="text-muted mb-0 small">
                                                    {{ $borrow->copy->book->author->name }} |
                                                    Alış: {{ $borrow->purchase_date->format('d.m.Y') }}
                                                </p>
                                                @if($borrow->status == 'borrowed')
                                                    <div class="mt-2">
                                                        <span class="badge bg-primary">Ödünç Alındı</span>
                                                        <small class="text-muted ms-2">
                                                            Teslim: {{ $borrow->return_date->format('d.m.Y') }}
                                                            ({{ ceil(now()->diffInDays($borrow->return_date, false)) }} gün kaldı)
                                                        </small>
                                                        <form action="{{ route('borrowing.extend', $borrow->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                                                <i class="bi bi-calendar-plus"></i> Süre Uzat
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="mt-2">
                                                        <span class="badge bg-success">Teslim Edildi</span>
                                                        <small class="text-muted ms-2">
                                                            {{ $borrow->returned_at->format('d.m.Y') }}
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-book h1 d-block mb-3"></i>
                                    <p>Henüz kitap ödünç alınmamış.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Değerlendirmeler -->
                        <div class="tab-pane fade" id="ratings">
                            @forelse($user->ratings->sortByDesc('created_at') as $rating)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <img src="{{ asset('storage/' . $rating->book->image) }}" 
                                                     alt="Kitap Kapağı"
                                                     class="rounded"
                                                     width="60" height="90"
                                                     style="object-fit: cover;">
                                            </div>
                                            <div class="col">
                                                <h6 class="mb-1">{{ $rating->book->book_name }}</h6>
                                                <div class="text-warning mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $rating->rating)
                                                            <i class="bi bi-star-fill"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                    <small class="text-muted ms-2">({{ number_format($rating->rating, 1) }}/5)</small>
                                                </div>
                                                <small class="text-muted">
                                                    {{ $rating->created_at->format('d.m.Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-star h1 d-block mb-3"></i>
                                    <p>Henüz kitap değerlendirmesi yapılmamış.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Yorumlar -->
                        <div class="tab-pane fade" id="reviews">
                            @forelse($user->reviews->sortByDesc('created_at') as $review)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <img src="{{ asset('storage/' . $review->book->image) }}" 
                                                     alt="Kitap Kapağı"
                                                     class="rounded"
                                                     width="60" height="90"
                                                     style="object-fit: cover;">
                                            </div>
                                            <div class="col">
                                                <h6 class="mb-2">{{ $review->book->book_name }}</h6>
                                                <p class="mb-2">{{ $review->comment }}</p>
                                                <small class="text-muted">
                                                    {{ $review->created_at->format('d.m.Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-chat-quote h1 d-block mb-3"></i>
                                    <p>Henüz kitap yorumu yapılmamış.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
