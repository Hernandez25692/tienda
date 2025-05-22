<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'codigo',
        'total',
        'estado',
        'fecha_entrega_estimada'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class);
    }
}
