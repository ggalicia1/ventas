<x-app-layout>
    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800">Agregar Nueva Compra</h2>

                    <!-- Contenedor Flex -->
                    <div class="flex space-x-6">
                        <!-- Tabla de Productos (Lado izquierdo) -->
                        <div class="w-1/2">
                            <h3 class="text-xl font-semibold mt-6">Detalles del Producto</h3>
                            <table id="products-table" class="min-w-full table-auto mt-4">
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Producto</th>
                                        <th class="border px-4 py-2">Cantidad</th>
                                        <th class="border px-4 py-2">Cantidad Restante</th>
                                        <th class="border px-4 py-2">Precio de Compra</th>
                                        <th class="border px-4 py-2">Precio de Venta</th>
                                        <th class="border px-4 py-2">Fecha de Expiración</th>
                                        <th class="border px-4 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border px-4 py-2">
                                            <select name="products[0][product_id]" class="mt-1 block w-full border border-gray-300 rounded" required>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="number" name="products[0][quantity]" class="mt-1 block w-full border border-gray-300 rounded" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="number" name="products[0][remaining_quantity]" class="mt-1 block w-full border border-gray-300 rounded" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="number" name="products[0][purchase_price]" class="mt-1 block w-full border border-gray-300 rounded" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="number" name="products[0][sale_price]" class="mt-1 block w-full border border-gray-300 rounded" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="date" name="products[0][expiration_date]" class="mt-1 block w-full border border-gray-300 rounded" required>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded" onclick="removeProductRow(this)">Eliminar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="button" id="add-product-btn" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Agregar Producto</button>
                        </div>

                        <!-- Formulario de Compra (Lado derecho) -->
                        <div class="w-1/2">
                            <form action="{{ route('purchases.store') }}" method="POST">
                                @csrf

                                <!-- Main Purchase Details -->
                                <div class="mb-4">
                                    <label for="provider_id" class="block text-sm font-medium">Proveedor</label>
                                    <select name="provider_id" id="provider_id" class="mt-1 block w-full border border-gray-300 rounded" required>
                                        @foreach ($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('provider_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="date" class="block text-sm font-medium">Fecha</label>
                                    <input type="date" name="date" id="date" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('date') }}" required>
                                    @error('date')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="user_id" class="block text-sm font-medium">Usuario</label>
                                    <input type="number" name="user_id" id="user_id" class="mt-1 block w-full border border-gray-300 rounded" value="{{ auth()->user()->id }}" required readonly>
                                    @error('user_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="receipt_type" class="block text-sm font-medium">Tipo de Comprobante</label>
                                    <input type="text" name="receipt_type" id="receipt_type" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('receipt_type') }}" required>
                                    @error('receipt_type')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="receipt_number" class="block text-sm font-medium">Número de Comprobante</label>
                                    <input type="text" name="receipt_number" id="receipt_number" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('receipt_number') }}" required>
                                    @error('receipt_number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="receipt_series" class="block text-sm font-medium">Serie del Comprobante</label>
                                    <input type="text" name="receipt_series" id="receipt_series" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('receipt_series') }}" required>
                                    @error('receipt_series')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="total" class="block text-sm font-medium">Total</label>
                                    <input type="number" name="total" id="total" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('total') }}" required>
                                    @error('total')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium">Estado</label>
                                    <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded" required>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completado</option>
                                        <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    @error('status')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-6">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let productCount = 1;
        
        document.getElementById('add-product-btn').addEventListener('click', function () {
            const table = document.getElementById('products-table').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
                <td class="border px-4 py-2">
                    <select name="products[${productCount}][product_id]" class="mt-1 block w-full border border-gray-300 rounded" required>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="border px-4 py-2">
                    <input type="number" name="products[${productCount}][quantity]" class="mt-1 block w-full border border-gray-300 rounded" required>
                </td>
                <td class="border px-4 py-2">
                    <input type="number" name="products[${productCount}][remaining_quantity]" class="mt-1 block w-full border border-gray-300 rounded" required>
                </td>
                <td class="border px-4 py-2">
                    <input type="number" name="products[${productCount}][purchase_price]" class="mt-1 block w-full border border-gray-300 rounded" required>
                </td>
                <td class="border px-4 py-2">
                    <input type="number" name="products[${productCount}][sale_price]" class="mt-1 block w-full border border-gray-300 rounded" required>
                </td>
                <td class="border px-4 py-2">
                    <input type="date" name="products[${productCount}][expiration_date]" class="mt-1 block w-full border border-gray-300 rounded" required>
                </td>
                <td class="border px-4 py-2">
                    <button type="button" class="bg-red-500 text-white px-2 py-1 rounded" onclick="removeProductRow(this)">Eliminar</button>
                </td>
            `;
            productCount++;
        });

        function removeProductRow(button) {
            button.closest('tr').remove();
        }
    </script>
</x-app-layout>
