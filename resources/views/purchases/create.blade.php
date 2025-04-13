<x-app-layout>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container px-6">
            <div class="flex justify-between items-center w-full py-2">
                <!-- Texto a la izquierda -->
                <h2 class="text-2xl text-left font-bold">Nueva Compra</h2>
                <!-- Contenedor centrado -->
                <div class="flex flex-1 justify-center">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold">Total de compra</h3>
                        <p class="text-green-500 text-3xl"><b>Q <span id="totalAmount">0.00</span></b></p>
                    </div>
                </div>
            </div>
            <div class="flex gap-12 items-start">
                <!-- Sección de búsqueda de productos -->
                <div class="mb-10 mr-2 w-1/2">
                    <label for="productSearch" class="block text-gray-700">Buscar Producto:</label>
                    <div class="flex">
                        <input type="text" id="productSearch" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500" placeholder="Buscar por nombre...">
                        <button type="button" 
                                class="ml-2 bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center gap-2" 
                                onclick="searchProducts()">
                            <!-- Icono de búsqueda (Heroicons) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1117.5 10.5a7.5 7.5 0 01-7.5 7.5z"></path>
                            </svg>
                            Buscar
                        </button>

                    </div>
                    <!-- Botón alineado a la derecha -->
                    <div class="w-full flex justify-end py-4">
                        <button type="button" 
                                class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 flex items-center gap-2"
                                onclick="validateAndConfirmPurchase()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l1 5m2 0h9l1-5m-5 12a2 2 0 110 4 2 2 0 010-4zM7 13a2 2 0 110 4 2 2 0 010-4zM9 8h6"></path>
                            </svg>
                            Guardar compra
                        </button>
                    </div>
                    <!-- Contenedor de notificaciones -->
                    <div id="notification-container" class="fixed top-5 right-5 z-[9999]"></div>
                    <!-- Modal -->
                    <div id="productsModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
                        <!-- Fondo oscuro -->
                        <div class="absolute inset-0 bg-black opacity-50"></div>

                        <!-- Contenido del Modal -->
                        <div class="relative bg-white rounded-lg shadow-lg w-3/5 h-3/5 p-6 flex flex-col z-50">
                            <!-- Encabezado del Modal -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">Productos Disponibles</h3>
                                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                            </div>

                            <!-- Cuerpo del Modal con Scroll -->
                            <div class="flex-grow overflow-y-auto border border-gray-300">
                                <table class="w-full">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2 text-left text-gray-600">Código</th>
                                            <th class="px-4 py-2 text-left text-gray-600">Producto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product-list-body">
                                        <!-- Los productos se llenarán aquí por JavaScript -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pie del Modal -->
                            <div class="mt-4 flex justify-end">
                                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" border p-4 bg-gray-50">
                    <h3 class="text-lg font-semibold mb-4 text-center">Proveedor</h3>
                    <!-- Sección de Efectivo -->
                    <div id="cashPaymentSection" class="">
                      <div class="mb-4">
                        <label for="provider_id" class="block text-sm font-medium">Proveedor</label>
                        <select name="provider_id" id="provider_id" class="mt-1 block w-full border border-gray-300 rounded" required>
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @endforeach
                        </select>
                        @error('provider_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="date" class="block text-sm font-medium">Fecha</label>
                        <input type="date" name="date" id="date" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('date') }}" required>
                        @error('date')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
    
                  </div>

                </div>
                <div class=" border p-4 bg-gray-50">
                    <h3 class="text-lg font-semibold mb-4 text-center">Comprobante</h3>
                    <div id="cashPaymentSection" class="">
                      <div class="mb-4">
                        <label for="receipt_type" class="block text-sm font-medium">Tipo de Comprobante</label>
                        <input type="text" name="receipt_type" id="receipt_type" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('receipt_type') }}" required>
                        @error('receipt_type')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="receipt_number" class="block text-sm font-medium">Número de Comprobante</label>
                        <input type="text" name="receipt_number" id="receipt_number" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('receipt_number') }}" required>
                        @error('receipt_number')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="receipt_series" class="block text-sm font-medium">Serie del Comprobante</label>
                        <input type="text" name="receipt_series" id="receipt_series" class="mt-1 block w-full border border-gray-300 rounded" value="{{ old('receipt_series') }}" required>
                        @error('receipt_series')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
    
                  </div>
                  <!-- Sección de Tarjeta -->
                </div>
                <!-- Método de Pago - 20% -->
                <div class="border p-4 bg-gray-50">
                    <h3 class="text-lg font-semibold mb-4 ">Método de Pago</h3>
                    <div class="">
                        
                        <!-- Selector de método de pago -->
                        <div>
                            <label class="block text-gray-700 mb-2">Seleccione el método de pago:</label>
                            <div class="space-x-4 py-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="payment_method" value="cash" 
                                           class="form-radio text-blue-600" 
                                           onchange="togglePaymentMethod('cash')" checked>
                                    <span class="ml-2">Efectivo</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="payment_method" value="card" 
                                           class="form-radio text-blue-600" 
                                           onchange="togglePaymentMethod('card')">
                                    <span class="ml-2">Tarjeta</span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium">Estado</label>
                            <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completado</option>
                                <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="container rounded">
                <form id="purchaseForm" action="{{ route('purchases.store') }}" method="POST" class="space-y-4">
                    @csrf                    
                    <!-- Selección de productos a vender -->
                    <div id="selected-products" class="space-y-4 mb-6">
                        <h3 class="text-lg font-semibold mb-2">Productos Seleccionados</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead>
                                    <tr class="bg-blue-100">
                                        <th class="px-4 py-2 text-left text-gray-600">Codigo</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Producto</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Cantidad</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Precio de compra</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Precio de venta</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Fecha de vencimiento</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Total</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="selected-product-list" class="divide-y divide-gray-300">
                                    <!-- Los productos seleccionados se agregarán aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                </form>
            </div>
           
        </div>
    </div>
