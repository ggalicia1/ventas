<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800">Editar Compra</h2>

                    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="provider_id" class="block text-sm font-medium">Proveedor</label>
                            <select name="provider_id" id="provider_id" class="mt-1 block w-full border border-gray-300 rounded" required>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}" {{ $purchase->provider_id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            @error('provider_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium">Fecha</label>
                            <input type="date" name="date" id="date" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('date', $purchase->date) }}" required>
                            @error('date')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium">Usuario</label>
                            <input type="number" name="user_id" id="user_id" class="mt-1 block w-full border border-gray-300 rounded" value="{{ $purchase->user_id }}" required readonly>
                            @error('user_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="receipt_type" class="block text-sm font-medium">Tipo de Comprobante</label>
                            <input type="text" name="receipt_type" id="receipt_type" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('receipt_type', $purchase->receipt_type) }}" required>
                            @error('receipt_type')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="receipt_number" class="block text-sm font-medium">Número de Comprobante</label>
                            <input type="text" name="receipt_number" id="receipt_number" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('receipt_number', $purchase->receipt_number) }}" required>
                            @error('receipt_number')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="receipt_series" class="block text-sm font-medium">Serie del Comprobante</label>
                            <input type="text" name="receipt_series" id="receipt_series" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('receipt_series', $purchase->receipt_series) }}" required>
                            @error('receipt_series')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="total" class="block text-sm font-medium">Total</label>
                            <input type="number" name="total" id="total" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('total', $purchase->total) }}" required>
                            @error('total')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium">Estado</label>
                            <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded" required>
                                <option value="pending" {{ $purchase->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="completed" {{ $purchase->status == 'completed' ? 'selected' : '' }}>Completado</option>
                                <option value="canceled" {{ $purchase->status == 'canceled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
