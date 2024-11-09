@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-4xl font-bold mb-6 text-center">Bienvenido a la Tienda</h1>
    

</div>

<script>
function selectProduct(id, name, price) {
    alert(`Producto seleccionado: ${name} (Q ${price.toFixed(2)})`);
}
</script>
@endsection
