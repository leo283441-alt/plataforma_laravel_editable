<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $pagina->titulo ?? 'Inicio' }}</title>

  <!-- Fuentes y Bootstrap -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: {{ $pagina->color_fondo ?? '#f9fafb' }};
      color: {{ $pagina->color_texto ?? '#212529' }};
      font-family: "Poppins", sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      position: relative;
    }

    header {
      background: linear-gradient(135deg, #6c63ff, #928dff);
      color: #fff;
      text-align: center;
      padding: 100px 20px 120px;
      border-bottom-left-radius: 60px;
      border-bottom-right-radius: 60px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      position: relative;
      overflow: hidden;
    }

    header h1 {
      font-weight: 700;
      font-size: 2.8rem;
    }

    header p {
      font-size: 1.1rem;
      opacity: 0.95;
      max-width: 600px;
      margin: 10px auto 0;
    }

    /* ✅ BOTÓN LOGIN FIJO ARRIBA A LA DERECHA (SIEMPRE VISIBLE) */
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

    .login-btn:hover {
      background: #f1f0ff;
      color: #574bff;
      transform: translateY(-2px);
    }

    .section-title {
      font-weight: 600;
      font-size: 1.8rem;
      text-align: center;
      margin: 60px 0 40px;
      color: #333;
      position: relative;
    }

    .section-title::after {
      content: "";
      width: 60px;
      height: 4px;
      background: #6c63ff;
      display: block;
      margin: 10px auto 0;
      border-radius: 2px;
    }

    .card-service {
      background: #fff;
      border: none;
      border-radius: 20px;
      padding: 35px 25px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .card-service:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    footer {
      background: #222;
      color: #bbb;
      text-align: center;
      padding: 25px 10px;
      margin-top: 80px;
      font-size: 0.95rem;
    }

    /* ✏️ Botón flotante de edición */
    .edit-btn {
      position: fixed;
      bottom: 25px;
      right: 25px;
      background: linear-gradient(135deg, #6c63ff, #928dff);
      color: #fff;
      border: none;
      border-radius: 50px;
      padding: 14px 26px;
      font-weight: 600;
      box-shadow: 0 5px 15px rgba(108, 99, 255, 0.4);
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 9999;
      text-decoration: none;
      font-size: 1rem;
    }

    .edit-btn:hover {
      background: linear-gradient(135deg, #574bff, #7b73ff);
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(87, 75, 255, 0.5);
    }
  </style>
</head>
<body>

  {{-- 🌟 Botón de Login siempre visible, incluso si hay contenido dinámico --}}
  <a href="{{ url('login') }}" class="login-btn">🔐 Login</a>

  {{-- 🌟 Mostrar contenido guardado si existe --}}
  @if (!empty($pagina->contenido_html))
      {!! $pagina->contenido_html !!}
  @else
      {{-- 🌟 Diseño base --}}
      <div id="page-container">
        <header>
          <h1>Bienvenido a tu página editable</h1>
          <p>Puedes personalizar este contenido desde el editor visual.</p>
        </header>

        <section id="servicios" class="container">
          <h2 class="section-title">Nuestros Servicios</h2>
          <div class="row text-center">
            <div class="col-md-4 mb-4">
              <div class="card-service h-100">
                <h4 class="fw-bold mb-3">💻 Diseño Web</h4>
                <p>Creamos sitios modernos, elegantes y adaptables a cualquier dispositivo.</p>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="card-service h-100">
                <h4 class="fw-bold mb-3">⚙️ Desarrollo</h4>
                <p>Soluciones personalizadas con tecnologías de última generación.</p>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="card-service h-100">
                <h4 class="fw-bold mb-3">🚀 Marketing Digital</h4>
                <p>Impulsamos tu marca con estrategias digitales efectivas.</p>
              </div>
            </div>
          </div>
        </section>

        <footer>
          <p>© 2025 Mi Sitio. Todos los derechos reservados.</p>
        </footer>
      </div>
  @endif

  {{-- ✏️ Botón flotante para editar --}}
  <a href="{{ route('editar_home') }}" class="edit-btn">✏️ Editar página</a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
