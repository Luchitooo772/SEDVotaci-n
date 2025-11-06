<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Votación</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
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
            padding: 2rem 1rem;
        }

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

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .ticket-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 0; /* Sin padding para que el ticket-header funcione */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--primary-celeste);
            animation: fadeIn 0.5s ease-out;
            max-width: 450px;
            width: 100%;
            overflow: hidden; /* Para los bordes redondeados */
        }
        
        .ticket-header {
            background: var(--light-celeste);
            padding: 1.5rem;
            text-align: center;
        }
        
        .ticket-header .icon {
            font-size: 3rem;
            color: var(--primary-celeste);
        }
        
        .ticket-header h2 {
            font-weight: 700;
            color: var(--dark-celeste);
            margin-top: 0.5rem;
        }
        
        .ticket-body {
            padding: 2rem;
            text-align: center;
        }
        
        .ticket-body h1 {
            font-weight: 700;
            color: var(--primary-celeste);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .ticket-body p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .ticket-actions {
            padding: 0 2rem 2rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        /* Botón Primario (Finalizar) */
        .btn-primary-custom {
            background: var(--primary-celeste);
            border: none;
            color: white;
            font-weight: 600;
            padding: 14px;
            font-size: 1.1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-primary-custom:hover {
            background: var(--dark-celeste);
            color: white;
        }
        
        /* Botones Secundarios (Imprimir / Email) */
        .btn-secondary-custom {
            background: #e9ecef;
            border: 1px solid #ced4da;
            color: #333;
            font-weight: 500;
            padding: 12px;
            font-size: 1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-secondary-custom:hover {
            background: #dee2e6;
        }

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

        /* --- Estilos de Impresión --- */
        @media print {
            /* Oculta todo menos el ticket */
            body > *:not(.main-content) {
                display: none;
            }
            .main-content, .ticket-card {
                margin: 0;
                padding: 0;
                box-shadow: none;
                border: none;
                animation: none;
            }
            .ticket-actions {
                display: none; /* Oculta los botones al imprimir */
            }
            .ticket-header {
                background: #eee !important; /* Quita el fondo de color */
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h1>SED</h1>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        
        <div class="ticket-card">
            
            <!-- Encabezado del Ticket -->
            <div class="ticket-header">
                <div class="icon"><i class="bi bi-patch-check-fill"></i></div>
                <h2>Comprobante de Voto</h2>
            </div>
            
            <!-- Cuerpo del Ticket -->
            <div class="ticket-body">
                <p>Tu voto ha sido registrado con el siguiente comprobante:</p>
                <!-- NÚMERO DE COMPROBANTE -->
                <h1>{{ $voto->user->numero_comprobante }}</h1>


                
                <!-- CORRECCIÓN: Comprueba si created_at existe antes de formatear -->
                <p><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }} hs</p>

            </div>
            
            <!-- Acciones -->
            <div class="ticket-actions">
                <!-- Botón de Email (aún no funcional, solo visual) -->
<a href="{{ route('voto.enviar', $voto->id) }}" class="btn btn-secondary-custom">
    <i class="bi bi-envelope"></i> Enviar copia al Email
</a>

                
                <!-- Botón de Imprimir (o Guardar como PDF) -->
                <button onclick="window.print()" class="btn btn-secondary-custom">
                    <i class="bi bi-printer"></i> Imprimir o Guardar PDF
                </button>
                
                <!-- Botón Finalizar -->
                <a href="{{ route('voto.confirmado') }}" class="btn btn-primary-custom">
                    Finalizar y Salir <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <footer>
        <p>Soporte: <a href="mailto:soporte@votacionapp.com">soporte@votacionapp.com</a> | Tel: 0800-123-4567</p>
        <p>© 2025 SED-. Gobierno de Misiones. Todos los derechos reservados.</p>
        <p><a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
    </footer>

</body>
</html>

