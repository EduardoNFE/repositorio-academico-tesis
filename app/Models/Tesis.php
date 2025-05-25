<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tesis extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla
    protected $table = 'tesis';

    // Especifica la clave primaria si no se llama 'id'
    protected $primaryKey = 'id_tesis';

    // Define las columnas que se pueden asignar masivamente
    protected $fillable = [
        'titulo',
        'autor',
        'carrera_id', // ¡Importante para la relación!
        'asesor',
        'año_publicacion',
        'palabras_clave',
        'resumen',
        'archivo_pdf',
        'fecha_registro',
    ];

    // Define la relación: una Tesis pertenece a una Carrera
    // 'Carrera::class' es el modelo relacionado
    // 'carrera_id' es la clave foránea en la tabla 'tesis'
    // 'id_carrera' es la clave local en la tabla 'carreras' (la PK de la tabla 'carreras')
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id', 'id_carrera');
    }
}
