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
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-text {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: auto;
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
    border-radius: 10px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.book-card .card-body {
    padding: 15px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
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

.footer {
    background-color: #343a40;
    color: white;
    padding: 10px;
    text-align: center;
    border-radius: 10px;
    margin-top: 20px;
}

.book-card .btn-details {
    background-color: #007bff;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.book-card .btn-details:hover {
    transform: scale(1.05);
    background-color: #0056b3;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.book-link {
    text-decoration: none;
    color: inherit;
}

.book-link:hover {
    color: inherit;
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
            <form action="/books" method="GET">
                <!-- Remove the search input from filters -->
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
                    <label class="form-label">Tür</label>
                    <select name="genre" class="form-select">
                        <option value="">Tümü</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                                {{ $genre->genre_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Ara</button>
                    @if(request('search') || request('category') || request('genre'))
                        <a href="/books" class="btn btn-secondary">Filtreleri Temizle</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Books List -->
    <div class="col-md-9">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($books as $book)
            <div class="col">
                <a href="/books/{{ $book->id }}" class="book-link">
                    <div class="card book-card h-100">
                        <img src="{{ $book->book_cover }}" class="card-img-top" alt="{{ $book->book_name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->book_name }}</h5>
                            <p class="card-text">{{ $book->author }}</p>
                            <button type="button" class="btn btn-details">
                                Detaylar
                            </button>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="page-info">
                    <p>Toplam {{ $books->total() }} kitap, {{ $books->lastPage() }} sayfa</p>
                </div>
                <div class="pagination">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2023 Library Control Site</p>
</div>
@endsection