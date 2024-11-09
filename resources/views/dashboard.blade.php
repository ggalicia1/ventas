@extends('layouts.app')

@section('title', 'Dashboard')

@section('header-title', 'Panel de Control')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Total de Ventas</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">$1,200</p>
            <span class="text-green-500 text-sm">+8% desde ayer</span>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Órdenes Totales</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">320</p>
            <span class="text-green-500 text-sm">+5% desde ayer</span>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Productos Vendidos</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">85</p>
            <span class="text-green-500 text-sm">+12% desde ayer</span>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Nuevos Clientes</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">12</p>
            <span class="text-green-500 text-sm">+0.5% desde ayer</span>
        </div>
    </div>
</div>
@endsection
