<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Abarrotes', 'description' => 'Productos básicos como arroz, frijol y azúcar.'],
            ['name' => 'Bebidas', 'description' => 'Refrescos, jugos, café y agua embotellada.'],
            ['name' => 'Snacks', 'description' => 'Productos rápidos como papas, galletas y dulces.'],
            ['name' => 'Lácteos', 'description' => 'Productos derivados de la leche como quesos y yogures.'],
            ['name' => 'Limpieza', 'description' => 'Productos para el hogar como jabones y detergentes.'],
            ['name' => 'Cuidado Personal', 'description' => 'Artículos como shampoo y desodorantes.'],
        ];

        DB::table('categories')->insert($categories);
    }
}
