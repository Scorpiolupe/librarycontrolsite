@extends('layout')

@section('title', $book->title)

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">{{ $book->title }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Yazar:</strong> {{ $book->author }}</p>
        <p><strong>Yayın Tarihi:</strong> {{ $book->published_date }}</p>
        <p><strong>Kategori:</strong> {{ $book->category->name }}</p>
        <p><strong>Tür:</strong> {{ $book->genre->name }}</p>
        <p><strong>Açıklama:</strong> {{ $book->description }}</p>
        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
        <p><strong>Ortalama Puan:</strong> {{ number_format($book->average_rating, 1) }} ({{ $book->ratings_count }} oy)</p>
        
        @auth
        <form action="{{ route('books.rate', $book->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="rating" class="form-label">Puanınız</label>
                <input type="number" class="form-control" id="rating" name="rating" step="0.1" min="0.5" max="5.0" value="{{ $book->user_rating->rating ?? '' }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Puanla</button>
        </form>
        @endauth

        <hr>

        <h5>Yorumlar</h5>
        @foreach($book->comments as $comment)
        <div class="mb-3">
            <p><strong>{{ $comment->user->name }}</strong> ({{ $comment->comment_date->format('d-m-Y H:i') }})</p>
            <p>{{ $comment->comment }}</p>
        </div>
        @endforeach

        @auth
        <form action="{{ route('books.comment', $book->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="comment" class="form-label">Yorumunuz</label>
                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Yorum Yap</button>
        </form>
        @endauth
    </div>
</div>
@endsection
