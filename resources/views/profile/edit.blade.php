@extends('layouts.app')

@section('title', 'Profil Akun')

@section('content')
<x-card title="Pengaturan Profil" subtitle="Kelola informasi akun dan foto profil Anda">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Bagian Foto Profil --}}
        <div class="lg:col-span-1">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl p-6 text-center text-white shadow-lg">
                @csrf
                @method('patch')

                <div class="relative mx-auto w-28 h-28 mb-4">
                    {{-- Tampilkan Foto Profil --}}
                    @if(Auth::user()->foto_profil)
                        <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover rounded-full border-4 border-white/30">
                    @else
                        <div class="w-full h-full rounded-full bg-white/20 flex items-center justify-center text-4xl font-bold border-4 border-white/30">
                            {{ mb_substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif

                    {{-- Tombol Ganti Foto --}}
                    <label for="foto_profil" class="absolute -bottom-1 -right-1 bg-white rounded-full p-2 shadow-lg cursor-pointer hover:bg-gray-50 transition">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="hidden" onchange="this.form.submit()">
                    </label>
                </div>

                <h3 class="text-xl font-bold">{{ Auth::user()->name }}</h3>
                <p class="text-white/80 text-sm mt-1">{{ Auth::user()->email }}</p>
                <div class="mt-4 px-3 py-1 rounded-full bg-white/20 text-xs font-medium inline-block">
                    {{ Auth::user()->role ?? 'Administrator' }}
                </div>

                @if (session('status') === 'profile-updated')
                    <p class="mt-3 text-xs text-white/90 font-medium">Foto profil diperbarui!</p>
                @endif
            </form>

            <div class="mt-5 p-4 bg-gray-50 rounded-xl border border-gray-100">
                <h4 class="font-semibold text-sm text-gray-700 mb-3">Informasi Akun</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Terdaftar sejak</span>
                        <span class="font-medium text-gray-700">{{ Auth::user()->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Terakhir diperbarui</span>
                        <span class="font-medium text-gray-700">{{ Auth::user()->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sisa form ubah data dan ganti sandi tetap sama seperti sebelumnya --}}
        <div class="lg:col-span-2 space-y-5">
            {{-- Form ubah nama & email --}}
            <form method="POST" action="{{ route('profile.update') }}" class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm">
                @csrf
                @method('patch')

                <h4 class="text-lg font-semibold text-gray-800 mb-4">Ubah Informasi Profil</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name" name="name" type="text" class="mt-1.5" :value="old('name', Auth::user()->name)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Alamat Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1.5" :value="old('email', Auth::user()->email)" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6">
                    <x-button type="submit" variant="primary">Simpan Perubahan</x-button>
                </div>
            </form>

            {{-- Form ganti sandi & hapus akun tetap sama seperti sebelumnya --}}
        </div>
    </div>
</x-card>

{{-- Modal dan form verifikasi tetap sama --}}
@endsection