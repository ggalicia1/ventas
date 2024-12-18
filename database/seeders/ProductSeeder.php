<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Abarrotes', 'description' => 'Productos básicos y no perecederos'],
            ['name' => 'Bebidas', 'description' => 'Refrescos, jugos y bebidas alcohólicas'],
            ['name' => 'Lácteos y Huevos', 'description' => 'Productos lácteos y huevos frescos'],
            ['name' => 'Frutas y Verduras', 'description' => 'Productos frescos de temporada'],
            ['name' => 'Carnes y Embutidos', 'description' => 'Carnes frescas y embutidos'],
            ['name' => 'Limpieza y Hogar', 'description' => 'Productos de limpieza y para el hogar'],
            ['name' => 'Cuidado Personal', 'description' => 'Artículos de higiene y cuidado personal'],
            ['name' => 'Snacks y Golosinas', 'description' => 'Botanas, dulces y galletas'],
        ];

        // Insertar categorías
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Datos de productos (versión reducida, expande a 200 siguiendo este patrón)
        
            $products = [
                // Abarrotes (ID: 1)
                ['name' => 'Frijoles negros La Tía', 'description' => 'Bolsa de frijoles negros de 1 libra', 'price' => 8.50, 'stock' => 50, 'category_id' => 1, 'supplier' => 'Distribuidora La Tía'],
                ['name' => 'Arroz Gallo Dorado', 'description' => 'Bolsa de arroz de 5 libras', 'price' => 30.00, 'stock' => 40, 'category_id' => 1, 'supplier' => 'Distribuidora Central'],
                ['name' => 'Aceite vegetal Olmeca', 'description' => 'Botella de aceite vegetal Olmeca de 1 litro', 'price' => 22.00, 'stock' => 30, 'category_id' => 1, 'supplier' => 'Distribuidora Central'],
                ['name' => 'Azúcar San Antonio', 'description' => 'Bolsa de azúcar blanca de 5 libras', 'price' => 25.00, 'stock' => 35, 'category_id' => 1, 'supplier' => 'Ingenio San Antonio'],
                ['name' => 'Sal refinada El Dragón', 'description' => 'Bolsa de sal refinada de 2 libras', 'price' => 5.00, 'stock' => 60, 'category_id' => 1, 'supplier' => 'Salinera Nacional'],
                ['name' => 'Pasta de tornillo Ina', 'description' => 'Paquete de pasta de tornillo de 200g', 'price' => 6.50, 'stock' => 45, 'category_id' => 1, 'supplier' => 'Distribuidora Central'],
                ['name' => 'Atún en lata Bumble Bee', 'description' => 'Lata de atún en agua de 142g', 'price' => 12.00, 'stock' => 40, 'category_id' => 1, 'supplier' => 'Importadora del Pacífico'],
                ['name' => 'Café instantáneo Nescafé', 'description' => 'Frasco de café instantáneo de 100g', 'price' => 35.00, 'stock' => 25, 'category_id' => 1, 'supplier' => 'Nestlé Guatemala'],
                ['name' => 'Consomé de pollo Maggi', 'description' => 'Caja de 8 cubos de consomé', 'price' => 8.00, 'stock' => 55, 'category_id' => 1, 'supplier' => 'Nestlé Guatemala'],
                ['name' => 'Harina de trigo Gold Medal', 'description' => 'Bolsa de harina de trigo de 5 libras', 'price' => 20.00, 'stock' => 30, 'category_id' => 1, 'supplier' => 'Molino Santa Clara'],
                ['name' => 'Mayonesa McCormick', 'description' => 'Frasco de mayonesa de 200g', 'price' => 15.00, 'stock' => 35, 'category_id' => 1, 'supplier' => 'Distribuidora del Sur'],
                ['name' => 'Salsa de tomate Naturas', 'description' => 'Botella de salsa de tomate de 400g', 'price' => 10.00, 'stock' => 40, 'category_id' => 1, 'supplier' => 'Alimentos Kerns'],
                ['name' => 'Leche en polvo Anchor', 'description' => 'Bolsa de leche en polvo de 360g', 'price' => 30.00, 'stock' => 25, 'category_id' => 1, 'supplier' => 'Importadora Láctea'],
                ['name' => 'Sopa instantánea Maruchan', 'description' => 'Vaso de sopa instantánea de 64g', 'price' => 5.00, 'stock' => 70, 'category_id' => 1, 'supplier' => 'Distribuidora Central'],
                ['name' => 'Avena en hojuelas Quaker', 'description' => 'Bote de avena en hojuelas de 900g', 'price' => 25.00, 'stock' => 30, 'category_id' => 1, 'supplier' => 'PepsiCo Guatemala'],
    
                // Bebidas (ID: 2)
                ['name' => 'Coca-Cola 2 litros', 'description' => 'Botella de Coca-Cola de 2 litros', 'price' => 12.00, 'stock' => 30, 'category_id' => 2, 'supplier' => 'Embotelladora La Mariposa'],
                ['name' => 'Jugo Del Valle naranja', 'description' => 'Botella de jugo Del Valle sabor naranja de 1 litro', 'price' => 8.50, 'stock' => 35, 'category_id' => 2, 'supplier' => 'Embotelladora La Mariposa'],
                ['name' => 'Cerveza Gallo', 'description' => 'Six pack de cerveza Gallo en lata', 'price' => 60.00, 'stock' => 25, 'category_id' => 2, 'supplier' => 'Cervecería Centroamericana'],
                ['name' => 'Agua pura Salvavidas', 'description' => 'Botella de agua pura de 2.5 litros', 'price' => 7.00, 'stock' => 50, 'category_id' => 2, 'supplier' => 'Cervecería Centroamericana'],
                ['name' => 'Pepsi 1.5 litros', 'description' => 'Botella de Pepsi de 1.5 litros', 'price' => 10.00, 'stock' => 30, 'category_id' => 2, 'supplier' => 'CABCORP'],
                ['name' => 'Gatorade Tropical', 'description' => 'Botella de Gatorade sabor tropical de 600ml', 'price' => 12.00, 'stock' => 40, 'category_id' => 2, 'supplier' => 'PepsiCo Guatemala'],
                ['name' => 'Jugo de naranja Naturas', 'description' => 'Caja de jugo de naranja de 1 litro', 'price' => 15.00, 'stock' => 25, 'category_id' => 2, 'supplier' => 'Alimentos Kerns'],
                ['name' => 'Cerveza Modelo Especial', 'description' => 'Six pack de cerveza Modelo Especial en botella', 'price' => 75.00, 'stock' => 20, 'category_id' => 2, 'supplier' => 'Cervecería Centroamericana'],
                ['name' => '7Up 2 litros', 'description' => 'Botella de 7Up de 2 litros', 'price' => 11.00, 'stock' => 30, 'category_id' => 2, 'supplier' => 'CABCORP'],
                ['name' => 'Café helado Splash', 'description' => 'Botella de café helado Splash de 500ml', 'price' => 8.00, 'stock' => 35, 'category_id' => 2, 'supplier' => 'Embotelladora La Mariposa'],
                ['name' => 'Jugo de manzana Del Monte', 'description' => 'Caja de jugo de manzana de 1 litro', 'price' => 14.00, 'stock' => 25, 'category_id' => 2, 'supplier' => 'Del Monte Foods'],
                ['name' => 'Bebida energética Red Bull', 'description' => 'Lata de Red Bull de 250ml', 'price' => 20.00, 'stock' => 30, 'category_id' => 2, 'supplier' => 'Distribuidora de Bebidas'],
                ['name' => 'Agua con gas Salvavidas Twist', 'description' => 'Botella de agua con gas de 600ml', 'price' => 6.00, 'stock' => 40, 'category_id' => 2, 'supplier' => 'Cervecería Centroamericana'],
                ['name' => 'Cerveza Corona', 'description' => 'Six pack de cerveza Corona en botella', 'price' => 70.00, 'stock' => 20, 'category_id' => 2, 'supplier' => 'Cervecería Centroamericana'],
                ['name' => 'Té frío Lipton', 'description' => 'Botella de té frío Lipton de 500ml', 'price' => 9.00, 'stock' => 35, 'category_id' => 2, 'supplier' => 'PepsiCo Guatemala'],
    
                // Lácteos y Huevos (ID: 3)
                ['name' => 'Leche entera Dos Pinos', 'description' => 'Caja de leche entera de 1 litro', 'price' => 10.50, 'stock' => 25, 'category_id' => 3, 'supplier' => 'Lacteos del Norte'],
                ['name' => 'Huevos blancos', 'description' => 'Cartón de 30 huevos blancos', 'price' => 35.00, 'stock' => 15, 'category_id' => 3, 'supplier' => 'Granja El Gallo Feliz'],
                ['name' => 'Queso fresco', 'description' => 'Queso fresco por libra', 'price' => 20.00, 'stock' => 15, 'category_id' => 3, 'supplier' => 'Lacteos del Norte'],
                ['name' => 'Yogurt Yoplait fresa', 'description' => 'Paquete de 4 yogures Yoplait sabor fresa', 'price' => 22.00, 'stock' => 20, 'category_id' => 3, 'supplier' => 'Distribuidora Centroamericana'],
                ['name' => 'Crema pura', 'description' => 'Bote de crema pura de 450ml', 'price' => 18.00, 'stock' => 25, 'category_id' => 3, 'supplier' => 'Lacteos del Norte'],
                ['name' => 'Mantequilla Anchor', 'description' => 'Barra de mantequilla de 115g', 'price' => 12.00, 'stock' => 30, 'category_id' => 3, 'supplier' => 'Importadora Láctea'],
                ['name' => 'Queso cheddar en rodajas', 'description' => 'Paquete de queso cheddar en rodajas de 200g', 'price' => 25.00, 'stock' => 20, 'category_id' => 3, 'supplier' => 'Distribuidora del Sur'],
                ['name' => 'Leche descremada Foremost', 'description' => 'Caja de leche descremada de 1 litro', 'price' => 11.00, 'stock' => 25, 'category_id' => 3, 'supplier' => 'Foremost Dairies'],
                ['name' => 'Yogurt griego natural', 'description' => 'Vaso de yogurt griego natural de 150g', 'price' => 8.00, 'stock' => 30, 'category_id' => 3, 'supplier' => 'Lacteos del Norte'],
                ['name' => 'Queso mozzarella', 'description' => 'Queso mozzarella por libra', 'price' => 30.00, 'stock' => 15, 'category_id' => 3, 'supplier' => 'Distribuidora del Sur'],
                ['name' => 'Huevos orgánicos', 'description' => 'Cartón de 12 huevos orgánicos', 'price' => 25.00, 'stock' => 20, 'category_id' => 3, 'supplier' => 'Granja Eco Huevos'],
                ['name' => 'Leche de almendras', 'description' => 'Caja de leche de almendras sin azúcar de 1 litro', 'price' => 28.00, 'stock' => 15, 'category_id' => 3, 'supplier' => 'Importadora de Alimentos Saludables'],
            // ... Agrega los 198 productos restantes aquí
        ];

        // Insertar productos
/*         foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'category_id' => $product['category_id'],
                'supplier' => $product['supplier'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } */
    }
}
