<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

class PerfilController extends Controller
{
    private $userController;

    public function __construct()
    {
        $this->userController = new UserController();
    }

    public function index()
    {
        $email = Auth::user()->email;
        $usuario = $this->userController->getUserByEmail($email);
    
        if (!$usuario) {
            abort(404, 'Usuario no encontrado');
        }
    
        // Mesa dinámica
        $usuario['mesa'] = Auth::user()->mesa ?? 'No asignada';
    
        // Obtener userKey para la foto
        $usersArray = $this->userController->getUsersArray();
        $userKey = null;
        foreach($usersArray as $key => $u) {
            if($u['email'] === $usuario['email']){
                $userKey = $key;
                break;
            }
        }
    
        return view('perfil', compact('usuario', 'userKey'));
    }
    
}

