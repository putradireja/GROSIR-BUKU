<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') &mdash; Grosir Buku</title>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Aset --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-700 antialiased latar-gerak">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <x-sidebar />

        {{-- Wadah Kanan (Navbar + Konten) --}}
        <div class="flex min-h-screen w-full flex-1 flex-col lg:ml-0">
            {{-- Navbar Atas --}}
            <x-navbar :title="trim($__env->yieldContent('title')) ?: 'Dashboard'" />

            {{-- Konten Utama --}}
            <main class="flex-1 px-4 py-6 lg:px-8">
                {{-- Pesan Sukses --}}
                @if(session('success'))
                    <div class="mb-5 flex items-center gap-3 rounded-2xl border border-green-100 bg-green-50 px-4 py-3 text-sm font-medium text-green-700 shadow-sm">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Pesan Error --}}
                @if(session('error'))
                    <div class="mb-5 flex items-center gap-3 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 shadow-sm">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Isi Halaman --}}
                @yield('content')
            </main>

            {{-- Footer --}}
            <x-footer />
        </div>
    </div>

    {{-- Skrip Tambahan --}}
    @stack('scripts')
</body>
</html>