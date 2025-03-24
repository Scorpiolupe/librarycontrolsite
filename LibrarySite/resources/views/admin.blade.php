@extends('layout')

@section('title', 'Admin Panel')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Yönetim Paneli</h2>
        <hr>
    </div>

    <!-- İstatistikler -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Toplam Kitap</h5>
                <h2 class="card-text">{{ $totalBooks }}</h2>
                <small>Kütüphanedeki kitap sayısı</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Aktif Üyeler</h5>
                <h2 class="card-text">{{ $totalUsers }}</h2>
                <small>Kayıtlı kullanıcı sayısı</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5 class="card-title">Ödünç Kitaplar</h5>
                <h2 class="card-text">{{ $borrowedBooks }}</h2>
                <small>Ödünç verilen kitap sayısı</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Kategoriler</h5>
                <h2 class="card-text">{{ $totalCategories }}</h2>
                <small>Toplam kategori sayısı</small>
            </div>
        </div>
    </div>

    <!-- Yönetim Kartları -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kitap Yönetimi</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('books.create') }}" class="list-group-item list-group-item-action">Kitap Ekle</a>
                    <a href="{{ route('books.index') }}" class="list-group-item list-group-item-action">Kitapları Listele</a>
                    <a href="{{ route('categories.index') }}" class="list-group-item list-group-item-action">Kategorileri Yönet</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Üye Yönetimi</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('users.create') }}" class="list-group-item list-group-item-action">Üye Ekle</a>
                    <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">Üyeleri Listele</a>
                    <a href="{{ route('roles.index') }}" class="list-group-item list-group-item-action">Üye Rolleri</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Son İşlemler Tablosu -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Son İşlemler</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>İşlem</th>
                                <th>Kullanıcı</th>
                                <th>Tarih</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentActivities as $activity)
                                <tr>
                                    <td>{{ $activity->action }}</td>
                                    <td>{{ $activity->user->name }}</td>
                                    <td>{{ $activity->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ $activity->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Henüz işlem bulunmuyor</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection