<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Administrador</title>

  <!-- Fuente y estilos -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      height: 100vh;
      background: linear-gradient(135deg, #6c63ff, #928dff);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #333;
    }

    .container {
      background: #fff;
      border-radius: 20px;
      padding: 40px 35px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      text-align: center;
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .heading {
      font-size: 1.8rem;
      font-weight: 600;
      color: #6c63ff;
      margin-bottom: 20px;
    }

    .form {
      margin-top: 10px;
      text-align: left;
    }

    .form .input {
      width: 100%;
      padding: 12px 18px;
      font-size: 1rem;
      border-radius: 10px;
      border: 1px solid #ccc;
      box-sizing: border-box;
      margin-bottom: 15px;
      background-color: #fff;
      color: #000;
      transition: 0.2s;
    }

    .form .input:focus {
      border-color: #6c63ff;
      box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.15);
      outline: none;
    }

    .password-container {
      position: relative;
      width: 100%;
      margin-bottom: 15px;
    }

    .password-container input {
      width: 100%;
      padding-right: 40px;
      font-size: 1rem;
      border-radius: 10px;
      border: 1px solid #ccc;
      background-color: #fff;
      color: #000;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #6c63ff;
      font-size: 1.2rem;
      cursor: pointer;
      opacity: 0.7;
    }

    .toggle-password:hover {
      opacity: 1;
    }

    .login-button {
      width: 100%;
      background: #6c63ff;
      color: #fff;
      border: none;
      padding: 12px;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .login-button:hover {
      background: #574bff;
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(108, 99, 255, 0.3);
    }

    




    .social-account-container {
    margin-top: 22px;
    text-align: center;
  }

  .social-account-container .title {
    display: block;
    font-size: 0.95rem;
    color: #6b6b6b;
    margin-bottom: 10px;
    font-weight: 500;
  }

  .social-accounts {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 8px;
  }

  .social-button {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    border: 1px solid #e6e6e6;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    cursor: pointer;
    transition: transform .15s ease, box-shadow .15s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  }

  .social-button:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.09);
  }

  /* tamaño SVG */
  .social-button svg { width: 20px; height: 20px; display: block; }

    .agreement {
      display: block;
      margin-top: 25px;
      font-size: 0.85rem;
      color: #666;
    }

    .agreement a {
      color: #6c63ff;
      text-decoration: none;
    }

    .agreement a:hover {
      text-decoration: underline;
    }

    ul {
      list-style: none;
      padding: 0;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="heading">Login Administrador</div>

    {{-- Mensajes de error --}}
    @if (session('error'))
      <ul style="color:red; font-size:13px;">
        <li>{{ session('error') }}</li>
      </ul>
    @endif

    {{-- Formulario de login --}}
    <form method="POST" action="{{ route('login.post') }}" class="form">
      @csrf
      <input type="text" name="usuario" class="input" placeholder="Usuario o email" required>

      <div class="password-container">
        <input type="password" name="password" class="input" placeholder="Contraseña" id="password" required>
        <button type="button" class="toggle-password" onclick="togglePassword()">👁️</button>
      </div>

      <button type="submit" class="login-button">Ingresar</button>
    </form>

    <div class="social-account-container">
  <span class="title">O inicia sesión con</span>

  <div class="social-accounts">
    <!-- Google -->
    <button type="button" class="social-button" title="Iniciar con Google">
      <svg viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
        <path fill="#4285F4" d="M533.5 278.4c0-18.8-1.7-37.4-5.1-55.3H272v104.8h147.1c-6.4 34.8-25.5 64.3-54.6 84.1v69h88.3c51.6-47.6 81.7-117.7 81.7-202.6z"/>
        <path fill="#34A853" d="M272 544.3c73.6 0 135.4-24.3 180.6-65.9l-88.3-69c-24.6 16.5-56 26.4-92.3 26.4-71 0-131.1-47.9-152.5-112.2h-90.4v70.6C60.9 475.2 157 544.3 272 544.3z"/>
        <path fill="#FBBC05" d="M119.5 323.6c-10.9-32.3-10.9-67 0-99.3v-70.6h-90.4c-39.3 76.6-39.3 168.6 0 245.2l90.4-75.3z"/>
        <path fill="#EA4335" d="M272 107.7c39.9 0 75.9 13.7 104.2 40.6l78.1-78.1C403.4 24.6 344.4 0 272 0 157 0 60.9 69.1 29.5 170.3l90.4 70.6C140.9 155.6 201 107.7 272 107.7z"/>
      </svg>
    </button>

    <!-- Apple -->
    <button type="button" class="social-button" title="Iniciar con Apple">
      <svg viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
        <path fill="#000000" d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5c0 39.3 14.4 81.2 47.2 118.6 32.6 36.9 79.8 63.7 131.7 63.7 31.8 0 48.3-17.9 76.4-17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zM272.1 24c19.9-24.3 33.8-58 29.9-92.6-28.1 1.1-61.9 18.8-83.1 43.1-18.2 21.7-30.5 49.6-26.8 78.8 27.9 2 52-11.1 79.9-29.3z" transform="translate(0 64)"/>
      </svg>
    </button>

    <!-- Twitter -->
    <button type="button" class="social-button" title="Iniciar con Twitter">
      <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
        <path fill="#1DA1F2" d="M459.4 151.7c.3 4.1.3 8.3.3 12.5 0 127.4-97 274.6-274.6 274.6-54.6 0-105.4-16-148.1-43.5 7.6.9 15.2 1.2 23.1 1.2 45 0 86.5-15.2 119.5-40.8-42.1-.9-77.6-28.6-89.9-66.8 5.9.9 11.8 1.5 18 1.5 8.6 0 17-1.2 24.9-3.4C99.2 241 73.8 217 59.4 185.8c8.7 1.5 17.5 2.4 26.6 2.4 12.8 0 25.1-1.8 36.9-5.2-44.1-8.9-77.2-47.6-77.2-94.3 0-.4 0-.9 0-1.3 12.6 7 27 11.2 42.5 11.7-25.4-17-42.1-46.1-42.1-79 0-17.4 4.7-33.7 13-47.8 48.8 59.9 121.8 99.4 204.1 103.6-1.7-6.9-2.6-14.1-2.6-21.7 0-52.7 42.7-95.4 95.4-95.4 27.4 0 52.1 11.6 69.5 30.1 21.7-4.2 42.2-12.1 60.7-23-7.1 22.2-22.3 40.8-42.2 52.6 19.2-2.3 37.5-7.4 54.5-15-12.8 18.9-28.9 35.6-47.6 49z"/>
      </svg>
    </button>
  </div>
</div>

    <span class="agreement"><a href="#">Términos y condiciones</a></span>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById("password");
      const button = document.querySelector(".toggle-password");
      if (input.type === "password") {
        input.type = "text";
        button.textContent = "🙈";
      } else {
        input.type = "password";
        button.textContent = "👁️";
      }
    }
  </script>

</body>
</html>
