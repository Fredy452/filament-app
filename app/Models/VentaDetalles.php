<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalles extends Model
{
    use HasFactory;
    protected $table = 'venta_detalles';
    protected $fillable = ['sort', 'venta_id', 'producto_id', 'cantidad', 'precio'];

}
