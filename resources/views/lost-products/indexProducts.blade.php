<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Añadir Perdida a {{ $product->name }}</h2>
            @if(session('success'))
                <div class="bg-green-500 text-white p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @elseif ($errors->any())
                <div class="bg-red-500 text-white p-3 mb-4 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="lost-stock-form" action="{{ route('products.addLostProductStock.post', $product->id) }}" method="POST" class="bg-white p-6 rounded shadow mb-8">
                @csrf
                <div class="grid grid-cols-12 gap-4">
                    <div class="mb-4 col-span-3">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad a añadir</label>
                        <input type="number" name="quantity" id="quantity" class="border p-2 rounded w-full" required min="1" value="{{ old('quantity') }}">
                        @error('quantity')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4 col-span-9">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Razón o motivo</label>
                      {{--   <input type="text" id="reason" name="reason" value="{{ old('reason') }}" required class="border rounded-md p-2 w-full">
                        --}} 
                        <textarea id="reason" name="reason" rows="4" cols="120" required min="15" >{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Añadir Perdida</button>
            </form>

            <h3 class="text-xl font-bold mb-4">Historial de perdida</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Fecha</th>
                            <th scope="col" class="px-6 py-3">Cantidad</th>
                            <th scope="col" class="px-6 py-3">Cantidad Restante</th>
                            <th scope="col" class="px-6 py-3">Reason</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lost_products as $lost)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $lost->id}}</td>
                                <td class="px-6 py-4">{{ date('d-m-Y H:i', strtotime($lost->created_at))}}</td>
                                <td class="px-6 py-4">{{ $lost->quantity }}</td>
                                <td class="px-6 py-4">{{ $lost->remaining_quantity }}</td>
                                <td class="px-6 py-4">{{ $lost->reason }}</td>
                                <td class="px-6 py-4">
                                    @if(Auth::user()->email == 'gustavogalicia247@gmail.com')
                                        <div class="flex space-x-2">
                                            <button 
                                                onclick="deleteStockHistory({{ $lost->id }})"
                                                class="px-3 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                            <a href="{{ route('products.stock.edit', $lost->id) }}" 
                                                class="px-3 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                                 <!-- Ícono de lápiz -->
                                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
                                                      viewBox="0 0 24 24" stroke="currentColor">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                           d="M15.232 5.232l3.536 3.536M9 11l6 6M4 20h4l10-10a2.121 2.121 0 00-3-3L5 17v3z" />
                                                 </svg>
                                            </a>
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
                    {{ $lost_products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('lost-stock-form');

        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Detiene el envío automático

            Swal.fire({
                title: '¿Confirmar envío?',
                text: '¿Estás seguro de registrar esta pérdida?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Envía el formulario si se confirma
                }
            });
        });
    });
</script>



{{-- <script>
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
</script> --}}
