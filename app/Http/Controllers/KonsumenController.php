<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use App\Http\Requests\KonsumenRequest;

class KonsumenController extends Controller
{
    public function index()
    {
        $konsumens = Konsumen::latest()->paginate(10);
        return view('master.konsumen.index', compact('konsumens'));
    }

    public function create()
    {
        return view('master.konsumen.create');
    }

    public function store(KonsumenRequest $request)
    {
        Konsumen::create($request->validated());

        return redirect()->route('master.konsumen.index')
                         ->with('success', 'Data Konsumen berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Cari data berdasarkan ID untuk menghindari error singularisasi Laravel
        $konsumen = Konsumen::findOrFail($id);
        return view('master.konsumen.show', compact('konsumen'));
    }

    public function edit($id)
    {
        $konsumen = Konsumen::findOrFail($id);
        return view('master.konsumen.edit', compact('konsumen'));
    }

    public function update(KonsumenRequest $request, $id)
    {
        $konsumen = Konsumen::findOrFail($id);
        $konsumen->update($request->validated());

        return redirect()->route('master.konsumen.index')
                         ->with('success', 'Data Konsumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $konsumen = Konsumen::findOrFail($id);
        $konsumen->delete();

        return redirect()->route('master.konsumen.index')
                         ->with('success', 'Data Konsumen berhasil dihapus.');
    }
}