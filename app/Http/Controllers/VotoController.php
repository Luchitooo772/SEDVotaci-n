<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voto; // Asegúrate de que este modelo exista y esté correctamente configurado
use Illuminate\Support\Facades\Auth;
// Quitamos Gate ya que no lo usamos aquí directamente
// use Illuminate\Support\Facades\Gate; 
use Illuminate\Support\Facades\Mail;
use App\Mail\ComprobanteVotoMail;


class VotoController extends Controller
{
    /**
     * Muestra la página de votación (boleta).
     */
    public function index()
    {
        $user = Auth::user();
        // Asegúrate de que tu modelo User tenga el atributo 'ha_votado' o similar
        $yaVoto = (bool) ($user->ha_votado ?? false); 

        // Pasamos la variable $yaVoto a la vista
        return view('votar', compact('yaVoto'));
    }

    /**
     * Guarda el voto en la base de datos.
     */
    public function guardar(Request $request)
    {
        $user = Auth::user();
    
        if ($user->ha_votado) {
            return redirect()->route('inicio')->with('error', 'Ya has emitido tu voto.');
        }
    
        $request->validate([
            'candidato' => 'required|string'
        ]);
    
        $numeroComprobante = 'COMP-' . strtoupper(uniqid());

        $voto = Voto::create([
            'user_id' => $user->id,
            'nombre_candidato' => $request->candidato,
            'partido_candidato' => $request->candidato,
        ]);
    


    
 $numeroComprobante = 'COMP-' . strtoupper(uniqid());
$user->ha_votado = true;
$user->numero_comprobante = $numeroComprobante;
$user->save();

    
        // Enviar comprobante por email
        if ($user->email) {
            Mail::to($user->email)->send(new ComprobanteVotoMail($voto));
        }
    
        return redirect()->route('voto.confirmado')->with('voto_id', $voto->id);
    }
    
    

    /**
     * Muestra la página del comprobante.
     */
    public function mostrarComprobante($votoId)
    {
        $voto = Voto::with('user')->findOrFail($votoId);


        // CHEQUEO DE SEGURIDAD: Solo el dueño del voto puede verlo
        if (Auth::id() != $voto->user_id) {
             abort(403, 'Acción no autorizada.');
        }

        return view('comprobante', compact('voto'));
    }

    /**
     * Muestra la página final (Urna y contador).
     */
    public function mostrarConfirmacion()
    {
        return view('voto-confirmado');
    }

    /**
     * Busca el comprobante del usuario logueado y lo muestra,
     * o redirige al inicio si no ha votado.
     */
    public function verMiComprobante()
    {
        $user = Auth::user();

        if (!$user->ha_votado) {
            return redirect()->route('inicio')->with('info', 'Aún no has votado. Emite tu voto para poder ver el comprobante.');
        }

        // --- ¡ARREGLO RÁPIDO! ---
        // Cambiamos latest() por latest('id') para ordenar por ID
        // ya que la tabla 'votos' no tiene 'created_at'.
        $voto = Voto::where('user_id', $user->id) 
                    ->latest('id') // Ordena por ID descendente
                    ->first();  

        if ($voto) {
            return redirect()->route('voto.comprobante', ['votoId' => $voto->id]);
        } else {
            return redirect()->route('inicio')->with('error', 'Error: No se encontró tu comprobante de voto a pesar de estar marcado como votado.');
        }
    }
    
    public function enviarComprobante($id)
{
    $voto = Voto::findOrFail($id);
    $user = Auth::user();

    // Seguridad: solo el dueño del voto puede enviarlo
    if ($user->id !== $voto->user_id) {
        abort(403, 'Acción no autorizada.');
    }

    if (!$user->email) {
        return back()->with('error', 'No hay un correo asociado a tu cuenta.');
    }

    // Enviar correo
    Mail::to($user->email)->send(new ComprobanteVotoMail($voto));

    return back()->with('success', 'Comprobante enviado a tu email: ' . $user->email);
}

}
