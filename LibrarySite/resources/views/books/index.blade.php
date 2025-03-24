@extends('layout')

@section('title', 'Kitaplar')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Kitaplar</h2>
        <hr>
    </div>

    @foreach($books as $book)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $book->title }}</h5>
                <p class="card-text">{{ $book->author }}</p>
                <p class="card-text"><small class="text-muted">{{ $book->published_date }}</small></p>
                <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary">Detaylar</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center">
    {{ $books->links() }}
</div>
@endsection
