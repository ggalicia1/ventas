<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>


    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Detalle de Venta #{{ $sale->id }}</h2>
            
            <div class="bg-white px-6 py-6 rounded">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 text-left text-gray-600">Producto</th>
                            <th class="py-2 text-left text-gray-600">Cantidad</th>
                            <th class="py-2 text-left text-gray-600">Precio Unitario</th>
                            <th class="py-2 text-left text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->details as $detail)
                            <tr>
                                <td class="border px-4 py-2">{{ $detail->product->name }}</td>
                                <td class="border px-4 py-2">{{ $detail->quantity }}</td>
                                <td class="border px-4 py-2">Q. {{ number_format($detail->price, 2) }}</td>
                                <td class="border px-4 py-2">Q. {{ number_format($detail->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        
                <!-- Información de Pago -->
                <div class="mt-6 border-t pt-4">
                    <h3 class="text-lg font-semibold mb-3">Información de Pago</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Método de Pago:</p>
                            <p class="font-medium">{{ ucfirst($sale->payment_method) }}</p>
                        </div>
        
                        @if($sale->payment_method == 'cash')
                        <div>
                            <p class="text-gray-600">Monto Recibido:</p>
                            <p class="font-medium">Q. {{ number_format($sale->cash_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Cambio:</p>
                            <p class="font-medium">Q. {{ number_format($sale->change_amount, 2) }}</p>
                        </div>
                        @endif
        
                        @if($sale->payment_method == 'card')
                        <div>
                            <p class="text-gray-600">Referencia de Tarjeta:</p>
                            <p class="font-medium">{{ $sale->card_reference }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-gray-600">Fecha y hora:</p>
                            <p class="font-medium">{{ date('d-m-Y H:i', strtotime($sale->created_at)) }}</p>
                        </div>
                    </div>
                </div>
        
                <!-- Mostrar el Total General -->
                <div class="flex justify-end mt-6">
                    <div class="text-lg font-semibold">
                        Total de la Venta: 
                        <span class="text-blue-600">
                            Q. {{ number_format($sale->details->sum('total_price'), 2) }}
                        </span>
                    </div>
                </div>
        
                <div class="mt-4">
                    <a href="{{ route('sales.index') }}" class="text-blue-600 hover:underline">Volver a Ventas</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
