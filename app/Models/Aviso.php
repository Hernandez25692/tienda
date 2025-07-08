<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aviso extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'contenido',
        'imagen',
        'mostrar_desde',
        'mostrar_hasta',
        'activo',
    ];

    protected $dates = ['mostrar_desde', 'mostrar_hasta'];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'aviso_user')
            ->withPivot('leido')
            ->withTimestamps();
    }
}
