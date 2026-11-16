<?php

namespace App\Http\Requests;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Rapikan input: spasi berlebih dihapus, NPWP/kode pos/rekening hanya angka, kosong jadi null */
    protected function prepareForValidation(): void
    {
        $text   = fn ($v) => filled($v) ? preg_replace('/\s+/', ' ', trim((string) $v)) : null;
        $digits = fn ($v) => filled($v) ? (preg_replace('/\D/', '', (string) $v) ?: null) : null;
        $plain  = fn ($v) => filled($v) ? trim((string) $v) : null;

        $this->merge([
            'company_name'   => $text($this->company_name),
            'contact_person' => $text($this->contact_person),
            'email'          => filled($this->email) ? mb_strtolower(trim($this->email)) : null,
            'phone'          => $text($this->phone),
            'address'        => $plain($this->address),
            'city'           => $text($this->city),
            'postal_code'    => $digits($this->postal_code),
            'npwp'           => $digits($this->npwp),
            'bank_name'      => $text($this->bank_name),
            'account_number' => $digits($this->account_number),
            'account_holder' => $text($this->account_holder),
            'notes'          => $plain($this->notes),
        ]);
    }

    public function rules(): array
    {
        return [
            // identitas
            'company_name' => ['required', 'string', 'max:150'],

            // legalitas dan pajak: NPWP wajib kalau PKP
            'tax_type' => ['required', Rule::in(array_keys(Supplier::TAX_TYPES))],
            'npwp'     => [Rule::requiredIf($this->tax_type === 'PKP'), 'nullable', 'digits_between:15,16'],

            // narahubung (pengecekan duplikat ada di contact_person)
            'contact_person' => ['required', 'string', 'max:100', $this->notDuplicate()],
            'email'          => ['required', 'email:rfc', 'max:100'],
            'phone'          => ['required', 'string', 'max:25', 'regex:/^\+?[0-9\s\-]{8,25}$/'],

            // alamat
            'address'     => ['required', 'string', 'max:1000'],
            'city'        => ['required', 'string', 'max:60'],
            'postal_code' => ['nullable', 'digits:5'],

            // logistik dan pengadaan
            'delivery_type'     => ['required', Rule::in(array_keys(Supplier::DELIVERY_TYPES))],
            'lead_time_days'    => ['required', 'integer', 'min:0', 'max:365'],
            'minimum_order_qty' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'return_policy'     => ['required', Rule::in(array_keys(Supplier::RETURN_POLICIES))],

            // keuangan: data rekening diisi lengkap atau dikosongkan semua
            'payment_terms'  => ['required', Rule::in(array_keys(Supplier::PAYMENT_TERMS))],
            'bank_name'      => ['nullable', 'string', 'max:50', 'required_with:account_number,account_holder'],
            'account_number' => ['nullable', 'digits_between:5,30', 'required_with:bank_name,account_holder'],
            'account_holder' => ['nullable', 'string', 'max:100', 'required_with:bank_name,account_number'],

            // evaluasi
            'status' => ['required', Rule::in(array_keys(Supplier::STATUSES))],
            'rating' => ['required', 'integer', 'between:1,5'],
            'notes'  => ['nullable', 'string', 'max:2000'],
        ];
    }

    /** Duplikat = nama perusahaan dan narahubung sama (huruf besar/kecil diabaikan) */
    private function notDuplicate(): \Closure
    {
        return function ($attribute, $value, $fail) {
            $exists = Supplier::query()
                ->whereRaw('LOWER(company_name) = ?', [mb_strtolower((string) $this->input('company_name'))])
                ->whereRaw('LOWER(contact_person) = ?', [mb_strtolower((string) $value)])
                ->when($this->route('supplier'), fn ($q, $s) => $q->whereKeyNot($s->getKey()))
                ->exists();

            if ($exists) {
                $fail('Supplier dengan nama perusahaan dan narahubung ini sudah terdaftar. Ubah nama perusahaan atau narahubungnya.');
            }
        };
    }

    public function attributes(): array
    {
        return [
            'company_name'      => 'nama perusahaan',
            'tax_type'          => 'status pajak',
            'npwp'              => 'NPWP',
            'contact_person'    => 'narahubung',
            'email'             => 'email',
            'phone'             => 'nomor telepon',
            'address'           => 'alamat',
            'city'              => 'kota',
            'postal_code'       => 'kode pos',
            'delivery_type'     => 'jenis pengiriman',
            'lead_time_days'    => 'lead time',
            'minimum_order_qty' => 'minimum order',
            'return_policy'     => 'kebijakan retur',
            'payment_terms'     => 'termin pembayaran',
            'bank_name'         => 'nama bank',
            'account_number'    => 'nomor rekening',
            'account_holder'    => 'nama pemilik rekening',
            'status'            => 'status',
            'rating'            => 'rating',
            'notes'             => 'catatan',
        ];
    }

    public function messages(): array
    {
        return [
            'required'                => 'Isi :attribute.',
            'required_with'           => 'Isi :attribute, karena data rekening lain sudah diisi. Lengkapi semuanya atau kosongkan semuanya.',
            'max.string'              => ':attribute maksimal :max karakter. Persingkat isinya.',
            'email'                   => 'Format email belum benar. Contoh: sales@perusahaan.co.id.',
            'in'                      => 'Pilihan :attribute tidak dikenal. Pilih dari daftar.',
            'integer'                 => 'Isi :attribute dengan angka bulat, misalnya 3.',
            'numeric'                 => 'Isi :attribute dengan angka saja, misalnya 1250000.',
            'min.numeric'             => ':attribute tidak boleh kurang dari :min.',
            'max.numeric'             => ':attribute tidak boleh lebih dari :max.',
            'between.numeric'         => ':attribute harus antara :min dan :max.',
            'npwp.required'           => 'NPWP wajib diisi untuk supplier PKP. Isi 15 atau 16 digit.',
            'npwp.digits_between'     => 'NPWP harus 15 atau 16 digit angka. Titik dan tanda hubung boleh dipakai.',
            'phone.regex'             => 'Nomor telepon hanya boleh angka, spasi, tanda hubung, dan awalan +. Contoh: 0812 3456 7890.',
            'postal_code.digits'      => 'Kode pos harus 5 digit angka.',
            'account_number.digits_between' => 'Nomor rekening harus 5 sampai 30 digit angka.',
        ];
    }
}