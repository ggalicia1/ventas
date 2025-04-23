<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Añadir Stock a {{ $product->name }}</h2>
            
            {{-- <form action="{{ route('products.addStock', $product->id) }}" method="POST" class="bg-white p-6 rounded shadow mb-8">
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
                        <label for="expiration_date" class="block text-sm font-medium text-gray-700">Fecha de vencimiento</label>
                        <input type="date" name="expiration_date" id="expiration_date" class="border p-2 rounded w-full" value="{{ old('expiration_date') }}" required>
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Añadir Stock</button>
            </form>
 --}}
            <h3 class="text-xl font-bold mb-4">Historial de Stock</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Fecha</th>
                            <th scope="col" class="px-6 py-3">Cantidad</th>
                            <th scope="col" class="px-6 py-3">Cantidad Restante</th>
                            <th scope="col" class="px-6 py-3">Precio de Compra</th>
                            <th scope="col" class="px-6 py-3">Precio de Venta</th>
                            <th scope="col" class="px-6 py-3">Fecha de Vencimiento</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockHistories as $history)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $history->id}}</td>
                                <td class="px-6 py-4">{{ date('d-m-Y H:i', strtotime($history->created_at))}}</td>
                                <td class="px-6 py-4">{{ $history->quantity }}</td>
                                <td class="px-6 py-4">{{ $history->remaining_quantity }}</td>
                                <td class="px-6 py-4">{{ $history->purchase_price }}</td>
                                <td class="px-6 py-4">{{ number_format($history->sale_price, 2) }}</td>
                                <td class="px-6 py-4">{{ $history->expiration_date }}</td>
                                <td class="px-6 py-4">
                                    @if(Auth::user()->email == 'gustavogalicia247@gmail.com')
                                        <div class="flex space-x-2">
                                            <button 
                                                onclick="deleteStockHistory({{ $history->id }})"
                                                class="px-3 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </td>
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

<script>
    async function deleteStockHistory(productId) {
        const confirmation = await Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás revertir esta acción.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        });

        if (!confirmation.isConfirmed) {
            return;
        }

        try {
            const response = await fetch(`{{ url('products/delete-stock') }}/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
                    text: result.message,
                    confirmButtonText: 'Aceptar'
                });
                // Recargar la página
                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message,
                    confirmButtonText: 'Aceptar'
                });
            }
        } catch (error) {
            console.error('Error al eliminar el producto:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al intentar eliminar el producto.',
                confirmButtonText: 'Aceptar'
            });
        }
    }
</script>
