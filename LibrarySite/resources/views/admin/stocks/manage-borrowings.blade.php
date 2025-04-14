@extends('layout')

@section('title', 'Ödünç İşlemlerini Yönet')

@section('content')
<div class="row">
    <div class="col-12">
        <h2>Ödünç İşlemlerini Yönet</h2>
        <hr>
        <p>Bu sayfada ödünç işlemlerini yönetebilirsiniz.</p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ödünç ID</th>
                        <th>Kitap Adı</th>
                        <th>Üye Adı</th>
                        <th>Ödünç Tarihi</th>
                        <th>Son Teslim Tarihi</th>
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
                        <td>15/01/2023</td>
                        <td>Gecikmiş</td>
                        <td>
                            <button class="btn btn-warning btn-sm">Hatırlatma Gönder</button>
                        </td>
                    </tr>
                    <!-- Add dynamic rows here -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
