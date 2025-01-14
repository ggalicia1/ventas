
<x-app-layout>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Detalle de Cierre Diario</h2>
                <a href="{{ route('daily-closures.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500 transition">
                    Volver
                </a>
            </div>

            <div class="bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden">
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300">Fecha</h3>
                            <p>{{ $dailyClosure->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300">Total Ventas</h3>
                            <p>Q {{ number_format($dailyClosure->total_sales, 2) }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300">Ventas en Efectivo</h3>
                            <p>Q {{ number_format($dailyClosure->cash_sales_total, 2) }} ({{ $dailyClosure->cash_sales_quantity }} ventas)</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300">Ventas con Tarjeta</h3>
                            <p>Q {{ number_format($dailyClosure->card_sales_total, 2) }} ({{ $dailyClosure->card_sales_quantity }} ventas)</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300">Productos Vendidos</h3>
                            <p>{{ $dailyClosure->total_products_sold }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300">Diferencia</h3>
                            <p class="{{ $dailyClosure->difference < 0 ? 'text-red-600' : 'text-green-600' }}">
                                Q {{ number_format($dailyClosure->difference, 2) }}
                            </p>
                        </div>
                    </div>

                    @if($dailyClosure->comments)
                        <div class="mt-4">
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300">Comentarios</h3>
                            <p class="mt-1">{{ $dailyClosure->comments }}</p>
                        </div>
                    @endif
                </div>
            </div>

                        <!-- Tabla de Inventario -->
                        <div class="bg-white rounded-lg p-6 shadow mt-6">
                            <h3 class="text-lg font-semibold mb-4">Estado del Inventario</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2 text-left text-gray-600">Producto</th>
                                            <th class="px-4 py-2 text-left text-gray-600">Stock Actual</th>
                                            <th class="px-4 py-2 text-left text-gray-600">Movimientos</th>
                                            <th class="px-4 py-2 text-left text-gray-600">Precio de compra</th>
                                            <th class="px-4 py-2 text-left text-gray-600">Precio</th>
                                            <th class="px-4 py-2 text-left text-gray-600">Total vendido</th>
                                            <th class="px-4 py-2 text-left text-gray-600">Total invertido</th>
                                            <th class="px-4 py-2 text-left text-green-600">Diferencia o ganancia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stocks as $stock)
                                            <tr class="border-b">
                                                <td class="px-4 py-2">{{ $stock->name }}</td>
                                                <td class="px-4 py-2">{{ $stock->stock }}</td>
                                                <td class="px-4 py-2">{{ $stock->total_sold }}</td>
                                                <td class="px-4 py-2">{{ $stock->purchase_price }}</td>
                                                <td class="px-4 py-2">Q {{ number_format($stock->sale_price, 2) }}</td>
                                                <td class="px-4 py-2">Q {{ number_format($stock->sale_price * $stock->total_sold, 2) }}</td>
                                                <td class="px-4 py-2">Q {{ number_format($stock->purchase_price * $stock->total_sold, 2) }}</td>
                                                <td class="px-4 py-2 text-green-600">Q {{ number_format((($stock->sale_price * $stock->total_sold) - ($stock->purchase_price * $stock->total_sold)), 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-2 text-center">No hay productos en el inventario.</td>
                                            </tr>
                                        @endforelse
                                    
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ '-----' }}</td>
                                            <td class="px-4 py-2">{{ '-----' }}</td>
                                            <td class="px-4 py-2">{{ '-----' }}</td>
                                            <td class="px-4 py-2">{{ '-----' }}</td>
                                            <td class="px-4 py-2">{{ '-----' }}</td>
                                            <td class="px-4 py-2"><b>Q {{ number_format($sales_total, 2) }}</b></td>
                                            <td class="px-4 py-2"><b>Q {{ number_format($purchase_price, 2) }}</b></td>
                                            <td class="px-4 py-2 text-green-600"><b>Q {{ number_format($difference, 2) }}</b></td>
                                        </tr>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
        </div>
    </div>
</x-app-layout>