<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    protected $table = 'motivos';
    public $timestamps = false;
    protected $fillable = ['nombre','descripcion'];
}
