@extends('layout')

@section('title', 'Kitaplar')

@section('css')
<style>
    .filter-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
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
    .book-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 0;
    }
    .book-card {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 20px;
        width: calc(33.333% - 20px);
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .book-card h5 {
        font-size: 1.25rem;
        font-weight: bold;
    }
    .book-card p {
        margin: 0;
    }
    .pagination {
        justify-content: center;
    }
    .pagination .page-link {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
    .pagination .page-item .page-link {
        border-radius: 50%;
    }
    .content-wrapper {
        display: flex;
    }
    .filter-wrapper {
        flex: 1;
        max-width: 300px;
        margin-right: 20px;
    }
    .books-wrapper {
        flex: 3;
    }
    .cart-button {
        background-color: #28a745;
        color: white;
        margin-top: 10px;
    }
    .cart-animation {
        position: fixed;
        z-index: 9999;
        pointer-events: none;
        transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper">
    <!-- Filters and Search -->
    <div class="filter-wrapper">
        <div class="filter-card">
            <h5 class="mb-3">Filtreler ve Arama</h5>
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
    <div class="books-wrapper">
        <div class="book-list">
            @foreach($books as $book)
            <div class="book-card">
                <div>
                    <h5>{{ $book->book_name }}</h5>
                    <p><strong>Yazar:</strong> {{ $book->author }}</p>
                    <p><strong>Yayınevi:</strong> {{ $book->publisher }}</p>
                </div>
                <button type="button" class="btn btn-info mt-3" data-bs-toggle="modal" data-bs-target="#bookModal{{ $book->id }}">
                    Detaylar
                </button>
                <button type="button" class="btn cart-button" onclick="addToCart(event, '{{ $book->id }}')">
                    Sepete Ekle
                </button>
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

        <!-- Pagination -->
        <div class="mt-4">
            <div class="text-center">
                <div class="page-info mb-2">
                    <span class="text-muted">
                    Gösterilen: {{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }} / 
                    Toplam: {{ $books->total() }} kitap
                    </span>
                </div>
                @if($books->hasPages())
                    <nav aria-label="Sayfalama">
                        <ul class="pagination">
                            <li class="page-item {{ $books->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $books->previousPageUrl() }}" aria-label="Önceki">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                                <li class="page-item {{ $books->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            <li class="page-item {{ $books->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $books->nextPageUrl() }}" aria-label="Sonraki">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function addToCart(event, bookId) {
        const button = event.target;
        const cartIcon = document.querySelector('.cart-icon'); // Assuming there's a cart icon element with class 'cart-icon'
        const rect = button.getBoundingClientRect();
        const cartRect = cartIcon.getBoundingClientRect();

        const animation = document.createElement('div');
        animation.classList.add('cart-animation');
        animation.style.left = `${rect.left}px`;
        animation.style.top = `${rect.top}px`;
        animation.style.width = `${rect.width}px`;
        animation.style.height = `${rect.height}px`;
        animation.style.backgroundColor = '#28a745';
        animation.style.borderRadius = '50%';
        document.body.appendChild(animation);

        setTimeout(() => {
            animation.style.transform = `translate(${cartRect.left - rect.left}px, ${cartRect.top - rect.top}px) scale(0.1)`;
            animation.style.opacity = '0';
        }, 10);

        setTimeout(() => {
            document.body.removeChild(animation);
            // Add the book to the cart (this is just a placeholder, implement the actual logic)
            console.log(`Book ${bookId} added to cart`);
        }, 510);
    }
</script>
@endsection