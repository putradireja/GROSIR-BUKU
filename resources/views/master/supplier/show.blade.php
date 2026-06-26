@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Detail Supplier</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200px" class="bg-light">Kode Supplier</th>
                <td>{{ $supplier->kode }}</td>
            </tr>
            <tr>
                <th class="bg-light">Nama Supplier</th>
                <td>{{ $supplier->nama }}</td>
            </tr>
            <tr>
                <th class="bg-light">Telepon</th>
                <td>{{ $supplier->telepon }}</td>
            </tr>
            <tr>
                <th class="bg-light">Email</th>
                <td>{{ $supplier->email }}</td>
            </tr>
            <tr>
                <th class="bg-light">Alamat</th>
                <td>{{ $supplier->alamat }}</td>
            </tr>
        </table>
        <a href="{{ route('master.supplier.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection