<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Erro extends Model
{
    protected $fillable = [
<<<<<<< HEAD
        'id', 'usuario_id', 'titulo', 'descricao', 'nivel', 'eventos', 'id_frequencia', 'ambiente', 'origem', 'status', 'usuario_name', 'data'
=======
        'id', 'usuario_id', 'titulo', 'descricao', 'nivel', 'eventos', 'id_frequencia','ambiente', 'origem', 'status', 'usuario_name', 'data'
>>>>>>> 67dcd75d4c887dd18b194f1749cac0d50f827616
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //public $timestamps = false;

    public function user ()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

}


