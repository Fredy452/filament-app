<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'productos';
    protected $fillable = ['nombre', 'descripción', 'precio', 'medida_id', 'stock', 'categoria_producto_id', 'promocion'];
    public function categoria_producto()
    {
        // Una categoria pertenece a un producto
        return $this->belongsTo(CategoriaProducto::class);
    }

    public function medida()
{
    return $this->belongsTo('App\Models\Medida');
}
}
