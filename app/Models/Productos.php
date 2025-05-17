<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'id_categoria',
    ];

    public function categoria(){
        return $this->belongsTo(Categorias::class, 'id_categoria');
    }
}
