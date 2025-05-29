<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;
use Faker\Factory as Faker;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');
        $categorias = Categoria::pluck('id')->toArray();

        for ($i = 1; $i <= 200; $i++) {
            Producto::create([
                'nombre' => ucfirst($faker->words(3, true)),
                'descripcion' => $faker->paragraph,
                'precio_venta' => $faker->randomFloat(2, 200, 2500),
                'precio_compra' => $faker->randomFloat(2, 150, 2000),
                'link_compra' => $faker->url,
                'disponible' => true,
                'visible' => true,
                'categoria_id' => $faker->randomElement($categorias),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
