<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $table = "registros";

    public function usuario(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
