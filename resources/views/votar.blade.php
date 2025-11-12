<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta Única</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ---------------------------------
           --- ESTILOS UNIFICADOS ---
           --------------------------------- */
        :root {
            --primary-celeste: #0099e6; /* Celeste (un poco más oscuro) */
            --dark-celeste: #0077c2; /* Celeste oscuro */
            --light-celeste: #d9f0ff; /* Celeste claro */
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f7f9fc;
            color: #1c1e21;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
        }

        /* HEADER */
        .header {
            background: linear-gradient(to right, #5faad4, #8bc6e6, #5faad4);
            color: white;
            padding: 1rem 2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header h1 {
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
        }
        
        /* Contenido principal */
        .section {
            max-width: 1000px; /* Ancho para la boleta */
            margin: 2.5rem auto;
            padding: 1rem;
        }
        
        h2 {
            color: var(--primary-celeste);
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        /* Animación */
        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(15px); }
          to { opacity: 1; transform: translateY(0); }
        }

        /* ---------------------------------
           --- ESTILOS DE LA BOLETA ---
           --------------------------------- */
        
        .boleta { 
            display: flex; 
            justify-content: center; 
            gap: 1.5rem; /* Más espacio */
            flex-wrap: wrap; 
        }
        
        .candidato {
            background: white;
            border: 2px solid #ddd; /* Borde neutral */
            border-radius: 12px;
            width: 220px; /* Más ancho */
            padding: 0; /* Padding se maneja adentro */
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.5s ease-out;
            overflow: hidden; /* Para el borde superior */
        }
        
        .candidato:hover { 
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        
        /* Borde superior de color */
        .candidato-header {
            height: 10px;
            width: 100%;
        }
        
        .candidato-body {
            padding: 1.5rem;
        }

        .candidato input { display: none; }
        
        /* ¡ESTILO SELECCIONADO MEJORADO! */
        .candidato.seleccionado { 
            border-color: var(--primary-celeste); 
            background: var(--light-celeste);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 153, 230, 0.15);
        }
        
        .candidato.disabled { 
            opacity: 0.6; 
            cursor: not-allowed; 
            background: #eee;
        }
        .candidato.disabled:hover {
            transform: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .candidato-logo {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            margin: 0.5rem auto 1rem auto;
            object-fit: cover;
        }
        
        .candidato-nombre {
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
        }
        
        .candidato-numero {
            font-size: 0.9rem;
            color: #666;
        }
        
        /* Botón de confirmar */
        .btn-primary-custom {
            background-color: var(--primary-celeste);
            color: white;
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.9rem 1.2rem;
            font-size: 1.1rem;
            transition: all 0.3s;
            text-decoration: none;
            border: none;
        }
        .btn-primary-custom:hover {
            background-color: var(--dark-celeste);
            transform: translateY(-2px);
        }
        .btn-primary-custom:disabled {
            background-color: #aaa;
        }
        
        /* Alerta de redirección */
        .alert-redirect {
            background: var(--light-celeste);
            border: 1px solid var(--primary-celeste);
            color: var(--dark-celeste);
            font-weight: 500;
            text-align: center;
        }

        /* FOOTER */
        footer {
          margin-top: 50px;
          text-align: center;
          color: #6c757d;
          padding: 25px;
          font-size: 0.9rem;
          background: #ffffff;
          border-top: 1px solid #e9ecef;
        }
        footer a { color: var(--primary-celeste); text-decoration: none; }
        footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <h1><i class="bi bi-box-seam"></i> Boleta Única</h1>
</div>

<div class="main-content section">
    
    @if(session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if(isset($yaVoto) && $yaVoto)
      <div class="alert alert-redirect">
        ⚠️ Ya has votado. Solo se permite un voto por usuario.<br>
        Serás redirigido automáticamente en <span id="contador">5</span> segundos.
      </div>

      <script>
        let segundos = 5;
        const contadorSpan = document.getElementById('contador');
        const intervalo = setInterval(() => {
          segundos--;
          contadorSpan.textContent = segundos;
          if(segundos <= 0){
            clearInterval(intervalo);
            window.location.href = "{{ route('inicio') }}";
          }
        }, 1000);
      </script>
    @endif

    <form id="formVoto" action="{{ route('votar.guardar') }}" method="POST">
        @csrf

        <div class="boleta">
            @php
                $candidatosPorCurso = [
                    '1ro' => [
                        ['nombre' => 'Partido Aventura', 'numero' => '101', 'color' => '#8a2be2', 'logo' => '101/8a2be2/ffffff?text=PA'],
                        ['nombre' => 'Movimiento Joven', 'numero' => '102', 'color' => '#ff7f50', 'logo' => '102/ff7f50/ffffff?text=MJ'],
                        ['nombre' => 'Frente Futuro', 'numero' => '103', 'color' => '#00bfff', 'logo' => '103/00bfff/ffffff?text=FF']
                    ],
                    '2do' => [
                        ['nombre' => 'Alianza Saber', 'numero' => '201', 'color' => '#8a2be2', 'logo' => '201/8a2be2/ffffff?text=AS'],
                        ['nombre' => 'Partido Avance', 'numero' => '202', 'color' => '#ff7f50', 'logo' => '202/ff7f50/ffffff?text=PA'],
                        ['nombre' => 'Nuevo Horizonte', 'numero' => '203', 'color' => '#00bfff', 'logo' => '203/00bfff/ffffff?text=NH']
                    ],
                    '3ro' => [
                        ['nombre' => 'Frente Unidad', 'numero' => '301', 'color' => '#8a2be2', 'logo' => '301/8a2be2/ffffff?text=FU'],
                        ['nombre' => 'Partido Innovación', 'numero' => '302', 'color' => '#ff7f50', 'logo' => '302/ff7f50/ffffff?text=PI'],
                        ['nombre' => 'Cultura y Cambio', 'numero' => '303', 'color' => '#00bfff', 'logo' => '303/00bfff/ffffff?text=CC']
                    ],
                    '4to' => [
                        ['nombre' => 'Revolución Verde', 'numero' => '401', 'color' => '#8a2be2', 'logo' => '401/8a2be2/ffffff?text=RV'],
                        ['nombre' => 'Fuerza Estudiantil', 'numero' => '402', 'color' => '#ff7f50', 'logo' => '402/ff7f50/ffffff?text=FE'],
                        ['nombre' => 'Progreso', 'numero' => '403', 'color' => '#00bfff', 'logo' => '403/00bfff/ffffff?text=P']
                    ],
                    '5to' => [
                        ['nombre' => 'Líderes del Mañana', 'numero' => '501', 'color' => '#8a2be2', 'logo' => '501/8a2be2/ffffff?text=LM'],
                        ['nombre' => 'Alianza Evolución', 'numero' => '502', 'color' => '#ff7f50', 'logo' => '502/ff7f50/ffffff?text=AE'],
                        ['nombre' => 'Renovación Total', 'numero' => '503', 'color' => '#00bfff', 'logo' => '503/00bfff/ffffff?text=RT']
                    ],
                ];

                $curso = Auth::user()->curso ?? '1ro';
                $candidatos = $candidatosPorCurso[$curso] ?? $candidatosPorCurso['1ro'];

                shuffle($candidatos);
            @endphp

            @foreach($candidatos as $candidato)
                <label class="candidato @if($yaVoto) disabled @endif">
                    <div class="candidato-header" style="background-color: {{ $candidato['color'] }}"></div>
                    <div class="candidato-body">
                        <input type="radio" name="candidato" value="{{ $candidato['nombre'] }}" required @if($yaVoto) disabled @endif>
                        <img src="https://placehold.co/100x100/{{ ltrim($candidato['color'], '#') }}/ffffff?text={{ substr($candidato['nombre'], 0, 2) }}" alt="Logo {{ $candidato['nombre'] }}" class="candidato-logo" style="border: 2px solid {{ $candidato['color'] }};">
                        <div class="candidato-nombre">{{ $candidato['nombre'] }}</div>
                        <p class="candidato-numero">Número: {{ $candidato['numero'] }}</p>
                    </div>
                </label>
            @endforeach

            <!-- Voto en blanco -->
            <label class="candidato @if($yaVoto) disabled @endif">
                <div class="candidato-header" style="background-color: #ccc"></div>
                <div class="candidato-body">
                    <input type="radio" name="candidato" value="Voto en blanco" required @if($yaVoto) disabled @endif>
                    <img src="https://placehold.co/100x100/ccc/333?text=?" alt="Voto en blanco" class="candidato-logo" style="border: 2px solid #ccc;">
                    <div class="candidato-nombre">Voto en blanco</div>
                    <p class="candidato-numero">Número: 0</p>
                </div>
            </label>
        </div>

        <button type="submit" class="btn-primary-custom w-100 mt-4" @if($yaVoto) disabled @endif>
            Confirmar voto
        </button>
    </form>
</div>

<!-- FOOTER -->
<footer>
  <p>Soporte: <a href="mailto:soporte@votacionapp.com">soporte@votacionapp.com</a> | Tel: 0800-123-4567</p>
  <p>© 2025 Sistema de Votación Digital. Gobierno de Misiones. Todos los derechos reservados.</p>
  <p><a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
</footer>

<script>
    // Solo ejecuta el script si el formulario no está deshabilitado
    @if(!isset($yaVoto) || !$yaVoto)
        const opciones = document.querySelectorAll('.candidato');
        opciones.forEach(op => {
            op.addEventListener('click', () => {
                if (op.classList.contains('disabled')) return; // No hacer nada si está deshabilitado
                
                opciones.forEach(o => o.classList.remove('seleccionado'));
                op.classList.add('seleccionado');
                
                // Marca el input de radio correspondiente
                op.querySelector('input[type="radio"]').checked = true;
            });
        });
    @endif
</script>
</body>
</html>