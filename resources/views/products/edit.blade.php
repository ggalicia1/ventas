<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="container mx-auto px-6 py-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Producto</h2>
                <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
            
                    <div class="input-field">
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="border rounded-md p-2 w-full">
                        <label for="name" class="text-gray-700">Nombre</label>
                    </div>
                    <div class="input-field">
                        <textarea id="description" name="description" class="materialize-textarea border rounded-md p-2 w-full">{{ old('description', $product->description) }}</textarea>
                        <label for="description" class="text-gray-700">Descripción</label>
                    </div>
            
                    <div class="input-field">
                        <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required class="border rounded-md p-2 w-full">
                        <label for="price" class="text-gray-700">Precio</label>
                    </div>
                    <div class="input-field">
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required class="border rounded-md p-2 w-full">
                        <label for="price" class="text-gray-700">Stock</label>
                    </div>
                    <div class="input-field">
                        <input type="number" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}" required class="border rounded-md p-2 w-full">
                        <label for="price" class="text-gray-700">Codigo de barras</label>
                    </div>
            
                    <div class="input-field">
                        <select name="category_id" required class="border rounded-md p-2 w-full">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="text-gray-700">Categoría</label>
                    </div>
            
                    <button type="submit" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        Actualizar
                    </button>
                </form>
            </div>


                

        </div>
</x-app-layout>
