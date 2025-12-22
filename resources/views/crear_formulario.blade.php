<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>{{ $titulo_formulario ?? 'Crear Formulario' }}</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root {
  --morado:#8a2be2; --azul:#4b9fff; --fondo-card:#1a0e2b; --verde-limon:#a8ff00; --white:#fff;
}
body { font-family:'Poppins',sans-serif; background:linear-gradient(135deg,var(--azul),var(--morado)); min-height:100vh; display:flex; justify-content:center; align-items:flex-start; margin:0; padding:30px; color:var(--white);}
.container { background:var(--fondo-card); padding:35px 40px; border-radius:25px; box-shadow:0 10px 30px rgba(0,0,0,0.6); width:480px; animation:fadeIn 0.7s ease;}
@keyframes fadeIn { from{opacity:0; transform:translateY(-20px);} to{opacity:1; transform:translateY(0);} }
h2 { text-align:center; font-size:1.9rem; margin-bottom:25px; background:linear-gradient(90deg,var(--verde-limon),var(--azul)); -webkit-background-clip:text; -webkit-text-fill-color:transparent;}
.btn-regresar { display:inline-block; margin-bottom:20px; padding:10px 18px; border-radius:12px; text-decoration:none; color:white; font-weight:600; background: linear-gradient(135deg,var(--morado),var(--azul)); transition:all 0.3s ease;}
.btn-regresar:hover { filter:brightness(1.15); transform:translateY(-3px);}
label { font-weight:600; display:block; margin-top:15px; margin-bottom:5px;}

input, textarea, select { 
  width:100%; 
  padding:12px; 
  border:2px solid transparent; 
  border-radius:12px; 
  background: rgba(255,255,255,0.08); 
  color: #ffffff; /* texto visible */
  outline:none; 
  transition:0.3s; 
  font-size:0.95rem; 
  box-sizing:border-box;
}

select { 
  color: #ffffff; /* texto del select */
}

select option {
  color: #000000; /* opciones legibles al desplegar */
}



input:focus, textarea:focus, select:focus { border-color: var(--verde-limon); box-shadow:0 0 10px var(--morado); background: rgba(255,255,255,0.12);}
button { width:100%; margin-top:25px; background: linear-gradient(90deg,var(--azul),var(--morado)); color:var(--white); border:none; padding:14px; border-radius:15px; cursor:pointer; font-weight:600; font-size:1rem; transition:0.3s ease;}
button:hover { transform:scale(1.03);}
.field-container { background: rgba(255,255,255,0.05); padding:15px; border-radius:12px; margin-bottom:15px;}
.field-actions { margin-top:10px;}
.field-actions button { width:auto; margin-right:10px; }
</style>
</head>
<body>
<div class="container">
  <h2>Crear Formulario</h2>
  <div style="text-align:center;">
    <a href="{{ route('formulario.lista') }}" class="btn-regresar">⬅️ Regresar al Editor</a>
  </div>

  {{-- Mensajes --}}
  @if(session('success'))
    <div class="message success">{{ session('success') }}</div>
  @elseif(session('error'))
    <div class="message error">{{ session('error') }}</div>
  @endif

  <form method="POST" action="{{ route('formulario.crear') }}" id="formularioPrincipal">
    @csrf
    <label>Título del Formulario</label>
    <input type="text" name="titulo_formulario" id="titulo_formulario" placeholder="Ingrese el título" required>

    <h3>Campos del Formulario</h3>
    <div id="campos"></div>

    <button type="button" onclick="agregarCampo()">➕ Agregar Campo</button>
    <input type="hidden" name="estructura_formulario" id="estructura_formulario">
    <button type="submit" onclick="prepararJSON()">Crear Formulario</button>
  </form>
</div>

<script>
let contadorCampos = 0;

function agregarCampo() {
    contadorCampos++;
    const container = document.getElementById('campos');
    const div = document.createElement('div');
    div.className = 'field-container';
    div.id = 'campo_' + contadorCampos;
    div.innerHTML = `
      <label>Nombre del campo</label>
      <input type="text" class="campo-label" placeholder="Ej: Nombre" required>
      
      <label>Tipo de campo</label>
      <select class="campo-type">
        <option value="text">Texto</option>
        <option value="number">Número</option>
        <option value="decimal">Decimal</option>
        <option value="textarea">Texto Largo</option>
        <option value="password">Contraseña</option>
        <option value="select">Seleccionar</option>
        <option value="radio">Radio</option>
        <option value="checkbox">Checkbox</option>
      </select>
      
      <label>Máximo de caracteres (opcional)</label>
      <input type="number" class="campo-maxlength" placeholder="Ej: 100">
      
      <div class="field-actions">
        <button type="button" onclick="agregarOpciones(this)">Agregar opciones</button>
        <button type="button" onclick="eliminarCampo('${div.id}')">Eliminar</button>
      </div>
      <div class="opciones"></div>
    `;
    container.appendChild(div);
}

function agregarOpciones(btn) {
    const opcionesDiv = btn.parentElement.nextElementSibling;
    const input = document.createElement('input');
    input.type = 'text';
    input.placeholder = 'Opción';
    input.className = 'campo-opcion';
    opcionesDiv.appendChild(input);
}

function eliminarCampo(id) {
    document.getElementById(id).remove();
}

function prepararJSON() {
    const campos = document.querySelectorAll('.field-container');
    const estructura = [];
    campos.forEach(campo => {
        const label = campo.querySelector('.campo-label').value;
        const type = campo.querySelector('.campo-type').value;
        const maxlength = campo.querySelector('.campo-maxlength').value;
        let opciones = [];
        campo.querySelectorAll('.campo-opcion').forEach(op => { if(op.value) opciones.push(op.value); });
        estructura.push({label, type, maxlength: maxlength || null, options: opciones});
    });
    document.getElementById('estructura_formulario').value = JSON.stringify(estructura);
}
</script>
</body>
</html>
