@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col gap-6">

    {{-- Welcome banner --}}
    <div class="card-premium relative overflow-hidden bg-gradient-to-r from-pink-500 via-fuchsia-500 to-purple-600 p-6 text-white sm:p-8">
        <div class="relative z-10">
            <p class="text-sm font-medium text-white/80">Selamat datang kembali,</p>
            <h2 class="mt-1 text-2xl font-extrabold sm:text-3xl">{{ auth()->user()->name }} 👋</h2>
            <p class="mt-2 max-w-lg text-sm text-white/80">Berikut ringkasan performa toko buku grosir Anda hari ini, {{ now()->translatedFormat('l, d F Y') }}.</p>
        </div>
        <div class="pointer-events-none absolute -right-10 -top-10 h-56 w-56 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute -bottom-16 right-24 h-40 w-40 rounded-full bg-white/10"></div>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <div class="stat-grad-pink card-premium flex items-center justify-between p-5 text-white transition hover:-translate-y-1">
            <div>
                <p class="text-xs font-medium text-white/80">Total Buku</p>
                <p class="mt-1 text-2xl font-extrabold">{{ number_format($stats['total_barang']) }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
        </div>

        <div class="stat-grad-purple card-premium flex items-center justify-between p-5 text-white transition hover:-translate-y-1">
            <div>
                <p class="text-xs font-medium text-white/80">Total Supplier</p>
                <p class="mt-1 text-2xl font-extrabold">{{ number_format($stats['total_supplier']) }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349" />
                </svg>
            </div>
        </div>

        <div class="stat-grad-fuchsia card-premium flex items-center justify-between p-5 text-white transition hover:-translate-y-1">
            <div>
                <p class="text-xs font-medium text-white/80">Total Konsumen</p>
                <p class="mt-1 text-2xl font-extrabold">{{ number_format($stats['total_konsumen']) }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766" />
                </svg>
            </div>
        </div>

        <div class="stat-grad-dark card-premium flex items-center justify-between p-5 text-white transition hover:-translate-y-1">
            <div>
                <p class="text-xs font-medium text-white/80">Stok Menipis</p>
                <p class="mt-1 text-2xl font-extrabold">{{ number_format($stats['stok_menipis']) }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <x-card class="xl:col-span-1">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Penjualan</p>
            <p class="mt-2 text-xl font-extrabold text-slate-800">Rp {{ number_format($stats['total_penjualan'], 0, ',', '.') }}</p>
        </x-card>
        <x-card class="xl:col-span-1">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Pembelian</p>
            <p class="mt-2 text-xl font-extrabold text-slate-800">Rp {{ number_format($stats['total_pembelian'], 0, ',', '.') }}</p>
        </x-card>
        <x-card class="xl:col-span-1">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Piutang</p>
            <p class="mt-2 text-xl font-extrabold text-pink-600">Rp {{ number_format($stats['total_piutang'], 0, ',', '.') }}</p>
        </x-card>
        <x-card class="xl:col-span-1">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Hutang</p>
            <p class="mt-2 text-xl font-extrabold text-purple-600">Rp {{ number_format($stats['total_hutang'], 0, ',', '.') }}</p>
        </x-card>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">
        <x-card title="Statistik Penjualan &amp; Pembelian" subtitle="6 bulan terakhir" class="xl:col-span-2">
            <canvas id="chartPenjualan" height="110"></canvas>
        </x-card>
        <x-card title="Kategori Buku" subtitle="Distribusi stok per kategori">
            <canvas id="chartKategori" height="200"></canvas>
        </x-card>
    </div>
</div>

@push('scripts')
@endpush

<script>
document.addEventListener('DOMContentLoaded', function () {
    const palette = { pink: '#EC4899', purple: '#7C3AED', fuchsia: '#C026D3' };

    new Chart(document.getElementById('chartPenjualan'), {
        type: 'line',
        data: {
            labels: (@json($chart['bulan_labels'])),
            datasets: [
                {
                    label: 'Penjualan',
                    data: (@json($chart['penjualan_bulanan'])),
                    borderColor: palette.pink,
                    backgroundColor: 'rgba(236,72,153,0.12)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: palette.pink,
                },
                {
                    label: 'Pembelian',
                    data: (@json($chart['pembelian_bulanan'])),
                    borderColor: palette.purple,
                    backgroundColor: 'rgba(124,58,237,0.10)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: palette.purple,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, font: { family: 'Plus Jakarta Sans' } } } },
            scales: {
                y: { grid: { color: '#f1f5f9' }, ticks: { font: { family: 'Plus Jakarta Sans' } } },
                x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans' } } },
            },
        },
    });

    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: (@json($chart['kategori_labels'])),
            datasets: [{
                data: (@json($chart['kategori_data'])),
                backgroundColor: ['#EC4899', '#7C3AED', '#C026D3', '#f472b6', '#a78bfa', '#e879f9'],
                borderWidth: 2,
                borderColor: '#fff',
            }],
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, font: { family: 'Plus Jakarta Sans', size: 11 } } } },
        },
    });
});
</script>
@endsection