@extends('layout')

@section('title', 'Kitaplar')

@section('css')
<style>
option {
    color: black;
}

.card {
    border: none;
    transition: transform 0.2s;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card:hover {
    transform: scale(1.05);
}

.card-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 12px;
    line-height: 1.4;
}

.card-text {
    font-size: 1rem;
    color: #4a5568;
    margin-bottom: 15px;
    font-weight: 500;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.pagination {
    justify-content: center;
}

.page-info {
    text-align: center;
    margin-top: 10px;
    color: #6c757d;
}

.filter-card {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
}

.filter-card h5 {
    font-size: 1.25rem;
    font-weight: bold;
}

.filter-card .form-label {
    font-weight: bold;
}

.filter-card .btn {
    background-color: #007bff;
    color: white;
}

.book-card {
    border-radius: 15px;
    overflow: hidden;
    height: auto;
    display: flex;
    flex-direction: row;
    margin-bottom: 20px;
    padding: 20px;
    transition: all 0.3s ease;
    background: linear-gradient(145deg, #ffffff, #f3f4f6);
    border: none;
    box-shadow: 5px 5px 15px rgba(0,0,0,0.08);
}

.book-card:hover {
    transform: scale(1.02);
    box-shadow: 8px 8px 20px rgba(0,0,0,0.12);
    background: linear-gradient(145deg, #ffffff, #e8f0fe);
}

.card-body {
    padding: 20px;
    flex-grow: 1;
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    letter-spacing: 0.3px;
    margin-bottom: 15px;
}

.status-available {
    background: linear-gradient(145deg, #34d399, #10b981);
    color: white;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
}

.status-borrowed {
    background: linear-gradient(145deg, #f87171, #ef4444);
    color: white;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
}

.book-card img {
    width: 100%;
    height: 280px;
    object-fit: contain;
    background: #f8f9fa;
    padding: 10px;
}

.book-card .btn {
    margin-top: 10px;
    width: 100%;
}

.footer {
    background-color: #343a40;
    color: white;
    padding: 10px;
    text-align: center;
    border-radius: 10px;
    margin-top: 20px;
}

.book-link {
    text-decoration: none;
    color: inherit;
}

.book-link:hover {
    color: inherit;
}

.book-details {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
    font-size: 0.95rem;
    color: #4b5563;
    line-height: 1.6;
}

.book-details strong {
    color: #374151;
    font-weight: 600;
}

/* Add these new styles */
.search-section {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-bottom: 20px;
}

.search-form {
    display: flex;
    gap: 10px;
    max-width: 500px;
}

.search-form .form-control {
    width: 300px;
}
</style>
@endsection

@section('content')
<div class="header">
    <h1>Kitaplar</h1>
</div>

<!-- Move search section here -->
<div class="search-section">
    <form action="/books/search" method="GET" class="search-form">
        <input type="text" name="query" class="form-control" placeholder="Kitap adı veya yazar ara..." value="{{ request('query') }}">
        <button type="submit" class="btn btn-primary">Ara</button>
        @if(request('query'))
            <a href="/books" class="btn btn-secondary">Temizle</a>
        @endif
    </form>
</div>

<div class="row">
    <!-- Filters -->
    <div class="col-md-3 mb-4">
        <div class="filter-card">
            <h5 class="mb-3">Filtreler</h5>
            <form action="{{ request()->is('books/search') ? '/books/search' : '/books' }}" method="GET">
                @if(request()->has('query'))
                    <input type="hidden" name="query" value="{{ request('query') }}">
                @endif
                
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Tümü</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                

                <div class="mb-3">
                    <label class="form-label">Sayfa Aralığı</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" class="form-control" name="min_pages" placeholder="Min" value="{{ request('min_pages') }}" min="0">
                        </div>
                        <div class="col-6">
                            <input type="number" class="form-control" name="max_pages" placeholder="Max" value="{{ request('max_pages') }}" min="0">
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Filtrele</button>
                    @if(request()->anyFilled(['category', 'min_pages', 'max_pages', 'query']))
                        <a href="{{ request()->is('books/search') ? '/books/search' : '/books' }}" class="btn btn-secondary">Filtreleri Temizle</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Books List -->
    <div class="col-md-9">
        <div class="row">
            @foreach($copies as $copy)
            <div class="col-12">
                <a href="/books/{{ $copy->book->id }}" class="book-link">
                    <div class="card book-card">
                        <div class="card-body">
                            <h5 class="card-title mb-2">{{ $copy->book->book_name }}</h5>
                            <p class="card-text mb-2">{{ $copy->book->author->name }}</p>
                           
                            <div class="book-details">
                                <p><strong>ISBN:</strong> {{ $copy->book->isbn }} | 
                                <strong>Kategori:</strong> {{ $copy->book->category->category_name }} | 
                                <strong>Sayfa:</strong> {{ $copy->book->page_count }} |  
                                <strong>Yayınevi:</strong> {{ $copy->book->publisher->name }} | 
                                <strong>Yayın Yılı:</strong> {{ $copy->book->publish_year }} | 
                                <strong>Raf:</strong> {{ $copy->shelf_location ?? 'Belirtilmemiş' }} | <br>
                                <strong>Durum:</strong> {{ $copy->status == 'available' ? 'Müsait' : 'Ödünç Alındı' }} 
                            </p>

                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="page-info">
                    <p>Toplam {{ $copies->total() }} kitap, {{ $copies->lastPage() }} sayfa</p>
                </div>
                <div class="pagination">
                    {{ $copies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection