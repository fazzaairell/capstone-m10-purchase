<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /** Daftar supplier: pencarian + pagination (10, 25, atau 50 baris) */
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->per_page, [10, 25, 50], true)
            ? (int) $request->per_page
            : 10;

        $suppliers = Supplier::query()
            ->when($request->q, fn ($q, $s) => $q->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('contact', 'like', "%{$s}%")
                  ->orWhere('kode', 'like', "%{$s}%");
            }))
            ->orderBy('kode')
            ->paginate($perPage)
            ->withQueryString();

        return view('supplier.index', compact('suppliers'));
    }

    /** Form tambah supplier */
    public function create()
    {
        return view('supplier.create');
    }

    /** Simpan supplier baru */
    public function store(SupplierRequest $request)
    {
        $supplier = Supplier::create($request->validated());

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier tersimpan')
            ->with('success_detail', "{$supplier->name} sudah masuk daftar supplier.");
    }

    /** Detail supplier */
    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    /** Form edit supplier */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /** Simpan perubahan */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return redirect()->route('suppliers.index')
            ->with('success', 'Perubahan tersimpan')
            ->with('success_detail', "Data {$supplier->name} sudah diperbarui.");
    }

    /** Hapus supplier */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
        } catch (QueryException $e) {
            // misalnya supplier sudah dipakai di purchase order
            return back()->with('error', 'Supplier tidak bisa dihapus karena masih dipakai di data lain.');
        }

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier dihapus')
            ->with('success_detail', "{$supplier->name} sudah dihapus dari daftar.");
    }
}