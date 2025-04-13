<x-app-layout>
    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-2 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Proveedores</h2>
                        <a href="{{ route('providers.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Nuevo Proveedor
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre de Contacto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Correo Electrónico
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Teléfono
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dirección
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($providers as $provider)
                                    <tr>
                                        <td class="px-6 py-4">{{ $provider->name }}</td>
                                        <td class="px-6 py-4">{{ $provider->contact_name }}</td>
                                        <td class="px-6 py-4">{{ $provider->email }}</td>
                                        <td class="px-6 py-4">{{ $provider->phone }}</td>
                                        <td class="px-6 py-4">{{ $provider->address }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('providers.edit', $provider) }}" class="text-blue-500">Editar</a>
                                            <form action="{{ route('providers.destroy', $provider) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 ml-4">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $providers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
