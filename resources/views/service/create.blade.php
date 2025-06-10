<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Nuevo Servicios</h2>

                    <form id="form-service" action="{{ route('persons.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del servicio</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripcion</label>
                                <input type="text" id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md">
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                    Crear Servicios
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
    document.getElementById('form-service').addEventListener('submit', function(e) {
        e.preventDefault(); // Previene el envío normal del formulario

        const form = e.target;
        const formData = new FormData(form);

        const name = formData.get('name');
        const description = formData.get('description');
        if (!name) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe ingresar un nombre.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }
        if (!description) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe ingresar un email.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        fetch("{{ route('services.store') }}", {
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
                    title: 'Servicio creado',
                    text: 'El servicio ha sido registrada correctamente.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = "{{ route('services.index') }}"; 
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al crear el servicio.',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al crear el servicio.',
                confirmButtonText: 'Aceptar'
            });
            console.error('Error:', error);
        });
    });
</script>