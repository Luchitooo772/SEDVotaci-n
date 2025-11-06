<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>SED - Sistema Electoral Digital</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* ---------------------------------
        --- ESTILOS UNIFICADOS ---
        --------------------------------- */
    
    /* Variables de Color (Celeste Oscuro) */
    :root {
        --primary-celeste: #0099e6; /* Celeste (un poco más oscuro) */
        --dark-celeste: #0077c2; /* Celeste oscuro */
        --light-celeste: #d9f0ff; /* Celeste claro */
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f7f9fc; /* Fondo gris muy claro */
      color: #1c1e21;
      margin: 0;
    }

    /* HEADER */
    .header {
      /* Gradiente celeste metalizado (oscuro) */
      background: linear-gradient(to right, #5faad4, #8bc6e6, #5faad4); 
      
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1); /* Sombra suave */
      position: sticky;
      top: 0;
      z-index: 100;
    }

    /* ESTILOS PARA EL LOGO Y TITULO */
    .header-logo-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    #header-logo {
        height: 40px; /* Ajusta esta altura si lo necesitas */
        width: auto;
    }
    /* FIN ESTILOS LOGO */

    .header h2 {
      font-weight: 700;
      font-size: 1.8rem;
      margin: 0;
    }

    #user-btn {
      background: white;
      border: none;
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: transform 0.3s;
    }
    #user-btn:hover { transform: scale(1.15); }
    #user-btn .bi-person-fill { color: var(--primary-celeste) !important; } 


    #user-menu {
      position: absolute;
      top: 55px;
      right: 0;
      background: white;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      border-radius: 12px;
      display: none;
      overflow: hidden;
      z-index: 100;
      width: 200px; /* Ancho fijo para el menú */
    }
    #user-menu a,
    #user-menu button {
      display: flex; /* Para alinear ícono y texto */
      align-items: center;
      gap: 0.75rem; /* Espacio entre ícono y texto */
      padding: 14px 20px;
      font-weight: 500;
      color: #1c1e21;
      text-decoration: none;
      background: transparent;
      border: none;
      width: 100%;
      text-align: left;
      cursor: pointer;
      transition: background 0.2s;
    }
     #user-menu i { /* Estilo para los íconos del menú */
       color: var(--primary-celeste);
       font-size: 1.1rem;
       width: 20px; /* Ancho fijo para alinear */
       text-align: center;
     }
    #user-menu a:hover,
    #user-menu button:hover { background: #f0f4f8; }
    
    /* Separador en el menú */
    #user-menu .dropdown-divider {
      height: 1px;
      margin: 0.5rem 0;
      overflow: hidden;
      background-color: #e9ecef;
    }


    /* HERO */
    .hero {
      text-align: center;
      padding: 3rem 1rem;
      background: var(--light-celeste); /* Fondo claro de celeste */
      border-bottom: 1px solid #d0e0ff;
    }
    .hero h1 {
      font-size: 2.25rem;
      font-weight: 700;
      color: var(--primary-celeste); /* Color celeste principal */
      margin-bottom: 1rem;
    }
    .hero p {
      font-size: 1.1rem;
      color: #333;
      margin-bottom: 2rem;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    
    /* ---------------------------------
        --- ESTILOS DEL BOTÓN "EMPEZAR A VOTAR" ---
        --------------------------------- */
    .btn-pulsing {
      background: var(--primary-celeste);
      color: white;
      padding: 16px 35px;
      font-size: 1.25rem;
      font-weight: 600;
      border: none;
      border-radius: 50px;
      text-decoration: none;
      transition: all 0.3s ease;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(0, 153, 230, 0.4);
      position: relative;
      overflow: hidden;
      z-index: 1;
      display: inline-flex; /* Para alinear el ícono */
      align-items: center;
      gap: 0.5rem;
    }
    .btn-pulsing:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0, 153, 230, 0.6);
    }
    .btn-pulsing::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
      height: 100%;
      background-color: var(--primary-celeste);
      border-radius: 50px;
      z-index: -1;
      transition: all 0.6s ease;
      animation: pulseAnimation 2s infinite cubic-bezier(0.66, 0, 0, 1);
    }
    @keyframes pulseAnimation {
      0% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.6;
      }
      100% {
        transform: translate(-50%, -50%) scale(1.4);
        opacity: 0;
      }
    }
    
    /* Estilos para el estado "Cerrado" */
    .voting-status {
      display: inline-block;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
    }
    .voting-status.closed {
      background: #ffebee;
      color: #c62828;
    }
    .voting-status-message {
      margin-top: 10px;
      font-size: 0.9rem;
    }

    /* ---------------------------------
        --- RESTO DE LOS ESTILOS ---
        --------------------------------- */

    .section {
      max-width: 1100px;
      margin: 2.5rem auto;
      padding: 0 1rem;
    }

    .cards-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.8rem;
    }

    .info-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 1.8rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      border-top: 4px solid var(--primary-celeste);
      animation: fadeIn 0.5s ease-out;
    }
    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }
    .info-card h5 {
      color: var(--primary-celeste);
      font-weight: 700;
      font-size: 1.2rem;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .info-card h5 i {
      font-size: 1.1rem;
    }
    .info-card p { color: #3b3b3b; font-size: 1rem; line-height: 1.5; }
    .info-card p strong {
      color: #000;
    }

    .section-title {
      color: var(--primary-celeste);
      font-weight: 700;
      font-size: 1.8rem;
      margin-bottom:1.5rem;
      text-align: center;
    }

    .steps {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin-top: 1rem;
      counter-reset: step-counter; 
    }
    .step-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 1.5rem 1rem;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s;
      position: relative;
      padding-top: 3.5rem;
      animation: fadeIn 0.5s ease-out;
    }
    .step-card:hover { transform: translateY(-3px); }
    
    .step-card::before {
      counter-increment: step-counter;
      content: counter(step-counter);
      position: absolute;
      top: 1.5rem;
      left: 50%;
      transform: translateX(-50%);
      background: var(--primary-celeste);
      color: white;
      font-weight: 700;
      font-size: 1.1rem;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .step-card i {
      font-size: 2rem;
      color: var(--primary-celeste);
      margin-bottom: 0.5rem;
    }
    .step-card p {
      font-size: 0.95rem;
      color: #333;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    /* ---------------------------------
        --- ESTILOS CHATBOT ---
        --------------------------------- */
    #chatbot-btn {
      position: fixed;
      bottom: 25px;
      right: 25px;
      background: var(--primary-celeste);
      color: white;
      border: none;
      border-radius: 50%;
      width: 65px;
      height: 65px;
      font-size: 1.7rem;
      box-shadow: 0 6px 20px rgba(0,0,0,0.25);
      cursor: pointer;
      z-index: 1000;
      transition: transform 0.2s;
    }
    #chatbot-btn:hover { transform: scale(1.1); }

    #chatbot-btn svg {
      width: 32px; 
      height: 32px;
      transition: transform 0.2s ease-out;
    }
    #chatbot-btn:hover svg {
      transform: rotate(10deg);
    }

    #chatbot-card {
      position: fixed;
      bottom: 95px;
      right: 25px;
      width: 350px;
      max-height: 500px;
      display: none;
      border-radius: 16px;
      overflow: hidden; 
      box-shadow: 0 8px 35px rgba(0,0,0,0.25);
      background: white;
      z-index: 1000;
      animation: fadeIn 0.3s ease-out;
    }
    
    #chatbot-card > .card-body {
        max-height: inherit; 
    }
    
    #chat-header {
      background: var(--primary-celeste);
      color: white;
      padding: 12px 15px;
      font-weight: 600;
      font-size: 1.1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-bottom-left-radius: 12px;
      border-bottom-right-radius: 12px;
      margin-top: 10px; /* separa del borde de la pantalla */
    }

    #close-chat-btn {
      background: none;
      border: none;
      color: white;
      font-size: 1.5rem;
      opacity: 0.8;
      cursor: pointer;
    }
    #close-chat-btn:hover { opacity: 1; }

    #chat-messages {
      flex: 1;
      overflow-y: auto;
      padding: 12px;
      background: #f8f9ff;
      font-size: 0.95rem;
      min-height: 300px; /* más alto */
      max-height: 400px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      border-bottom: 1px solid #dee2e6;
    }

    
    .message {
      padding: 10px 15px;
      border-radius: 18px;
      line-height: 1.4;
      max-width: 85%;
    }
    .message.bot {
      background: #e9ecef;
      color: #333;
      align-self: flex-start;
      border-radius: 18px 18px 18px 4px;
      padding: 10px 14px;
    }
    .message.user {
      background: var(--primary-celeste);
      color: white;
      align-self: flex-end;
      border-radius: 18px 18px 4px 18px;
      padding: 10px 14px;
    }
    
    .message.bot::before,
    .message.user::before {
      content: '';
      display: inline-block;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      margin-right: 8px;
      vertical-align: middle;
    }

    .message.bot::before {
      background: url('/images/bot-icon.png') center/cover no-repeat;
    }

    .message.user::before {
      background: url('/images/user-icon.png') center/cover no-repeat;
    }


    #chat-quick-replies {
      display: flex;
      flex-wrap: wrap; 
      gap: 8px;
      padding: 0 12px 12px 12px;
      border-bottom: 1px solid #dee2e6;
    }
    .quick-reply {
      background: var(--light-celeste);
      border: 1px solid var(--primary-celeste);
      color: var(--primary-celeste);
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
    }
    .quick-reply:hover {
      background: var(--primary-celeste);
      color: white;
    }
    
    #chat-input-area {
        background: #fff;
    }
    #chat-send-btn {
      flex-shrink: 0;
      border-radius: 50%;
      width: 45px;
      height: 45px;
      background-color: var(--primary-celeste);
      border-color: var(--primary-celeste);
    }
    #chat-send-btn:hover {
        background-color: var(--dark-celeste);
        border-color: var(--dark-celeste);
    }
    #chat-input {
      border-radius: 20px;
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

  <div class="header">
    <div class="header-logo-title">
      <img src="{{ asset('img/logoSED.png') }}" alt="Logo SED" id="header-logo">
      <h2>SED - Sistema Electoral Digital</h2>
    </div>
    
    <div class="position-relative">
      <button id="user-btn"><i class="bi bi-person-fill fs-5"></i></button>
      
      <div id="user-menu">
        <a href="{{ route('perfil') }}">
          <i class="bi bi-person-circle"></i> Mi Perfil
        </a>
        <a href="{{ route('voto.mi_comprobante') }}">
          <i class="bi bi-receipt"></i> Mi Comprobante
        </a>
        <div class="dropdown-divider"></div> 
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit">
             <i class="bi bi-box-arrow-right"></i> Cerrar sesión
          </button>
        </form>
      </div>
      </div>
  </div>

  <div class="hero">
    <h1>Bienvenido a SED</h1>

    <p>Vota de manera segura, rápida y confiable desde cualquier dispositivo. Este sistema es oficial del Estado de Misiones.</p>
    
    <div id="voting-status-container" class="mt-3" style="min-height: 80px;">
      </div>
    <p id="voting-status-message" class="voting-status-message"></p>
    
    @if(session('info'))
      <div class="alert alert-info mt-3" role="alert">
         {{ session('info') }}
      </div>
    @endif
     @if(session('error'))
       <div class="alert alert-danger mt-3" role="alert">
         {{ session('error') }}
       </div>
    @endif

  </div>

  <div class="section">
    <div class="cards-grid">
      <div class="info-card">
        <h5><i class="bi bi-person-circle"></i> Tus Datos</h5>
        <p><strong>Nombre:</strong> {{ $usuario['nombre'] }}</p>
        <p><strong>Email:</strong> {{ $usuario['email'] }}</p>
        <p><strong>Curso:</strong> {{ $usuario['curso'] ?? 'Sin asignar' }}</p>
        <p><strong>Mesa asignada:</strong> Mesa {{ $usuario['mesa'] ?? 'No asignada' }}</p>
      </div>
      <div class="info-card">
        <h5><i class="bi bi-shield-lock-fill"></i> Seguridad</h5>
        <p>Todos tus datos y votos están protegidos con cifrado de nivel gubernamental. Garantizamos privacidad y transparencia.</p>
      </div>
      <div class="info-card">
        <h5><i class="bi bi-info-circle-fill"></i> Soporte</h5>
        <p>ChatBot disponible para asistencia inmediata y FAQs. También puedes contactar la línea oficial de soporte.</p>
      </div>
    </div>
  </div>

  <div class="section">
    <h3 class="section-title">Cómo Votar</h3>
    <div class="steps">
      <div class="step-card">
        <i class="bi bi-card-checklist"></i>
        <p>Revisa tus datos personales y mesa asignada.</p>
      </div>
      <div class="step-card">
        <i class="bi bi-hand-index-thumb"></i>
        <p>Selecciona tu candidato o propuesta.</p>
      </div>
      <div class="step-card">
        <i class="bi bi-check-circle-fill"></i>
        <p>Confirma tu voto y genera un comprobante digital.</p>
      </div>
      <div class="step-card">
        <i class="bi bi-shield-fill-check"></i>
        <p>Tu voto queda registrado de manera segura y anónima.</p>
      </div>
    </div>
  </div>

  <button id="chatbot-btn" aria-label="Abrir chat de ayuda">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
      <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"/>
    </svg>
  </button>

  <div id="chatbot-card">
    <div class="card-body d-flex flex-column p-0">
        <div id="chat-header">
            Asistente Virtual
            <button id="close-chat-btn">&times;</button>
        </div>
        <div id="chat-messages" class="chat-window mb-0">
            <div class="message bot">¡Hola {{ $usuario['nombre'] }}, ¿en qué puedo ayudarte?</div>
        </div>
        <div id="chat-quick-replies">
            <button class="quick-reply" data-message="¿En qué mesa voto?">¿En qué mesa voto?</button>
            <button class="quick-reply" data-message="¿Cómo votar?">¿Cómo votar?</button>
            <button class="quick-reply" data-message="Saludar">Saludar</button>
            <button class="quick-reply" data-message="¿Ya voté?">¿Ya voté?</button>
            <button class="quick-reply" data-message="Info Candidatos">Info Candidatos</button>
            <button class="quick-reply" data-message="Horarios">Horarios</button>
        </div>
        <div id="chat-input-area" class="d-flex p-3">
            <input type="text" id="chat-input" class="form-control me-2" placeholder="Escribe tu mensaje...">
            <button class="btn btn-primary" id="chat-send-btn" type="button">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>
  </div>

  <footer>
    <p>Soporte: <a href="mailto:soporte@votacionapp.com">soporte@votacionapp.com</a> | Tel: 0800-123-4567</p>
    <p>© 2025 Sistema de Votación Digital. Gobierno de Misiones. Todos los derechos reservados.</p>
    <p><a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Menú usuario
    const userBtn = document.getElementById('user-btn');
    const userMenu = document.getElementById('user-menu');
    userBtn.addEventListener('click', () =>
      userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block'
    );
    document.addEventListener('click', function(event) {
      if (!userBtn.contains(event.target) && !userMenu.contains(event.target)) {
        userMenu.style.display = 'none';
      }
    });

    // --- LÓGICA DEL ESTADO DE VOTACIÓN ---
    const inicio = new Date("2025-10-25T09:00:00"); // Asegúrate que esta fecha sea correcta
    const fin = new Date("2025-10-30T20:00:00");   // Asegúrate que esta fecha sea correcta
    const statusContainer = document.getElementById("voting-status-container");
    const statusMessage = document.getElementById("voting-status-message");
    const botonAbiertoHTML = `
      <a href="{{ route('votar') }}" class="btn-pulsing">
        <i class="bi bi-box-arrow-in-right"></i> Empezar a Votar
      </a>`;
    const botonCerradoHTML = `
      <span class="voting-status closed">
        VOTACIÓN CERRADA
      </span>`;
    function actualizarBoton() {
        const ahora = new Date();
        if (ahora < inicio) {
            statusContainer.innerHTML = botonCerradoHTML;
            statusMessage.textContent = "La votación se habilitará el " + inicio.toLocaleString();
            statusMessage.style.color = "#c62828"; 
        } else if (ahora > fin) {
            statusContainer.innerHTML = botonCerradoHTML;
            statusMessage.textContent = "La votación finalizó el " + fin.toLocaleString();
            statusMessage.style.color = "#c62828";
        } else {
            statusContainer.innerHTML = botonAbiertoHTML;
            statusMessage.textContent = "La votación está actualmente abierta.";
            statusMessage.style.color = "#2e7d32"; 
        }
    }
    actualizarBoton();
    setInterval(actualizarBoton, 60000); 

