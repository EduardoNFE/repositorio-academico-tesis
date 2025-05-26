<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tesis; // Importa el modelo Tesis
use App\Models\Carrera; // Importa el modelo Carrera
use App\Models\User; // Importa el modelo User
use Illuminate\Support\Facades\DB; // Para consultas de agrupamiento (opcional)

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Número total de tesis
        $totalTesis = Tesis::count();

        // 2. Número total de carreras
        $totalCarreras = Carrera::count();

        // 3. Número total de usuarios
        $totalUsuarios = User::count();

        // 4. Tesis más recientes (ej. las 5 últimas)
        $recentTesis = Tesis::with('carrera') // Carga la relación para mostrar el nombre de la carrera
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

        // 5. Opcional: Distribución de tesis por carrera
        // Esto contará cuántas tesis hay por cada carrera
        $tesisByCarrera = Tesis::select('carreras.nombre', DB::raw('count(tesis.id_tesis) as count'))
                                ->join('carreras', 'tesis.carrera_id', '=', 'carreras.id_carrera')
                                ->groupBy('carreras.nombre')
                                ->orderBy('count', 'desc')
                                ->get();

        return view('dashboard', compact('totalTesis', 'totalCarreras', 'totalUsuarios', 'recentTesis', 'tesisByCarrera'));
    }
}
