<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Sistema de Votación</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Fuente unificada 'Inter' -->
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
            font-family: 'Inter', sans-serif; /* Fuente unificada */
            background: #f7f9fc; /* Fondo unificado */
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
            max-width: 500px; /* Ancho para la tarjeta de bienvenida */
            margin: 2.5rem auto; /* Ajustado para dar espacio al logo de arriba */
            padding: 1rem;
            display: flex;
            flex-direction: column; /* Cambiado a columna */
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }
        
        /* ---------------------------------
           --- ¡NUEVOS ESTILOS PARA LOGOS! ---
           --------------------------------- */

        /* ¡NUEVA ANIMACIÓN DE "SALTO"! */
        @keyframes jump-in {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            60% {
                opacity: 1;
                transform: translateY(-10px) scale(1.05);
            }
            80% {
                transform: translateY(5px) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Contenedor para el logo principal (LogoSED) */
        .main-logo-container {
            margin-bottom: 1.5rem; /* Espacio entre el logo y la tarjeta */
            animation: jump-in 0.6s ease-out; /* Animación de salto */
        }
        .main-logo {
            max-height: 140px; /* ¡TAMAÑO AUMENTADO! */
            width: auto;
        }

        /* Contenedor para logos de instituciones (esquinas) */
        .institution-logo-container {
            position: fixed; /* Fija los logos en la pantalla */
            bottom: 20px;
            z-index: 100;
            /* Animación de salto con retraso */
            animation: jump-in 0.6s ease-out 0.3s; 
            animation-fill-mode: both; /* Mantiene la opacidad 0 antes de animar */
        }
        .logo-left { left: 20px; }
        .logo-right { right: 20px; }
        
        /* Fondo blanco circular (¡SIN AURA!) */
        .institution-logo-bg {
            background: #ffffff;
            border-radius: 50%;
            padding: 15px; /* Espacio blanco alrededor del logo */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Se quitó la animación 'pulseAura' */
        }
        .institution-logo-bg img {
            height: 60px; /* Tamaño de los logos de instituciones */
            width: auto;
        }
        /* --- FIN DE ESTILOS DE LOGOS --- */
        

        /* Tarjeta de Bienvenida */
        .welcome-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--primary-celeste);
            padding: 3rem 2.5rem;
            width: 100%;
            animation: jump-in 0.6s ease-out 0.1s; /* Animación de salto con retraso */
            animation-fill-mode: both;
            position: relative; 
            z-index: 10;
        }
        
        .welcome-card h3 {
            color: var(--primary-celeste);
            font-weight: 700;
            font-size: 1.8rem;
        }
        .welcome-card p { color: #6c757d; font-size: 1.1rem; }
        
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
            width: 100%;
            display: block;
        }
        .btn-primary-custom:hover {
            background-color: var(--dark-celeste);
            transform: translateY(-2px);
            color: white;
        }
        
        .toast-custom {
            background-color: var(--primary-celeste);
            color: white;
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
        
        /* Ocultar logos de esquina en pantallas pequeñas */
        @media (max-width: 768px) {
            .institution-logo-container {
                display: none;
            }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- HEADER -->
    <div class="header">
        <h1><i class="bi bi-check2-square"></i> SED - Sistema Electoral Digital</h1>
    </div>

    <!-- Contenido principal -->
    <div class="main-content section">
        
        <!-- Logo Principal (SED) -->
        <div class="main-logo-container text-center">
            <img src="{{ asset('img/LogoSED.png') }}" alt="Logo SED" class="main-logo">
        </div>
        
        <!-- Tarjeta de Bienvenida -->
        <div class="welcome-card text-center">
            <h3 class="fw-bold mb-3">Bienvenido</h3>
            <p class="lead mb-4">Seleccione un método de acceso para comenzar a votar de manera segura y confiable.</p>

            <div class="d-grid gap-3">
                <!-- Botón login facial -->
                <a href="/face-login" class="btn-primary-custom">
                    <i class="bi bi-camera"></i> Ingresar con Reconocimiento Facial
                </a>
            </div>
        </div>
    </div>
    
    <!-- Logos Institucionales Flotantes -->
    
    <!-- Logo Izquierda (Cámara) -->
    <div class="institution-logo-container logo-left">
        <div class="institution-logo-bg">
            <!-- Asegúrate que el nombre 'camara.png' sea correcto -->
            <img src="{{ asset('img/camara.png') }}" alt="Logo Cámara de Representantes">
        </div>
    </div>
    
    <!-- Logo Derecha (Innovación) -->
    <div class="institution-logo-container logo-right">
        <div class="institution-logo-bg">
            <!-- Asegúrate que el nombre 'innovavcion.png' sea correcto -->
            <img src="{{ asset('img/innovavcion.png') }}" alt="Logo Innovación Misiones">
        </div>
    </div>
    <!-- Fin Logos Flotantes -->


    <!-- Toast de confirmación de voto -->
    @if(session('success'))
        <div id="voteToast" class="toast align-items-center text-white toast-custom border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1050;">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.getElementById('voteToast');
                // Asegúrate que Bootstrap JS esté cargado si usas new bootstrap.Toast
                if (typeof bootstrap !== 'undefined') {
                    var toast = new bootstrap.Toast(toastEl, { delay: 2500 });
                    toast.show();
                } else {
                    // Fallback si Bootstrap JS no está
                    toastEl.style.display = 'block';
                    setTimeout(() => { toastEl.style.display = 'none'; }, 2500);
                }
            });
        </script>
    @endif

    <!-- FOOTER -->
    <footer>
      <p>Soporte: <a href="mailto:soporte@votacionapp.com">soporte@votacionapp.com</a> | Tel: 0800-123-4567</p>
      <p>© 2025 Sistema de Votación Digital. Gobierno de Misiones. Todos los derechos reservados.</p>
      <p><a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>