<header class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto py-4 px-6 sm:px-8 flex justify-between items-center">
        <!-- Título -->
        <h1 class="text-2xl font-bold text-gray-900">@yield('header-title', 'Dashboard')</h1>
        
        <!-- Menú de usuario -->
        <div class="flex items-center space-x-4">
            <!-- Botón Hamburguesa (solo visible en dispositivos móviles) -->
            <button id="hamburgerButton" class="text-gray-500 focus:outline-none md:hidden">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Información del Usuario -->
            <div class="hidden md:flex flex-col text-right">
                <div class="text-gray-800 dark:text-gray-200 text-base font-medium">{{ Auth::user()->name }}</div>
                <div class="text-gray-500 dark:text-gray-400 text-sm">{{ Auth::user()->email }}</div>
            </div>

            <!-- Menú desplegable -->
            <div class="relative">
                <button id="dropdownButton" 
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                    <i class="fas fa-chevron-down text-xl"></i>
                </button>
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-20">
                    <a href="{{ route('profile.edit') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Script para funcionalidad -->
<script>
    // Botón del menú desplegable
    document.getElementById('dropdownButton').addEventListener('click', () => {
        const menu = document.getElementById('dropdownMenu');
        menu.classList.toggle('hidden');
    });

    // Botón del menú hamburguesa (si tienes contenido para mostrar en móvil)
    document.getElementById('hamburgerButton').addEventListener('click', () => {
        const menu = document.getElementById('mobileMenu'); // Ajustar si tienes un menú móvil
        menu?.classList.toggle('hidden');
    });
</script>
