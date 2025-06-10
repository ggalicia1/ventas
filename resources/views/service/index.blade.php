<x-app-layout>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Servicios</h2>
                <a href="{{ route('services.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
                    Nueva servicios
                </a>
            </div>
        
            <div class="container bg-white px-6 py-6 rounded">
        
                <table class="min-w-full bg-white ">
                    <thead>
                        <tr>
                            <th class="py-2">Id</th>
                            <th class="py-2">name</th>
                            <th class="py-2">descripcion</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td class="border px-4 py-2">{{ $service->id }}</td>
                                <td class="border px-4 py-2">{{ $service->name }}</td>
                                <td class="border px-4 py-2">{{ $service->description }}</td>
                                <td class="border px-4 py-2 flex space-x-2">
                                    <a href="{{ route('services.edit', $service->id) }}" 
                                       class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
                                        Edit
                                    </a>
                                    <a href="{{ route('services.show', $service->id) }}" 
                                       class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
                                        Ver pagos
                                    </a>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
