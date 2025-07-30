<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
                        <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selecciona el mes:</label>
                        <input type="month" name="month" id="month" value="{{ request('month') ?? now()->format('Y-m') }}"
                            class="mt-1 block w-60 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Filtrar</button>
                    </form>
                    @if($rangoMes)
                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
                            Mostrando ventas del <strong>{{ $rangoMes['inicio'] }}</strong> al <strong>{{ $rangoMes['fin'] }}</strong> (Mes: {{ \Carbon\Carbon::parse($rangoMes['mesSeleccionado'])->locale('es')->translatedFormat('F Y') }})
                        </div>
                    @endif --}}
                   <div class="mt-8">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">📊 Top 30 Productos Más Vendidos</h2>

                        <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Producto</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Total Vendido</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Hoy {{ $hoy }}</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Semana {{ date("m-d", strtotime($inicioSemana)) }} al {{ date("m-d", strtotime($finSemana)) }}</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Mes {{ date("m-d", strtotime($inicioMes)) }} al {{ date("m-d", strtotime($finMes)) }}</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Stock</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($productos as $producto)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $producto->name }}</td>
                                        <td class="px-4 py-2 text-sm text-right">{{ $producto->total_vendido }}</td>
                                        <td class="px-4 py-2 text-sm text-right">{{ $producto->vendido_hoy }}</td>
                                        <td class="px-4 py-2 text-sm text-right">{{ $producto->vendido_semana }}</td>
                                        <td class="px-4 py-2 text-sm text-right">{{ $producto->vendido_mes }}</td>
                                        <td class="px-4 py-2 text-sm text-right">{{ $producto->stock }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">No hay productos vendidos aún.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
