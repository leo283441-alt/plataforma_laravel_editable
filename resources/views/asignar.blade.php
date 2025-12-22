<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Asignar Roles y Formularios</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #4b9fff, #8a2be2);
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 100vh;
      margin: 0;
      padding: 40px 20px;
    }

    .container {
      background: rgba(20, 10, 40, 0.9);
      padding: 35px;
      border-radius: 25px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.6);
      width: 450px;
      text-align: center;
      margin-bottom: 40px;
    }

    h2 {
      background: linear-gradient(90deg, #a8ff00, #4b9fff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 0 0 10px rgba(168, 255, 0, 0.4);
      margin-bottom: 25px;
    }

    label {
      display: block;
      text-align: left;
      margin-bottom: 6px;
      font-weight: 600;
      color: #fff;
    }

    input, select {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 15px;
      border: 2px solid transparent;
      background: rgba(255,255,255,0.1);
      color: white;
      transition: all 0.3s ease-in-out;
      font-size: 0.95em;
      box-sizing: border-box;
    }

    input:focus, select:focus {
      border: 2px solid #a8ff00;
      box-shadow: 0 0 10px rgba(168,255,0,0.5);
      outline: none;
      background: rgba(255,255,255,0.15);
    }

    select option {
      color: black;
      background: white;
    }

    .password-container {
      position: relative;
      width: 100%;
      margin-bottom: 15px;
    }

    .password-container input {
      width: 100%;
      padding-right: 40px;
      box-sizing: border-box;
    }

    .toggle-password {
      position: absolute;
      right: -200px;
      top: 25%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #a8ff00;
      font-size: 1.2rem;
      cursor: pointer;
      transition: color 0.3s ease, transform 0.2s ease;
    }

    .toggle-password:hover {
      color: #4b9fff;
      transform: translateY(-50%) scale(1.1);
    }

    .checkbox-group {
      margin-top: 15px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      background: rgba(255,255,255,0.05);
      padding: 15px;
      border-radius: 15px;
      text-align: left;
    }

    .checkbox-group label {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      font-weight: 500;
      font-size: 0.95em;
    }

    .checkbox-group input[type="checkbox"] {
      appearance: none;
      width: 20px;
      height: 20px;
      border: 2px solid #a8ff00;
      border-radius: 6px;
      background: transparent;
      cursor: pointer;
      position: relative;
      transition: all 0.25s ease;
    }

    .checkbox-group input[type="checkbox"]:checked {
      background: linear-gradient(135deg, #a8ff00, #4b9fff);
      box-shadow: 0 0 10px #a8ff00;
      border-color: #4b9fff;
    }

    .checkbox-group input[type="checkbox"]::after {
      content: "✓";
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -60%) scale(0);
      color: #0b0212;
      font-size: 14px;
      transition: transform 0.2s ease;
    }

    .checkbox-group input[type="checkbox"]:checked::after {
      transform: translate(-50%, -60%) scale(1);
    }

    button {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, #4b9fff, #8a2be2);
      border: none;
      border-radius: 25px;
      color: white;
      font-weight: 600;
      font-size: 1em;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.3s;
      margin-top: 10px;
    }

    .table-container {
      background: rgba(20, 10, 40, 0.9);
      border-radius: 20px;
      padding: 25px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.5);
      width: 90%;
      max-width: 850px;
      text-align: center;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    th {
      color: #a8ff00;
      background: rgba(255,255,255,0.08);
    }

    .btn-volver {
      display: inline-block;
      margin-top: 25px;
      padding: 10px 20px;
      border-radius: 25px;
      background: linear-gradient(135deg, #4b9fff, #8a2be2);
      color: white;
      font-weight: 600;
      text-decoration: none;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-volver:hover {
      transform: scale(1.05);
      box-shadow: 0 0 15px #a8ff00;
    }

    .login-btn {
      position: fixed;
      top: 20px;
      right: 25px;
      background: #ffffff;
      color: #6c63ff;
      border: none;
      border-radius: 30px;
      padding: 10px 20px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      z-index: 9999 !important;
      font-size: 0.95rem;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>🧑‍💼 Crear Usuario y Asignar Formularios</h2>

    <form action="{{ route('usuarios.guardar') }}" method="POST">
      @csrf

      <label for="nombre">Nombre completo:</label>
      <input type="text" id="nombre" name="nombre" required>

      <label for="correo">Correo electrónico:</label>
      <input type="email" id="correo" name="correo" required>

      <label for="rol">Rol del usuario:</label>
      <select id="rol" name="rol" required>
        <option value="usuario">Usuario</option>
        <option value="admin">Administrador</option>
      </select>


      <label for="password">Contraseña:</label>
      <div class="password-container">
        <input type="password" id="password" name="password" required>
        <button type="button" class="toggle-password" onclick="togglePassword()">
          <i class="fa-solid fa-eye"></i>
        </button>
      </div>

      <label>Formularios con acceso:</label>
      <div class="checkbox-group">
        @forelse($formularios as $form)
          <label>
            <input type="checkbox" name="formularios_permitidos[]" value="{{ $form->id }}">
            {{ $form->titulo }}
          </label>
        @empty
          <p style="grid-column: span 2; color: #ccc;">No hay formularios disponibles.</p>
        @endforelse
      </div>

      <button type="submit">💾 Crear Usuario</button>
    </form>
  </div>

  <div class="table-container">
    <h3>📋 Usuarios creados</h3>
    @if($usuarios->count() > 0)
      <table>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Formularios con acceso</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($usuarios as $u)
                <tr>
                  <td>{{ $u->name }}</td>
                  <td>{{ $u->email }}</td>
                  <td>{{ ucfirst($u->rol) }}</td>
                  <td>
                    @forelse($u->formularios as $f)
                      {{ $f->titulo }}@if(!$loop->last), @endif
                    @empty
                      Ninguno
                    @endforelse
                  </td>

                  @if(auth()->user()->rol === 'admin')
                  <td>
                    <a href="{{ route('usuarios.editar', $u->id) }}" style="color:#4b9fff;">✏️</a>
                    <form action="{{ route('usuarios.eliminar', $u->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="return confirm('¿Eliminar este usuario?')" style="background:none; border:none; color:#e74c3c; cursor:pointer;">🗑️</button>
                    </form>
                  </td>
                  @endif


                </tr>
              @endforeach
            </tbody>
          </table>

    @else
      <p class="no-users">Aún no se han creado usuarios.</p>
    @endif

    @auth
    @if(auth()->user()->rol === 'admin')
        <a href="{{ route('usuarios.asignar') }}" class="btn-volver">⚙️ Panel de Asignación</a>
        <a href="{{ url('login') }}" class="login-btn">🔐 Login</a>
    @endif
@endauth

  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById("password");
      const icon = document.querySelector(".toggle-password i");
      if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
      }
    }
  </script>

</body>
</html>
