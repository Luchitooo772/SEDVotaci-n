<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Sistema de Votación</title>
    
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
            max-width: 800px; /* Ancho ajustado para perfil */
            margin: 2.5rem auto;
            padding: 1rem;
        }
        
        /* Animación */
        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(15px); }
          to { opacity: 1; transform: translateY(0); }
        }

        /* Tarjeta de Perfil */
        .profile-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--primary-celeste);
            padding: 2rem;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            align-items: center; /* Centra verticalmente foto e info */
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Foto de Perfil (¡NUEVO ESTILO CIRCULAR!) */
        .profile-photo {
            flex-shrink: 0;
            width: 180px;
            height: 180px;
            border-radius: 50%; /* Círculo */
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 4px solid white; /* Borde blanco */
            margin-left: auto;
            margin-right: auto;
        }
        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Asegura que la imagen llene el círculo */
        }
        
        .profile-info {
            flex: 2 1 300px;
        }
        
        .profile-info h3 {
            color: var(--primary-celeste);
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.7rem;
        }
        .profile-info p {
            color: #495057;
            font-size: 1.1rem;
            margin-bottom: 0.7rem;
        }
        .profile-info p strong {
            color: #1c1e21;
        }
        
        /* Botón "Volver" */
        .btn-primary-custom {
            background-color: var(--primary-celeste);
            color: white;
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.9rem 1.2rem;
            font-size: 1rem;
            margin-top: 1.5rem;
            display: inline-block;
            transition: all 0.3s;
            text-decoration: none;
            border: none;
        }
        .btn-primary-custom:hover {
            background-color: var(--dark-celeste);
            transform: translateY(-2px);
        }
        
        /* Encabezado DNI */
        .dni-header {
            background-color: var(--primary-celeste); /* Color unificado */
            color: white;
            padding: 0.8rem 1rem;
            border-radius: 0.75rem 0.75rem 0 0;
            font-weight: 600;
            margin-bottom: 1.5rem; /* Más espacio */
            text-align: center;
        }
        
        /* Responsive */
        @media (max-width: 600px){
            .profile-card { 
                flex-direction: column; 
                align-items: center; 
                padding: 1.5rem;
            }
            .profile-info { 
                text-align: center; 
            }
            .profile-photo {
                width: 150px;
                height: 150px;
            }
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
    <h1><i class="bi bi-person-circle"></i> Perfil del Usuario</h1>
</div>

<div class="main-content section">
    <div class="profile-card">
        <div class="profile-photo">
            <!-- Asume que $userKey es el 'userX' (ej. 'user9') -->
            <img src="{{ asset('users/' . $userKey . '.jpg') }}" alt="Foto de {{ $usuario['nombre'] }}">
        </div>

        <div class="profile-info">
            <div class="dni-header">Frente de DNI - Virtual</div>
            <h3>{{ $usuario['nombre'] }}</h3>
            <p><strong>DNI:</strong> {{ $usuario['dni'] }}</p>
            <p><strong>Email:</strong> {{ $usuario['email'] }}</p>
            <p><strong>Curso:</strong> {{ $usuario['curso'] ?? 'Sin asignar' }}</p>
            <p><strong>Mesa asignada:</strong> Mesa {{ $usuario['mesa'] ?? 'No asignada' }}</p>

            <a href="{{ url('/inicio') }}" class="btn-primary-custom">
                <i class="bi bi-arrow-left-circle"></i> Volver al inicio
            </a>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
  <p>Soporte: <a href="mailto:soporte@votacionapp.com">soporte@votacionapp.com</a> | Tel: 0800-123-4567</p>
  <p>© 2025 Sistema de Votación Digital. Gobierno de Misiones. Todos los derechos reservados.</p>
  <p><a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
</footer>

</body>
</html>
