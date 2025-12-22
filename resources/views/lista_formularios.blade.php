<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Formularios</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #4b9fff, #8a2be2);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding: 30px;
    }

    .container {
      background: rgba(20, 10, 40, 0.9);
      padding: 35px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.6);
      width: 600px;
      text-align: center;
    }

    h2 {
      background: linear-gradient(90deg, #a8ff00, #4b9fff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 25px;
    }

    .form-card {
      background: rgba(255, 255, 255, 0.08);
      padding: 20px;
      margin-bottom: 15px;
      border-radius: 15px;
      text-align: left;
      transition: 0.3s;
    }

    .form-card:hover {
      transform: scale(1.02);
      box-shadow: 0 0 10px rgba(168, 255, 0, 0.4);
    }

    .form-card h3 {
      margin: 0 0 8px 0;
      color: #a8ff00;
    }

    .form-card ul {
      list-style: none;
      padding-left: 10px;
      margin: 10px 0;
    }

    .form-card li {
      color: #ccc;
      margin-bottom: 4px;
      font-size: 0.95rem;
    }

    .actions {
      margin-top: 12px;
      display: flex;
      justify-content: flex-start;
      gap: 10px;
    }

    .btn {
      display: inline-block;
      padding: 8px 15px;
      border-radius: 10px;
      text-decoration: none;
      color: white;
      font-weight: 600;
      transition: 0.3s;
      border: none;
      cursor: pointer;
    }

    .btn-create {
      display: inline-block;
      margin-bottom: 25px;
      padding: 10px 18px;
      border-radius: 25px;
      background: linear-gradient(135deg, #4b9fff, #8a2be2);
      color: white;
      font-weight: 600;
      text-decoration: none;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-create:hover {
      transform: scale(1.05);
      box-shadow: 0 0 15px #a8ff00;
    }

    /* 🔹 Botón Asignar (solo para admin) */
    .btn-assign {
      display: inline-block;
      margin-left: 10px;
      padding: 10px 18px;
      border-radius: 25px;
      background: linear-gradient(135deg, #ff9f43, #ff6b6b);
      color: white;
      font-weight: 600;
      text-decoration: none;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-assign:hover {
      transform: scale(1.05);
      box-shadow: 0 0 15px rgba(255, 159, 67, 0.8);
    }

    .btn-edit { background: #2ecc71; }
    .btn-edit:hover { background: #27ae60; }

    .btn-danger { background: #e74c3c; }
    .btn-danger:hover { background: #c0392b; }

    .no-form {
      color: #ccc;
      font-style: italic;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>📄 Mis Formularios</h2>

    <a href="{{ route('formulario.crear') }}" class="btn-create">➕ Crear Nuevo Formulario</a>

    {{-- 🔹 Mostrar botón "Asignar Formularios" solo si es admin --}}
    @if(Auth::user() && Auth::user()->rol === 'admin')
      <a href="{{ route('usuarios.asignar') }}" class="btn-assign">⚙️ Crear Usuarios</a>
    @endif

    @if($formularios->count() > 0)
      @foreach($formularios as $form)
        <div class="form-card">
          <h3>{{ $form->titulo }}</h3>
          <p><strong>Campos:</strong></p>

          @php
              $estructura = is_array($form->estructura)
                  ? $form->estructura
                  : json_decode($form->estructura, true);
          @endphp

          <ul>
            @foreach($estructura as $field)
              <li>{{ $field['label'] ?? 'Sin etiqueta' }} ({{ $field['type'] ?? 'Sin tipo' }})</li>
            @endforeach
          </ul>

          <div class="actions">
            <a href="{{ route('formulario.editar', $form->id) }}" class="btn btn-edit">✏️ Editar</a>

            <form action="{{ route('formulario.eliminar', $form->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este formulario?')">
                🗑️ Eliminar
              </button>
            </form>
          </div>
        </div>
      @endforeach
    @else
      <p class="no-form">Aún no tienes formularios creados.</p>
    @endif
  </div>
</body>
</html>
