<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ventas';
    protected $fillable = ['numero_factura', 'users_id', 'clientes_id', 'metodo_pagos_id', 'estado_pagos_id','fecha', 'total_venta'];

    public function users()
    {
        // Una venta fue realizado por un usuario
        return $this->belongsTo(User::class);
    }

    public function metodo_pagos()
    {
        // Una venta tiene un metodo de pago
        return $this->belongsTo(MetodoPago::class);
    }

    // Una venta tiene un estado de pago
    public function estado_pagos()
    {
        return $this->belongsTo(EstadoPago::class);
    }

    // Una venta es realizado por un cliente
    public function clientes()
    {
        return $this->belongsTo(Cliente::class);
    }
}
