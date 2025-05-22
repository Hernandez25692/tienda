<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $fillable = [
        'pedido_id',
        'archivo'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
