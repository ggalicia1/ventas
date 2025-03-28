<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles de Compras del Día') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Detalles de Compras del Día: {{ $date }}</h2>

            <!-- Muestra Total de la Compra y Cantidad Total Comprada -->
            <div class="mb-6">
                <p class="text-4xl font-bold text-green-600">
                    <strong>Total de la Compra: </strong>Q{{ number_format($totalPurchaseAmount, 2) }}
                </p>
                <p class="text-lg mt-2"><strong>Cantidad Total Comprada: </strong>{{ $totalQuantity }} unidades</p>
            </div>

            <!-- Tabla de Detalles de Compras -->
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Producto</th>
                        <th scope="col" class="px-6 py-3">Cantidad</th>
                        <th scope="col" class="px-6 py-3">Precio de Compra</th>
                        <th scope="col" class="px-6 py-3">Precio de Venta</th>
                        <th scope="col" class="px-6 py-3">Fecha de Vencimiento</th>
                        <th scope="col" class="px-6 py-3">Total por Producto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockDetails as $detail)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $detail->product->name }}</td>
                            <td class="px-6 py-4">{{ $detail->quantity }}</td>
                            <td class="px-6 py-4">{{ number_format($detail->purchase_price, 2) }}</td>
                            <td class="px-6 py-4">{{ number_format($detail->sale_price, 2) }}</td>
                            <td class="px-6 py-4">{{ $detail->expiration_date }}</td>
                            <td class="px-6 py-4">Q{{ number_format($detail->quantity * $detail->purchase_price, 2) }}</td> <!-- Total por Producto -->
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <td colspan="5" class="px-6 py-3 text-right font-bold">Total de la Compra</td>
                        <td class="px-6 py-3 text-left font-bold text-green-600">Q {{ number_format($totalPurchaseAmount, 2) }}</td> <!-- Total de la Compra -->
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</x-app-layout>
