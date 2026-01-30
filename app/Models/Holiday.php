<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calendar()
    {
        //Accerder a las tablas pivotes y a sus modelos a traves de las relaciones
        return $this->belongsTo(Calendar::class);
    }
}
