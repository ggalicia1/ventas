<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de Compra') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        <h3 class="text-2xl font-bold mb-4">Compra del {{ $purchase->date }}</h3>
        <p><strong>Proveedor:</strong> {{ $purchase->provider->name }}</p>
        <p><strong>Usuario:</strong> {{ $purchase->user->name }}</p>
        <p><strong>Tipo de Comprobante:</strong> {{ $purchase->receipt_type }}</p>
        <p><strong>Serie:</strong> {{ $purchase->receipt_series }}</p>
        <p><strong>Número:</strong> {{ $purchase->receipt_number }}</p>
        <p><strong>Total Compra (sólo suma registrada):</strong> Q{{ number_format($purchase->total, 2) }}</p>

        <h4 class="mt-6 text-lg font-semibold">Productos</h4>
        <table class="w-full mt-2 border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Producto</th>
                    <th class="p-2">Cantidad</th>
                    <th class="p-2">Precio Compra</th>
                    <th class="p-2">Precio Venta</th>
                    <th class="p-2">Subtotal Compra</th>
                    <th class="p-2">Subtotal Venta</th>
                    <th class="p-2">Ganancia</th>
                    <th class="p-2">Fecha Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalCompra = 0;
                    $totalVenta = 0;
                    $totalGanancia = 0;
                @endphp

                @foreach ($purchase->productStockHistories as $item)
                    @php
                        $subtotalCompra = $item->quantity * $item->purchase_price;
                        $subtotalVenta = $item->quantity * $item->sale_price;
                        $ganancia = $subtotalVenta - $subtotalCompra;

                        $totalCompra += $subtotalCompra;
                        $totalVenta += $subtotalVenta;
                        $totalGanancia += $ganancia;
                    @endphp
                    <tr class="border-t">
                        <td class="p-2 text-center">{{ $item->product->name }}</td>
                        <td class="p-2 text-center">{{ $item->quantity }}</td>
                        <td class="p-2 text-center">Q{{ number_format($item->purchase_price, 2) }}</td>
                        <td class="p-2 text-center">Q{{ number_format($item->sale_price, 2) }}</td>
                        <td class="p-2 text-center  text-blue-600 font-semibold">Q{{ number_format($subtotalCompra, 2) }}</td>
                        <td class="p-2 text-center  text-green-600 font-semibold">Q{{ number_format($subtotalVenta, 2) }}</td>
                        <td class="p-2 text-center  text-purple-600 font-semibold">Q{{ number_format($ganancia, 2) }}</td>
                        <td class="p-2 text-center">{{ $item->expiration_date }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-100 font-bold">
                    <td colspan="4" class="p-2 text-right">Totales:</td>
                    <td class="p-2 text-center text-blue-700">Q{{ number_format($totalCompra, 2) }}</td>
                    <td class="p-2 text-center text-green-700">Q{{ number_format($totalVenta, 2) }}</td>
                    <td class="p-2 text-center text-purple-700">Q{{ number_format($totalGanancia, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-app-layout>
