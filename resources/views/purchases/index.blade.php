<x-app-layout>
    <div class="py-1">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Compras</h2>
                        <a href="{{ route('product-stock-history.total-by-day') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Compras son proveedor
                        </a>
                        <a href="{{ route('purchases.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Nueva Compra
                        </a>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-6">

                        {{-- Resumen mensual (lado izquierdo) --}}
                        <div class="lg:w-1/3 p-1 rounded">
                            {{-- Formulario de filtro --}}
                            <form method="GET" action="{{ route('purchases.index') }}" class="flex flex-col space-y-4">
                                <div>
                                    <label for="month" class="block text-sm font-medium text-black">Mes</label>
                                    <select name="month" id="month" class="form-select rounded border-gray-300 w-full">
                                        <option value="">Todos</option>
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="year" class="block text-sm font-medium text-black">Año</label>
                                    <select name="year" id="year" class="form-select rounded border-gray-300 w-full">
                                        <option value="">Todos</option>
                                        @foreach(range(date('Y'), 2000) as $y)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" id="btn-filter" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition disabled:opacity-50" disabled>
                                    Filtrar
                                </button>
                            </form>
                            <br>
                            <h3 class="text-xl font-semibold mb-2">Resumen mensual</h3>
                            <ul class="list-disc list-inside mb-4">
                                @foreach($monthly_totals as $month_data)
                                    <li>{{ $month_data->month_name }}: Q{{ number_format($month_data->total, 2) }}</li>
                                @endforeach
                            </ul>
                            <h2 class="font-bold mb-4">Total: Q {{ number_format($total_amount, 2) }}</h2>
                            
                        </div>

                        <div class="lg:w-2/3 bg-white px-6 py-6 rounded shadow">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-800">Pagos</h2>
                                {{-- <a href="{{ route('services.payment.create', $service->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
                                    Nuevo pago
                                </a> --}}
                            </div>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Proveedor
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($purchases as $purchase)
                                        <tr>
                                            <td class="px-6 py-4">{{ $purchase->provider->name }}</td>
                                            <td class="px-6 py-4">{{ date("d-m-Y", strtotime($purchase->date)) }}</td>
                                            <td class="px-6 py-4">Q. {{ number_format($purchase->total, 2) }}</td>
                                            <td class="px-6 py-4">{{ ucfirst($purchase->status) }}</td>
                                            <td class="px-6 py-4">
                                                {{-- <a href="{{ route('purchases.edit', $purchase) }}" class="text-blue-500">Editar</a> --}}
                                                <a href="{{ route('purchases.show', $purchase) }}" 
                                                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded mr-2">
                                                        Ver
                                                </a>
                                                {{-- <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 ml-4">Eliminar</button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="border px-4 py-2 font-bold">Total:</td>
                                        <td class="border px-4 py-2 font-bold">Q {{ number_format($total_month, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $purchases->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
        const yearInput = document.getElementById('year');
        const monthInput = document.getElementById('month');
        const filterButton = document.getElementById('btn-filter');

        function validateInputs() {
            const year = parseInt(yearInput.value);
            const month = parseInt(monthInput.value);

            const isValidYear = !isNaN(year) && year > 1900 && year <= new Date().getFullYear();
            const isValidMonth = !isNaN(month) && month >= 1 && month <= 12;

            filterButton.disabled = !(isValidYear && isValidMonth);
        }

        yearInput.addEventListener('input', validateInputs);
        monthInput.addEventListener('input', validateInputs);
</script>