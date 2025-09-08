<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    public $timestamps = false;
    protected $fillable = ['usuario_id', 'motivo_id','mensaje','visto'];

}