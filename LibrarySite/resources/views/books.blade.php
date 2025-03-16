@extends('layout')

@section('title', 'Kitaplar')

@section('content')
<div class="row">
    <!-- Filters -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Filtreler</h5>
            </div>
            <div class="card-body">
                <form action="/books" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Tümü</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
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
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Filtrele</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Books List -->
    <div class="col-md-9">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($books as $book)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ $book->author }}</p>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bookModal{{ $book->id }}">
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
                            <h5 class="modal-title">{{ $book->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Yazar:</strong> {{ $book->author }}</p>
                            <p><strong>Kategori:</strong> {{ $book->category->name }}</p>
                            <p><strong>Tür:</strong> {{ $book->genre->name }}</p>
                            <p><strong>Yayın Yılı:</strong> {{ $book->publication_year }}</p>
                            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                            <p><strong>Sayfa Sayısı:</strong> {{ $book->page_count }}</p>
                            <p><strong>Açıklama:</strong> {{ $book->description }}</p>
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
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection