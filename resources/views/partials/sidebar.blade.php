<aside class="bg-gradient-to-br from-blue-800 to-blue-600 text-white w-64 space-y-6 py-7 px-2 relative inset-y-0 left-0 transition-transform duration-200 ease-in-out">
    <a href="#" class="text-white flex items-center space-x-2 px-4">
        {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-full"> --}}
        <span class="text-2xl font-extrabold justify-center">Sistema de Ventas</span>
    </a>
    <nav class="mt-6">
        <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
            <i class="fas fa-home mr-2"></i>Dashboard
        </a>
        <a href="{{ route('categories.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
            <i class="fas fa-folder mr-2"></i>Categorías
        </a>
        <a href="{{ route('products.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
            <i class="fas fa-box mr-2"></i>Productos
        </a>
        <a href="{{ route('sales.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
            <i class="fas fa-shopping-cart mr-2"></i>Ventas
        </a>
        <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
            <i class="fas fa-chart-bar mr-2"></i>Reportes
        </a>
        <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
            <i class="fas fa-cog mr-2"></i>Configuración
        </a>
        <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
            <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
        </a>
    </nav>
</aside>
