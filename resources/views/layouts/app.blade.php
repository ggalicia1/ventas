
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Ventas')</title>
    <script src="{{ asset('js/tailwind.js') }}"></script>
    <link href="{{ asset('css/font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    
</head>
<style>
    .pagination .active a {
        @apply bg-blue-600 text-white; /* Cambia esto a tu preferencia */
    }

    .pagination a {
        @apply text-gray-600 hover:bg-blue-500 hover:text-white; /* Cambia según lo necesites */
    }
</style>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            @include('partials.navbar')
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-200">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('partials.footer')
        </div>
    </div>

    <script src="{{ asset('js/chart.js') }} "></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script>
        const sidebarToggle = document.querySelector('.md\\:hidden');
        const sidebar = document.querySelector('aside');
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
    @stack('scripts')
</body>

</html>