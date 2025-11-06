<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // 🔹 IMPORTANTE
use App\Models\User;

class FaceAuthController extends Controller
{
    public function index()
    {
        return view('face-login');
    }

    public function labeledImages()
    {
        return response()->json([
            ['id' => 0, 'dni' => '', 'foto' => url('images/usero.jpg')],
            ['id' => 1, 'dni' => '', 'foto' => url('images/user1.jpg')],
            ['id' => 2, 'dni' => '', 'foto' => url('images/user2.jpg'), 'curso' => ''],
            ['id' => 3, 'dni' => '', 'foto' => url('images/user3.jpg')],
            ['id' => 4, 'dni' => '', 'foto' => url('images/user4.jpg')],
            ['id' => 5, 'dni' => '', 'foto' => url('images/user5.jpg')],
            ['id' => 6, 'dni' => '', 'foto' => url('images/user6.jpg')],
            ['id' => 7, 'dni' => '', 'foto' => url('images/user7.jpg')],
            ['id' => 8, 'dni' => '', 'foto' => url('images/user8.jpg')],
            ['id' => 9, 'dni' => '', 'foto' => url('images/user9.jpg')],
            ['id' => 10, 'dni' => '', 'foto' => url('images/user10.jpg')],
            ['id' => 11, 'dni' => '', 'foto' => url('images/user11.jpg')],
            ['id' => 13, 'dni' => '', 'foto' => url('images/user13.jpg')],
            ['id' => 14, 'dni' => '', 'foto' => url('images/user14.jpg')],
            ['id' => 15, 'dni' => '', 'foto' => url('images/user15.jpg')],
            ['id' => 16, 'dni' => '', 'foto' => url('images/user16.jpg')],
            ['id' => 17, 'dni' => '', 'foto' => url('images/user17.jpg')],
            ['id' => 18, 'dni' => '', 'foto' => url('images/user18.jpg')],
            ['id' => 19, 'dni' => '', 'foto' => url('images/user19.jpg')],
            ['id' => 20, 'dni' => '', 'foto' => url('images/user20.jpg')],
            ['id' => 21, 'dni' => '', 'foto' => url('')],
            ['id' => 22, 'dni' => '', 'foto' => url('images/user22.jpg')],
        ]);
    }

    public function confirm(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'nombre' => 'required|string'
            ]);
    
            $email = $request->input('email');
            $nombre = $request->input('nombre');
    
            // Traer datos desde UserController
            $userController = new UserController();
            $userData = $userController->getUserByEmail($email);
    
            if (!$userData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado en la lista de UserController'
                ]);
            }
    
            // Crear o buscar usuario en la base de datos con los datos correctos
            $usuario = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $userData['nombre'],
                    'password' => Hash::make('123456'),
                    'curso' => $userData['curso'], // 👈 ahora se guarda correctamente
                ]
            );
    
            // Si no tiene mesa, asignarle una entre 1 y 3
            if (!$usuario->mesa) {
                $usuario->mesa = rand(1, 3);
            }
    
            $usuario->save();
    
            Auth::login($usuario);
    
            return response()->json([
                'success' => true,
                'redirect' => route('inicio'),
                'curso' => $usuario->curso,
                'mesa' => $usuario->mesa
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el login facial: ' . $e->getMessage()
            ]);
        }
    }
    

    
}




