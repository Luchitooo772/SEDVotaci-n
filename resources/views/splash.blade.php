<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SED - Sistema Electoral Digital</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #007bff; /* Azul primario */
            --light-blue: #00c0f0;  /* Azul claro */
            --dark-blue: #002d62;   /* Azul muy oscuro */
            /* --accent-purple: #7f00ff; <-- ELIMINADO */
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: white;
            text-align: center;
            overflow: hidden;
            
            background-color: var(--dark-blue);
            /* --- FONDO ACTUALIZADO (Sin Púrpura) --- */
            background-image: 
                radial-gradient(circle at 10% 90%, var(--light-blue) 0%, transparent 50%),
                radial-gradient(circle at 90% 10%, var(--primary-blue) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, white 0%, transparent 40%); /* Reemplazado por blanco */
            
            background-size: 400% 400%;
            animation: gradientMove 30s ease infinite alternate;
        }

        @keyframes gradientMove {
            0%   { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }

        .container {
            position: relative;
            z-index: 10;
            padding: 2rem;
        }

        /* --- Animación de "Salto" (Sin cambios) --- */
        @keyframes jump-in {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.9);
                filter: blur(8px);
            }
            60% {
                opacity: 1;
                transform: translateY(-15px) scale(1.05);
                filter: blur(0px);
            }
            80% {
                transform: translateY(5px) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0px);
            }
        }

        /* --- ¡NUEVA ANIMACIÓN DE FLOTACIÓN! (Más suave) --- */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px); /* Flota más suave */
            }
        }
        
        .main-logo-container {
            margin-bottom: 1.5rem;
            animation: jump-in 0.8s ease-out;
            animation-fill-mode: both;
        }
        .main-logo {
            max-height: 140px;
            width: auto;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.1;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            animation: jump-in 0.8s ease-out 0.1s;
            animation-fill-mode: both;
        }

        p {
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 2.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            animation: jump-in 0.8s ease-out 0.2s;
            animation-fill-mode: both;
        }

        .btn-empezar {
            padding: 1.2rem 3rem;
            font-size: 1.4rem;
            font-weight: 700;
            border-radius: 50px;
            border: none;
            background: linear-gradient(90deg, #00bfff, #007bff);
            color: white;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 0 20px rgba(0, 191, 255, 0.7);
            
            animation: pulseAura 2s infinite cubic-bezier(0.25, 0.46, 0.45, 0.94),
                         jump-in 0.8s ease-out 0.3s;
            animation-fill-mode: both;
        }

        .btn-empezar:hover {
            transform: scale(1.08);
            box-shadow: 0 0 35px rgba(0, 191, 255, 1);
        }

        @keyframes pulseAura {
            0% { box-shadow: 0 0 20px rgba(0, 191, 255, 0.7); }
            50% { box-shadow: 0 0 45px rgba(0, 191, 255, 1); }
            100% { box-shadow: 0 0 20px rgba(0, 191, 255, 0.7); }
        }
        
        /* --- Logos de Instituciones (Fondos Blancos) --- */
        .institution-logo-container {
            position: fixed;
            bottom: 30px;
            z-index: 100;
            /* Animación de entrada (jump-in) + Animación de flotación (float) */
            animation: jump-in 0.8s ease-out 0.5s, float 4s ease-in-out infinite 1.5s;
            animation-fill-mode: both;
        }
        .logo-left { left: 30px; }
        .logo-right { right: 30px; }
        
        /* ¡FONDO BLANCO (No tan feo)! */
        .institution-logo-bg {
            background: #ffffff; /* Fondo blanco sólido */
            border-radius: 50%;
            padding: 15px; /* Espacio blanco */
            box-shadow: 
                0 5px 20px rgba(0, 0, 0, 0.2); /* Sombra normal para despegarlo */
            
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .institution-logo-bg:hover {
             /* Al pasar el mouse, agregamos el aura celeste */
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2), 0 0 30px rgba(0, 191, 255, 0.7);
            transform: scale(1.05); /* Y lo agrandamos un poco */
        }

        .institution-logo-bg img {
            height: 70px; /* ¡LOGOS MÁS GRANDES! */
            width: auto;
        }
        /* --- Fin Logos Instituciones --- */


        /* Responsive */
        @media (max-width: 768px) {
            h1 { font-size: 2.5rem; }
            p { font-size: 1.2rem; }
            .btn-empezar { 
                padding: 1rem 2rem; 
                font-size: 1.2rem; 
            }
            .institution-logo-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Logo Principal (SED) --><div class="main-logo-container text-center">
            <img src="{{ asset('img/LogoSED.png') }}" alt="Logo SED" class="main-logo">
        </div>

        <h1>SED - Sistema Electoral Digital</h1>
        <p>Bienvenido</p>
        <a href="{{ route('welcome') }}" class="btn-empezar">Empezar</a>
    </div>

    <!-- Logos Institucionales Flotantes --><div class="institution-logo-container logo-left">
        <div class="institution-logo-bg">
            <img src="{{ asset('img/camara.png') }}" alt="Logo Cámara de Representantes">
        </div>
    </div>
    <div class="institution-logo-container logo-right">
        <div class="institution-logo-bg">
            <img src="{{ asset('img/innovavcion.png') }}" alt="Logo Innovación Misiones">
        </div>
    </div>
    <!-- Fin Logos Flotantes --></body>
</html>