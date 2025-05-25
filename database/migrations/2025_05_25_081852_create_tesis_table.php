<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tesis', function (Blueprint $table) {
            $table->increments('id_tesis'); // Identificador único de la tesis (PK)
            $table->string('titulo'); // Título de la tesis
            $table->string('autor'); // Nombre del autor

            // Clave Foránea para carreras
            $table->unsignedInteger('carrera_id'); // Tipo de datos para la FK, debe coincidir con el tipo de id_carrera en carreras
            // Define la restricción de clave foránea
            $table->foreign('carrera_id')->references('id_carrera')->on('carreras')->onDelete('cascade');

            $table->string('asesor'); // Nombre del asesor
            $table->integer('año_publicacion'); // Año de publicación
            $table->text('palabras_clave')->nullable(); // Palabras clave, pueden ser opcionales
            $table->text('resumen')->nullable(); // Resumen de la tesis, puede ser opcional
            $table->string('archivo_pdf')->nullable(); // Ruta o nombre del archivo PDF, puede ser opcional
            $table->date('fecha_registro'); // Fecha en que fue registrada

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tesis');
    }
};
