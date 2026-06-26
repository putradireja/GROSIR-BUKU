@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Dashboard</div>
    <div class="card-body">
        <h5>Selamat datang, {{ auth()->user()->name }}</h5>
        <p>Ringkasan sistem akan ditampilkan di sini.</p>
    </div>
</div>
@endsection