<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $table = 'denuncias';
    public $timestamps = false;
    protected $fillable = ['producto_id','usuario_id','chat_id', 'motivo_id','estado_id'];
}
