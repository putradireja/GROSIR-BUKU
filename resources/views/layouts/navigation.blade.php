<nav class="bg-white border-b border-purple-100 shadow-sm sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            {{-- Ruang kosong untuk tombol hamburger di HP --}}
            <div class="lg:hidden w-10"></div>

            {{-- Pencarian --}}
            <div class="flex-1 max-w-xl mx-4">
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Cari sesuatu..." 
                        class="w-full rounded-lg border border-gray-200 px-4 py-2 pl-10 text-sm focus:border-purple-500 focus:ring-purple-200 outline-none relative z-10"
                    >
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 z-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- Notifikasi & Profil --}}
            <div class="flex items-center gap-3 relative z-40">
                {{-- Tombol Notifikasi --}}
                <button class="relative p-2 rounded-lg text-gray-500 hover:text-purple-600 hover:bg-purple-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                {{-- Dropdown Profil --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-full border border-transparent bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 focus:outline-none transition">
                            {{-- ✅ Tampilkan Foto Profil atau Inisial --}}
                            <div class="h-8 w-8 rounded-full flex items-center justify-center overflow-hidden bg-purple-100">
                                @if(Auth::user()->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                @else
                                    <span class="text-purple-600 font-bold text-sm">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>

                            <div class="hidden sm:block">{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>