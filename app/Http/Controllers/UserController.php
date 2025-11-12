<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    private $users = [
        'user0' => [
            'nombre' => 'ALMADA, CANDELA AYELÉN', 
            'edad' => 17, 
            'email' => 'candela.almada@esim.edu.ar', 
            'dni' => '48473506',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user1' => [
            'nombre' => 'BERGALO, SUSANA EDIT', 
            'edad' => 17, 
            'email' => 'susana.bergalo@esim.edu.ar', 
            'dni' => '48652648',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user2' => [
            'nombre' => 'CIANCIA ARIAS, LUDMILA', 
            'edad' => 17, 
            'email' => 'ludmila.ciancia@esim.edu.ar', 
            'dni' => '48827714',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user3' => [
            'nombre' => 'ESPINOLA, TIAGO LEONEL', 
            'edad' => 17, 
            'email' => 'tiago.espinola@esim.edu.ar', 
            'dni' => '48825769',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user4' => [
            'nombre' => 'FLORES, DANTE DANIEL', 
            'edad' => 17, 
            'email' => 'dante.flores@esim.edu.ar', 
            'dni' => '48611182',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user5' => [
            'nombre' => 'JARA, JEREMIAS NAZARENO ADRIAN', 
            'edad' => 17, 
            'email' => 'jeremias.jara@esim.edu.ar', 
            'dni' => '48741153',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user6' => [
            'nombre' => 'LIDBOM, SOLANGE CLARIBEL', 
            'edad' => 17, 
            'email' => 'solange.lidbom@esim.edu.ar', 
            'dni' => '48474143',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user7' => [
            'nombre' => 'MANGINI, MAITENA',
            'edad' => 18,
            'email' => 'maitena.mangini@esim.edu.ar',
            'dni' => '48068101',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user8' => [
            'nombre' => 'OLMEDO, GUILLERMO NICOLAS',
            'edad' => 17,
            'email' => 'guillermo.olmedo@esim.edu.ar',
            'dni' => '48826276',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],

        'user9' => [
            'nombre' => 'PEREZ ZURAKOWSKI, FERNANDO NICOLAS',
            'edad' => 17,
            'email' => 'fernando.perez@esim.edu.ar',
            'dni' => '48198083',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],

        'user10' => [
            'nombre' => 'RINDFLEISCH, ANA',
            'edad' => 17,
            'email' => 'Rindfleisch.ana@esim.edu.ar',
            'dni' => '48612201',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],

        'user11' => [
            'nombre' => 'PHANTHACHITH, LEONELA ABRIL',
            'edad' => 18,
            'email' => 'leonela.phanthachith@esim.edu.ar',
            'dni' => '48365173',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user13' => [
            'nombre' => 'RAMON, ALAN BENJAMIN',
            'edad' => 18,
            'email' => 'alan.ramon@esim.edu.ar',
            'dni' => '47536438',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        'user14' => [
            'nombre' => 'RODRÍGUEZ PUCZKO, MATÍAS JOAQUÍN', 
            'edad' => 18, 
            'email' => 'matias.rodriguez@esim.edu.ar', 
            'dni' => '48266018',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ], 

        'user15' => [
            'nombre' => 'ROMERO NUÑEZ, BRISA MAYLEN', 
            'edad' => 17, 
            'email' => 'brisa.romero@esim.edu.ar', 
            'dni' => '48826140',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],

        'user16' => [
            'nombre' => 'HORORODESKI, FRANCISCO', 
            'edad' => 16, 
            'email' => 'francisco.hororodeski@esim.edu.ar', 
            'dni' => '50114782',
            'curso' => '3ro A',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],

        'user17' => [
            'nombre' => 'TORGEN, DENNISE SOFIA CHARLOTTE', 
            'edad' => 18, 
            'email' => 'dennise.torgen@esim.edu.ar', 
            'dni' => '47596341',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        
        'user18' => [
            'nombre' => 'ZARZA, GABRIEL LISANDRO', 
            'edad' => 18, 
            'email' => 'gabriel.zarza@esim.edu.ar', 
            'dni' => '48546178',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],

        'user19' => [
            'nombre' => 'PIRIZ, VITALE LUCIANO',
            'edad' => 17,
            'email' => 'luciano.piriz@esi.edu.ar',
            'dni' => '48950772',
            'curso' => '5to',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],
        

        'user20' => [
            'nombre' => 'DUARTE, FEDERICO JOEL',
            'edad' => 15,
            'email' => 'federico.duarte@esim.edu.ar',
            'dni' => '49992124',
            'curso' => '3ro C',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],

        'user21' => [
            'nombre' => 'PIRIZ VITALE, LORENZO', 
            'edad' => 14, 
            'email' => 'lorenzopirizvitale@gmail.com', 
            'dni' => '50661165',
            'curso' => '2do',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],

        'user22' => [
            'nombre' => 'FLAVIA, BOJANOVICH',
            'edad' => 25,
            'email' => 'flavia.bojanovich@esim.edu.ar',
            'dni' => '33333333',
            'curso' => '5to C',
            'mesa' => null, // la mesa se asignará automáticamente cuando inicie sesión
        ],

    ];


    // Método para obtener todos los usuarios
    public function getUsersArray()
    {
        return $this->users;
    }

    // Método para obtener un usuario por email
    public function getUserByEmail($email)
    {
        foreach ($this->users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        return null;
    }

    // Método para API
    public function getUser($label)
    {
        if(array_key_exists($label, $this->users)){
            return response()->json($this->users[$label]);
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }
    
}
