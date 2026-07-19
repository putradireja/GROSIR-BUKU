<x-guest-layout>
    <div class="mb-8 text-center lg:text-left">
        <h2 class="text-2xl font-extrabold text-slate-800">Buat Akun Baru ✨</h2>
        <p class="mt-1 text-sm text-slate-400">Daftar untuk mulai mengelola toko buku grosir Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
        @csrf

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" class="mt-1.5" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1.5" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="mt-1.5" type="password" name="password" required autocomplete="new-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" class="mt-1.5" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <button type="submit" class="btn-premium-primary w-full py-3 text-sm">
            Daftar
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-400">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-purple-600 hover:text-pink-500">Masuk di sini</a>
    </p>
</x-guest-layout>