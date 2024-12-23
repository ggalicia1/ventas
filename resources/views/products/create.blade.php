<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Productos') }}
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
                    <input type="text" id="barcode" name="barcode" step="0.01" value="{{ old('barcode') }}"  class="border rounded-md p-2 w-full">
                    <label for="barcode" class="text-gray-700">Codigo de barras</label>
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

        <!-- Massive Product Import Section -->
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Importación Masiva de Productos</h2>
                    <!-- Mensajes Flash -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
            <form action="{{ route('products.store.massive') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="input-field">
                    <label for="products_file" class="text-gray-700 block mb-2">Seleccionar Archivo Excel</label>
                    <input type="file" id="products_file" name="products_file" accept=".xlsx,.xls" required class="border rounded-md p-2 w-full">
                </div>

                <div class="input-field">
                    <label class="text-gray-700 block mb-2">Instrucciones</label>
                    <p class="text-sm text-gray-600">
                        Por favor, suba un archivo Excel con las siguientes columnas:
                        <br>
                        - ID
                        - Nombre
                        - Descripción
                        - No. de Categoría
                        - Distribuidor
                    </p>
                </div>

                <button type="submit" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">
                    <i class="material-icons left mr-2">cloud_upload</i> Importar Productos
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
