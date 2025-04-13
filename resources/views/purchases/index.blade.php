<x-app-layout>
    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Compras</h2>
                        <a href="{{ route('purchases.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Nueva Compra
                        </a>
                    </div>

                    <div class="overflow-x-auto">
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
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
