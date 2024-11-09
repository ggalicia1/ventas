<header class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto py-4 px-6 sm:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">@yield('header-title', 'Dashboard')</h1>
        <div class="flex items-center space-x-4">
            <button class="text-gray-500 focus:outline-none md:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <div class="relative">
                <button class="flex items-center text-gray-500 focus:outline-none">
                    <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/150" alt="User avatar">
                    <span class="ml-2 text-sm font-medium">John Doe</span>
                    <i class="fas fa-chevron-down ml-1"></i>
                </button>
            </div>
        </div>
    </div>
</header>
