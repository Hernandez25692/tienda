<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'precio_compra',
        'link_compra',
        'disponible',
        'visible'
    ];

    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class);
    }
}
