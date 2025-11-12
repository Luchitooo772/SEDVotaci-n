<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voto;

class EstadisticasController extends Controller
{
    public function index()
    {
        // Obtener todos los cursos
        $cursos = User::select('curso')->distinct()->pluck('curso');

        $data = [];

        foreach ($cursos as $curso) {
            // Cantidad de usuarios registrados por curso
            $registrados = User::where('curso', $curso)->count();

            // Cantidad de usuarios que votaron por curso
            $votaron = Voto::whereIn('user_id', User::where('curso', $curso)->pluck('id'))->count();

            // Cantidad de votos por candidato en ese curso
            $candidatos = Voto::whereIn('user_id', User::where('curso', $curso)->pluck('id'))
                               ->select('nombre_candidato')
                               ->selectRaw('COUNT(*) as total')
                               ->groupBy('nombre_candidato')
                               ->pluck('total','nombre_candidato');

            $data[$curso] = [
                'registrados' => $registrados,
                'votaron' => $votaron,
                'candidatos' => $candidatos
            ];
        }

        return view('estadisticas', compact('data'));

        
    }


    
}

