<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Editar Proveedor</h2>

                    <form action="{{ route('persons.update', $person) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                             <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la persona</label>
                                <input type="text" id="name" name="name" value="{{ old('address', $person->name) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                <input type="email" id="email" name="email" value="{{ old('address', $person->email) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                    Actualizar datos persona
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
