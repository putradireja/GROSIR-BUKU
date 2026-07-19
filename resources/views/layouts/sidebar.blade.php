@props([])
@php
    $currentRoute = \Route::currentRouteName();
@endphp

{{-- Logika utama sidebar --}}
<div x-data="{ sidebarOpen: false }" class="relative">

    {{-- Overlay --}}
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        style="display: none;"
    ></div>

    {{-- Sidebar --}}
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 z-50 h-screen w-64 bg-gradient-to-b from-pink-500 via-purple-500 to-purple-700 text-white shadow-xl transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static"
    >
        {{-- Header & Menu tetap sama seperti sebelumnya --}}
        <div class="p-5 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Grosir Buku</h3>
                    <p class="text-xs text-white/60">Dashboard Admin</p>
                </div>
            </div>
        </div>

        {{-- Sisa menu tetap sama seperti yang sudah kamu buat --}}
    </aside>

    {{-- ✅ Tombol Hamburger: Z-index tertinggi, tidak tertutup --}}
    <button 
        @click="sidebarOpen = !sidebarOpen"
        class="fixed top-4 left-4 z-[999] lg:hidden bg-white p-2 rounded-lg shadow-lg hover:bg-gray-50 transition-colors"
    >
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>