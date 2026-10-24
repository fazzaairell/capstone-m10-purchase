@extends('layouts.app')
@section('content')
<div class="p-4 lg:p-6">
    <div class="flex justify-between items-start">
        <div>
            <div class="text-sm text-gray-500 mb-1">Pengadaan > Supplier</div>
            <h1 class="text-2xl font-bold">Daftar supplier</h1>
            <p class="text-sm text-gray-500 mb-4">Kelola supplier terdaftar.</p>
        </div>
        <button onclick="toggleForm()" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap mt-2">+ Tambah supplier</button>
    </div>

    <!-- MODAL TENGAH -->
    <div id="supplierForm" class="hidden fixed inset-0 z-[999] bg-black/60 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl p-5 w-full max-w-2xl">
            <div class="flex justify-between mb-4"><h3 class="font-bold">Tambah supplier</h3><button onclick="toggleForm()" class="text-xl">×</button></div>
            <div class="grid grid-cols-2 gap-3">
                <input placeholder="Kode" class="border p-2 rounded"><input placeholder="Nama supplier" class="border p-2 rounded">
                <input placeholder="Kontak" class="border p-2 rounded"><input placeholder="HP" class="border p-2 rounded">
                <input placeholder="Alamat" class="border p-2 rounded col-span-2">
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button onclick="toggleForm()" class="border px-4 py-2 rounded">Batal</button>
                <button onclick="toggleForm()" class="bg-slate-900 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </div>
    </div>

    <div class="bg-white border rounded-lg p-3 mt-2">
        <div class="flex gap-2 mb-3">
            <input id="searchInput" onkeyup="filterAndPaginate()" placeholder="Cari nama atau kontak supplier" class="flex-1 border p-2 rounded text-sm">
            <select id="statusFilter" onchange="filterAndPaginate()" class="border p-2 rounded text-sm"><option value="">Semua status</option><option>Aktif</option><option>Nonaktif</option></select>
            <select id="rowsPerPage" onchange="changeRows()" class="border p-2 rounded text-sm"><option value="10">10 / halaman</option><option value="25">25 / halaman</option></select>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b bg-gray-50 text-left"><th class="p-2">Kode</th><th class="p-2">Nama supplier</th><th class="p-2">Kontak</th><th class="p-2">Alamat</th><th class="p-2">Aksi</th></tr></thead>
                <tbody id="tableBody">
                @foreach($suppliers as $s)
                <tr class="border-b data-row" data-nama="{{ strtolower($s->nama) }}" data-status="{{ $s->status }}">
                    <td class="p-2">{{ $s->kode }}</td><td class="p-2">{{ $s->nama }}</td>
                    <td class="p-2">{{ $s->kontak_nama }}<br><span class="text-xs text-gray-500">{{ $s->kontak_hp }}</span></td>
                    <td class="p-2">{{ $s->alamat }}</td>
                    <td class="p-2"><button class="border px-2 py-1 rounded text-xs">Lihat</button></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-between mt-3 text-xs text-gray-600"><div id="infoText"></div><div id="pagination" class="flex gap-1"></div></div>
    </div>
</div>
<script>
let currentPage=1,rows=10,filteredRows=[];
function toggleForm(){document.getElementById('supplierForm').classList.toggle('hidden');document.getElementById('supplierForm').classList.toggle('flex');}
function changeRows(){rows=parseInt(document.getElementById('rowsPerPage').value);filterAndPaginate();}
function filterAndPaginate(){const q=document.getElementById('searchInput').value.toLowerCase();const st=document.getElementById('statusFilter').value;const all=document.querySelectorAll('.data-row');filteredRows=[];all.forEach(r=>{if(r.dataset.nama.includes(q)&&(!st||r.dataset.status===st))filteredRows.push(r);r.style.display='none';});showPage();}
function showPage(){document.querySelectorAll('.data-row').fogitrEach(r=>r.style.display='none');const start=(currentPage-1)*rows,end=start+rows;filteredRows.slice(start,end).forEach(r=>r.style.display='');const total=filteredRows.length;document.getElementById('infoText').innerText=`Menampilkan ${total==0?0:start+1}-${Math.min(end,total)} dari ${total} supplier`;let pag='';const tp=Math.ceil(total/rows)||1;for(let i=1;i<=tp;i++){pag+=`<button onclick="currentPage=${i};showPage()" class="px-2 py-1 border rounded ${i==currentPage?'bg-slate-900 text-white':''}">${i}</button>`;}document.getElementById('pagination').innerHTML=pag;}
filterAndPaginate();
</script>
@endsection