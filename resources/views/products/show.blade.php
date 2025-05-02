<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalle del Producto') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Producto: {{ $product->name }}</h2>

            <div class="bg-white px-6 py-6 rounded">
                <!-- Información del Producto -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Nombre:</p>
                        <p class="font-medium">{{ $product->name }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600">Descripción:</p>
                        <p class="font-medium">{{ $product->description ?? 'No disponible' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600">Precio:</p>
                        <p class="font-medium">Q. {{ number_format($product->price, 2) }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600">Stock:</p>
                        <p class="font-medium">{{ $product->stock }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600">Categoría:</p>
                        <p class="font-medium">{{ $product->category->name ?? 'No asignada' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600">Proveedor:</p>
                        <p class="font-medium">{{ $product->supplier ?? 'No especificado' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600">Código de Barras:</p>
                        <p class="font-medium">{{ $product->barcode ?? 'No especificado' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600">Creado el:</p>
                        <p class="font-medium">{{ $product->created_at->format('d-m-Y H:i') }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600">Última actualización:</p>
                        <p class="font-medium">{{ $product->updated_at->format('d-m-Y H:i') }}</p>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="mt-6 border-t pt-4 flex justify-between items-center">
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Volver a Productos</a>
                    <div class="flex space-x-2">
                        <div class="flex space-x-2">
                            <a href="{{ route('products.edit', $product->id) }}" 
                               class="px-3 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                               title="Editar producto">
                               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 3l8 8-7 7h-5l-1 4-4-1 1-4v-5l7-7-8-8 4-4 8 8z" />
                                </svg>
                            </a>
                            <a href="{{ route('products.addStock', $product->id) }}" 
                                class="px-3 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                title="Ver stock de producto">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <!-- Icono de ojo (Heroicons eye) -->
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                           d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                           d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                 </svg>
                             </a>
                             <a href="{{ route('products.lostProduct', $product->id) }}" 
                                class="px-3 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                                title="Agregar pérdida de producto">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <!-- Ícono de signo menos -->
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                 </svg>
                             </a>                                             
                             
                            @if(Auth::user()->email == 'gustavogalicia247@gmail.com')
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                            title="Eliminar producto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                    </button>
                                </form>
                                
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
