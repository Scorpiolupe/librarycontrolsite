<div class="row g-4">
    @forelse($copies as $copy)
    <div class="col-md-6 col-lg-4">
        <div class="book-card" style="background-image: url('{{ $copy->book->book_cover ?? 'https://via.placeholder.com/400x600?text=No+Cover' }}');">
            <a href="{{ url('/books/'.$copy->id) }}" class="book-link">
                <div class="status-badge 
                    @if($copy->status == 'available') status-available
                    @elseif($copy->status == 'borrowed') status-borrowed
                    @elseif($copy->status == 'reserved') status-reserved
                    @endif">
                    @if($copy->status == 'available')
                        <i class="fas fa-check-circle"></i> Müsait
                    @elseif($copy->status == 'borrowed')
                        <i class="fas fa-clock"></i> Ödünç Alındı
                    @elseif($copy->status == 'reserved')
                        <i class="fas fa-bookmark"></i> Rezerve
                    @endif
                </div>

                <div class="card-body">
                    <div class="book-header">
                        <h5 class="book-title">{{ $copy->book->book_name }}</h5>
                        <p class="book-author">{{ $copy->book->author->name }}</p>
                    </div>
                    
                    <div class="book-info">
                        <div class="info-row">
                            <span class="info-label">ISBN:</span>
                            <span class="info-value">{{ $copy->book->isbn }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Kategori:</span>
                            <span class="info-value">{{ $copy->book->category->category_name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Sayfa:</span>
                            <span class="info-value">{{ $copy->book->page_count }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Yayınevi:</span>
                            <span class="info-value">{{ $copy->book->publisher->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Yayın Yılı:</span>
                            <span class="info-value">{{ $copy->book->publish_year }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Raf:</span>
                            <span class="info-value">{{ $copy->shelf_location ?? 'Belirtilmemiş' }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-warning text-center">Sonuç bulunamadı.</div>
    </div>
    @endforelse
</div>
@if(method_exists($copies, 'links'))
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
@endif