</x-app-layout>

<script>
    function openModal() {
        document.getElementById('productsModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('productsModal').classList.add('hidden');
    }
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

    function showNotification(message, type = 'success') {
        const container = document.getElementById('notification-container');

        // Estilos según el tipo de mensaje
        const bgColor = type === 'error' ? 'bg-red-500' : 'bg-green-500';

        // Crear el elemento de notificación
        const notification = document.createElement('div');
        notification.className = `${bgColor} text-white px-4 py-2 rounded shadow-lg mb-2 opacity-100 transition-opacity duration-500 ease-in-out z-[9999]`;
        notification.innerText = message;

        // Agregar al contenedor
        container.appendChild(notification);

        // Desvanecer y eliminar la notificación después de 5 segundos
        setTimeout(() => {
            notification.classList.add('opacity-0');
            setTimeout(() => {
                notification.remove();
            }, 400);
        }, 5000);
    }

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
                    selectProduct(product.id, product.barcode, product.name, product.price);
                }
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                const productSearch = document.getElementById('productSearch');
                productSearch.value = ''; // Limpiar el campo
                productSearch.focus(); 
            });
    }

    function searchProducts() {
        const searchValue = document.getElementById('productSearch').value;
        fetch(`/products/search/${encodeURIComponent(searchValue)}`)
            .then(response => {
                if (!response.ok) throw new Error(`Error en la búsqueda: ${response.statusText}`);
                return response.json();
            })
            .then(products => {
                const productListBody = document.getElementById('product-list-body');
                productListBody.innerHTML = ''; // Limpiar la lista de productos
    
                if (products.length === 0) {
                    
                    const productSearch = document.getElementById('productSearch');
                    //productSearch.value = ''; // Limpiar el campo
                    productSearch.focus();
                    productListBody.innerHTML = `<tr><td colspan="2" class="text-center py-2">No se encontraron productos.</td></tr>`;
                     Swal.fire({
                        icon: 'error',
                        title: 'Producto no encontrado',
                        text: 'No se encontraron productos.',
                        timer: 1000, // Opcional: Cierra automáticamente después de 3 segundos
                        showConfirmButton: false // Sin botón de confirmación;
                    });
                    
                    return;
                }
                openModal();
    
                // Renderizar los productos disponibles
                products.forEach(product => {
                    const row = document.createElement('tr');
                    row.classList.add('hover:bg-blue-100', 'cursor-pointer');
                    row.onclick = () => selectProduct(product.id, product.barcode, product.name, product.price);
    
                    row.innerHTML = `
                        <td class="px-4 py-2">${product.barcode}</td>
                        <td class="px-4 py-2">${product.name}</td>

                    `;
                    productListBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function selectProduct(id, barcode, name) {
        // Valores iniciales para los precios (en este caso, todos son editables)
        let purchasePrice = 0.00; // Precio de compra inicial
        let salePrice = 0.00;     // Precio de venta inicial
        const expirationDate = "2025-12-31"; // Fecha de vencimiento inicial
        const quantityInput = 1;   // Cantidad inicial

        // Verificar si el producto ya fue seleccionado
        const existingProduct = selectedProducts.find(product => product.id === id);
        if (existingProduct) {
            // Si el producto ya existe, incrementar la cantidad en 1
            existingProduct.quantity += 1;

            // Actualizar el input de cantidad en la interfaz
            const quantityElement = document.querySelector(`#product-row-${id} input[type="number"].quantity`);
            quantityElement.value = existingProduct.quantity;

            // Actualizar el input oculto
            document.querySelector(`#quantity-${id}`).value = existingProduct.quantity;

            // Actualizar el total de la línea (basado en precio de compra)
            const totalCell = document.querySelector(`#total-${id}`);
            totalCell.textContent = `Q ${(purchasePrice * existingProduct.quantity).toFixed(2)}`;

            // Actualizar el total general
            calculateTotal();
            showNotification(`Producto "${name}" seleccionado con éxito!`, "success");
            return;
        }

        selectedProducts.push({ id, name, barcode, purchasePrice, salePrice, expirationDate, quantity: quantityInput });

        const newRow = document.createElement('tr');
        
        newRow.addEventListener('mouseover', function() {
            newRow.style.backgroundColor = '#DDDFE3';
        });

        newRow.addEventListener('mouseout', function() {
            newRow.style.backgroundColor = '';
        });

        newRow.id = `product-row-${id}`;
        newRow.innerHTML = `
            <td class="px-4 py-2">${barcode}</td>
            <td class="px-4 py-2">${name}</td>

            <!-- Cantidad del Producto (editable) -->
            <td class="px-4 py-2">
                <input type="number" class="w-25 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 quantity"
                    min="1" value="" 
                    onchange="updateTotal(this, ${id})">
                <input type="hidden" name="products[${selectedProducts.length - 1}][id]" value="${id}">
                <input type="hidden" name="products[${selectedProducts.length - 1}][quantity]" id="quantity-${id}" value="${quantityInput}">
            </td>

            <!-- Precio de Compra (editable) -->
            <td class="px-4 py-2">
                <input type="number" class="w-22 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 purchase-price"
                    value="" 
                    onchange="updatePurchasePrice(this, ${id})">
            </td>

            <!-- Precio de Venta (editable) -->
            <td class="px-4 py-2">
                <input type="number" class="w-22 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 sale-price"
                    value="" 
                    onchange="updateSalePrice(this, ${id})">
            </td>

            <!-- Fecha de Vencimiento -->
            <td class="px-4 py-2">
                <input type="date" name="products[${selectedProducts.length - 1}][expiration_date]" value="">
            </td>

            <!-- Total (calculado con el precio de compra) -->
            <td class="px-4 py-2" id="total-${id}">Q ${(purchasePrice * quantityInput).toFixed(2)}</td>

            <!-- Acción para Eliminar Producto -->
            <td class="px-4 py-2 border-b border-gray-300">
                <button type="button" class="text-red-700 hover:text-red-300 focus:outline-none" onclick="removeProduct(${id})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>

            
        `;
        
        document.getElementById('selected-product-list').appendChild(newRow);

        calculateTotal();
        showNotification(`Producto "${name}" seleccionado con éxito!`, "success");
    }

    function updateTotal(input, id) {
        const quantity = parseInt(input.value) || 1; // Asegurar al menos 1 unidad
        const purchasePrice = parseFloat(document.querySelector(`#product-row-${id} .purchase-price`).value); // Obtener precio de compra
        const total = (purchasePrice * quantity).toFixed(2);
        
        // Actualizar el total del producto en su celda correspondiente
        document.getElementById(`total-${id}`).textContent = `Q ${total}`;
        
        // Actualizar la cantidad en el arreglo de productos seleccionados
        const productIndex = selectedProducts.findIndex(product => product.id === id);
        selectedProducts[productIndex].quantity = quantity;
        
        // Actualizar el input oculto con la nueva cantidad
        document.getElementById(`quantity-${id}`).value = quantity;
        
        calculateTotal(); // Recalcular el total general
    }

    function updatePurchasePrice(input, id) {
        const newPurchasePrice = parseFloat(input.value);
        if (isNaN(newPurchasePrice) || newPurchasePrice <= 0) {
            input.value = 0;  // Evitar precios negativos o cero
        }

        // Actualizar el total de la fila con el nuevo precio de compra
        const quantityInput = document.querySelector(`#product-row-${id} input[type="number"].quantity`);
        const newQuantity = parseInt(quantityInput.value);
        const totalCell = document.querySelector(`#total-${id}`);
        const total = newPurchasePrice * newQuantity;
        totalCell.textContent = `Q ${total.toFixed(2)}`;
        
        // Actualizar el precio de compra en el arreglo de productos seleccionados
        const productIndex = selectedProducts.findIndex(product => product.id === id);
        selectedProducts[productIndex].purchasePrice = newPurchasePrice;

        // Recalcular el total general
        calculateTotal();
    }

    function updateSalePrice(input, id) {
        let newSalePrice = parseFloat(input.value);
        if (isNaN(newSalePrice) || newSalePrice <= 0) {
            input.value = 0;  // Evitar precios negativos o cero
            newSalePrice = 0;
        }

        // Actualizar el precio de venta en el arreglo de productos seleccionados
        const productIndex = selectedProducts.findIndex(product => product.id === id);
        selectedProducts[productIndex].salePrice = newSalePrice;

        // Recalcular el total general
        calculateTotal();
    }

    function removeProduct(id) {
        // Eliminar el producto de la lista
        selectedProducts = selectedProducts.filter(product => product.id !== id);

        // Eliminar la fila del DOM
        const row = document.getElementById(`product-row-${id}`);
        row.parentNode.removeChild(row);

        // Recalcular el total general
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        selectedProducts.forEach(product => {
            const quantity = product.quantity;
            const purchasePrice = product.purchasePrice;
            total += quantity * purchasePrice; // Sumar basado en precio de compra
        });
        // Actualizar el total visible
        document.getElementById('totalAmount').textContent = total.toFixed(2);
        
        // Actualizar el input oculto con el total
        if (!document.getElementById('totalAmountInput')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.id = 'totalAmountInput';
            input.name = 'total_amount';
            document.querySelector('form').appendChild(input);
        }
        document.getElementById('totalAmountInput').value = total.toFixed(2);
    }

    function validateAndConfirmPurchase() {
        // Validar que haya un proveedor seleccionado
        const providerId = document.getElementById('provider_id').value;
        if (!providerId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar un proveedor.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Validar que la fecha esté seleccionada
        const date = document.getElementById('date').value;
        if (!date) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar una fecha.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Validar el tipo de comprobante
        const receiptType = document.getElementById('receipt_type').value;
        if (!receiptType) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe ingresar el tipo de comprobante.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Validar el número de comprobante
        const receiptNumber = document.getElementById('receipt_number').value;
        if (!receiptNumber) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe ingresar el número de comprobante.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Validar la serie del comprobante
        const receiptSeries = document.getElementById('receipt_series').value;
        if (!receiptSeries) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe ingresar la serie del comprobante.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Validar que al menos un producto haya sido seleccionado y que todos los campos del producto sean correctos
        if (selectedProducts.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar al menos un producto para la compra.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Verificar que todos los productos tengan datos válidos (cantidad y precio de compra)
        for (let product of selectedProducts) {
            if (!product.quantity || product.quantity <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `El producto ${product.name} debe tener una cantidad válida.`,
                    confirmButtonText: 'Aceptar'
                });
                return;
            }
            if (!product.purchasePrice || product.purchasePrice <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `El producto ${product.name} debe tener un precio de compra válido.`,
                    confirmButtonText: 'Aceptar'
                });
                return;
            }
        }

        // Ahora que todos los campos están validados, podemos proceder con la compra
        confirmPurchase(); // Llamar a la función para confirmar la compra
    }

    function confirmPurchase() {
        // Validar que haya productos seleccionados
        if (selectedProducts.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar al menos un producto para realizar la compra.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        const totalPurchaseAmount = parseFloat(document.getElementById('totalAmountInput').value);

        // Mostrar diálogo de confirmación
        Swal.fire({
            title: '¿Confirmar Compra?',
            html: `
                <p>Total de la compra: Q ${totalPurchaseAmount.toFixed(2)}</p>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const createPurchaseButton = document.querySelector('button[onclick="validateAndConfirmPurchase()"]');
                createPurchaseButton.disabled = true;
                createPurchaseButton.textContent = "Procesando...";

                // Obtener el formulario de compra
                const form = document.getElementById('purchaseForm');
                
                // Crear y enviar el formulario usando fetch
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        provider_id: document.getElementById('provider_id').value,
                        date: document.getElementById('date').value,
                        receipt_type: document.getElementById('receipt_type').value,
                        receipt_number: document.getElementById('receipt_number').value,
                        receipt_series: document.getElementById('receipt_series').value,
                        products: selectedProducts,  // Productos seleccionados con su precio de compra, cantidad, etc.
                        total_amount: totalPurchaseAmount  // Total de la compra
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en el servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    // Mostrar mensaje de éxito
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Compra realizada',
                            text: 'La compra se ha registrado correctamente.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            // Redireccionar o recargar el formulario de compras
                            window.location.reload(); // O ajusta para que redirija donde necesites
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'Aceptar'
                        });
                        createPurchaseButton.disabled = false;
                        createPurchaseButton.textContent = "Confirmar Compra";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    createPurchaseButton.disabled = false;
                    createPurchaseButton.textContent = "Confirmar Compra";

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la compra.',
                        confirmButtonText: 'Aceptar'
                    });
                });
            }
        });
    }


</script>
{{-- 
<script>
     

    
    
    
    
    
    
    

    
    
    
    

    function removeProduct(productId) {
        Swal.fire({
            title: '¿Eliminar producto?',
            text: "¿Estás seguro de que deseas eliminar este producto?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Eliminar el producto del arreglo
                selectedProducts = selectedProducts.filter(product => product.id !== productId);
                
                // Eliminar la fila de la tabla
                const row = document.getElementById(`product-row-${productId}`);
                if (row) {
                    row.remove();
                }
                
                // Recalcular el total
                calculateTotal();
                
                // Mostrar mensaje de confirmación
                Swal.fire({
                    icon: 'success',
                    title: 'Producto eliminado',
                    showConfirmButton: false,
                    timer: 1000
                });
            }
        });
    }
    
    
    
    



    function togglePaymentMethod(method) {
        const cashSection = document.getElementById('cashPaymentSection');
        const cardSection = document.getElementById('cardPaymentSection');
        const lblPay = document.getElementById('lblPay');
        
        if (method === 'cash') {
            cashSection.classList.remove('hidden');
            cardSection.classList.add('hidden');
            //lblPay.textContent = 'Efectivo recibido:'; // Cambiar texto del label
            calculateChange(); // Recalcular el cambio al cambiar a efectivo
        } else {
            cashSection.classList.add('hidden');
            //lblPay.textContent = 'Total pagado con tarjeta.'; // Cambiar texto del label
            cardSection.classList.remove('hidden');
        }
    }

    

    


</script> --}}