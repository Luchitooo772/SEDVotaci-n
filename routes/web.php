<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FaceAuthController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\VotoController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// --- CONFIGURACIÓN DE INICIO ---
Route::get('/', function () {
    return view('splash');
})->name('splash');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


// --- OTRAS RUTAS PÚBLICAS ---
Route::get('/face-login', [FaceAuthController::class, 'index'])->name('login-facial');
Route::post('/face-login/confirm', [FaceAuthController::class, 'confirm']);
Route::get('/api/labeled-images', [FaceAuthController::class, 'labeledImages']);
Route::get('/api/user/{user}', [UserApiController::class, 'show']);
Route::post('/chatbot', [ChatbotController::class, 'handle']);


/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren inicio de sesión)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('welcome')->with('success', 'Has cerrado sesión correctamente.');
    })->name('logout');

    // --- FLUJO DE VOTACIÓN ---
    Route::get('/votar', [VotoController::class, 'index'])->name('votar');
    Route::post('/votar', [VotoController::class, 'guardar'])->name('votar.guardar');
    Route::get('/comprobante/{votoId}', [VotoController::class, 'mostrarComprobante'])->name('voto.comprobante');
    Route::get('/voto-confirmado', [VotoController::class, 'mostrarConfirmacion'])->name('voto.confirmado');
    
    // --- ¡NUEVA RUTA! Ver mi comprobante ---
    Route::get('/mi-comprobante', [VotoController::class, 'verMiComprobante'])->name('voto.mi_comprobante');
    Route::get('/voto/enviar/{id}', [VotoController::class, 'enviarComprobante'])->name('voto.enviar');

    // ----------------------------------------

    // Estadísticas
    Route::get('/estadisticas', [EstadisticasController::class, 'index'])->name('estadisticas');

    

});

