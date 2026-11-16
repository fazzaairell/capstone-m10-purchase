<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequest extends Model
{
    public const DEPARTMENTS = [
        'Operasional', 'Gudang dan logistik', 'Keuangan', 'Pemasaran',
        'Penjualan', 'Produksi', 'Teknologi informasi', 'SDM dan umum',
    ];

    public const UNITS = ['Pcs', 'Unit', 'Set', 'Box', 'Pak', 'Kg', 'Liter', 'Meter', 'Paket', 'Jam'];

    protected $fillable = [
        'pr_number', 'requester_name', 'department', 'reason',
        'total_estimated', 'status', 'submitted_at',
    ];

    protected $attributes = [
        'status'          => 'draft',
        'total_estimated' => 0,
    ];

    protected function casts(): array
    {
        return [
            'total_estimated' => 'decimal:2',
            'submitted_at'    => 'datetime',
        ];
    }

    /** Nomor otomatis PR-0001, PR-0002, ... */
    protected static function booted(): void
    {
        static::creating(function (PurchaseRequest $pr) {
            if (blank($pr->pr_number)) {
                $last = static::max('pr_number');
                $next = $last ? ((int) substr($last, 3)) + 1 : 1;
                $pr->pr_number = sprintf('PR-%04d', $next);
            }
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }
}