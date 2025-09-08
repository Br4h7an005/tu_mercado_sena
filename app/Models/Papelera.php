<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Papelera extends Model
{
    protected $table = 'papelera';
    public $timestamps = false;
    protected $fillable = ['usuario_id','mensaje','es_imagen'];
}
