@extends('layout')

@section('title', 'Rezervasyonları Yönet')

@section('content')
<div class="row">
    <div class="col-12">
        <h2>Rezervasyonları Yönet</h2>
        <hr>
        <p>Bu sayfada rezervasyon işlemlerini yönetebilirsiniz.</p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Rezervasyon ID</th>
                        <th>Kitap Adı</th>
                        <th>Üye Adı</th>
                        <th>Rezervasyon Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row -->
                    <tr>
                        <td>1</td>
                        <td>Kitap Adı Örneği</td>
                        <td>Üye Adı Örneği</td>
                        <td>01/01/2023</td>
                        <td>Beklemede</td>
                        <td>
                            <button class="btn btn-success btn-sm">Onayla</button>
                            <button class="btn btn-danger btn-sm">İptal Et</button>
                        </td>
                    </tr>
                    <!-- Add dynamic rows here -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
