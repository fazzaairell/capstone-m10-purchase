<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequestStoreRequest;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    /** Form buat permintaan pembelian */
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

        return redirect()->route('purchase-requests.create')
            ->with('success', $submitting ? 'Pengajuan terkirim' : 'Draf tersimpan')
            ->with('success_detail', $submitting
                ? "{$purchaseRequest->pr_number} menunggu persetujuan."
                : "{$purchaseRequest->pr_number} disimpan sebagai draf.");
    }
}