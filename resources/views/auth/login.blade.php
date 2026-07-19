<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login &mdash; Grosir Buku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen bg-gradient-to-br from-pink-500 via-fuchsia-500 to-purple-700">

        {{-- Left: illustration --}}
        <div class="relative hidden w-1/2 flex-col items-center justify-center overflow-hidden p-12 text-white lg:flex">
            <div class="pointer-events-none absolute -left-16 -top-16 h-72 w-72 rounded-full bg-white/10"></div>
            <div class="pointer-events-none absolute -bottom-24 right-0 h-96 w-96 rounded-full bg-white/10"></div>

            <div class="relative z-10 flex max-w-md flex-col items-center text-center">
                <div class="mb-8 flex h-28 w-28 items-center justify-center rounded-3xl bg-white/15 backdrop-blur">
                    <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke-width="1.4" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold leading-tight">Grosir Buku</h1>
                <p class="mt-3 text-sm leading-relaxed text-white/80">
                    Kelola stok, transaksi, dan keuangan toko buku grosir Anda dalam satu dashboard premium yang cepat dan rapi.
                </p>
            </div>
        </div>

        {{-- Right: login card --}}
        <div class="flex w-full items-center justify-center p-6 lg:w-1/2">
            <div class="w-full max-w-md rounded-3xl bg-white/95 p-8 shadow-soft-xl backdrop-blur sm:p-10">
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-2xl font-extrabold text-slate-800">Selamat Datang 👋</h2>
                    <p class="mt-1 text-sm text-slate-400">Masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                @if($errors->any())
                    <div class="mb-5 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm font-medium text-red-500">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                    @csrf

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" type="email" name="email" required autofocus class="mt-1.5" placeholder="nama@email.com" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password" type="password" name="password" required class="mt-1.5" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 text-slate-500">
                            <input type="checkbox" name="remember" class="rounded border-purple-200 text-pink-500 focus:ring-pink-400">
                            Ingat saya
                        </label>

                        @if(\Illuminate\Support\Facades\Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-semibold text-purple-600 hover:text-pink-500">Lupa password</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-premium-primary w-full py-3 text-sm">
                        Masuk
                    </button>
                    </form>

                    @if(\Illuminate\Support\Facades\Route::has('register'))
                        <p class="text-center text-sm text-slate-600 mt-6">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-semibold text-purple-600 hover:text-pink-500">Daftar di sini</a>
                        </p>
                    @endif
            </div>
        </div>
    </div>
</body>
</html>