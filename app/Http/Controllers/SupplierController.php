<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /** Daftar: pencarian, filter status dan pengiriman, pagination 10/25/50 */
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->per_page, [10, 25, 50], true)
            ? (int) $request->per_page
            : 10;

        $suppliers = Supplier::query()
            ->when($request->q, fn ($q, $s) => $q->where(function ($q) use ($s) {
                $q->where('supplier_code', 'like', "%{$s}%")
                  ->orWhere('company_name', 'like', "%{$s}%")
                  ->orWhere('contact_person', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('city', 'like', "%{$s}%");
            }))
            ->when(
                array_key_exists((string) $request->status, Supplier::STATUSES),
                fn ($q) => $q->where('status', $request->status)
            )
            ->when(
                array_key_exists((string) $request->delivery, Supplier::DELIVERY_TYPES),
                fn ($q) => $q->where('delivery_type', $request->delivery)
            )
            ->orderBy('supplier_code')
            ->paginate($perPage)
            ->withQueryString();

        // jumlah supplier per status, untuk kartu ringkasan di atas tabel
        $counts = Supplier::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('supplier.index', compact('suppliers', 'counts'));
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
            ->with('success_detail', "{$supplier->company_name} ({$supplier->supplier_code}) sudah masuk daftar supplier.");
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

        return redirect()->route('suppliers.show', $supplier)
            ->with('success', 'Perubahan tersimpan')
            ->with('success_detail', "Data {$supplier->company_name} sudah diperbarui.");
    }

    /** Soft delete: data disembunyikan dari daftar, tidak dihapus permanen */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier dihapus')
            ->with('success_detail', "{$supplier->company_name} tidak tampil lagi di daftar. Riwayat transaksinya tetap tersimpan.");
    }
}