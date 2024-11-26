<x-app-layout>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="container px-6 py-8">
            <h2 class="text-2xl font-bold mb-6">Crear Nueva Venta</h2>
            <div class="container px-6 py-6 bg-white rounded">
                <form id="saleForm" action="{{ route('sales.store') }}" method="POST" class="space-y-4">
                    @csrf
        
                    <!-- Sección de búsqueda de productos -->
                    <div class="mb-4">
                        <label for="productSearch" class="block text-gray-700">Buscar Producto:</label>
                        <div class="flex">
                            <input type="text" id="productSearch" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500" placeholder="Buscar por nombre...">
                            <button type="button" class="ml-2 bg-blue-600 text-white px-4 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400" onclick="searchProducts()">
                                Buscar
                            </button>
                        </div>
                    </div>
        
                    <!-- Lista de productos disponibles -->
                    <div id="available-products" class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Productos Disponibles</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left text-gray-600">Producto</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Precio</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list-body">
                                    <!-- Los productos se llenarán aquí por JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
        
                    <!-- Selección de productos a vender -->
                    <div id="selected-products" class="space-y-4 mb-6">
                        <h3 class="text-lg font-semibold mb-2">Productos Seleccionados</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left text-gray-600">Producto</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Cantidad</th>
                                        <th class="px-4 py-2 text-left text-gray-600">Precio</th>
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
                    <div class="space-y-4 mb-6 border p-4 rounded-lg bg-gray-50">
                        <h3 class="text-lg font-semibold mb-4">Método de Pago</h3>
                        
                        <div class="space-y-4">
                            <!-- Selector de método de pago -->
                            <div>
                                <label class="block text-gray-700 mb-2">Seleccione el método de pago:</label>
                                <div class="space-x-4">
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
                    
                            <!-- Sección de Efectivo -->
                            <div id="cashPaymentSection" class="space-y-4">
                                <div>
                                    <label for="cashAmount" class="block text-gray-700 mb-2">Efectivo recibido:</label>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 mr-2">Q</span>
                                        <input type="number" id="cashAmount" name="cash_amount" 
                                               class="w-32 border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500"
                                               step="0.01" min="0" onchange="calculateChange()"
                                               oninput="calculateChange()">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 mb-2">Cambio a entregar:</label>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 mr-2">Q</span>
                                        <span id="changeAmount" class="text-lg font-semibold">0.00</span>
                                        <input type="hidden" name="change_amount" id="changeAmountInput" value="0">
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Sección de Tarjeta -->
                            <div id="cardPaymentSection" class="space-y-4 hidden">
                                <div>
                                    <label for="cardReference" class="block text-gray-700 mb-2">Referencia de transacción:</label>
                                    <input type="text" id="cardReference" name="card_reference" 
                                           class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500"
                                           placeholder="Número de referencia">
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="flex justify-between mb-6">
                        <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400" onclick="confirmSale()">
                            Crear Venta
                        </button>
                    </div>
        
                    <div id="total-summary" class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                        <h3 class="text-lg font-semibold">Total Estimado</h3>
                        <p class="text-gray-700">Q <span id="totalAmount">0.00</span></p>
                    </div>
                </form>
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
                    selectProduct(product.id, product.name, product.price);
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
    
                // Renderizar los productos disponibles
                products.forEach(product => {
                    const row = document.createElement('tr');
                    row.classList.add('hover:bg-gray-50', 'cursor-pointer');
                    row.onclick = () => selectProduct(product.id, product.name, product.price);
    
                    row.innerHTML = `
                        <td class="px-4 py-2">${product.name}</td>
                        <td class="px-4 py-2">Q ${parseFloat(product.price).toFixed(2)}</td>
                    `;
                    productListBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error:', error));
    }
    
    function selectProduct(id, name, price) {
        price = parseFloat(price);

        if (isNaN(price)) {
            alert("El precio del producto no es válido.");
            return;
        }

        // Verificar si el producto ya fue seleccionado
        if (selectedProducts.some(product => product.id === id)) {
            alert("Este producto ya ha sido seleccionado.");
            return;
        }

        const quantityInput = 1; // Cantidad inicial
        selectedProducts.push({ id, name, price, quantity: quantityInput });

        const newRow = document.createElement('tr');
        newRow.id = `product-row-${id}`; // Añadir ID a la fila para poder eliminarla después
        newRow.innerHTML = `
            <td class="px-4 py-2">${name}</td>
            <td class="px-4 py-2">
                <input type="number" class="w-16 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                    min="1" value="${quantityInput}" 
                    onchange="updateTotal(this, ${price}, ${id})">
                <input type="hidden" name="products[${selectedProducts.length - 1}][id]" value="${id}">
                <input type="hidden" name="products[${selectedProducts.length - 1}][quantity]" 
                    id="quantity-${id}" value="${quantityInput}">
            </td>
            <td class="px-4 py-2">Q ${price.toFixed(2)}</td>
            <td class="px-4 py-2" id="total-${id}">Q ${(price * quantityInput).toFixed(2)}</td>
            <td class="px-4 py-2">
                <button type="button" 
                        class="text-red-600 hover:text-red-800 focus:outline-none"
                        onclick="removeProduct(${id})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </td>
            `;
        document.getElementById('selected-product-list').appendChild(newRow);

        calculateTotal(); // Actualizar el total general
    }

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
    
    function updateTotal(input, price, id) {
        const quantity = parseInt(input.value) || 1; // Asegurar al menos 1 unidad
        const total = (price * quantity).toFixed(2);
    
        // Actualizar el total del producto en su celda correspondiente
        document.getElementById(`total-${id}`).textContent = `Q ${total}`;
    
        // Actualizar la cantidad en el arreglo de productos seleccionados
        const productIndex = selectedProducts.findIndex(product => product.id === id);
        selectedProducts[productIndex].quantity = quantity;
    
        // Actualizar el input oculto con la nueva cantidad
        document.getElementById(`quantity-${id}`).value = quantity;
    
        calculateTotal(); // Recalcular el total general
    }
    
    function calculateTotal() {
        let total = 0;

        // Sumar el total de cada producto seleccionado
        selectedProducts.forEach(product => {
            total += product.price * product.quantity;
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

        // Si estamos en modo de pago en efectivo, recalcular el cambio
        if (document.querySelector('input[name="payment_method"]:checked').value === 'cash') {
            calculateChange();
        }
    }

    function confirmSale() {
        // Validar que haya productos seleccionados
        if (selectedProducts.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar al menos un producto para realizar la venta.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        const totalAmount = parseFloat(document.getElementById('totalAmountInput').value);
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        
        // Validar método de pago
        if (paymentMethod === 'cash') {
            const cashAmount = parseFloat(document.getElementById('cashAmount').value) || 0;
            if (cashAmount < totalAmount) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el pago',
                    text: 'El efectivo recibido es menor que el total de la venta.',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }
        } else if (paymentMethod === 'card') {
            const cardReference = document.getElementById('cardReference').value.trim();
            if (!cardReference) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el pago',
                    text: 'Por favor ingrese la referencia de la transacción con tarjeta.',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }
        }

        // Mostrar diálogo de confirmación
        Swal.fire({
            title: '¿Confirmar Venta?',
            html: `
                <p>Total de la venta: Q ${totalAmount.toFixed(2)}</p>
                <p>Método de pago: ${paymentMethod === 'cash' ? 'Efectivo' : 'Tarjeta'}</p>
                ${paymentMethod === 'cash' ? 
                    `<p>Efectivo recibido: Q ${document.getElementById('cashAmount').value}</p>
                    <p>Cambio: Q ${document.getElementById('changeAmount').textContent}</p>` 
                    : 
                    `<p>Referencia: ${document.getElementById('cardReference').value}</p>`
                }
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const createSaleButton = document.querySelector('button[onclick="confirmSale()"]');
                createSaleButton.disabled = true;
                createSaleButton.textContent = "Procesando...";

                // Obtener el formulario
                const form = document.getElementById('saleForm');
                
                // Crear y enviar el formulario usando fetch
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        products: selectedProducts,
                        payment_method: paymentMethod,
                        total_amount: totalAmount,
                        cash_amount: document.getElementById('cashAmount')?.value,
                        change_amount: document.getElementById('changeAmountInput')?.value,
                        card_reference: document.getElementById('cardReference')?.value
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
                    if(data.success){
                        Swal.fire({
                            icon: 'success',
                            title: 'Venta realizada',
                            text: 'La venta se ha registrado correctamente',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            // Redireccionar a la página de ventas o recargar el formulario
                            window.location.reload();
                        });

                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'Aceptar'
                        });
                        createSaleButton.disabled = false;
                        createSaleButton.textContent = "Crear venta";
                    }

                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    createSaleButton.disabled = false;
                    createSaleButton.textContent = "Crear Venta";
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la venta',
                        confirmButtonText: 'Aceptar'
                    });
                });
            }
        });
    }

    function togglePaymentMethod(method) {
        const cashSection = document.getElementById('cashPaymentSection');
        const cardSection = document.getElementById('cardPaymentSection');
        
        if (method === 'cash') {
            cashSection.classList.remove('hidden');
            cardSection.classList.add('hidden');
            calculateChange(); // Recalcular el cambio al cambiar a efectivo
        } else {
            cashSection.classList.add('hidden');
            cardSection.classList.remove('hidden');
        }
    }

    function calculateChange() {
        const totalAmount = parseFloat(document.getElementById('totalAmount').textContent);
        const cashAmount = parseFloat(document.getElementById('cashAmount').value) || 0;
        const changeAmount = cashAmount - totalAmount;
        
        document.getElementById('changeAmount').textContent = changeAmount.toFixed(2);
        document.getElementById('changeAmountInput').value = changeAmount.toFixed(2);
        
        // Validar si el efectivo es suficiente
        if (cashAmount < totalAmount) {
            document.getElementById('changeAmount').classList.add('text-red-600');
        } else {
            document.getElementById('changeAmount').classList.remove('text-red-600');
        }
    }

</script>