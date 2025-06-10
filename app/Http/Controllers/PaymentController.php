<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // Mostrar lista de pagos
    }

    public function create()
    {
        // Mostrar formulario para crear un pago
    }

    public function store(Request $request)
    {
        // Guardar un nuevo pago
    }

    public function show($id)
    {
        // Mostrar un pago específico
    }

    public function edit($id)
    {
        // Mostrar formulario para editar un pago
    }

    public function update(Request $request, $id)
    {
        // Actualizar un pago existente
    }

    public function destroy($id)
    {
        // Eliminar un pago
    }
}
