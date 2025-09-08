<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pqrs extends Model
{
    protected $table = 'pqrs';
    public $timestamps = false;
    protected $fillable = ['usuario_id','mensaje','motivo_id','estado_id'];
}
