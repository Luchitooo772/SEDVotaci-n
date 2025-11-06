<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token para el formulario de logout -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Voto Emitido - Sistema de Votación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ---------------------------------
           --- ESTILOS UNIFICADOS ---
           --------------------------------- */
        :root {
            --primary-celeste: #0099e6;
            --dark-celeste: #0077c2;
            --light-celeste: #d9f0ff;
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* HEADER */
        .header {
            background: linear-gradient(to right, #5faad4, #8bc6e6, #5faad4); 
            color: white;
            padding: 1rem 2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header h1 {
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
        }

        /* ---------------------------------
           --- NUEVOS ESTILOS DE CONFIRMACIÓN ---
           --------------------------------- */

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .confirmation-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--primary-celeste);
            animation: fadeIn 0.5s ease-out;
            text-align: center;
            max-width: 450px;
            width: 100%;
        }

        .confirmation-icon {
            color: var(--primary-celeste);
            font-size: 4rem; /* Icono de check grande */
            line-height: 1;
        }

        .confirmation-card h2 {
            font-weight: 700;
            color: #333;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .confirmation-card p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 2rem;
        }

        /* --- Estilos para la Urna y la Mano (SVGs) --- */
        .urna-container {
            position: relative;
            width: 150px; /* Ancho suficiente para ambos SVGs */
            height: 150px;
            margin: 0 auto 1.5rem auto;
        }
        
        /* La Urna Minimalista */
        .urna-svg {
            width: 100px; /* Ancho de la urna */
            position: absolute;
            bottom: 0; /* Abajo */
            left: 50%;
            transform: translateX(-50%);
            z-index: 1; /* Detrás de la mano */
        }

        /* La Mano con el Voto */
        .mano-svg {
            width: 80px; /* Ancho de la mano */
            position: absolute;
            top: 0; /* Arriba */
            left: 60%; /* Ligeramente a la derecha para centrar la acción */
            z-index: 2; /* Encima de la urna */
            animation: dropVote 1.5s ease-out forwards;
        }
        
        /* Animación de la mano soltando el voto */
        @keyframes dropVote {
            0% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(40px); opacity: 1; } /* Baja hasta la ranura */
            100% { transform: translateY(30px); opacity: 0; } /* Desaparece */
        }

        /* Barra de progreso de 10 segundos */
        .progress-bar-container {
            width: 100%;
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 1rem;
        }

        .progress-bar-inner {
            height: 100%;
            width: 0%;
            background-color: var(--primary-celeste);
            border-radius: 4px;
            animation: progressBar 10s linear forwards;
        }

        @keyframes progressBar {
            from { width: 0%; }
            to { width: 100%; }
        }

        /* FOOTER */
        footer {
            margin-top: auto; /* Empuja el footer hacia abajo */
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
        <h1>SED</h1>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <div class="confirmation-card">
            
            <!-- Icono de Check (Logo de Confirmación) -->
            <div class="confirmation-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <h2>¡Voto Emitido!</h2>
            <p>Tu sufragio ha sido registrado exitosamente.</p>

            <!-- Urna y Mano (SVGs) -->
            <div class="urna-container">
                <!-- Mano -->
                <svg class="mano-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                  <!-- Sobre blanco -->
                  <rect x="10" y="15" width="60" height="40" fill="white" stroke="#ccc" stroke-width="2" rx="3"/>
                  <!-- Sello (opcional) -->
                  <circle cx="60" cy="35" r="5" fill="red"/> 
                  <!-- Dedos sosteniendo -->
                  <path fill="#f2d4b7" d="M 60 55 C 55 55, 50 60, 50 65 L 50 85 C 50 95, 60 95, 60 95 L 70 95 C 75 95, 80 90, 80 85 L 80 65 C 80 60, 75 55, 70 55 Z"/>
                  <!-- Pulgar -->
                  <path fill="#f2d4b7" d="M 50 65 C 45 65, 40 70, 40 75 Q 45 80, 50 80 Z"/>
                </svg>

                <!-- Urna -->
                <svg class="urna-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                  <!-- Cuerpo de la urna -->
                  <rect x="10" y="20" width="80" height="70" fill="#f0f0f0" stroke="#aaa" stroke-width="2" rx="5"/>
                  <!-- Ranura -->
                  <rect x="30" y="25" width="40" height="5" fill="#555" rx="2"/>
                  <!-- Base -->
                  <rect x="5" y="90" width="90" height="5" fill="#ccc" stroke="#888" stroke-width="1" rx="2"/>
                </svg>
            </div>

            <div class="ticket-actions" style="display: flex; justify-content: center; gap: 0.75rem; margin-top: 1.5rem;">
    <!-- Ver Comprobante -->
    <a href="{{ route('voto.mi_comprobante') }}" class="btn btn-primary-custom">
        Ver Comprobante
    </a>

    <!-- No ver Comprobante -->
    <button onclick="document.getElementById('logout-form').submit()" class="btn btn-secondary-custom">
        Terminar
    </button>
</div>


            <p>Serás desconectado automáticamente en unos segundos.</p>
            
            <!-- Barra de progreso -->
            <div class="progress-bar-container">
                <div class="progress-bar-inner"></div>
            </div>
            
            <script>
    setTimeout(() => {
        document.getElementById('logout-form').submit();
    }, 10000);
</script>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>


        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>Soporte: <a href="mailto:soporte@votacionapp.com">soporte@votacionapp.com</a> | Tel: 0800-123-4567</p>
        <p>© 2025 Sistema de Votación Digital. Gobierno de Misiones. Todos los derechos reservados.</p>
        <p><a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
    </footer>

    <script>
        // Espera 10 segundos y luego envía el formulario de logout
        setTimeout(() => {
            document.getElementById('logout-form').submit();
        }, 10000); // 10000 milisegundos = 10 segundos
    </script>

</body>
</html>