// --- LÓGICA DEL CHATBOT ---
const chatbotBtn = document.getElementById('chatbot-btn');
const chatbotCard = document.getElementById('chatbot-card');
const closeChatBtn = document.getElementById('close-chat-btn');
const messagesContainer = document.getElementById('chat-messages');
const inputField = document.getElementById('chat-input');
const sendBtn = document.getElementById('chat-send-btn');
const quickRepliesContainer = document.getElementById('chat-quick-replies');

// Abrir/cerrar chat
chatbotBtn.addEventListener('click', () => { chatbotCard.style.display = 'block'; });
closeChatBtn.addEventListener('click', () => { chatbotCard.style.display = 'none'; });

// Enviar mensaje
sendBtn.addEventListener('click', sendMessage);
inputField.addEventListener('keypress', function(e) { 
    if (e.key === 'Enter') { 
        e.preventDefault(); 
        sendMessage(); 
    } 
});

// Respuesta rápida del menú
quickRepliesContainer.addEventListener('click', function(e) { 
    if (e.target.classList.contains('quick-reply')) { 
        const message = e.target.getAttribute('data-message'); 
        inputField.value = message; 
        sendMessage(message); 
    } 
});

// Función para enviar mensaje al backend
function sendMessage(messageOverride = null) {
    const message = messageOverride || inputField.value.trim();
    if (message === '') return;

    appendMessage(message, 'user');
    inputField.value = '';

    fetch('/chatbot', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => {
        if (!response.ok) throw new Error('Error de red o servidor');
        return response.json();
    })
    .then(data => {
        appendMessage(data.reply, 'bot');
        // Control de visibilidad del menú según show_menu
        quickRepliesContainer.style.display = data.show_menu ? 'flex' : 'none';
    })
    .catch(error => {
        console.error('Error en fetch:', error);
        appendMessage('Lo siento, hubo un error de conexión con el asistente.', 'bot');
    });
}

// Añadir mensaje al chat
function appendMessage(text, sender) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', sender);
    messageDiv.innerHTML = text;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Mensajes flash que desaparecen
const infoAlert = document.querySelector('.alert-info');
const errorAlert = document.querySelector('.alert-danger');
if(infoAlert) {
    setTimeout(() => {
        infoAlert.style.transition = 'opacity 0.5s ease-out';
        infoAlert.style.opacity = '0';
        setTimeout(() => infoAlert.style.display = 'none', 500);
    }, 5000);
}
if(errorAlert) {
    setTimeout(() => {
        errorAlert.style.transition = 'opacity 0.5s ease-out';
        errorAlert.style.opacity = '0';
        setTimeout(() => errorAlert.style.display = 'none', 500);
    }, 5000);
}

  </script>

</body>
</html>