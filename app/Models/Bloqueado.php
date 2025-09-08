<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloqueado extends Model
{
    protected $table = 'bloqueados';
    public $timestamps = false;
    protected $fillable = ['bloqueador_id','bloqueado_id'];
}
