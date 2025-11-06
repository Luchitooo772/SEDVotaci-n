<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; 

class ChatbotController extends Controller
{
    protected $userController;

    public function __construct()
    {
        $this->userController = new UserController();
    }

    public function handle(Request $request)
    {
        try {
            $messageRaw = $request->input('message');
            $message = $this->normalize($messageRaw);
    
            $state = $request->session()->get('chatbot_state', '');
            $user = Auth::user();
    
            // Si estamos esperando DNI
            if ($state === 'awaiting_dni') {
                $response = $this->findVotingPlace($messageRaw, $request);
                return response()->json(['reply' => $response, 'show_menu' => false]);
            }
    
            $inicio = new \DateTime("2025-10-25T09:00:00");
            $fin = new \DateTime("2025-10-30T20:00:00");
    
            // Preguntas y keywords
            $preguntas = [
                'saludo' => [
                    'keywords' => ['hola','saludar','menu'],
                    'response' => '¡Hola! 👋 Soy tu asistente de votación. ¿Cómo puedo ayudarte? Seleccione una opcion del menu por favor.'
                ],
                'mesa' => [
                    'keywords' => ['mesa','donde','voto','escuela','ubicación'],
                    'response' => $user && $user->mesa
                        ? "¡Hola ".ucwords(strtolower($user->nombre))."! Tu mesa asignada es la **Mesa " . $user->mesa . "**."
                        : 'Por favor ingresa tu número de DNI.'
                ],
                'como_votar' => [
                    'keywords' => ['votar','cómo','hacer','proceso'],
                    'response' => 'Es simple: 1. Revisá tus datos. 2. Seleccioná tu candidato. 3. Confirmá tu voto. 4. Generá tu comprobante. ¡Y listo!'
                ],
                'ha_votado' => [
                    'keywords' => ['ya vote','ya voté','voté','voto','votaste'],
                    'response' => $user && $user->ha_votado
                        ? '¡Sí! Ya emitiste tu voto.'
                        : 'Aún no registramos tu voto.'
                ],
                'info_candidatos' => [
                    'keywords' => ['candidatos','listas','propuestas'],
                    'response' => function($user) {
                        $curso = $user->curso ?? '1ro';
                
                        $candidatosPorCurso = [
                            '1ro' => [
                                ['nombre' => 'Partido Aventura', 'numero' => '101'],
                                ['nombre' => 'Movimiento Joven', 'numero' => '102'],
                                ['nombre' => 'Frente Futuro', 'numero' => '103']
                            ],
                            '2do' => [
                                ['nombre' => 'Alianza Saber', 'numero' => '201'],
                                ['nombre' => 'Partido Avance', 'numero' => '202'],
                                ['nombre' => 'Nuevo Horizonte', 'numero' => '203']
                            ],
                            '3ro' => [
                                ['nombre' => 'Frente Unidad', 'numero' => '301'],
                                ['nombre' => 'Partido Innovación', 'numero' => '302'],
                                ['nombre' => 'Cultura y Cambio', 'numero' => '303']
                            ],
                            '4to' => [
                                ['nombre' => 'Revolución Verde', 'numero' => '401'],
                                ['nombre' => 'Fuerza Estudiantil', 'numero' => '402'],
                                ['nombre' => 'Progreso', 'numero' => '403']
                            ],
                            '5to' => [
                                ['nombre' => 'Líderes del Mañana', 'numero' => '501'],
                                ['nombre' => 'Alianza Evolución', 'numero' => '502'],
                                ['nombre' => 'Renovación Total', 'numero' => '503']
                            ],
                        ];
                
                        $candidatos = $candidatosPorCurso[$curso] ?? $candidatosPorCurso['1ro'];
                
                        $html = "Candidatos para tu curso ($curso):<br>";
                        foreach ($candidatos as $c) {
                            $html .= "• <strong>{$c['nombre']}</strong> (Lista {$c['numero']})<br>";
                        }
                
                        return $html;
                    }
                ],
                
                'horarios' => [
                    'keywords' => ['horario','fecha','votación','abrir','cerrar'],
                    'response' => "La votación está habilitada desde el ".$inicio->format('d/m/Y H:i')." hasta el ".$fin->format('d/m/Y H:i')."."
                ],
                'gracias' => [
                    'keywords' => ['gracias','ok','perfecto'],
                    'response' => '¡De nada! Un placer ayudarte.'
                ]
            ];
    
            // Coincidencia difusa y por keywords
            $mejor = null;
            $distMin = 3;
            foreach ($preguntas as $key => $data) {
                foreach ($data['keywords'] as $keyword) {
                    $dist = levenshtein($message, $this->normalize($keyword));
                    if ($dist < $distMin) {
                        $distMin = $dist;
                        $mejor = $key;
                    }
                }
            }
    
            if (!$mejor) {
                foreach ($preguntas as $key => $data) {
                    foreach ($data['keywords'] as $keyword) {
                        if (strlen($keyword) > 3 && str_contains($message, $this->normalize($keyword))) {
                            $mejor = $key;
                            break 2;
                        }
                    }
                }
            }
    
            // Generar respuesta y show_menu
            if ($mejor) {
                $response = is_callable($preguntas[$mejor]['response'])
    ? $preguntas[$mejor]['response']($user)
    : $preguntas[$mejor]['response'];

                $show_menu = ($mejor === 'saludo'); // menú solo aparece en saludo/menu
            } else {
                $relacionadas = [];
                foreach ($preguntas as $key => $data) {
                    foreach ($data['keywords'] as $keyword) {
                        if (strlen($keyword) > 3 && str_contains($message, $this->normalize($keyword))) {
                            $relacionadas[] = $keyword;
                            break;
                        }
                    }
                }
                $response = $relacionadas
                    ? 'No entendí tu consulta exactamente. Quizás te interesen:<br>• '.implode('<br>• ', $relacionadas)
                    : 'No entendí esa consulta. Puedes escribir otra pregunta.';
                $show_menu = false;
            }
    
            return response()->json(['reply' => $response, 'show_menu' => $show_menu]);
    
        } catch (\Exception $e) {
            Log::error('Error en ChatbotController: '.$e->getMessage().' línea '.$e->getLine());
            return response()->json(['reply'=>'Error interno', 'show_menu'=>false],500);
        }
    }
    
    private function normalize($txt) {
        $txt = strtolower(trim($txt));
        $txt = str_replace(['á','é','í','ó','ú','ü'], ['a','e','i','o','u','u'], $txt);
        $txt = preg_replace('/[¿?¡!.,]/', '', $txt);
        return $txt;
    }
    

    private function findVotingPlace($dni, Request $request)
    {
        if (!is_numeric($dni)) {
            $request->session()->put('chatbot_state', 'awaiting_dni');
            return 'Por favor, ingresa un número de DNI válido (solo números).';
        }

        $users = $this->userController->getUsersArray();
        $foundUser = null;

        foreach ($users as $user) {
            if (isset($user['dni']) && $user['dni'] == $dni) {
                $foundUser = $user;
                break;
            }
        }

        if ($foundUser) {
            $request->session()->forget('chatbot_state');
            return $foundUser['mesa'] !== null
                ? "Según el padrón, el DNI $dni vota en la **Mesa ".$foundUser['mesa']."**. (Nombre: ".$foundUser['nombre'].")"
                : "El DNI $dni (".$foundUser['nombre'].") está en el padrón, pero no tiene mesa asignada.";
        } else {
            $request->session()->put('chatbot_state', 'awaiting_dni');
            return 'No encontramos ese DNI en el padrón general. Verifica el número.';
        }
    }
}
