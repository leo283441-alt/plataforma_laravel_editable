<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nueva Página</title>

  <!-- 🧩 Bootstrap para estilo moderno y responsivo -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f6f9;
      font-family: "Poppins", sans-serif;
    }
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    .btn-primary {
      background-color: #6c63ff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #574bff;
    }
  </style>
</head>
<body>
  <!-- 🧭 Contenedor principal -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-7">

        <!-- 🗂️ Tarjeta visual -->
        <div class="card p-4">
          <h2 class="fw-bold mb-4 text-center text-primary">🆕 Crear nueva página editable</h2>

          <!-- 🧾 FORMULARIO: Envia datos al servidor -->
          <form method="POST" action="{{ route('paginas.store') }}">
            @csrf
            
            <!-- Campo 1: Nombre interno -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Nombre interno (para el sistema)</label>
              <input 
                type="text" 
                name="nombre" 
                class="form-control" 
                placeholder="Ejemplo: acerca-de, contacto, servicios"
                required>
              <div class="form-text">
                Este nombre se usará internamente y generará la URL de la página.
              </div>
            </div>

            <!-- Campo 2: Título visible -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Título visible</label>
              <input 
                type="text" 
                name="titulo" 
                class="form-control" 
                placeholder="Ejemplo: Acerca de Nosotros">
              <div class="form-text">
                Este título aparecerá en la pestaña del navegador y en el encabezado de la página.
              </div>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between mt-4">
              <a href="{{ route('lista_paginas') }}" class="btn btn-outline-secondary">← Volver</a>
              <button type="submit" class="btn btn-primary px-4">💾 Crear página</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
