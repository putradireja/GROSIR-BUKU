<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController, SupplierController, KonsumenController, BarangController,
    PemesananController, PembelianController, PenjualanController, PenagihanController,
    PembayaranHutangController, ReturPenjualanController, ReturPembelianController, LaporanController
};
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Modul 1 - Master
    Route::prefix('master')->name('master.')->group(function() {
        Route::resource('supplier', SupplierController::class);
        Route::resource('konsumen', KonsumenController::class);
        Route::resource('barang', BarangController::class);
    });

    // Modul 2 & 3 - Pemesanan & Pembelian
    Route::resource('pemesanan', PemesananController::class);
    Route::post('pemesanan/{id}/approve', [PemesananController::class, 'approve'])->name('pemesanan.approve');
    Route::post('pemesanan/{id}/cancel', [PemesananController::class, 'cancel'])->name('pemesanan.cancel');
    
    Route::resource('pembelian', PembelianController::class);

    // Modul 4 - Penjualan
    Route::resource('penjualan', PenjualanController::class);

    // Modul 5 & 6 - Penagihan & Hutang
    Route::resource('penagihan', PenagihanController::class);
    Route::resource('pembayaran-hutang', PembayaranHutangController::class);

    // Modul 7 - Retur
    Route::resource('retur-penjualan', ReturPenjualanController::class);
    Route::resource('retur-pembelian', ReturPembelianController::class);

    // Modul 8 - Laporan
    Route::prefix('laporan')->name('laporan.')->group(function() {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::post('/cetak', [LaporanController::class, 'cetak'])->name('cetak');
    });
});