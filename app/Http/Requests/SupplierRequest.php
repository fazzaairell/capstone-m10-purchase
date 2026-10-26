<?php

namespace App\Http\Requests;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rapikan input sebelum divalidasi:
     * spasi di awal dan akhir dihapus, spasi ganda di tengah jadi satu.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'    => preg_replace('/\s+/', ' ', trim((string) $this->name)),
            'contact' => preg_replace('/\s+/', ' ', trim((string) $this->contact)),
        ]);
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:150'],
            'contact' => [
                'required', 'string', 'max:100',
                // duplikat = nama dan kontak sama, huruf besar/kecil diabaikan
                function ($attribute, $value, $fail) {
                    $exists = Supplier::query()
                        ->whereRaw('LOWER(name) = ?', [mb_strtolower($this->input('name'))])
                        ->whereRaw('LOWER(contact) = ?', [mb_strtolower($value)])
                        // saat edit, abaikan data supplier itu sendiri
                        ->when($this->route('supplier'), fn ($q, $s) => $q->whereKeyNot($s->getKey()))
                        ->exists();

                    if ($exists) {
                        $fail('Supplier dengan nama dan kontak ini sudah terdaftar. Ubah nama atau kontaknya.');
                    }
                },
            ],
            'address' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Isi nama supplier.',
            'name.max'         => 'Nama supplier maksimal 150 karakter. Persingkat namanya.',
            'contact.required' => 'Isi nama kontak atau nomor telepon.',
            'contact.max'      => 'Kontak maksimal 100 karakter. Persingkat isinya.',
            'address.required' => 'Isi alamat supplier.',
        ];
    }
}