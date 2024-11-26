<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>


    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Reportes de Ventas</h2>
        
            <!-- Filtros -->
            <form method="GET" action="{{ route('reports.sales.index') }}" class="flex space-x-4 mb-6">
                <select name="report_type" id="report_type" class="border p-2 rounded" onchange="toggleDateFields()">
                    <option value="daily" {{ $reportType == 'daily' ? 'selected' : '' }}>Diario</option>
                    <option value="weekly" {{ $reportType == 'weekly' ? 'selected' : '' }}>Semanal</option>
                    <option value="monthly" {{ $reportType == 'monthly' ? 'selected' : '' }}>Mensual</option>
                    <option value="range" {{ $reportType == 'range' ? 'selected' : '' }}>Por Rango</option>
                </select>
        
                <!-- Fechas de inicio y fin, visibles solo para el rango -->
                <div id="date_fields" class="flex space-x-4 {{ $reportType == 'range' ? '' : 'hidden' }}">
                    <input type="date" name="start_date" value="{{ $startDate }}" class="border p-2 rounded" placeholder="Fecha Inicio">
                    <input type="date" name="end_date" value="{{ $endDate }}" class="border p-2 rounded" placeholder="Fecha Fin">
                </div>
        
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filtrar</button>
            </form>
        
            <!-- Total de Ventas -->
            <div class="bg-white rounded p-6 shadow mb-6">
                <h3 class="text-lg font-semibold">Total de Ventas: <span class="text-green-600">Q {{ number_format($totalSales, 2) }}</span></h3>
                
                <!-- Total de Productos Vendidos en el Reporte Diario -->
                @if($reportType === 'daily')
                    <h3 class="text-lg font-semibold">Total de Productos Vendidos: <span class="text-blue-600">{{ $totalProductsSold }}</span></h3>
                @endif
            </div>
            
            <!-- Tabla de Ventas -->
            <div class="bg-white rounded p-6 shadow">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-gray-600">Fecha</th>
                            <th class="px-4 py-2 text-left text-gray-600">Cliente</th>
                            <th class="px-4 py-2 text-left text-gray-600">Método de Pago</th>
                            <th class="px-4 py-2 text-left text-gray-600">Monto Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ date('d-m-Y', strtotime($sale->date)) }}</td>
                                <td class="px-4 py-2">{{ $sale->customer_id ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ ucfirst($sale->payment_method) }}</td>
                                <td class="px-4 py-2">Q {{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center">No se encontraron ventas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function toggleDateFields() {
        const reportType = document.getElementById('report_type').value;
        const dateFields = document.getElementById('date_fields');
        
        if (reportType === 'range') {
            dateFields.classList.remove('hidden');
        } else {
            dateFields.classList.add('hidden');
        }
    }

    // Ejecuta la función al cargar la página por si se selecciona "range" al inicio
    document.addEventListener('DOMContentLoaded', toggleDateFields);
</script>