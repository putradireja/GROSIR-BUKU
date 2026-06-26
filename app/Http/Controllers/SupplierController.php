<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    public function index() {
        $suppliers = Supplier::latest()->paginate(10);
        return view('master.supplier.index', compact('suppliers'));
    }

    public function create() {
        return view('master.supplier.create');
    }

    public function store(SupplierRequest $request) {
        Supplier::create($request->validated());
        return redirect()->route('master.supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier) {
        return view('master.supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier) {
        return view('master.supplier.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier) {
        $supplier->update($request->validated());
        return redirect()->route('master.supplier.index')->with('success', 'Supplier berhasil diupdate.');
    }

    public function destroy(Supplier $supplier) {
        $supplier->delete();
        return redirect()->route('master.supplier.index')->with('success', 'Supplier dihapus.');
    }
}