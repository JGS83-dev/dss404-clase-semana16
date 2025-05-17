<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = 'ventas';
    protected $fillable = [
        'codigo',
        'id_producto',
        'cantidad',
        'totalVenta'
    ];

    public function producto(){
        return $this->belongsTo(Productos::class, 'id_producto');
    }
}
