<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --morado: #8a2be2;
      --azul: #4b9fff;
      --verde-limon: #a8ff00;
      --fondo-card: #1a0e2b;
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
      padding: 40px 20px;
      color: var(--white);
    }

    .container {
      background: var(--fondo-card);
      padding: 40px 45px;
      border-radius: 25px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
      width: 600px;
      animation: fadeIn 0.6s ease;
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

    label {
      font-weight: 600;
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
    }

    input, select {
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

    input:focus, select:focus {
      border-color: var(--verde-limon);
      box-shadow: 0 0 10px var(--morado);
      background: rgba(255, 255, 255, 0.12);
    }

    select option {
      background-color: #2b1845;
      color: #ffffff;
    }

    /* 🔹 Formularios permitidos */
    .checkbox-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 12px;
      margin-top: 12px;
    }

    .formulario-card {
      background: rgba(255, 255, 255, 0.05);
      border: 2px solid transparent;
      border-radius: 12px;
      padding: 12px 15px;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: 0.3s ease;
      box-shadow: 0 0 6px rgba(0,0,0,0.3);
    }

    .formulario-card:hover {
      border-color: var(--azul);
      background: rgba(75,159,255,0.1);
      transform: translateY(-2px);
    }

    .formulario-card input {
      accent-color: var(--verde-limon);
      transform: scale(1.2);
      margin-right: 8px;
    }

    .formulario-card span {
      flex: 1;
      color: var(--white);
      font-size: 0.95rem;
    }

    .formulario-card.checked {
      border-color: var(--verde-limon);
      background: rgba(168,255,0,0.12);
      box-shadow: 0 0 10px rgba(168,255,0,0.25);
    }

    /* 🔹 Botones */
    .acciones {
      margin-top: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .btn {
      border: none;
      padding: 12px 22px;
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      font-size: 0.95rem;
    }

    .btn-primary {
      background: linear-gradient(90deg, var(--azul), var(--morado));
      color: var(--white);
      box-shadow: 0 0 12px rgba(75,159,255,0.5);
    }

    .btn-primary:hover {
      transform: scale(1.05);
      box-shadow: 0 0 18px rgba(168,255,0,0.6);
    }

    .btn-secondary {
      color: var(--white);
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.2);
    }

    .btn-secondary:hover {
      color: var(--verde-limon);
      border-color: var(--verde-limon);
    }

    .alert-danger {
      background: rgba(255, 77, 77, 0.2);
      border: 1px solid rgba(255,77,77,0.4);
      color: #ffb3b3;
      padding: 10px 15px;
      border-radius: 10px;
      margin-bottom: 15px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>✏️ Editar Usuario</h2>

    @if ($errors->any())
      <div class="alert-danger">
        <strong>⚠️ Hay errores:</strong>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('usuarios.actualizar', $usuario->id) }}" method="POST">
      @csrf
      @method('PUT')

      <label>👤 Nombre</label>
      <input type="text" name="nombre" value="{{ old('nombre', $usuario->name) }}" required>

      <label>📧 Correo</label>
      <input type="email" name="correo" value="{{ old('correo', $usuario->email) }}" required>

      <label>🎭 Rol</label>
      <select name="rol" required>
        <option value="admin" {{ $usuario->rol === 'admin' ? 'selected' : '' }}>Administrador</option>
        <option value="editor" {{ $usuario->rol === 'editor' ? 'selected' : '' }}>Editor</option>
        <option value="usuario" {{ $usuario->rol === 'usuario' ? 'selected' : '' }}>Usuario</option>
      </select>

      <label>📝 Formularios permitidos</label>
      <div class="checkbox-container">
        @foreach ($formularios as $f)
          <label class="formulario-card {{ $usuario->formularios->contains($f->id) ? 'checked' : '' }}">
            <input type="checkbox" name="formularios_permitidos[]" value="{{ $f->id }}"
              {{ $usuario->formularios->contains($f->id) ? 'checked' : '' }}
              onchange="this.parentElement.classList.toggle('checked', this.checked)">
            <span>{{ $f->titulo }}</span>
          </label>
        @endforeach
      </div>

      <div class="acciones">
        <a href="{{ route('usuarios.asignar') }}" class="btn btn-secondary">⬅️ Volver</a>
        <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
      </div>
    </form>
  </div>
</body>
</html>
