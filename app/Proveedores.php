<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
	protected $table = 'proveedores';
	protected $primaryKey = 'id_proveedor';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['nombre', 'direccion', 'cuit', 'coordenadas', 'email', 'telefono','observaciones', 'rubros', 'estado'];
}
