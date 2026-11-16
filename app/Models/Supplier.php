<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    // ===== Daftar pilihan: nilai di database => label tampilan =====
    public const TAX_TYPES = ['PKP' => 'PKP', 'NON_PKP' => 'Non-PKP'];

    public const DELIVERY_TYPES = [
        'DC'  => 'Gudang pusat (DC)',
        'DSD' => 'Langsung ke toko (DSD)',
    ];

    public const RETURN_POLICIES = [
        'Exchange'    => 'Tukar barang',
        'Credit_Note' => 'Nota kredit',
        'No_Return'   => 'Tidak bisa retur',
    ];

    public const PAYMENT_TERMS = [
        'COD' => 'COD', 'Net 7' => 'Net 7', 'Net 14' => 'Net 14',
        'Net 30' => 'Net 30', 'Net 45' => 'Net 45', 'Net 60' => 'Net 60',
    ];

    public const STATUSES = [
        'active'     => 'Aktif',
        'suspended'  => 'Ditangguhkan',
        'terminated' => 'Dihentikan',
    ];

    // status => warna badge baku di Panduan UI (success, pending, danger)
    public const STATUS_BADGE = [
        'active'     => 'success',
        'suspended'  => 'pending',
        'terminated' => 'danger',
    ];

    public const RATINGS = [
        5 => '5 - Sangat baik', 4 => '4 - Baik', 3 => '3 - Cukup', 2 => '2 - Kurang', 1 => '1 - Buruk',
    ];

    protected $fillable = [
        'supplier_code', 'company_name',
        'tax_type', 'npwp',
        'contact_person', 'email', 'phone',
        'address', 'city', 'postal_code',
        'delivery_type', 'lead_time_days', 'minimum_order_qty', 'return_policy',
        'payment_terms', 'bank_name', 'account_number', 'account_holder',
        'status', 'rating', 'notes',
    ];

    // nilai awal untuk supplier baru (sama dengan DEFAULT di database)
    protected $attributes = [
        'tax_type'          => 'PKP',
        'delivery_type'     => 'DC',
        'lead_time_days'    => 3,
        'minimum_order_qty' => 0,
        'return_policy'     => 'Credit_Note',
        'payment_terms'     => 'Net 30',
        'status'            => 'active',
        'rating'            => 5,
    ];

    protected function casts(): array
    {
        return [
            'lead_time_days'    => 'integer',
            'rating'            => 'integer',
            'minimum_order_qty' => 'decimal:2',
        ];
    }

    /** Kode otomatis SUP-0001, SUP-0002, ... (withTrashed supaya kode data terhapus tidak dipakai ulang) */
    protected static function booted(): void
    {
        static::creating(function (Supplier $supplier) {
            if (blank($supplier->supplier_code)) {
                $last = static::withTrashed()->max('supplier_code');
                $next = $last ? ((int) substr($last, 4)) + 1 : 1;
                $supplier->supplier_code = sprintf('SUP-%04d', $next);
            }
        });
    }

    // ===== Accessor untuk tampilan (dipakai di view) =====
    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => self::STATUSES[$this->status] ?? $this->status);
    }

    protected function statusType(): Attribute
    {
        return Attribute::get(fn () => self::STATUS_BADGE[$this->status] ?? 'neutral');
    }

    protected function taxLabel(): Attribute
    {
        return Attribute::get(fn () => self::TAX_TYPES[$this->tax_type] ?? $this->tax_type);
    }

    protected function deliveryLabel(): Attribute
    {
        return Attribute::get(fn () => self::DELIVERY_TYPES[$this->delivery_type] ?? $this->delivery_type);
    }

    protected function returnPolicyLabel(): Attribute
    {
        return Attribute::get(fn () => self::RETURN_POLICIES[$this->return_policy] ?? $this->return_policy);
    }

    /** 0812 3456 7890 (dikelompokkan per 4 digit sesuai panduan) */
    protected function phoneFormat(): Attribute
    {
        return Attribute::get(function () {
            $raw = preg_replace('/[^\d+]/', '', $this->phone ?? '');

            if (str_starts_with($raw, '+62')) {
                return '+62 ' . trim(chunk_split(substr($raw, 3), 4, ' '));
            }

            return trim(chunk_split(preg_replace('/\D/', '', $raw), 4, ' '));
        });
    }

    /** 15 digit: 01.234.567.8-901.000 | 16 digit: dikelompokkan per 4 */
    protected function npwpFormat(): Attribute
    {
        return Attribute::get(function () {
            $d = $this->npwp;

            if (blank($d)) {
                return null;
            }

            if (strlen($d) === 15) {
                return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d)(\d{3})(\d{3})$/', '$1.$2.$3.$4-$5.$6', $d);
            }

            return trim(chunk_split($d, 4, ' '));
        });
    }

    /** Rp 1.250.000 */
    protected function minimumOrderFormat(): Attribute
    {
        return Attribute::get(function () {
            $n = (float) $this->minimum_order_qty;

            return 'Rp ' . number_format($n, fmod($n, 1) == 0.0 ? 0 : 2, ',', '.');
        });
    }

    /** Inisial perusahaan untuk avatar: "PT Sumber Pangan Nusantara" jadi "SP" */
protected function initials(): Attribute
{
    return Attribute::get(function () {
        $name  = preg_replace('/^(PT|CV|UD)\.?\s+/i', '', (string) $this->company_name);
        $words = preg_split('/\s+/', trim($name));

        return mb_strtoupper(mb_substr($words[0] ?? '', 0, 1) . mb_substr($words[1] ?? '', 0, 1));
    });
}
}