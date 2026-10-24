<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengadaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fb]">
<div class="flex">
    @include('partials.sidebar')
    <div class="flex-1 lg:ml-[260px] min-h-screen flex flex-col">
        @include('partials.topbar')
        <main class="p-4 lg:p-6 flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>
<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('overlay').classList.toggle('hidden');
}
</script>
</body>
</html>