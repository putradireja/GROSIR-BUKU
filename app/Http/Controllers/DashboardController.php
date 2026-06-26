<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        // Logika ringkasan penjualan, stok, piutang, hutang (akan dilengkapi di modul terkait)
        return view('dashboard');
    }
}
