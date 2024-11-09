<!DOCTYPE html>
<html>
<head>
    <title>Recibo de Venta #{{ $sale->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h1>Recibo de Venta #{{ $sale->id }}</h1>
<p>Fecha: {{ $sale->created_at->format('d/m/Y') }}</p>

<table class="table">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sale->details as $detail)
            <tr>
                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>Q. {{ number_format($detail->price, 2) }}</td>
                <td>Q. {{ number_format($detail->total_price, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Total a Pagar: Q. {{ number_format($sale->details->sum('total_price'), 2) }}</strong></p>

</body>
</html>
