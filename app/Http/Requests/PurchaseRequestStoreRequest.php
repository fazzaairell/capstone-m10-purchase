<?php

namespace App\Http\Requests;

use App\Models\PurchaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequestStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Rapikan input. Baris barang yang nama dan harganya kosong dianggap tidak ada. */
    protected function prepareForValidation(): void
    {
        $items = collect($this->input('items', []))
            ->filter(fn ($row) => is_array($row))
            ->map(fn ($row) => [
                'name'     => filled($row['name'] ?? null) ? preg_replace('/\s+/', ' ', trim((string) $row['name'])) : null,
                'quantity' => $row['quantity'] ?? null,
                'unit'     => $row['unit'] ?? null,
                'price'    => filled($row['price'] ?? null) ? $row['price'] : null,
            ])
            ->filter(fn ($row) => filled($row['name']) || filled($row['price']));

        $this->merge([
            'requester_name' => filled($this->requester_name) ? preg_replace('/\s+/', ' ', trim((string) $this->requester_name)) : null,
            'reason'         => filled($this->reason) ? trim((string) $this->reason) : null,
            'items'          => $items->all(),
        ]);
    }

    public function rules(): array
    {
        // draf boleh belum lengkap, pengajuan harus lengkap
        $submitting = $this->input('action') === 'submit';
        $req = $submitting ? 'required' : 'nullable';

        return [
            'action'         => ['required', Rule::in(['draft', 'submit'])],

            'requester_name' => ['required', 'string', 'max:100'],
            'department'     => [$req, Rule::in(PurchaseRequest::DEPARTMENTS)],
            'reason'         => [$req, 'string', 'max:2000'],

            'items'            => $submitting ? ['required', 'array', 'min:1'] : ['nullable', 'array'],
            'items.*.name'     => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'numeric', 'gt:0', 'max:999999'],
            'items.*.unit'     => ['required', Rule::in(PurchaseRequest::UNITS)],
            'items.*.price'    => [$req, 'numeric', 'min:0', 'max:99999999999'],
        ];
    }

    public function attributes(): array
    {
        return [
            'requester_name'   => 'nama pemohon',
            'department'       => 'departemen',
            'reason'           => 'alasan pembelian',
            'items'            => 'barang',
            'items.*.name'     => 'nama barang',
            'items.*.quantity' => 'jumlah',
            'items.*.unit'     => 'satuan',
            'items.*.price'    => 'estimasi harga',
        ];
    }

    public function messages(): array
    {
        return [
            'required'              => 'Isi :attribute.',
            'in'                    => 'Pilihan :attribute tidak dikenal. Pilih dari daftar.',
            'numeric'               => 'Isi :attribute dengan angka saja, misalnya 2000.',
            'max.string'            => ':attribute maksimal :max karakter. Persingkat isinya.',
            'max.numeric'           => 'Angka :attribute terlalu besar. Periksa lagi.',
            'min.numeric'           => ':attribute tidak boleh kurang dari :min.',
            'department.required'   => 'Pilih departemen.',
            'items.required'        => 'Tambahkan minimal satu barang atau jasa.',
            'items.min'             => 'Tambahkan minimal satu barang atau jasa.',
            'items.*.quantity.gt'   => 'Jumlah harus lebih dari 0.',
            'action.required'       => 'Pilih Simpan draf atau Kirim pengajuan.',
        ];
    }
}