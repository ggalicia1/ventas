<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Añadir Stock a {{ $product->name }}</h2>
            
            <form action="{{ route('products.addStock', $product->id) }}" method="POST" class="bg-white p-6 rounded shadow mb-8">
                @csrf
                <div class="grid grid-cols-2 gap-4">
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
                        <label for="date_added" class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                        <input type="date" name="date_added" id="date_added" class="border p-2 rounded w-full">
                    </div>
                    <div class="mb-4">
                        <label for="expiration_date" class="block text-sm font-medium text-gray-700">Fecha de vencimiento</label>
                        <input type="date" name="expiration_date" id="expiration_date" class="border p-2 rounded w-full">
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Añadir Stock</button>
            </form>

            <h3 class="text-xl font-bold mb-4">Historial de Stock</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Fecha</th>
                            <th scope="col" class="px-6 py-3">Cantidad</th>
                            <th scope="col" class="px-6 py-3">Precio de Compra</th>
                            <th scope="col" class="px-6 py-3">Precio de Venta</th>
                            <th scope="col" class="px-6 py-3">Fecha de Vencimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockHistories as $history)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $history->date_added }}</td>
                                <td class="px-6 py-4">{{ $history->quantity }}</td>
                                <td class="px-6 py-4">{{ number_format($history->purchase_price, 2) }}</td>
                                <td class="px-6 py-4">{{ number_format($history->sale_price, 2) }}</td>
                                <td class="px-6 py-4">{{ $history->expiration_date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">No hay historial de stock</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Pagination Links --}}
                <div class="p-4">
                    {{ $stockHistories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>