<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>


    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Añadir Stock a {{ $product->name }}</h2>
        
            <form action="{{ route('products.addStock', $product->id) }}" method="POST" class="bg-white p-6 rounded shadow">
                @csrf
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad a añadir</label>
                    <input type="number" name="quantity" id="quantity" class="border p-2 rounded w-full" required min="1">
                </div>
                <div class="input-field">
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700">Precio de compra</label>
                    <input type="number" id="purchase_price" name="purchase_price" step="0.01" value="{{ old('purchase_price') }}" required class="border rounded-md p-2 w-full">
                </div>
                <div class="input-field">
                    <label for="sale_price" class="block text-sm font-medium text-gray-700">Precio de venta</label>
                    <input type="number" id="sale_price" name="sale_price" step="0.01" value="{{ old('sale_price') }}" required class="border rounded-md p-2 w-full">
                </div>
        
            
                <div class="mb-4">
                    <label for="expiration_date" class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                    <input type="date" name="date_added" id="expiration_date" class="border p-2 rounded w-full">
                </div>
                <div class="mb-4">
                    <label for="expiration_date" class="block text-sm font-medium text-gray-700">Fecha de vencimiento</label>
                    <input type="date" name="expiration_date" id="expiration_date" class="border p-2 rounded w-full">
                </div>
            
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Añadir Stock</button>
            </form>
        </div>


                

    </div>
</x-app-layout>
