<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login con Reconocimiento Facial</title>
  <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
      text-align: center;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .main-content { flex: 1; padding-bottom: 3rem; }

    .header {
      background: linear-gradient(to right, #5faad4, #8bc6e6, #5faad4);
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .header h2 {
      font-weight: 700;
      font-size: 1.8rem;
      margin: 0;
      width: 100%;
      text-align: center;
    }

    .section { max-width: 1100px; margin: 2.5rem auto; padding: 0 1rem; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin { to { transform: rotate(360deg); } }

    .card {
      background: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      border-top: 4px solid var(--primary-celeste);
      margin: 20px auto;
      max-width: 550px;
      text-align: center;
      animation: fadeIn 0.5s ease-out;
    }

    .step-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--primary-celeste);
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    .step-text { color: #3b3b3b; margin-bottom: 20px; font-size: 1.1rem; line-height: 1.6; }
    .step-image { max-width: 100%; border-radius: 10px; margin-top: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }

    button, .btn-custom {
      padding: 12px 22px; font-size: 1rem; cursor: pointer; border-radius: 10px;
      border: none; background: var(--primary-celeste); color: white; transition: all 0.3s;
      font-weight: 600; letter-spacing: 0.5px; display: inline-block; margin: 5px;
    }
    button:hover, .btn-custom:hover { background: var(--dark-celeste); transform: translateY(-2px); }

    .btn-secondary-custom { background: #6c757d; }
    .btn-secondary-custom:hover { background: #5a6268; }
    .input-custom { width: 120px; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; }

    #cameraDataContainer { display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 25px; margin-top: 25px; }
    #video { border: 4px solid var(--primary-celeste); border-radius: 12px; width: 400px; height: 300px; object-fit: cover; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); animation: fadeIn 0.5s ease-out; }
    #statusUserContainer { display: flex; flex-direction: column; align-items: center; gap: 12px; width: 100%; max-width: 450px; }
    #status { font-weight: bold; font-size: 1.1rem; color: var(--dark-celeste); background: var(--light-celeste); padding: 10px 20px; border-radius: 10px; min-height: 2.5rem; display: flex; align-items: center; justify-content: center; gap: 12px; }
    #status.loading::before { content: ''; display: inline-block; width: 1.2rem; height: 1.2rem; border: 3px solid var(--dark-celeste); border-top-color: transparent; border-radius: 50%; animation: spin 0.8s linear infinite; }
    #userData { width: 100%; }
    .user-data-box { background: #ffffff; padding: 20px; border-radius: 12px; text-align: left; line-height: 1.6; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-top: 4px solid var(--primary-celeste); font-size: 1.1rem; animation: fadeIn 0.4s ease-out; }
    .user-data-box strong { color: #000; }
    #dniContainer { margin-top:15px; padding-top: 15px; border-top: 1px solid #eee; }
    canvas { position: absolute; top: 0; left: 0; }

    footer { margin-top: 50px; text-align: center; color: #6c757d; padding: 25px; font-size: 0.9rem; background: #ffffff; border-top: 1px solid #e9ecef; }
    footer a { color: var(--primary-celeste); text-decoration: none; }
    footer a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="header"><h2>Inicio de Sesión con Reconocimiento Facial</h2></div>

  <div class="main-content section">
    <div id="steps" class="card"><div id="stepContent"></div><button id="nextStep">Siguiente</button></div>

    <div id="cameraDataContainer">
      <video id="video" autoplay muted width="400" height="300"></video>
      <div id="statusUserContainer">
        <div id="status"></div>
        <div id="userData"></div>
      </div>
    </div>
  </div>

  <footer>
    <p>Soporte: <a href="mailto:voto.digital1@gmail.com">voto.digital1@gmail.com</a> | Tel: 0800-123-4567</p>
    <p>© 2025 Sistema de Votación Digital. Gobierno de Misiones. Todos los derechos reservados.</p>
    <p><a href="#">Política de privacidad</a> | <a href="#">Términos y condiciones</a></p>
  </footer>

<script>
const statusDiv = document.getElementById("status");
const userDataDiv = document.getElementById("userData");
const video = document.getElementById("video");

const steps = [
  { text: "Busca un lugar con buena iluminación, preferentemente luz de frente.", img:"paso1.png" },
  { text: "Colócate centrado frente a la cámara, sin objetos que tapen tu rostro.", img:"paso2.png" },
  { text: "Mantén una distancia de 40-60 cm de la cámara.", img:"paso3.png" },
  { text: "Cuando estés listo, inicia el reconocimiento.", img:"paso4.png" }
];
let currentStep = 0;

const stepContent = document.getElementById("stepContent");
const nextBtn = document.getElementById("nextStep");

let detectionStreak = 0;
let canvas, interval;
let faceMatcher;
let escaneoActivo = false; 

function renderStep(){
  const step = steps[currentStep];
  stepContent.innerHTML = `
    <div class="step-title"><i class="bi bi-card-checklist" style="font-size: 1.7rem;"></i>Paso ${currentStep+1}</div>
    <div class="step-text">${step.text}</div>
    <img src="/img/${step.img}" class="step-image" alt="Paso ${currentStep+1}">
  `;
  nextBtn.innerText = currentStep === steps.length-1 ? "Iniciar Reconocimiento" : "Siguiente";
}
renderStep();

nextBtn.addEventListener("click", async ()=>{
  if(currentStep < steps.length-1){
    currentStep++; renderStep();
  }else{
    document.getElementById("steps").style.display="none";
    video.style.display="block";
    statusDiv.innerHTML="Solicitando cámara...";
    statusDiv.classList.add('loading');
    userDataDiv.innerHTML="";
    await cargarModelos();
    faceMatcher = await cargarReferencias();
    iniciarCamara();
  }
});

const labels = ['user0','user1','user2','user3','user4','user5','user6','user7','user8','user9','user10','user11','user13','user14','user15','user16','user17','user18','user19','user20','user22'];

async function cargarModelos(){
  await Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('/models')
  ]);
  statusDiv.innerHTML="Aguarde frente a la camara del dispositivo";
  statusDiv.classList.remove('loading');
}

async function cargarReferencias(){
  const descriptions=[];
  for(const label of labels){
    try{
      const img = await faceapi.fetchImage(`/users/${label}.jpg`);
      const detections = await faceapi.detectSingleFace(img,new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
      if(!detections) continue;
      descriptions.push(new faceapi.LabeledFaceDescriptors(label,[detections.descriptor]));
    }catch(e){ console.warn(`No se pudo cargar la imagen para ${label}: ${e.message}`);}
  }
  return new faceapi.FaceMatcher(descriptions,0.6);
}

async function iniciarCamara(){
  try{
    const stream = await navigator.mediaDevices.getUserMedia({video:true});
    video.srcObject = stream;
    escaneoActivo = true;
  }catch(err){
    statusDiv.innerHTML="❌ No se pudo acceder a la cámara. Revisa los permisos.";
    statusDiv.classList.remove('loading');
    return;
  }

  video.addEventListener("play",()=>{
    statusDiv.innerHTML="Buscando rostro...";
    statusDiv.classList.add('loading');
    const displaySize={width:400,height:300};
    canvas = faceapi.createCanvasFromMedia(video);
    document.body.append(canvas);
    canvas.style.position='absolute';
    const videoRect = video.getBoundingClientRect();
    canvas.style.top = `${videoRect.top + window.scrollY}px`;
    canvas.style.left = `${videoRect.left + window.scrollX}px`;
    faceapi.matchDimensions(canvas, displaySize);
    const options = new faceapi.TinyFaceDetectorOptions({inputSize:416, scoreThreshold:0.4});
    detectionStreak=0;

    interval = setInterval(async ()=>{
      if(!escaneoActivo) return;
      const detections = await faceapi.detectAllFaces(video,options).withFaceLandmarks().withFaceDescriptors();
      const resized = faceapi.resizeResults(detections,displaySize);
      const ctx = canvas.getContext("2d");
      ctx.clearRect(0,0,canvas.width,canvas.height);

      if(detections.length>0){
        detectionStreak++;
        if(detectionStreak===1){ statusDiv.innerHTML="Rostro detectado. Verificando..."; statusDiv.classList.add('loading'); }

        if(detectionStreak>=3){
          const matches = labels.map((label,i)=>{
            if(!faceMatcher.labeledDescriptors[i]) return null;
            return { label, distance: faceapi.euclideanDistance(detections[0].descriptor, faceMatcher.labeledDescriptors[i].descriptors[0]) };
          }).filter(m=>m!==null);
          matches.sort((a,b)=>a.distance-b.distance);
          const best = matches[0];

          if(best && best.distance<0.6){
            escaneoActivo=false;
            fetch(`/api/user/${best.label}`).then(res=>res.json()).then(data=>{
              if(data.error){ userDataDiv.innerHTML=`⚠️ ${data.error}`; statusDiv.classList.remove('loading'); }
              else{
                statusDiv.innerHTML="✅ Coincidencia encontrada";
                statusDiv.classList.remove('loading');
                userDataDiv.innerHTML=`
                  <div class="user-data-box">
                    <h5 style="color: var(--primary-celeste); font-weight: 700; margin-bottom: 15px;">
                      <i class="bi bi-person-check-fill" style="margin-right: 10px;"></i>¡Hola, ${data.nombre}!
                    </h5>
                    <p style="margin:0;"><strong>Email:</strong> ${data.email}</p>
                    <hr style="margin: 15px 0;">
                    <button id="btnYes">Sí, soy yo</button>
                    <button id="btnNo" class="btn-secondary-custom">No soy yo</button>
                    <div id="dniContainer"></div>
                  </div>
                `;

                document.getElementById('btnYes').addEventListener('click',()=>{
                  const dniContainer=document.getElementById('dniContainer');
                  let intentos=0;
                  dniContainer.innerHTML=`
                    <label style="font-weight:500;">Últimos 3 dígitos DNI:</label><br>
                    <input type="text" id="dniInput" maxlength="3" class="input-custom">
                    <button id="verificarDNI">Verificar</button>
                  `;
                  document.getElementById('verificarDNI').addEventListener('click',()=>{
                    const dniInput=document.getElementById('dniInput').value;
                    if(data.dni && dniInput===data.dni.slice(-3)){
                      fetch('/face-login/confirm',{
                        method:'POST',
                        headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                        body: JSON.stringify({ email:data.email, nombre:data.nombre, curso:data.curso, mesa:data.mesa, dni:data.dni })
                      }).then(res=>res.json()).then(res=>{
                        if(res.success){ statusDiv.innerHTML="✅ DNI verificado. Redirigiendo..."; statusDiv.classList.remove('loading'); clearInterval(interval); if(canvas) canvas.remove(); window.location.href=res.redirect; }
                        else{ statusDiv.innerHTML="❌ "+res.message; reiniciarDeteccion(); }
                      });
                    }else{
                      intentos++;
                      if(intentos>=3){ statusDiv.innerHTML="❌ DNI inválido. Volviendo al inicio..."; statusDiv.classList.remove('loading'); setTimeout(()=>{location.reload()},2000);}
                      else{ statusDiv.innerHTML=`❌ DNI incorrecto. Te quedan ${3-intentos} intento(s).`; statusDiv.classList.remove('loading'); document.getElementById('dniInput').value="";}
                    }
                  });
                });

                document.getElementById('btnNo').addEventListener('click',()=>{ reiniciarDeteccion(); });

              }
            }).catch(err=>{ console.error(err); userDataDiv.innerHTML=`⚠️ Error al obtener datos`; statusDiv.classList.remove('loading'); });
          }else{
            statusDiv.innerHTML="❌ No coincide con ninguna";
            statusDiv.classList.remove('loading');
            reiniciarDeteccion();
          }

          if(resized[0]){
            const box=resized[0].detection.box;
            ctx.lineWidth=3;
            ctx.strokeStyle='var(--primary-celeste)';
            ctx.strokeRect(box.x, box.y, box.width, box.height);
          }
        }
      }else{
        detectionStreak=0;
        if(escaneoActivo){ statusDiv.innerHTML="❌ No se detecta rostro"; statusDiv.classList.remove('loading'); userDataDiv.innerHTML=''; }
      }
    },500);
  });
}

function reiniciarDeteccion(){
  detectionStreak=0;
  escaneoActivo=true;
  statusDiv.innerHTML="Buscando otra coincidencia...";
  statusDiv.classList.add('loading');
  userDataDiv.innerHTML='';
}
</script>

</body>
</html>
