<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Erro extends Model
{

    protected $fillable = [
        'id',
        'usuario_id',
        'titulo',
        'descricao',
        'nivel',
        'eventos',
        'ambiente',
        'status',
        'usuario_name',
        'data'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
