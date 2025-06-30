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
        'visible',
        'categoria_id',
        'precio_oferta',
        'oferta_expires_at',
    ];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_producto')
            ->withPivot('cantidad', 'precio_unitario', 'comentario')
            ->withTimestamps();
    }


    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
