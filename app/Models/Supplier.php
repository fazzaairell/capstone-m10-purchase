<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'address',
        'kode',
        'aktif'
    ];

    /**
     * Buat kode otomatis (SUP-0001, SUP-0002, ...) saat supplier baru disimpan.
     */
    protected static function booted(): void
    {
        static::creating(function (Supplier $supplier) {
            if (blank($supplier->kode)) {
                $last = static::max('kode');                      // contoh: "SUP-0010" atau null
                $next = $last ? ((int) substr($last, 4)) + 1 : 1;
                $supplier->kode = sprintf('SUP-%04d', $next);
            }
        });
    }

    /**
     * Format tampilan kontak. Kalau isinya nomor telepon, dikelompokkan per 4 digit
     * sesuai panduan (0812 3456 7890). Kalau isinya nama atau teks lain, dibiarkan apa adanya.
     * Dipakai di view: $supplier->contact_format
     */
    protected function contactFormat(): Attribute
    {
        return Attribute::get(function () {
            $raw = trim($this->contact ?? '');

            if (! preg_match('/^\+?[\d\s\-]+$/', $raw)) {
                return $raw;
            }

            $clean = preg_replace('/[^\d+]/', '', $raw);

            if (str_starts_with($clean, '+62')) {
                return '+62 ' . trim(chunk_split(substr($clean, 3), 4, ' '));
            }

            return trim(chunk_split(preg_replace('/\D/', '', $clean), 4, ' '));
        });
    }
}