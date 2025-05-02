<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Perdida') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <form action="{{ route('lost-products.update', $lost_product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $lost_product->quantity) }}" class="border p-2 rounded w-full" required>
                @error('quantity')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700">Razón o motivo</label>
                <textarea id="reason" name="reason" rows="4" class="border p-2 rounded w-full" required>{{ old('reason', $lost_product->reason) }}</textarea>
                @error('reason')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Actualizar Perdida</button>
        </form>
    </div>
</x-app-layout>
