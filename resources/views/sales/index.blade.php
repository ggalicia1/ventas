<x-app-layout>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Ventas</h2>
                <a href="{{ route('sales.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Nueva Venta
                </a>
            </div>
        
            <div class="container bg-white px-6 py-6 rounded">
        
                <table class="min-w-full bg-white ">
                    <thead>
                        <tr>
                            <th class="py-2">ID Venta</th>
                            <th class="py-2">Fecha</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr>
                                <td class="border px-4 py-2">{{ $sale->id }}</td>
                                <td class="border px-4 py-2">{{ $sale->created_at->format('d/m/Y') }}</td>
                                <td class="border px-4 py-2">Q {{ number_format($sale->details->sum('total_price'), 2) }}</td>
                                <td class="border px-4 py-2 flex space-x-2">
                                    <a href="{{ route('sales.show', $sale->id) }}" 
                                       class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
                                        Ver Detalle
                                    </a>
                                    <a href="{{ route('sales.receipt', $sale->id) }}" 
                                       class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-500 transition">
                                        Recibo
                                    </a>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
            <div class="mt-4">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
