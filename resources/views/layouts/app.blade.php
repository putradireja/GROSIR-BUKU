<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Grosir Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Grosir Buku</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-2">
                <div class="list-group">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="{{ route('master.supplier.index') }}" class="list-group-item list-group-item-action">Master Supplier</a>
                    <a href="{{ route('master.konsumen.index') }}" class="list-group-item list-group-item-action">Master Konsumen</a>
                    <a href="{{ route('master.barang.index') }}" class="list-group-item list-group-item-action">Master Barang</a>
                    <a href="{{ route('pemesanan.index') }}" class="list-group-item list-group-item-action">Pemesanan</a>
                    <a href="{{ route('pembelian.index') }}" class="list-group-item list-group-item-action">Pembelian</a>
                    <a href="{{ route('penjualan.index') }}" class="list-group-item list-group-item-action">Penjualan</a>
                    <a href="{{ route('penagihan.index') }}" class="list-group-item list-group-item-action">Penagihan</a>
                    <a href="{{ route('pembayaran-hutang.index') }}" class="list-group-item list-group-item-action">Pembayaran Hutang</a>
                    <a href="{{ route('retur-pembelian.index') }}" class="list-group-item list-group-item-action">Retur Pembelian</a>
                    <a href="{{ route('retur-penjualan.index') }}" class="list-group-item list-group-item-action">Retur Penjualan</a>
                </div>
            </div>
            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>