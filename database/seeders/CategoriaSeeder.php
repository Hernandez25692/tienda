<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Ropa de mujer',
            'Ropa de hombre',
            'Ropa de niña',
            'Ropa de niño',
            'Calzado de mujer',
            'Calzado de hombre',
            'Calzado de niña',
            'Calzado de niño',
            'Accesorios',
            'Bolsos y carteras',
            'Tecnología',
            'Hogar y decoración',
            'Belleza y cuidado personal',
            'Ropa deportiva',
            'Lencería y pijamas',
            'Ropa de bebés',
            'Juguetes y juegos',
            'Electrónicos pequeños',
            'Moda plus size',
        ];

        foreach ($categorias as $nombre) {
            Categoria::create(['nombre' => $nombre]);
        }
    }
}
