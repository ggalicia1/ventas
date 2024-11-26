<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>


    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Producto</h2>
            <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
                @csrf
        
                <div class="input-field">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="border rounded-md p-2 w-full">
                    <label for="name" class="text-gray-700">Nombre</label>
                </div>
        
                <div class="input-field">
                    <textarea id="description" name="description" class="materialize-textarea border rounded-md p-2 w-full">{{ old('description') }}</textarea>
                    <label for="description" class="text-gray-700">Descripción</label>
                </div>
        
                <div class="input-field">
                    <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}" required class="border rounded-md p-2 w-full">
                    <label for="price" class="text-gray-700">Precio</label>
                </div>
        
                <div class="input-field">
                    <select name="category_id" required class="border rounded-md p-2 w-full">
                        <option value="" disabled selected>Elige una categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <label class="text-gray-700">Categoría</label>
                </div>
        
                <button type="submit" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V3a2 2 0 012-2h14a2 2 0 012 2v16a2 2 0 01-2 2zM12 12v6m-3-3h6" />
                    </svg> Guardar
                </button>
            </form>
        </div>


                

    </div>
</x-app-layout>
