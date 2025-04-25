<x-app-layout>
  
    @section('content')
    <h2 class="text-2xl font-bold mb-6">Editar Stock de {{ $productStock->product->name }}</h2>

    <form action="{{ route('products.stock.update', $productStock->id) }}" method="POST" class="bg-white p-6 rounded shadow mb-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" name="quantity" id="quantity" class="border p-2 rounded w-full" required min="1" value="{{ $productStock->quantity }}">
            </div>
            <div class="mb-4">
                <label for="remaining_quantity" class="block text-sm font-medium text-gray-700">Cantidad restante</label>
                <input type="number" name="remaining_quantity" id="remaining_quantity" class="border p-2 rounded w-full" required min="1" value="{{ $productStock->remaining_quantity }}">
            </div>

            <div class="input-field">
                <label for="purchase_price" class="block text-sm font-medium text-gray-700">Precio de compra</label>
                <input type="number" id="purchase_price" name="purchase_price" step="0.01" class="border rounded-md p-2 w-full" required value="{{ $productStock->purchase_price }}">
            </div>

            <div class="input-field">
                <label for="sale_price" class="block text-sm font-medium text-gray-700">Precio de venta</label>
                <input type="number" id="sale_price" name="sale_price" step="0.01" class="border rounded-md p-2 w-full" required value="{{ $productStock->sale_price }}">
            </div>

            <div class="mb-4">
                <label for="expiration_date" class="block text-sm font-medium text-gray-700">Fecha de vencimiento</label>
                <input type="date" name="expiration_date" id="expiration_date" class="border p-2 rounded w-full" required value="{{ $productStock->expiration_date }}">
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Actualizar Stock</button>
    </form>

</x-app-layout>