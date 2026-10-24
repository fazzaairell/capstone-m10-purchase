<?php
use Illuminate\Support\Facades\Route;

Route::get('/supplier', function () {
    // Data dummy biar tabelnya muncul, sesuai foto Fazza
    $suppliers = collect([
        (object)['kode'=>'SUP-0001','nama'=>'PT Maju Jaya Abadi','kontak_nama'=>'Budi Santoso','kontak_hp'=>'08123456789','alamat'=>'Jl. Industri No. 10 Jakarta','status'=>'Aktif'],
        (object)['kode'=>'SUP-0002','nama'=>'CV Sumber Makmur','kontak_nama'=>'Siti','kontak_hp'=>'08234567890','alamat'=>'Jl. Merdeka No. 5 Bandung','status'=>'Aktif'],
        (object)['kode'=>'SUP-0003','nama'=>'PT Berkah Sentosa','kontak_nama'=>'Andi','kontak_hp'=>'08134567891','alamat'=>'Jl. Raya No. 20 Surabaya','status'=>'Nonaktif'],
    ]);
    return view('supplier.index', compact('suppliers'));
});

Route::get('/', function () {
    return redirect('/supplier');
});