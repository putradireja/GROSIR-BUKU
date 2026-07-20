<!DOCTYPE html>
<html>
<head>
    <title>Laporan {{ ucfirst($jenis) }}</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; font-size: 12px; }
    </style>
</head>
<body>
    <h3>Laporan {{ ucfirst($jenis) }}</h3>
    <table>
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
</body>
</html>