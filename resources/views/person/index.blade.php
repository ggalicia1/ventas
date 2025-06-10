<x-app-layout>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Personas</h2>
                <a href="{{ route('persons.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
                    Nueva persona
                </a>
            </div>
        
            <div class="container bg-white px-6 py-6 rounded">
        
                <table class="min-w-full bg-white ">
                    <thead>
                        <tr>
                            <th class="border py-2">Id</th>
                            <th class="border py-2">name</th>
                            <th class="border py-2">email</th>
                            <th class="border py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($persons as $person)
                            <tr>
                                <td class="border px-4 py-2 text-center">{{ $person->id }}</td>
                                <td class="border px-4 py-2">{{ $person->name }}</td>
                                <td class="border px-4 py-2">{{ $person->email }}</td>
                                <td class="border px-4 py-2 flex space-x-2">
                                    <a href="{{ route('persons.edit', $person->id) }}" 
                                       class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
                                        Edit
                                    </a>
                                    <a href="{{ route('persons.show', $person->id) }}" 
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
                {{ $persons->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
