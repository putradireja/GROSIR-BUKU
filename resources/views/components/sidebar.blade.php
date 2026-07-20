@php
    $menuIcon = fn($path) => $path;
@endphp
<aside
    x-data="{ mobileOpen: false }"
    x-on:toggle-sidebar.window="mobileOpen = !mobileOpen"
>
    <!-- Mobile overlay -->
    <div
        x-show="mobileOpen"
        x-transition.opacity
        @click="mobileOpen = false"
        class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
        style="display: none;"
    ></div>

    <div
        :class="mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="sidebar-gradient fixed inset-y-0 left-0 z-40 flex w-72 flex-col gap-1 overflow-y-auto px-4 py-6 shadow-2xl transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen lg:translate-x-0"
    >
        <!-- Brand -->
        <div class="mb-6 flex items-center gap-3 px-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/20 shadow-inner backdrop-blur">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold leading-tight text-white">Grosir Buku</p>
                <p class="text-[11px] font-medium text-white/70">Dashboard Admin</p>
            </div>
        </div>

        <nav class="flex flex-1 flex-col gap-6">
            <div class="flex flex-col gap-1">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>
            </div>

            <div class="flex flex-col gap-1">
                <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-white/50">Master Data</p>
                <a href="{{ route('master.barang.index') }}" class="sidebar-link {{ request()->routeIs('master.barang.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    Barang
                </a>
                <a href="{{ route('master.supplier.index') }}" class="sidebar-link {{ request()->routeIs('master.supplier.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.017a3.001 3.001 0 0 0 3.75.616m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72" />
                    </svg>
                    Supplier
                </a>
                <a href="{{ route('master.konsumen.index') }}" class="sidebar-link {{ request()->routeIs('master.konsumen.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    Konsumen
                </a>
            </div>

            <div class="flex flex-col gap-1">
                <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-white/50">Transaksi</p>
                <a href="{{ route('pemesanan.index') }}" class="sidebar-link {{ request()->routeIs('pemesanan.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                    </svg>
                    Pemesanan
                </a>
                <a href="{{ route('pembelian.index') }}" class="sidebar-link {{ request()->routeIs('pembelian.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.8-4.798 2.25-7.316a.75.75 0 0 0-.383-1.437H6.858m.383 1.437 2.383 8.938m2.383-8.938L7.5 14.25m0 0L5.106 5.272M7.5 14.25c-1.657 0-3 1.343-3 3m3-3h9.75" />
                    </svg>
                    Pembelian
                </a>
                <a href="{{ route('penjualan.index') }}" class="sidebar-link {{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Penjualan
                </a>
            </div>

            <div class="flex flex-col gap-1">
                <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-white/50">Retur</p>
                <a href="{{ route('retur-pembelian.index') }}" class="sidebar-link {{ request()->routeIs('retur-pembelian.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    Retur Pembelian
                </a>
                <a href="{{ route('retur-penjualan.index') }}" class="sidebar-link {{ request()->routeIs('retur-penjualan.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3" />
                    </svg>
                    Retur Penjualan
                </a>
            </div>

            <div class="flex flex-col gap-1">
                <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-white/50">Keuangan</p>
                <a href="{{ route('penagihan.index') }}" class="sidebar-link {{ request()->routeIs('penagihan.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Penagihan
                </a>
                <a href="{{ route('pembayaran-hutang.index') }}" class="sidebar-link {{ request()->routeIs('pembayaran-hutang.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a1.5 1.5 0 0 0 1.5-1.5V6.75a1.5 1.5 0 0 0-1.5-1.5h-15a1.5 1.5 0 0 0-1.5 1.5v10.5a1.5 1.5 0 0 0 1.5 1.5Z" />
                    </svg>
                    Pembayaran Hutang
                </a>
            </div>

            <div class="flex flex-col gap-1">
                <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-white/50">Laporan</p>
                <a href="{{ route('laporan.index') }}" class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.5M12 15v3.75m3-6v6M8.25 6h7.5a2.25 2.25 0 0 1 2.25 2.25v9a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-9A2.25 2.25 0 0 1 8.25 6Z" />
                    </svg>
                    Laporan
                </a>
            </div>

            <div class="flex flex-col gap-1" x-data="{ laporanModulOpen: false }">
                <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-white/50">Laporan Modul</p>

                <button
                    type="button"
                    @click="laporanModulOpen = !laporanModulOpen"
                    class="sidebar-link w-full items-center justify-between"
                >
                    <span class="flex items-center gap-3">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Laporan Modul
                    </span>
                    <svg
                        class="h-4 w-4 shrink-0 transition-transform"
                        :class="laporanModulOpen ? 'rotate-180' : ''"
                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div x-show="laporanModulOpen" x-transition class="ml-4 flex flex-col gap-1 border-l border-white/10 pl-3">
                    <p class="mt-1 px-2 text-[10px] font-semibold uppercase tracking-wider text-white/40">Transaksi</p>
                    <a href="{{ asset('dokumen/laporan-pemesanan.pdf') }}" target="_blank" class="sidebar-link text-sm">Pemesanan</a>
                    <a href="{{ asset('dokumen/laporan-pembelian.pdf') }}" target="_blank" class="sidebar-link text-sm">Pembelian</a>
                    <a href="{{ asset('dokumen/laporan-penjualan.pdf') }}" target="_blank" class="sidebar-link text-sm">Penjualan</a>

                    <p class="mt-2 px-2 text-[10px] font-semibold uppercase tracking-wider text-white/40">Retur</p>
                    <a href="{{ asset('dokumen/laporan-retur-pembelian.pdf') }}" target="_blank" class="sidebar-link text-sm">Retur Pembelian</a>
                    <a href="{{ asset('dokumen/laporan-retur-penjualan.pdf') }}" target="_blank" class="sidebar-link text-sm">Retur Penjualan</a>

                    <p class="mt-2 px-2 text-[10px] font-semibold uppercase tracking-wider text-white/40">Keuangan</p>
                    <a href="{{ asset('dokumen/laporan-penagihan.pdf') }}" target="_blank" class="sidebar-link text-sm">Penagihan</a>
                    <a href="{{ asset('dokumen/laporan-hutang.pdf') }}" target="_blank" class="sidebar-link text-sm">Pembayaran Hutang</a>
                </div>
            </div>
        </nav>

        <div class="mt-4 flex flex-col gap-1 border-t border-white/15 pt-4">
            <a href="{{ asset('dokumen/BUKU PANDUAN PENGGUNA.pdf') }}" target="_blank" class="sidebar-link">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
                Panduan
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>