<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reporte Diario de Ventas') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Tarjeta de Ventas Totales -->
                <div class="bg-white rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold mb-2">Ventas del Día</h3>
                    <p class="text-2xl text-green-600 font-bold">Q {{ number_format($totalVentasDia, 2) }}</p>
                    <p class="text-sm text-gray-600 mt-2">Costo: Q {{ number_format($costoVentasDia, 2) }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        Ganancia: Q {{ number_format($totalVentasDia - $costoVentasDia, 2) }}
                    </p>
                </div>

                <!-- Tarjeta de Productos Vendidos -->
                <div class="bg-white rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold mb-2">Productos Vendidos</h3>
                    <p class="text-2xl text-blue-600 font-bold">{{ $cantidadProductosVendidos }}</p>
                    <div class="mt-2 text-sm">
                        <p class="flex justify-between">
                            <span>Efectivo:</span>
                            <span class="font-medium">{{ $cantidadProductosEfectivo }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span>Tarjeta:</span>
                            <span class="font-medium">{{ $cantidadProductosTarjeta }}</span>
                        </p>
                    </div>
                </div>

                <!-- Tarjeta de Fecha -->
                <div class="bg-white rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold mb-2">Fecha del Reporte</h3>
                    <p class="text-2xl text-gray-700">{{ date('d-m-Y', strtotime($date)) }}</p>
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
                                <th class="px-4 py-2 text-left text-gray-600">Precio</th>
                                <th class="px-4 py-2 text-left text-gray-600">Total vendido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $stock)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $stock->name }}</td>
                                    <td class="px-4 py-2">{{ $stock->stock }}</td>
                                    <td class="px-4 py-2">{{ $stock->total_sold }}</td>
                                    <td class="px-4 py-2">Q {{ number_format($stock->price, 2) }}</td>
                                    <td class="px-4 py-2">Q {{ number_format($stock->price * $stock->total_sold, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-center">No hay productos en el inventario.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>