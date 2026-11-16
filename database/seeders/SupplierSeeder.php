<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        if (Supplier::withTrashed()->exists()) {
            $this->command->warn('Tabel suppliers sudah berisi data, seeder dilewati.');
            return;
        }

        $rows = [
            [
                'company_name' => 'PT Sumber Pangan Nusantara', 'npwp' => '013456789012000',
                'contact_person' => 'Rina Pratiwi', 'email' => 'sales@sumberpangan.example', 'phone' => '081200001001',
                'address' => 'Jl. Industri Raya No. 12, Kawasan Industri Rancaekek', 'city' => 'Bandung', 'postal_code' => '40394',
                'delivery_type' => 'DC', 'lead_time_days' => 3, 'minimum_order_qty' => 5000000,
                'payment_terms' => 'Net 30', 'bank_name' => 'BCA', 'account_number' => '1234567890', 'account_holder' => 'PT Sumber Pangan Nusantara',
                'rating' => 5,
            ],
            [
                'company_name' => 'CV Bina Usaha Mandiri', 'tax_type' => 'NON_PKP',
                'contact_person' => 'Dedi Saputra', 'email' => 'dedi@binausaha.example', 'phone' => '081200001002',
                'address' => 'Jl. Kenanga No. 8, Kebayoran Baru', 'city' => 'Jakarta Selatan', 'postal_code' => '12120',
                'delivery_type' => 'DSD', 'lead_time_days' => 2, 'minimum_order_qty' => 1000000,
                'return_policy' => 'Exchange', 'payment_terms' => 'COD',
                'rating' => 4,
            ],
            [
                'company_name' => 'PT Cipta Niaga Sentosa', 'npwp' => '024567890123000',
                'contact_person' => 'Siti Rahma', 'email' => 'siti@ciptaniaga.example', 'phone' => '081200001003',
                'address' => 'Jl. Anggrek No. 24, Rungkut', 'city' => 'Surabaya', 'postal_code' => '60293',
                'delivery_type' => 'DC', 'lead_time_days' => 5, 'minimum_order_qty' => 7500000,
                'payment_terms' => 'Net 45', 'bank_name' => 'Mandiri', 'account_number' => '9876543210', 'account_holder' => 'PT Cipta Niaga Sentosa',
                'rating' => 4,
            ],
            [
                'company_name' => 'CV Sinar Perkasa', 'tax_type' => 'NON_PKP',
                'contact_person' => 'Andi Wijaya', 'email' => 'andi@sinarperkasa.example', 'phone' => '081200001004',
                'address' => 'Jl. Mawar No. 16, Gajahmungkur', 'city' => 'Semarang', 'postal_code' => '50232',
                'delivery_type' => 'DC', 'lead_time_days' => 4, 'minimum_order_qty' => 2000000,
                'return_policy' => 'No_Return', 'payment_terms' => 'Net 14',
                'status' => 'suspended', 'rating' => 2, 'notes' => 'Pengiriman terlambat dua kali berturut-turut. Ditinjau ulang bulan depan.',
            ],
            [
                'company_name' => 'PT Berkah Alat Prima', 'npwp' => '035678901234000',
                'contact_person' => 'Maya Lestari', 'email' => 'maya@berkahalat.example', 'phone' => '081200001005',
                'address' => 'Jl. Flamboyan No. 5, Umbulharjo', 'city' => 'Yogyakarta', 'postal_code' => '55161',
                'delivery_type' => 'DSD', 'lead_time_days' => 1, 'minimum_order_qty' => 3000000,
                'payment_terms' => 'Net 30', 'bank_name' => 'BNI', 'account_number' => '5566778899', 'account_holder' => 'PT Berkah Alat Prima',
                'rating' => 5,
            ],
            [
                'company_name' => 'CV Karya Persada', 'tax_type' => 'NON_PKP',
                'contact_person' => 'Fajar Nugraha', 'email' => 'fajar@karyapersada.example', 'phone' => '081200001006',
                'address' => 'Jl. Cempaka No. 30, Tanah Sareal', 'city' => 'Bogor', 'postal_code' => '16161',
                'delivery_type' => 'DC', 'lead_time_days' => 3, 'minimum_order_qty' => 1500000,
                'payment_terms' => 'Net 7', 'rating' => 3,
            ],
            [
                'company_name' => 'PT Pilar Sukses Bersama', 'npwp' => '046789012345000',
                'contact_person' => 'Nadia Putri', 'email' => 'nadia@pilarsukses.example', 'phone' => '081200001007',
                'address' => 'Jl. Dahlia No. 9, Cipondoh', 'city' => 'Tangerang', 'postal_code' => '15148',
                'delivery_type' => 'DC', 'lead_time_days' => 7, 'minimum_order_qty' => 10000000,
                'payment_terms' => 'Net 60', 'bank_name' => 'BRI', 'account_number' => '1122334455', 'account_holder' => 'PT Pilar Sukses Bersama',
                'status' => 'terminated', 'rating' => 1, 'notes' => 'Kerja sama dihentikan karena barang kedaluwarsa tidak diganti.',
            ],
            [
                'company_name' => 'PT Daya Prima Teknik', 'npwp' => '057890123456000',
                'contact_person' => 'Budi Santoso', 'email' => 'budi@dayaprima.example', 'phone' => '081200001009',
                'address' => 'Jl. Kamboja No. 7, Beji', 'city' => 'Depok', 'postal_code' => '16421',
                'delivery_type' => 'DC', 'lead_time_days' => 3, 'minimum_order_qty' => 4000000,
                'return_policy' => 'Exchange', 'payment_terms' => 'Net 30',
                'rating' => 4,
            ],
        ];

        foreach ($rows as $row) {
            Supplier::create($row); // kode SUP-0001 dst. dibuat otomatis oleh model
        }
    }
}