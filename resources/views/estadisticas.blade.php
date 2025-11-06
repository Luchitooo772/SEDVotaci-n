<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Estadísticas de Votación</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        --silver-metal: #c0c0c0; /* Plateado para "No Votaron" */
        --green-lista: #1cc88a; /* Verde para otra lista */
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
        max-width: 1000px; 
        margin: 2.5rem auto; 
        padding: 1rem; 
    }

    h2 { 
        color: var(--primary-celeste); 
        margin-bottom: 1.5rem; 
        text-align: center; 
        font-weight: 700;
    }
    
    .filter-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }
    .filter-container label {
        font-weight: 500;
        font-size: 1.1rem;
        color: #333;
    }
    select { 
        padding: 10px 15px; 
        border-radius: 8px; 
        border: 1px solid #ccc; 
        width: 250px; 
        font-size: 1rem;
        background: white;
    }
    
    /* Animación */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Contenedor de gráficos */
    .chart-container {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* Estilo de Tarjeta Unificado */
    .card {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-top: 4px solid var(--primary-celeste);
        flex: 1 1 400px; /* ancho mínimo 400px, se adapta */
        animation: fadeIn 0.5s ease-out;
    }

    canvas { 
        max-width: 100%; 
        height: 280px; /* Un poco más de altura */
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
  <h1>Estadísticas de Votación</h1>
</div>

<div class="main-content section">
    <div class="filter-container">
      <label for="cursoSelect">Selecciona un curso:</label>
      <select id="cursoSelect">
    <option value="todos">Todos los cursos</option>
    @foreach($data as $curso => $info)
        <option value="{{ $curso }}">{{ $curso }}</option>
    @endforeach
</select>

    </div>

    <div class="chart-container">
        <div class="card">
            <h2>Participación (Registrados vs Votaron)</h2>
            <canvas id="graficoParticipacion"></canvas>
        </div>

        <div class="card">
            <h2>Resultados por Candidato</h2>
            <canvas id="graficoCandidatos"></canvas>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
  <p>Soporte: <a href="mailto:soporte@votacionapp.com">soporte@votacionapp.com</a> | Tel: 0800-123-4567</p>
  <p>© 2025 Sistema de Votación Digital. Gobierno de Misiones. Todos los derechos reservados.</p>
  <p><a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
</footer>

<script>
// --- ¡LÓGICA MEJORADA! ---

const data = @json($data);

// --- ¡NUEVO! Mapa de colores por partido ---
// Define aquí los nombres exactos de tus listas/candidatos
const partyColors = {
    'Lista A': 'var(--primary-celeste)', // Celeste
    'Lista B': 'var(--green-lista)',     // Verde
    'Votos en Blanco': 'var(--silver-metal)', // Plateado
    // Añade más listas si es necesario
    'default': '#ffc107' // Un color de fallback (amarillo)
};

// --- ¡NUEVO! Colores para el gráfico de estado ---
const statusColors = {
    'Votaron': 'var(--primary-celeste)', // Celeste
    'No Votaron': '#e0e0e0' // Gris claro (para el "no votó")
};


const participacionCtx = document.getElementById('graficoParticipacion').getContext('2d');
const candidatoCtx = document.getElementById('graficoCandidatos').getContext('2d');
let participacionChart, candidatoChart;

// Función para obtener el color CSS (porque Chart.js no lee variables CSS directamente)
function getCssColor(colorVar) {
    return getComputedStyle(document.documentElement).getPropertyValue(colorVar.match(/\((.*?)\)/)[1]).trim();
}

function calcularTotales(data) {
    let totalRegistrados = 0;
    let totalVotaron = 0;
    let candidatosGlobal = {};

    for (const curso in data) {
        totalRegistrados += data[curso].registrados;
        totalVotaron += data[curso].votaron;

        for (const [cand, votos] of Object.entries(data[curso].candidatos)) {
            candidatosGlobal[cand] = (candidatosGlobal[cand] || 0) + votos;
        }
    }

    const porcentaje = totalRegistrados > 0 ? ((totalVotaron / totalRegistrados) * 100).toFixed(1) : 0;

    return {
        registrados: totalRegistrados,
        votaron: totalVotaron,
        candidatos: candidatosGlobal,
        porcentaje
    };
}

function actualizarGraficos(curso) {
    // Si selecciona "todos", calcula totales globales
    const info = curso === 'todos' ? calcularTotales(data) : data[curso];

    // Destruir gráficos previos
    if (participacionChart) participacionChart.destroy();
    if (candidatoChart) candidatoChart.destroy();

    // --- Gráfico de Torta: Participación ---
    const noVotaron = info.registrados - info.votaron;
    const porcentaje = info.porcentaje ?? ((info.votaron / info.registrados) * 100).toFixed(1);

    participacionChart = new Chart(participacionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Votaron', 'No Votaron'],
            datasets: [{
                data: [info.votaron, noVotaron],
                backgroundColor: [
                    getCssColor(statusColors['Votaron']),
                    statusColors['No Votaron']
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label;
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a,b)=>a+b,0);
                            const perc = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} (${perc}%)`;
                        }
                    }
                }
            }
        },
        plugins: [{
            id: 'porcentajeCentro',
            afterDraw(chart) {
                const {ctx, chartArea:{width,height}} = chart;
                ctx.save();
                ctx.font = 'bold 22px Inter';
                ctx.fillStyle = '#333';
                ctx.textAlign = 'center';
                ctx.fillText(`${porcentaje}%`, chart.width / 2, chart.height / 2 + 10);
            }
        }]
    });

    // --- Gráfico de Barras: Votos por Candidato ---
    const candidateLabels = Object.keys(info.candidatos);
    const candidateVotes = Object.values(info.candidatos);

    const backgroundColors = candidateLabels.map(label => {
        const colorName = partyColors[label] || partyColors['default'];
        return colorName.startsWith('var(') ? getCssColor(colorName) : colorName;
    });

    candidatoChart = new Chart(candidatoCtx, {
        type: 'bar',
        data: {
            labels: candidateLabels,
            datasets: [{
                label: 'Votos',
                data: candidateVotes,
                backgroundColor: backgroundColors,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'x',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { 
                y: { 
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                } 
            }
        }
    });
}


// Evento select
document.getElementById('cursoSelect').addEventListener('change', (e) => {
    actualizarGraficos(e.target.value);
});

// Inicializamos con primer curso (espera a que los estilos CSS se carguen)
document.addEventListener('DOMContentLoaded', () => {
    actualizarGraficos(Object.keys(data)[0]);
});
</script>

</body>
</html>