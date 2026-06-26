<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\BarangRequest;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->paginate(10);
        return view('master.barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('master.barang.create');
    }

    public function store(BarangRequest $request)
    {
        Barang::create($request->validated());

        return redirect()->route('master.barang.index')
                         ->with('success', 'Data Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        return view('master.barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        return view('master.barang.edit', compact('barang'));
    }

    public function update(BarangRequest $request, Barang $barang)
    {
        $barang->update($request->validated());

        return redirect()->route('master.barang.index')
                         ->with('success', 'Data Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('master.barang.index')
                         ->with('success', 'Data Barang berhasil dihapus.');
    }
}