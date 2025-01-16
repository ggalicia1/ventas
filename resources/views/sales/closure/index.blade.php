

<x-app-layout>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Cierres Diarios</h2>
                <a href="{{ route('daily-closures.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition">
                    Nuevo Cierre
                </a>
            </div>

            <div class="container bg-white dark:bg-gray-700 px-6 py-6 rounded">
                <table class="min-w-full bg-white dark:bg-gray-700">
                    <thead>
                        <tr>
                            <th class="py-2 text-left px-6">Fecha</th>
                            <th class="py-2 text-right px-4">Ventas Efectivo</th>
                            <th class="py-2 text-right px-4">Ventas Tarjeta</th>
                            <th class="py-2 text-right px-4">Total Ventas</th>
                            <th class="py-2 text-right px-4">Productos Vendidos</th>
                            <th class="py-2 text-right px-4">Inversion</th>
                            <th class="py-2 text-right px-4">Sobrantes</th>
                            <th class="py-2 text-right px-4 bg-green-600 text-white-600">Diferencia o ganacia</th>
                            <th class="py-6 text-center px-6">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyClosures as $closure)
                            <tr class="border-t dark:border-gray-600">
                                <td class="px-0 py-2">{{ $closure->created_at }}</td>
                                <td class="px-4 py-2 text-right">Q {{ number_format($closure->cash_sales_total, 2) }}</td>
                                <td class="px-4 py-2 text-right">Q {{ number_format($closure->card_sales_total, 2) }}</td>
                                <td class="px-4 py-2 text-right">Q {{ number_format($closure->total_sales, 2) }}</td>
                                <td class="px-4 py-2 text-right">{{ $closure->total_products_sold }}</td>
                                <td class="px-4 py-2 text-right">{{ $closure->purchase_price }}</td>
                                <td class="px-4 py-2 text-right">{{ $closure->surplus }}</td>
                                <td class="px-4 py-2 text-right bg-green-500">{{ $closure->difference }}</td>
                                <td class="px-0 py-2">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('daily-closures.show', $closure->id) }}"
                                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition">
                                            Ver Detalle
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="border-t dark:border-gray-600">
                            <td class="px-4 py-2 text-right">{{ '----' }}</td>
                            <td class="px-4 py-2 text-right">{{ '----' }}</td>
                            <td class="px-4 py-2 text-right">{{ '----' }}</td>
                            <td class="px-4 py-2 text-right"><b>{{ $totals['sales_total'] }}</b></td>
                            <td class="px-4 py-2 text-right">{{ '----' }}</td>
                            <td class="px-4 py-2 text-right"><b>{{ $totals['purchase_price'] }}</b></td>
                            <td class="px-4 py-2 text-right"><b>{{ $totals['surplus'] }}</b></td>
                            <td class="px-4 py-2 text-right"><b>{{ $totals['difference'] }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $dailyClosures->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

