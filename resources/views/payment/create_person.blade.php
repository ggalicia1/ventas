<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Nuevo pago</h2>

                    <form id="form-paymet" action="{{ route('persons.paymentPerson', $objet->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Monto: </label>
                                <input type="number" id="amount" name="amount" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripcion</label>
                                <input type="text" id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md">
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                    Crear pago
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('form-paymet').addEventListener('submit', function(e) {
        e.preventDefault(); // Previene el envío normal del formulario

        const form = e.target;
        const formData = new FormData(form);

        const amount = formData.get('amount');
        const description = formData.get('description');
        if (!amount) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe ingresar un monto.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }
        if (!description) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe ingresar una descripcion.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        fetch("{{ route('persons.paymentPerson', $objet->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }
            return response.json(); // Asume que el servidor devuelve JSON
        })
        .then(data => {
            // Puedes cambiar este mensaje según la respuesta
            //console.log(data);
            if(data.status){
                Swal.fire({
                    icon: 'success',
                    title: 'Pago creada',
                    text: 'El pago ha sido registrado correctamente.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = "{{ route('person.show', $objet->id) }}"; 
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al crear el pago.',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al crear el pago.',
                confirmButtonText: 'Aceptar'
            });
            console.error('Error:', error);
        });
    });
</script>