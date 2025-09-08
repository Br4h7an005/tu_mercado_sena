<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correos';
    public $timestamps = false;
    protected $fillable = ['correo','clave','pin','fecha_mail'];
}
