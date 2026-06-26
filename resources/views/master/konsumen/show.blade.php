@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Detail Konsumen</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200px" class="bg-light">Kode Konsumen</th>
                <td>{{ $konsumen->kode }}</td>
            </tr>
            <tr>
                <th class="bg-light">Nama Konsumen</th>
                <td>{{ $konsumen->nama }}</td>
            </tr>
            <tr>
                <th class="bg-light">Telepon</th>
                <td>{{ $konsumen->telepon }}</td>
            </tr>
            <tr>
                <th class="bg-light">Email</th>
                <td>{{ $konsumen->email }}</td>
            </tr>
            <tr>
                <th class="bg-light">Alamat</th>
                <td>{{ $konsumen->alamat }}</td>
            </tr>
        </table>
        <a href="{{ route('master.konsumen.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection