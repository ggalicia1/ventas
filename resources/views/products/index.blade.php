<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>


        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="container mx-auto px-6 py-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Productos</h2>
                    <a href="{{ route('products.create') }}" 
                       class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                       <i class="fas fa-plus mr-2"></i> Nuevo Producto
                    </a>
                </div>
            
                <div class="bg-white px-6 py-3 rounded">
                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('products.index') }}" class="mb-6">
                        <div class="flex items-center">
                            <input type="text" id="productSearch" name="search" value="{{ request('search') }}" placeholder="Buscar productos..." class="border border-gray-300 rounded-md px-4 py-2 w-full" />
                            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Buscar
                            </button>
                        </div>
                    </form>
                
                    <div class="overflow-hidden border border-gray-200 rounded-lg shadow-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Compra</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($products as $product)
                                <tr class="hover:bg-gray-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Q {{ number_format($product->purchase_price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Q {{ number_format($product->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->stock }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('products.edit', $product->id) }}" 
                                               class="px-3 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 3l8 8-7 7h-5l-1 4-4-1 1-4v-5l7-7-8-8 4-4 8 8z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('products.addStock', $product->id) }}" 
                                                class="px-3 py-2 text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16M4 12h16" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="px-3 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                
                    <!-- Paginación -->
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>

        </div>
</x-app-layout>
<script>

    let selectedProducts = []; // Arreglo para almacenar productos seleccionados
    let barcodeBuffer = ''; // Buffer para almacenar el código de barras

    document.getElementById("productSearch").focus();
    document.addEventListener('DOMContentLoaded', function() {
        // Detectar la entrada de códigos de barras automáticamente
        document.getElementById('productSearch').addEventListener('keydown', function(event) {
            // Detectar Enter y enviar la búsqueda
            if (event.key === 'Enter') {
                event.preventDefault();
                if (barcodeBuffer) {
                    const productSearch = document.getElementById('productSearch');
                    const searchValue = productSearch.value;
                    
                    searchByBarcode(searchValue);
                    barcodeBuffer = ''; // Limpiar el buffer después de la búsqueda
                }
            } else {
                barcodeBuffer += event.key;
            }
        });
    });

    function searchByBarcode(barcode) {
        fetch(`/products/barcode/${barcode}`)
            .then(response => {
                if (!response.ok) {
                    if (response.status === 404) {
                        //alert("No se encontró un producto con este código de barras.");
                        Swal.fire({
                        icon: 'error',
                        title: 'Producto no encontrado',
                        text: 'No se encontró un producto con este código de barras.',
                        timer: 1000, // Opcional: Cierra automáticamente después de 3 segundos
                        showConfirmButton: false // Sin botón de confirmación
                    });
                    } else {
                        throw new Error(`Error en la búsqueda: ${response.statusText}`);
                    }
                    return null; // Retornar null para que no se intente procesar un producto inexistente
                }
                return response.json();
            })
            .then(product => {
                if (product) { // Solo procesar si se obtuvo un producto válido
                    window.location.href = `/products/${product.id}`;

                    /* alert(product.id);
                    selectProduct(product.id, product.name, product.price); */
                }
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                const productSearch = document.getElementById('productSearch');
                productSearch.value = ''; // Limpiar el campo
                productSearch.focus(); 
            });
    }

</script>
