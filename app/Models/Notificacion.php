<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'titulo',
        'mensaje',
        'leido',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
