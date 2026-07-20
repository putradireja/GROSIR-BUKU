@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Laporan {{ ucfirst($jenis) }}</h3>
    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-secondary mb-3">Kembali</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                @if($data->isNotEmpty())
                    @foreach(array_keys($data->first()->getAttributes()) as $kolom)
                        <th>{{ $kolom }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    @foreach($row->getAttributes() as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @empty
                <tr><td>Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection