<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Total de Compras por Mes') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Total de Compras del Mes: {{ $month }}</h2>

            <!-- Filtro por Mes -->
            <form action="{{ route('product-stock-history.total-by-day') }}" method="GET" class="mb-6">
                <label for="month" class="mr-4">Filtrar por mes:</label>
                <input type="month" name="month" value="{{ old('month', $month) }}" required class="border p-2 rounded">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded ml-2">Filtrar por Mes</button>
            </form>

            <!-- Mostrar Total por Mes -->
            <div class="mt-6 text-xl font-bold text-right mb-6">
                <p><strong>Total de la Compra (Mes): </strong>Q{{ number_format($totalPurchaseAmountMonth, 2) }}</p>
                <p><strong>Cantidad Total Comprada (Mes): </strong>{{ $totalQuantityMonth }} unidades</p>
            </div>

            <!-- Tabla de Totales por Día -->
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Total Comprado</th>
                        <th scope="col" class="px-6 py-3">Cantidad Total Comprada</th>
                        <th scope="col" class="px-6 py-3">Total de Productos</th> <!-- Nueva columna -->
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($totalsByDay as $total)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $total->day }}</td>
                            <td class="px-6 py-4">Q{{ number_format($total->total_purchase, 2) }}</td> <!-- Total de Compra por Día -->
                            <td class="px-6 py-4">{{ $total->total_quantity }} unidades</td> <!-- Cantidad Comprada por Día -->
                            <td class="px-6 py-4">{{ $total->total_products }} productos</td> <!-- Total de Productos Diferentes Comprados -->
                            <td class="px-6 py-4">
                                <a href="{{ route('product-stock-history.details-by-day', $total->day) }}" class="text-blue-600 hover:text-blue-800">Ver Detalles</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Mostrar Total por Mes Abajo -->
            <div class="mt-6 text-xl font-bold text-right">
                <p><strong>Total de la Compra (Mes): </strong>Q{{ number_format($totalPurchaseAmountMonth, 2) }}</p>
                <p><strong>Cantidad Total Comprada (Mes): </strong>{{ $totalQuantityMonth }} unidades</p>
            </div>
        </div>
    </div>
</x-app-layout>
