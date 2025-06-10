<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="mt-4">
            <a href="{{ route('services.index') }}" class="text-blue-600 hover:underline">Volver a los servivos</a>
        </div>
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Detalle de pagos de {{ $service->name }}</h2>

            {{-- Contenedor principal en horizontal --}}
            <div class="flex flex-col lg:flex-row gap-6">

                {{-- Resumen mensual (lado izquierdo) --}}
                <div class="lg:w-1/3 p-4 rounded">
                    {{-- Formulario de filtro --}}
                    <form method="GET" action="{{ route('services.show', $service->id) }}" class="flex flex-col space-y-4">
                        <div>
                            <label for="month" class="block text-sm font-medium text-white">Mes</label>
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
                            <label for="year" class="block text-sm font-medium text-white">Año</label>
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
                    <h4 class=" font-bold mb-4">Total: Q {{ number_format($total_amount, 2) }}</h4>
                    <h3 class="text-xl font-semibold mb-2">Resumen mensual</h3>
                    <ul class="list-disc list-inside mb-4">
                        @foreach($monthly_totals as $month_data)
                            <li>{{ $month_data->month_name }}: Q{{ number_format($month_data->total, 2) }}</li>
                        @endforeach
                    </ul>
                    
                </div>

                {{-- Tabla de pagos (lado derecho) --}}
                <div class="lg:w-2/3 bg-white px-6 py-6 rounded shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Pagos</h2>
                        <a href="{{ route('services.payment.create', $service->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
                            Nuevo pago
                        </a>
                    </div>

                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left text-gray-600 border-b">Monto</th>
                                <th class="py-2 px-4 text-left text-gray-600 border-b">Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($payments) > 0)
                                @foreach($payments as $payment)
                                    <tr>
                                        <td class="border px-4 py-2">Q. {{ number_format($payment->amount, 2) }}</td>
                                        <td class="border px-4 py-2">{{ $payment->description }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-gray-500">No hay pagos registrados.</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="border px-4 py-2 font-bold">Total:</td>
                                <td class="border px-4 py-2 font-bold">Q {{ number_format($total_month, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $payments->appends(['month' => $month, 'year' => $year])->links() }}
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