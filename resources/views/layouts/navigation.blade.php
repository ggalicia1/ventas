<nav x-data="{ 
    sidebarOpen: false 
}" 
class="min-h-screen bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside 
            class="w-64 bg-gradient-to-br from-blue-800 to-blue-600 text-white py-7 px-2 hidden sm:block flex-shrink-0 h-full overflow-y-auto"
        >
            <div class="flex justify-between items-center px-4">
                <a href="#" class="text-white flex items-center space-x-2">
                    <span class="text-2xl font-extrabold">Sistema de Ventas</span>
                </a>
            </div>
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="{{ route('categories.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 {{ request()->routeIs('categories.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-folder mr-2"></i>Categorías
                </a>
                <a href="{{ route('products.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 {{ request()->routeIs('products.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-box mr-2"></i>Productos
                </a>
                <a href="{{ route('sales.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 {{ request()->routeIs('sales.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-shopping-cart mr-2"></i>Ventas
                </a>
                <a href="{{ route('reports.sales.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 {{ request()->routeIs('reports.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-chart-bar mr-2"></i>Reportes
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                        <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Mobile Sidebar -->
        <aside 
            x-show="sidebarOpen" 
            x-transition:enter="transition ease-in-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-br from-blue-800 to-blue-600 text-white py-7 px-2 sm:hidden overflow-y-auto"
        >
            <!-- Mobile sidebar content remains the same -->
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation Bar -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Mobile Sidebar Toggle -->
                            <button 
                                @click="sidebarOpen = !sidebarOpen" 
                                class="sm:hidden mr-2 inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="flex items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100">
                <div class="py-6">
                    <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-12">
                        {{ $slot ?? '' }}
                    </div>
                </div>
            </main>
            @include('partials.footer')
        </div>
    </div>
</nav>