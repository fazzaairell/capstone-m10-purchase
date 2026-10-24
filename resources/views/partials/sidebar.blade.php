<div id="overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black/30 z-20 lg:hidden"></div>
<aside id="sidebar" class="fixed left-0 top-0 z-30 w-[260px] h-screen bg-white border-r -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto">
    <div class="p-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-900 rounded flex items-center justify-center text-white">◫</div>
            <span class="font-bold">Sistem pengadaan</span>
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden">✕</button>
    </div>
    <nav class="p-4">
        <p class="text-xs text-gray-400 mb-2">Pengadaan</p>
        <a href="#" class="block bg-[#eef2ff] text-blue-900 px-3 py-2 rounded-lg text-sm font-medium mb-1">Supplier</a>
        <a href="#" class="block text-gray-500 px-3 py-2 text-sm">Permintaan pembelian</a>
        <a href="#" class="block text-gray-500 px-3 py-2 text-sm">Purchase order</a>
    </nav>
</aside>