<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Formulario - {{ $formulario->titulo }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --morado: #8a2be2;
      --azul: #4b9fff;
      --fondo-card: #1a0e2b;
      --verde-limon: #a8ff00;
      --white: #ffffff;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, var(--azul), var(--morado));
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      margin: 0;
      padding: 30px;
      color: var(--white);
    }

    .container {
      background: var(--fondo-card);
      padding: 35px 40px;
      border-radius: 25px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
      width: 550px;
      animation: fadeIn 0.7s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      font-size: 1.9rem;
      margin-bottom: 25px;
      background: linear-gradient(90deg, var(--verde-limon), var(--azul));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .btn-regresar {
      display: inline-block;
      margin-bottom: 20px;
      padding: 10px 18px;
      border-radius: 12px;
      text-decoration: none;
      color: white;
      font-weight: 600;
      background: linear-gradient(135deg, var(--morado), var(--azul));
      transition: all 0.3s ease;
    }

    .btn-regresar:hover {
      filter: brightness(1.15);
      transform: translateY(-3px);
    }

    label {
      font-weight: 600;
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
    }

    input, textarea, select {
      width: 100%;
      padding: 12px;
      border: 2px solid transparent;
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.08);
      color: var(--white);
      outline: none;
      transition: 0.3s;
      font-size: 0.95rem;
      box-sizing: border-box;
    }

    input:focus, textarea:focus, select:focus {
      border-color: var(--verde-limon);
      box-shadow: 0 0 10px var(--morado);
      background: rgba(255, 255, 255, 0.12);
    }

    .campo-box {
      background: rgba(255, 255, 255, 0.05);
      padding: 15px;
      border-radius: 12px;
      margin-bottom: 20px;
    }

    .acciones-campo {
      text-align: right;
      margin-top: 8px;
    }

    .acciones-campo a {
      color: var(--verde-limon);
      text-decoration: none;
      margin-left: 10px;
      font-weight: 600;
    }

    select {
      appearance: none;
      background-color: rgba(255, 255, 255, 0.1);
      color: var(--white);
      border: 2px solid transparent;
      border-radius: 12px;
      padding: 12px;
      font-size: 0.95rem;
      transition: 0.3s ease;
      cursor: pointer;
    }

    select option {
      background-color: #2b1845;
      color: #ffffff;
      padding: 8px;
    }

    button {
      width: 100%;
      margin-top: 25px;
      background: linear-gradient(90deg, var(--azul), var(--morado));
      color: var(--white);
      border: none;
      padding: 14px;
      border-radius: 15px;
      cursor: pointer;
      font-weight: 600;
      font-size: 1rem;
      transition: 0.3s ease;
    }

    button:hover {
      transform: scale(1.03);
    }



  </style>
</head>

<body>
  <div class="container">
    <h2>✏️ Editar Formulario</h2>

    <div style="text-align:center;">
      <a href="{{ route('formulario.lista') }}" class="btn-regresar">⬅️ Volver a la lista</a>
    </div>

    <form method="POST" action="{{ route('formulario.actualizar', $formulario->id) }}">
      @csrf
      @method('PUT')

      <label>Título del Formulario</label>
      <input type="text" name="titulo" value="{{ $formulario->titulo }}" required>

      <hr style="margin: 20px 0; opacity: 0.3;">

      @foreach($estructura as $i => $campo)
        <div class="campo-box">
          <label>Etiqueta del campo</label>
          <input type="text" name="campos[{{ $i }}][label]" value="{{ $campo['label'] ?? '' }}" required>

          <label>Tipo de campo</label>
          <select name="campos[{{ $i }}][type]" required>
            @foreach(['text','email','number','textarea','select','checkbox','radio','password'] as $tipo)
              <option value="{{ $tipo }}" {{ ($campo['type'] ?? '') == $tipo ? 'selected' : '' }}>
                {{ ucfirst($tipo) }}
              </option>
            @endforeach
          </select>

          <label>Opciones (solo para select, checkbox o radio)</label>
          <textarea name="campos[{{ $i }}][options]" placeholder="Separar por comas">{{ is_array($campo['options'] ?? null) ? implode(',', $campo['options']) : ($campo['options'] ?? '') }}</textarea>

          <label>Máx. longitud (opcional)</label>
          <input type="number" name="campos[{{ $i }}][maxlength]" value="{{ $campo['maxlength'] ?? '' }}">

          <div class="acciones-campo">
            <a href="#" onclick="eliminarCampo(this); return false;">🗑️ Eliminar</a>
          </div>
        </div>
      @endforeach

      <button type="button" onclick="agregarCampo()">➕ Agregar nuevo campo</button>
      <button type="submit">💾 Guardar Cambios</button>
    </form>
  </div>

  <script>
    function agregarCampo() {
      const campos = document.querySelectorAll('.campo-box');
      const nuevo = campos[campos.length - 1].cloneNode(true);
      const index = campos.length;

      nuevo.querySelectorAll('input, textarea, select').forEach(el => {
        if (el.name.includes('campos')) {
          el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
          el.value = '';
        }
      });

      campos[campos.length - 1].after(nuevo);
    }

    function eliminarCampo(btn) {
      const box = btn.closest('.campo-box');
      const campos = document.querySelectorAll('.campo-box');
      if (campos.length > 1) box.remove();
      else alert("Debe haber al menos un campo.");
    }
  </script>
</body>
</html>
