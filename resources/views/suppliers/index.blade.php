<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar supplier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="bg-[#f8f9fb] flex">
    <!-- SIDEBAR -->
    <aside class="w-[240px] bg-white border-r min-h-screen sticky top-0">
        <div class="p-4 border-b flex items-center gap-2 font-bold text-[#1e3a5f] text-[15px]">
            <div class="w-7 h-7 bg-[#1e3a5f] text-white rounded flex items-center justify-center">◫</div> Sistem pengadaan
        </div>
        <div class="p-3">
            <p class="text-[11px] font-semibold text-gray-400 tracking-wider mb-2 px-2">PENGADAAN</p>
            <div class="bg-[#eef2ff] text-[#1e3a5f] px-3 py-2 rounded-md text-[13px] font-medium">☰ Supplier</div>
            <div class="text-gray-500 px-3 py-2 text-[13px] mt-1">🗒 Permintaan pembelian</div>
            <div class="text-gray-500 px-3 py-2 text-[13px] mt-1">📄 Purchase order</div>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1">
        <!-- TOPBAR -->
        <div class="h-14 bg-white border-b flex items-center justify-between px-6">
            <div class="w-[360px] bg-gray-50 border rounded-full px-4 py-2 text-[13px] text-gray-400">🔍 Cari di sistem pengadaan</div>
            <div class="flex items-center gap-2 text-[13px]"><span class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center font-bold text-[#1e3a5f] text-xs">AD</span> Administrator ▾</div>
        </div>

        <div class="p-6">
            <div class="text-[11px] text-gray-400 mb-1">Pengadaan &nbsp;›&nbsp; Supplier</div>
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h1 class="text-[20px] font-bold text-gray-900">Daftar supplier</h1>
                    <p class="text-[12px] text-gray-500 mt-0.5">Kelola supplier terdaftar untuk kebutuhan pengadaan.</p>
                </div>
                <button class="bg-[#1e3a5f] hover:bg-[#162a45] text-white text-[13px] px-4 py-2 rounded-md">+ Tambah supplier</button>
            </div>

            <!-- SEARCH -->
            <div class="flex gap-3 mb-4">
                <div class="flex-1 relative">
                    <input placeholder="Cari nama atau kontak supplier" class="w-full border rounded-md py-2 pl-9 pr-3 text-[13px] bg-white">
                    <span class="absolute left-3 top-2.5 text-gray-400 text-[13px]">🔍</span>
                </div>
                <select class="border rounded-md px-3 py-2 text-[13px] bg-white w-[160px]"><option>Semua status</option><option>Aktif</option><option>Nonaktif</option></select>
            </div>

            <!-- TABLE -->
            <div class="bg-white border rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-[#f1f5f9] text-[11px] text-gray-500 uppercase text-left">
                        <tr>
                            <th class="py-3 px-4 font-medium">Kode</th>
                            <th class="py-3 px-4 font-medium">Nama supplier</th>
                            <th class="py-3 px-4 font-medium">Kontak</th>
                            <th class="py-3 px-4 font-medium">Alamat</th>
                            <th class="py-3 px-4 font-medium">Status</th>
                            <th class="py-3 px-4 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[13px] divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0001</td><td class="py-3.5 px-4 font-medium">PT Mitra Sarana Abadi</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Rina Pratiwi</div><div class="text-[11px] text-gray-400">0812 0000 1001</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Melati No. 12, Bandung</td><td class="py-3.5 px-4"><span class="bg-[#dcfce7] text-[#16a34a] px-2.5 py-1 rounded-full text-[11px] font-medium">● Aktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0002</td><td class="py-3.5 px-4 font-medium">CV Bina Usaha Mandiri</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Dedi Saputra</div><div class="text-[11px] text-gray-400">0812 0000 1002</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Kenanga No. 8, Jakarta Selatan</td><td class="py-3.5 px-4"><span class="bg-[#dcfce7] text-[#16a34a] px-2.5 py-1 rounded-full text-[11px] font-medium">● Aktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0003</td><td class="py-3.5 px-4 font-medium">PT Cipta Niaga Sentosa</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Siti Rahma</div><div class="text-[11px] text-gray-400">0812 0000 1003</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Anggrek No. 24, Surabaya</td><td class="py-3.5 px-4"><span class="bg-[#dcfce7] text-[#16a34a] px-2.5 py-1 rounded-full text-[11px] font-medium">● Aktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0004</td><td class="py-3.5 px-4 font-medium">CV Sinar Perkasa</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Andi Wijaya</div><div class="text-[11px] text-gray-400">0812 0000 1004</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Mawar No. 16, Semarang</td><td class="py-3.5 px-4"><span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full text-[11px] font-medium">● Nonaktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0005</td><td class="py-3.5 px-4 font-medium">PT Berkah Alat Prima</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Maya Lestari</div><div class="text-[11px] text-gray-400">0812 0000 1005</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Flamboyan No. 5, Yogyakarta</td><td class="py-3.5 px-4"><span class="bg-[#dcfce7] text-[#16a34a] px-2.5 py-1 rounded-full text-[11px] font-medium">● Aktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0006</td><td class="py-3.5 px-4 font-medium">CV Karya Persada</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Fajar Nugraha</div><div class="text-[11px] text-gray-400">0812 0000 1006</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Cempaka No. 30, Bogor</td><td class="py-3.5 px-4"><span class="bg-[#dcfce7] text-[#16a34a] px-2.5 py-1 rounded-full text-[11px] font-medium">● Aktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0007</td><td class="py-3.5 px-4 font-medium">PT Pilar Sukses Bersama</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Nadia Putri</div><div class="text-[11px] text-gray-400">0812 0000 1007</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Dahlia No. 9, Tangerang</td><td class="py-3.5 px-4"><span class="bg-[#dcfce7] text-[#16a34a] px-2.5 py-1 rounded-full text-[11px] font-medium">● Aktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0008</td><td class="py-3.5 px-4 font-medium">CV Inti Cemerlang</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Ricky Pratama</div><div class="text-[11px] text-gray-400">0812 0000 1008</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Teratai No. 18, Bekasi</td><td class="py-3.5 px-4"><span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full text-[11px] font-medium">● Nonaktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0009</td><td class="py-3.5 px-4 font-medium">PT Daya Prima Teknik</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Budi Santoso</div><div class="text-[11px] text-gray-400">0812 0000 1009</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Kamboja No. 7, Depok</td><td class="py-3.5 px-4"><span class="bg-[#dcfce7] text-[#16a34a] px-2.5 py-1 rounded-full text-[11px] font-medium">● Aktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-3.5 px-4 text-gray-400 text-[12px]">SUP-0010</td><td class="py-3.5 px-4 font-medium">CV Arta Sejahtera</td><td class="py-3.5 px-4"><div class="font-medium text-[12px]">Dewi Kartika</div><div class="text-[11px] text-gray-400">0812 0000 1010</div></td><td class="py-3.5 px-4 text-gray-600 text-[12px]">Jl. Soka No. 21, Malang</td><td class="py-3.5 px-4"><span class="bg-[#dcfce7] text-[#16a34a] px-2.5 py-1 rounded-full text-[11px] font-medium">● Aktif</span></td><td class="py-3.5 px-4 text-[#1e3a5f] font-medium">Lihat &nbsp; Edit</td></tr>
                    </tbody>
                </table>
                <div class="flex justify-between items-center px-4 py-3 border-t text-[11px] text-gray-500">
                    <div>1 - 10 dari 10 supplier &nbsp;&nbsp; Baris per halaman <span class="ml-2 border rounded px-2 py-1 bg-[#1e3a5f] text-white">10</span> <span class="ml-1 border rounded px-2 py-1">25</span> <span class="ml-1 border rounded px-2 py-1">50</span></div>
                    <div class="flex items-center gap-2"><span>‹</span><span class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center">1</span><span>›</span></div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>