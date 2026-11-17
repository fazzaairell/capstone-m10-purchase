<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequestStoreRequest;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    /** Halaman awal: daftar permintaan pembelian */
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->per_page, [10, 25, 50], true)
            ? (int) $request->per_page
            : 10;

        $purchaseRequests = PurchaseRequest::query()
            ->withCount('items')
            ->when($request->q, fn ($q, $s) => $q->where(function ($q) use ($s) {
                $q->where('pr_number', 'like', "%{$s}%")
                  ->orWhere('requester_name', 'like', "%{$s}%")
                  ->orWhere('department', 'like', "%{$s}%");
            }))
            ->when(
                array_key_exists((string) $request->status, PurchaseRequest::STATUSES),
                fn ($q) => $q->where('status', $request->status)
            )
            ->orderByDesc('id') // yang terbaru di atas
            ->paginate($perPage)
            ->withQueryString();

        // jumlah per status, untuk kartu ringkasan
        $counts = PurchaseRequest::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('purchase-request.index', compact('purchaseRequests', 'counts'));
    }

    /** Form ajukan pembelian baru */
    public function create()
    {
        return view('purchase-request.create');
    }

    /** Simpan sebagai draf atau kirim pengajuan */
    public function store(PurchaseRequestStoreRequest $request)
    {
        $data       = $request->validated();
        $submitting = $data['action'] === 'submit';

        $items = collect($data['items'] ?? [])->map(fn ($i) => [
            'name'            => $i['name'],
            'quantity'        => $i['quantity'],
            'unit'            => $i['unit'],
            'estimated_price' => $i['price'] ?? 0,
        ])->values();

        $purchaseRequest = DB::transaction(function () use ($data, $items, $submitting) {
            $pr = PurchaseRequest::create([
                'requester_name'  => $data['requester_name'],
                'department'      => $data['department'] ?? null,
                'reason'          => $data['reason'] ?? null,
                // total dihitung ulang di server, bukan dari angka di browser
                'total_estimated' => round($items->sum(fn ($i) => $i['quantity'] * $i['estimated_price']), 2),
                'status'          => $submitting ? 'pending' : 'draft',
                'submitted_at'    => $submitting ? now() : null,
            ]);

            $pr->items()->createMany($items->all());

            return $pr;
        });

        return redirect()->route('purchase-requests.index')
            ->with('success', $submitting ? 'Pengajuan terkirim' : 'Draf tersimpan')
            ->with('success_detail', $submitting
                ? "{$purchaseRequest->pr_number} menunggu persetujuan."
                : "{$purchaseRequest->pr_number} disimpan sebagai draf.");
    }
}