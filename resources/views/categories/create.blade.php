<x-app-layout>
    


    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Categoría</h2>
        
            <form action="{{ route('categories.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
                @csrf
        
                <!-- Campo Nombre -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
        
                <!-- Campo Descripción -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                </div>
        
                <!-- Botón de Guardar -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        <i class="fas fa-save mr-2"></i>Guardar
                    </button>
                </div>
            </form>
        </div>


                

    </div>
</x-app-layout>
