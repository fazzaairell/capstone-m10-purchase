<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Sistem pengadaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    @include('partials.navbar')
    @include('partials.sidebar')

    {{-- navbar 56px (pt-14), sidebar 240px (lg:pl-60) --}}
    <div class="pt-14 lg:pl-60">
        <main class="mx-auto max-w-7xl p-4 sm:p-6">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const menuButton = document.getElementById('menu-button');

        function setSidebar(open) {
            sidebar.classList.toggle('-translate-x-full', !open);
            overlay.classList.toggle('hidden', !open);
            menuButton.setAttribute('aria-expanded', open);
        }
        function toggleSidebar() {
            setSidebar(sidebar.classList.contains('-translate-x-full'));
        }
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') setSidebar(false);
        });
    </script>
    @stack('scripts')
</body>
</html>