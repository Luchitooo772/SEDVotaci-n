<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InicioController extends Controller
{
    public function index()
    {
        $authEmail = Auth::user()->email;

        // Traemos todos los datos del UserController (excepto mesa)
        $userController = new UserController();
        $usuarioDatos = $userController->getUserByEmail($authEmail);

        if (!$usuarioDatos) {
            abort(404, "Usuario no encontrado en la lista.");
        }

        // Traemos la mesa de la base de datos
        $usuarioBD = Auth::user(); // Usuario real
        $mesa = $usuarioBD->mesa;

        // Si no tiene mesa, asignamos aleatoria y guardamos
        if (empty($mesa)) {
            $mesa = rand(1, 3);
            $usuarioBD->mesa = $mesa;
            $usuarioBD->save();
        }

        // Combinar los datos del UserController con la mesa real
        $usuario = $usuarioDatos;
        $usuario['mesa'] = $mesa;

        // ===========================
        // CONTROL DE HABILITACIÓN DE VOTACIÓN
        // ===========================
        // Fecha y hora en la que se habilita la votación (hoy 14:10)
        $habilitarVotacion = Carbon::create(2025, 10, 9, 14, 10, 0); // Año, Mes, Día, Hora, Minuto, Segundo
        $ahora = Carbon::now();

        // Booleano que dice si la votación ya está habilitada
        $votacionHabilitada = $ahora->gte($habilitarVotacion);

        return view('inicio', compact('usuario', 'votacionHabilitada'));
    }
}
