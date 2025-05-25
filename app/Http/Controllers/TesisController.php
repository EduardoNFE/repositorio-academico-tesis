<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tesis; // <-- Asegúrate de que esta línea esté aquí
use App\Models\Carrera; // <-- Asegúrate de que esta línea esté aquí
use Illuminate\Support\Facades\Storage; // <-- Para manejar archivos (PDF)

class TesisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener todas las carreras para el filtro (si es necesario)
        $carreras = Carrera::all();

        // Iniciar la consulta de tesis
        $query = Tesis::with('carrera');

        // Aplicar filtro de búsqueda
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('titulo', 'like', '%' . $search . '%')
                  ->orWhere('autor', 'like', '%' . $search . '%')
                  ->orWhere('palabras_clave', 'like', '%' . $search . '%')
                  ->orWhere('resumen', 'like', '%' . $search . '%');
        }

        // Aplicar filtro por carrera
        if ($request->has('carrera_id') && $request->carrera_id != '') {
            $query->where('carrera_id', $request->carrera_id);
        }

        // Aplicar filtro por año de publicación
        if ($request->has('año_publicacion') && $request->año_publicacion != '') {
            $query->where('año_publicacion', $request->año_publicacion);
        }


        // Obtener las tesis paginadas (opcional, pero buena práctica si hay muchas)
        // Por ahora, solo las obtenemos todas o según el filtro
        $tesis = $query->get();
         // Retornar la vista 'tesis.index' y pasarle las tesis y las carreras
        return view('tesis.index', compact('tesis', 'carreras'));
        //-----------------------------------------------------------------

         // Obtener todas las tesis de la base de datos, con sus carreras relacionadas
        $tesis = Tesis::with('carrera')->get(); // 'carrera' es el nombre de la relación en el modelo Tesis

        // Retornar la vista 'tesis.index' y pasarle las tesis
        return view('tesis.index', compact('tesis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todas las carreras de la base de datos
        // La usamos para poblar el dropdown en el formulario
        $carreras = Carrera::all();

        // *** ¡DESCOMENTA ESTA LÍNEA PARA DEPURAR! ***
        //dd($carreras); // Esto detendrá la ejecución y mostrará el contenido de $carreras

        // Devolver la vista del formulario y pasarle las carreras
        return view('tesis.create', compact('carreras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación de los datos del formulario
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'carrera_id' => 'required|exists:carreras,id_carrera',
            'asesor' => 'required|string|max:255',
            'año_publicacion' => 'required|integer|min:1900|max:' . date('Y'),
            'palabras_clave' => 'nullable|string|max:1000',
            'resumen' => 'nullable|string',
            'archivo_pdf' => 'required|file|mimes:pdf|max:10240',
            'fecha_registro' => 'required|date',
        ]);

        $filePath = null;
        // 2. Manejo de la subida del archivo PDF
        if ($request->hasFile('archivo_pdf')) {
            $file = $request->file('archivo_pdf');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('tesis_pdfs', $fileName, 'public');
        }

        // 3. Crear un nuevo registro de Tesis
        Tesis::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'carrera_id' => $request->carrera_id,
            'asesor' => $request->asesor,
            'año_publicacion' => $request->año_publicacion,
            'palabras_clave' => $request->palabras_clave,
            'resumen' => $request->resumen,
            'archivo_pdf' => $filePath,
            'fecha_registro' => $request->fecha_registro,
        ]);

        // 4. Redireccionar al usuario con un mensaje de éxito
        return redirect()->route('tesis.index')->with('success', 'Tesis registrada exitosamente.');
    } // <-- ¡Asegúrate de que esta llave de cierre esté aquí para el método store()!

    /**
     * Display the specified resource.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Buscar la tesis por su ID. Si no se encuentra, Laravel automáticamente lanzará un 404.
        $tesis = Tesis::findOrFail($id);

        // Obtener todas las carreras para el dropdown
        $carreras = Carrera::all();

        // Devolver la vista de edición, pasando la tesis y las carreras
        return view('tesis.edit', compact('tesis', 'carreras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Buscar la tesis por su ID. Si no se encuentra, Laravel automáticamente lanzará un 404.
        $tesis = Tesis::findOrFail($id);

        // 2. Validación de los datos del formulario (similar a store, pero 'archivo_pdf' es opcional)
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'carrera_id' => 'required|exists:carreras,id_carrera',
            'asesor' => 'required|string|max:255',
            'año_publicacion' => 'required|integer|min:1900|max:' . date('Y'),
            'palabras_clave' => 'nullable|string|max:1000',
            'resumen' => 'nullable|string',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:10240', // Ahora es 'nullable'
            'fecha_registro' => 'required|date',
        ]);

        $filePath = $tesis->archivo_pdf; // Mantener el path actual por defecto

        // 3. Manejo de la subida del archivo PDF (si se sube uno nuevo)
        if ($request->hasFile('archivo_pdf')) {
            // Eliminar el archivo PDF antiguo si existe
            if ($tesis->archivo_pdf && Storage::disk('public')->exists($tesis->archivo_pdf)) {
                Storage::disk('public')->delete($tesis->archivo_pdf);
            }

            $file = $request->file('archivo_pdf');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('tesis_pdfs', $fileName, 'public');
        }

        // 4. Actualizar los campos de la tesis
        $tesis->update([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'carrera_id' => $request->carrera_id,
            'asesor' => $request->asesor,
            'año_publicacion' => $request->año_publicacion,
            'palabras_clave' => $request->palabras_clave,
            'resumen' => $request->resumen,
            'archivo_pdf' => $filePath, // Usar el nuevo path o el existente
            'fecha_registro' => $request->fecha_registro,
        ]);

        // 5. Redireccionar al usuario con un mensaje de éxito
        return redirect()->route('tesis.index')->with('success', 'Tesis actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 1. Buscar la tesis por su ID. Si no se encuentra, Laravel automáticamente lanzará un 404.
        $tesis = Tesis::findOrFail($id);

        // 2. Eliminar el archivo PDF asociado del almacenamiento
        if ($tesis->archivo_pdf && Storage::disk('public')->exists($tesis->archivo_pdf)) {
            Storage::disk('public')->delete($tesis->archivo_pdf);
        }

        // 3. Eliminar el registro de la tesis de la base de datos
        $tesis->delete();

        // 4. Redireccionar al usuario con un mensaje de éxito
        return redirect()->route('tesis.index')->with('success', 'Tesis eliminada exitosamente.');
    }

    public function downloadPdf($id)
    {
        $tesis = Tesis::findOrFail($id);

        if (!Storage::disk('public')->exists($tesis->archivo_pdf)) {
            abort(404, 'Archivo PDF no encontrado.');
        }

        $filePath = storage_path('app/public/' . $tesis->archivo_pdf);
        $fileName = basename($tesis->archivo_pdf); // Obtiene solo el nombre del archivo

        return response()->download($filePath, $fileName);
    }
}