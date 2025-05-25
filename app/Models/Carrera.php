<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carrera extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención de Laravel (plural)
    protected $table = 'carreras';

    // Especifica la clave primaria si no se llama 'id'
    protected $primaryKey = 'id_carrera';

    // Define las columnas que se pueden asignar masivamente (ej. al crear un registro)
    protected $fillable = [
        'nombre',
    ];

    // Define la relación inversa: una Carrera tiene muchas Tesis
    // 'Tesis::class' es el modelo relacionado
    // 'carrera_id' es la clave foránea en la tabla 'tesis'
    // 'id_carrera' es la clave local en la tabla 'carreras'
    public function tesis()
    {
        return $this->hasMany(Tesis::class, 'carrera_id', 'id_carrera');
    }
}
