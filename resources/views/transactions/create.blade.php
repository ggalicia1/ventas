<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Nueva Transacción</h2>

                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Fecha</label>
                                <input type="date" name="date" id="date" 
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <input type="text" name="description" id="description" 
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>

                            <div>
                                <label for="debit_balance" class="block text-sm font-medium text-gray-700">Saldo Deudor</label>
                                <input type="number" step="0.01" name="debit_balance" id="debit_balance" 
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>

                            <div>
                                <label for="change_amount" class="block text-sm font-medium text-gray-700">Para Cambio</label>
                                <input type="number" step="0.01" name="change_amount" id="change_amount" 
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>

                            <div>
                                <label for="cleared" class="block text-sm font-medium text-gray-700">Despejado</label>
                                <select name="cleared" id="cleared" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Transacción
                            </button>
                            <a href="{{ route('transactions.index') }}" 
                               class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>