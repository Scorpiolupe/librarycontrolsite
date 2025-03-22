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
    font-size: 1.25rem;
    font-weight: bold;
}

.card-text {
    color: #6c757d;
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
}

.book-card .card-body {
    padding: 20px;
}

.book-card .btn {
    background-color: #17a2b8;
    color: white;
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
</style>
@endsection

@section('content')
<div class="header">
    <h1>Kitaplar</h1>
</div>

<div class="row">
    <!-- Filters -->
    <div class="col-md-3 mb-4">
        <div class="filter-card">
            <h5 class="mb-3">Filtreler</h5>
            <form action="/books" method="GET">
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
                <button type="submit" class="btn w-100">Filtrele</button>
            </form>
        </div>
    </div>

    <!-- Books List -->
    <div class="col-md-9">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($books as $book)
            <div class="col">
                <div class="card book-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->book_name }}</h5>
                        <p class="card-text">{{ $book->author }}</p>
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#bookModal{{ $book->id }}">
                            Detaylar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Book Detail Modal -->
            <div class="modal fade" id="bookModal{{ $book->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $book->book_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Yazar:</strong> {{ $book->author }}</p>
                            <p><strong>Kategori:</strong> {{ $book->category->category_name ?? 'N/A' }}</p>
                            <p><strong>Tür:</strong> {{ $book->genre->name ?? 'N/A' }}</p>
                            <p><strong>Yayın Yılı:</strong> {{ $book->publish_year }}</p>
                            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                            <p><strong>Sayfa Sayısı:</strong> {{ $book->page_count }}</p>
                            <p><strong>Durum:</strong> {{ $book->status }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        </div>
                    </div>
                </div>
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