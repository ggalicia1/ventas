

<x-app-layout>
    <div class="pt-1 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-5">
            <div class="flex justify-between items-center mb-1">
                <h4 class="text-xl font-bold text-gray-800 dark:text-white">Cierres Diarios</h4>
            </div>
            {{-- 🔹 FORMULARIO DE FILTRO --}}
            <div class="mb-3 p-3 bg-gray-100 dark:bg-gray-800 rounded-lg shadow">
                <div class="flex flex-wrap justify-between gap-4 items-end">

                    {{-- Formulario principal --}}
                    <form method="GET" action="{{ route('daily-closures.index') }}" class="flex flex-wrap gap-6 items-end flex-grow">

                        {{-- Mes --}}
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <label for="month" class="text-sm font-medium text-gray-700 dark:text-gray-200">Mes:</label>
                            <select 
                                name="month" 
                                id="month" 
                                class="w-48 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == request('month', now()->month) ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Año --}}
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <label for="year" class="text-sm font-medium text-gray-700 dark:text-gray-200">Año:</label>
                            <select 
                                name="year" 
                                id="year" 
                                class="w-48 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                @for ($y = now()->year; $y >= 2000; $y--)
                                    <option value="{{ $y }}" {{ $y == request('year', now()->year) ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Botón de Filtrar --}}
                        <div>
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-5 py-2 text-white bg-blue-600 hover:bg-blue-500 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                Filtrar
                            </button>
                        </div>
                    </form>

                    {{-- Botón de cierre a la derecha --}}
                    <div class="self-end">
                        <a href="{{ route('sales.close') }}" 
                        class="inline-flex items-center px-5 py-2 text-white bg-green-600 hover:bg-green-500 rounded-md transition focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                            Cierre de hoy
                        </a>
                    </div>

                </div>
            </div>
            {{-- 🔹 TABLA DE CIERRES --}}

            <div class="container bg-white dark:bg-gray-700 px-3 py-3 rounded">
                <table class="min-w-full bg-white dark:bg-gray-700">
                    <thead>
                        <tr>
                            <th class="text-center px-6">Fecha</th>
                            <th class="text-center px-4">Ventas <br> con efectivo</th>
                            <th class="text-center px-4">Ventas <br> con tarjeta</th>
                            <th class="text-center px-4">Total</th>
                            <th class="text-center px-4">Sobrantes</th>
                            <th class="text-center px-4 bg-blue-600 text-white">Total de ventas</th>
                            <th class="text-center px-4 bg-green-600 text-white">Ganacia</th>
                            <th class="text-center px-4 bg-orange-600 text-white">Inversion</th>
                            <th class="text-center px-4">Productos <br> Vendidos</th>
                            <th class="text-center px-6">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyClosures as $closure)
                            <tr class="border-t dark:border-gray-600">
                                <td class="px-0">{{ $closure->created_at }}</td>
                                <td class="px-4 text-right">Q {{ number_format($closure->cash_sales_total, 2) }}</td>
                                <td class="px-4 text-right">Q {{ number_format($closure->card_sales_total, 2) }}</td>
                                <td class="px-4 text-right">Q {{ number_format($closure->total_sales, 2) }}</td>
                                <td class="px-4 text-right">Q {{ number_format($closure->surplus, 2) }}</td>
                                <td class="px-4 text-right bg-blue-50">Q {{ number_format(number_format($closure->total_sales, 2) + number_format($closure->surplus, 2), 2) }}</td>
                                <td class="px-4 text-right bg-green-50">Q {{ $closure->difference }}</td>
                                <td class="px-4 text-right bg-orange-50">Q {{ number_format($closure->purchase_price, 2) }}</td>
                                <td class="px-4 text-right">{{ $closure->total_products_sold }}</td>
                                <td class="px-0">
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
                            <td class="px-4 py-2 text-right"><b>Q {{ $totals['sales_total'] }}</b></td>
                            <td class="px-4 py-2 text-right"><b>Q {{ number_format($totals['surplus'], 2) }}</b></td>
                            <td class="px-4 py-2 text-right bg-blue-600 text-white"><b>Q {{ number_format(number_format($totals['sales_total']) + number_format($totals['surplus'], 2), 2)  }}</b></td>
                            <td class="px-4 py-2 text-right bg-green-600 text-white"><b>Q {{ $totals['difference'] }}</b></td>
                            <td class="px-4 py-2 text-right bg-orange-600 text-white"><b>Q {{ $totals['purchase_price'] }}</b></td>
                            <td class="px-4 py-2 text-right">{{ '----' }}</td>
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

