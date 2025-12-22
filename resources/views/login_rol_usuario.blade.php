<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Rol Usuario</title>
    <style>
        /* ==== CSS del login ==== */
        body {
            background-color: #111827;
            font-family: Arial, sans-serif;
        }

        .form-container {
          width: 320px;
          border-radius: 0.75rem;
          background-color: rgba(17, 24, 39, 1);
          padding: 2rem;
          color: rgba(243, 244, 246, 1);
          margin: 5% auto;
        }

        .title {
          text-align: center;
          font-size: 1.5rem;
          line-height: 2rem;
          font-weight: 700;
        }

        .form {
          margin-top: 1.5rem;
        }

        .input-group {
          margin-top: 0.25rem;
          font-size: 0.875rem;
          line-height: 1.25rem;
        }

        .input-group label {
          display: block;
          color: rgba(156, 163, 175, 1);
          margin-bottom: 4px;
        }

        .input-group input {
          width: 100%;
          border-radius: 0.375rem;
          border: 1px solid rgba(55, 65, 81, 1);
          outline: 0;
          background-color: rgba(17, 24, 39, 1);
          padding: 0.75rem 1rem;
          color: rgba(243, 244, 246, 1);
        }

        .input-group input:focus {
          border-color: rgba(167, 139, 250, 1);
        }

        .forgot {
          display: flex;
          justify-content: flex-end;
          font-size: 0.75rem;
          line-height: 1rem;
          color: rgba(156, 163, 175,1);
          margin: 8px 0 14px 0;
        }

        .forgot a,.signup a {
          color: rgba(243, 244, 246, 1);
          text-decoration: none;
          font-size: 14px;
        }

        .forgot a:hover, .signup a:hover {
          text-decoration: underline rgba(167, 139, 250, 1);
        }

        .sign {
          display: block;
          width: 100%;
          background-color: rgba(167, 139, 250, 1);
          padding: 0.75rem;
          text-align: center;
          color: rgba(17, 24, 39, 1);
          border: none;
          border-radius: 0.375rem;
          font-weight: 600;
          cursor: pointer;
        }

        .social-message {
          display: flex;
          align-items: center;
          padding-top: 1rem;
        }

        .line {
          height: 1px;
          flex: 1 1 0%;
          background-color: rgba(55, 65, 81, 1);
        }

        .social-message .message {
          padding-left: 0.75rem;
          padding-right: 0.75rem;
          font-size: 0.875rem;
          line-height: 1.25rem;
          color: rgba(156, 163, 175, 1);
        }

        .social-icons {
          display: flex;
          justify-content: center;
        }

        .social-icons .icon {
          border-radius: 0.125rem;
          padding: 0.75rem;
          border: none;
          background-color: transparent;
          margin-left: 8px;
          cursor: pointer;
        }

        .social-icons .icon svg {
          height: 1.25rem;
          width: 1.25rem;
          fill: #fff;
        }

        .signup {
          text-align: center;
          font-size: 0.75rem;
          line-height: 1rem;
          color: rgba(156, 163, 175, 1);
          margin-top: 1rem;
        }

        .error-messages {
            text-align: center;
            color: red;
            width: 200px;
            margin-bottom: 10px;
        }

        .password-wrapper {
          position: relative;
        }

        .password-wrapper input {
          width: 100%;
          padding-right: 17px;
        }

        .toggle-password {
          position: absolute;
          right: -30px;
          top: 50%;
          transform: translateY(-50%);
          cursor: pointer;
          font-size: 18px;
          user-select: none;
          color: #aaa;
        }

        .toggle-password:hover {
          color: #fff;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <p class="title">Login</p>

        <form class="form" method="POST" action="{{ route('login.rol') }}">
            @csrf

            {{-- Mensajes de error o sesión --}}
            @if(session('error'))
                <div class="error-messages">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @error('usuario')
                <div class="error-messages">{{ $message }}</div>
            @enderror
            @error('password')
                <div class="error-messages">{{ $message }}</div>
            @enderror

            <div class="input-group">
                <label for="username">Usuario</label>
                <input type="text" name="usuario" id="username" placeholder="Tu usuario" value="{{ old('usuario') }}">
            </div>

            <div class="input-group">
              <label for="password">Password</label>
              <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Tu contraseña">
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
              </div>
              <div class="forgot">
                <a href="#">¿Olvidaste tu contraseña?</a>
              </div>
            </div>

            <button type="submit" class="sign">Ingresar</button>
        </form>

        <div class="social-message">
            <div class="line"></div>
            <p class="message">Login con redes sociales</p>
            <div class="line"></div>
        </div>

        <div class="social-icons">
            <button aria-label="Google" class="icon">G</button>
            <button aria-label="Twitter" class="icon">T</button>
            <button aria-label="GitHub" class="icon">GH</button>
        </div>

        <p class="signup">¿No tienes una cuenta?
            <a href="#">Regístrate</a>
        </p>
    </div>

    <script>
        function togglePassword() {
          const input = document.getElementById("password");
          const toggle = document.querySelector(".toggle-password");

          if (input.type === "password") {
            input.type = "text";
            toggle.textContent = "🙈";
          } else {
            input.type = "password";
            toggle.textContent = "👁️";
          }
        }
    </script>
</body>
</html>
