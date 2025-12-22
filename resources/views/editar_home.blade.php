<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editor Visual - Página Home con Plantillas</title>

  <!-- CSS principales -->
  <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- JS principales -->
  <script src="https://unpkg.com/grapesjs"></script>

  <!-- 🔧 Plugins -->
  <script src="https://unpkg.com/grapesjs-blocks-basic"></script>
  <script src="https://unpkg.com/grapesjs-plugin-forms"></script>
  <script src="https://unpkg.com/grapesjs-plugin-export"></script>
  <script src="https://unpkg.com/grapesjs-preset-webpage"></script>
  <script src="https://unpkg.com/grapesjs-blocks-flexbox"></script>
  <script src="https://unpkg.com/grapesjs-navbar"></script>
  <script src="https://unpkg.com/grapesjs-component-countdown"></script>
  <script src="https://unpkg.com/grapesjs-plugin-ckeditor"></script>

  <style>
    body, html {height: 100%;margin: 0;font-family: "Poppins", sans-serif;background: #f9f9fb;}
    .editor-toolbar {position: fixed;top: 0;left: 0;right: 0;height: 60px;background: linear-gradient(90deg, #4f46e5, #7c3aed);color: white;display: flex;align-items: center;justify-content: space-between;padding: 0 20px;z-index: 1000;box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);}
    .editor-toolbar h1 {font-size: 18px;margin: 0;font-weight: 500;}
    .editor-buttons button, .editor-buttons a {background: white;color: #4f46e5;border: none;padding: 8px 14px;margin-left: 8px;border-radius: 6px;font-weight: 600;cursor: pointer;transition: all 0.2s ease;text-decoration: none;}
    .editor-buttons button:hover, .editor-buttons a:hover {background: #ede9fe;}
    #panel-lateral {position: fixed;top: 60px;left: 0;width: 250px;height: calc(100vh - 60px);background: #fff;border-right: 1px solid #ddd;overflow-y: auto;padding: 10px;z-index: 900;}
    #panel-derecho {position: fixed;top: 60px;right: 0;width: 300px;height: calc(100vh - 60px);background: #fff;border-left: 1px solid #ddd;overflow-y: auto;z-index: 900;}
    #gjs {margin-left: 250px;margin-right: 300px;height: calc(100vh - 60px);margin-top: 60px;border: none;}

    /* Modal */
    .modal-overlay {position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: none; justify-content: center; align-items: center; z-index: 3000;}
    .modal-content {background: white; padding: 25px; border-radius: 8px; max-width: 400px; text-align: center;}
    .toast-msg {position: fixed;bottom: 20px;right: 20px;background: #4f46e5;color: white;padding: 12px 20px;border-radius: 8px;box-shadow: 0 4px 10px rgba(0,0,0,0.3);display: none;z-index: 2000;font-weight: 500;}

    /* Panel de plantillas */
    #template-panel {position: fixed;top: 80px;left: 270px;z-index: 1000;background: white;border-radius: 12px;box-shadow: 0 2px 8px rgba(0,0,0,0.1);padding: 12px;}
    #template-panel h5 {font-size: 16px;font-weight: 600;margin-bottom: 8px;}
    .template-btn {display: block;background: #6c63ff;color: white;border: none;border-radius: 6px;padding: 8px 10px;margin: 5px 0;width: 180px;cursor: pointer;font-size: 14px;}
    .template-btn:hover {background: #574bff;}
  </style>

</head>
<body>

  <div class="editor-toolbar">
    <h1>🧩 Editor Visual - Página Home</h1>
    <div class="editor-buttons">
      <button id="preview-btn">👁️ Vista previa</button>
      <button id="save-btn">💾 Guardar</button>
      <button id="clear-btn">🧹 Limpiar</button>
      <a href="{{ url('/') }}" target="_blank">🌐 Ver página</a>
      <a href="{{ url('/') }}" class="btn btn-light">⬅️ Salir</a>
    </div>
  </div>

  <div id="panel-lateral">
    <h6>🧱 Bloques</h6>
    <div id="blocks"></div>
  </div>

  <div id="panel-derecho">
    <div id="styles-container"></div>
    <div id="traits-container"></div>
  </div>

  <!-- 🌟 Panel de plantillas -->
  <div id="template-panel">
    <h5>🌟 Plantillas</h5>
    <button class="template-btn" onclick="loadTemplate('empresa')">Empresa</button>
    <button class="template-btn" onclick="loadTemplate('restaurante')">Restaurante</button>
    <button class="template-btn" onclick="loadTemplate('portafolio')">Portafolio</button>
    <button class="template-btn" onclick="editor.runCommand('core:canvas-clear')">Vaciar</button>
  </div>

  <form id="editor-form" action="{{ route('editar_home_post') }}" method="POST">
    @csrf
    <input type="hidden" id="input-html" name="contenido_html">
  </form>

  <div id="gjs"></div>
  <div id="toast" class="toast-msg">✅ Página guardada con éxito</div>

  <div id="save-modal" class="modal-overlay">
    <div class="modal-content">
      <h5 class="mb-3">Confirmar Guardado</h5>
      <p class="mb-4">¿Deseas guardar los cambios realizados en el editor?</p>
      <button id="modal-confirm" class="btn btn-primary me-2">Sí, Guardar</button>
      <button id="modal-cancel" class="btn btn-secondary">Cancelar</button>
    </div>
  </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const savedHtmlContent = @json($pagina->contenido_html ?? '');
  let htmlPart = savedHtmlContent || '';
  let cssPart = '';
  const styleMatch = htmlPart.match(/<style[^>]*>([\s\S]*?)<\/style>/i);
  if (styleMatch) {
    cssPart = styleMatch[1];
    htmlPart = htmlPart.replace(styleMatch[0], '');
  }
  htmlPart = htmlPart.replace(/<\/?body[^>]*>/gi, '').trim();

  const editor = grapesjs.init({
    container: '#gjs',
    height: '100vh',
    storageManager: false,
    fromElement: false,
    canvas: {
      styles: ['https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css']
    },
    plugins: [
      'gjs-blocks-basic',
      'grapesjs-plugin-forms',
      'grapesjs-plugin-export',
      'grapesjs-preset-webpage',
      'grapesjs-blocks-flexbox',
      'grapesjs-navbar',
      'grapesjs-component-countdown',
      'grapesjs-plugin-ckeditor'
    ],
    blockManager: { appendTo: '#blocks' },
    styleManager: { appendTo: '#styles-container' },
    traitManager: { appendTo: '#traits-container' }
  });

  if (htmlPart.trim() !== '') {
    editor.setComponents(htmlPart);
    editor.setStyle(cssPart);
  }

  const bm = editor.BlockManager;

  // 🔧 Bloques personalizados
  bm.add('hero-section', {label: '🌄 Hero', category: 'Secciones', content: `
    <section class="py-5 text-center bg-light">
      <div class="container">
        <h1 class="display-5 fw-bold">Bienvenido a mi sitio</h1>
        <p class="lead">Edita este texto fácilmente.</p>
        <a href="#" class="btn btn-primary btn-lg">Llamar a la acción</a>
      </div>
    </section>
  `});

  bm.add('servicios-section', {label: '🧩 3 Columnas', category: 'Secciones', content: `
    <section class="py-5 bg-white text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-4"><h4>🔧 Servicio 1</h4><p>Descripción breve.</p></div>
          <div class="col-md-4"><h4>⚙️ Servicio 2</h4><p>Descripción breve.</p></div>
          <div class="col-md-4"><h4>🚀 Servicio 3</h4><p>Descripción breve.</p></div>
        </div>
      </div>
    </section>
  `});

  bm.add('footer-section', {label: '⚫ Footer', category: 'Secciones', content: `
    <footer class="py-4 text-center text-light" style="background:#333;">
      <div class="container"><p>© 2025 Mi Sitio. Todos los derechos reservados.</p></div>
    </footer>
  `});

  // 🌟 Plantillas
  window.loadTemplate = function(tipo) {
    const templates = {
      empresa: `
        <header class="bg-primary text-white text-center py-5">
          <h1>Mi Empresa Profesional</h1>
          <p>Innovación y tecnología para tu negocio</p>
        </header>
        <section class="py-5 text-center">
          <div class="container">
            <h2>Nuestros Servicios</h2>
            <div class="row mt-4">
              <div class="col-md-4"><h5>Consultoría</h5><p>Asesoría personalizada.</p></div>
              <div class="col-md-4"><h5>Desarrollo Web</h5><p>Sitios modernos y rápidos.</p></div>
              <div class="col-md-4"><h5>Soporte Técnico</h5><p>Atención 24/7.</p></div>
            </div>
          </div>
        </section>
        <footer class="bg-dark text-white text-center py-3">
          <p>© 2025 Empresa XYZ</p>
        </footer>
      `,
      restaurante: `
        <header class="bg-danger text-white text-center py-5">
          <h1>Restaurante Sabor Peruano</h1>
          <p>Tradición y sazón en cada plato</p>
        </header>
        <section class="py-5 bg-light text-center">
          <div class="container">
            <h2>Platos Destacados</h2>
            <div class="row mt-4">
              <div class="col-md-4"><img src="https://via.placeholder.com/200" class="img-fluid rounded mb-2"><h5>Ceviche</h5></div>
              <div class="col-md-4"><img src="https://via.placeholder.com/200" class="img-fluid rounded mb-2"><h5>Lomo Saltado</h5></div>
              <div class="col-md-4"><img src="https://via.placeholder.com/200" class="img-fluid rounded mb-2"><h5>Ají de Gallina</h5></div>
            </div>
          </div>
        </section>
        <footer class="bg-dark text-white text-center py-3">
          <p>© 2025 Restaurante Sabor Peruano</p>
        </footer>
      `,
      portafolio: `
        <header class="bg-secondary text-white text-center py-5">
          <h1>Portafolio de Diseñador</h1>
          <p>Proyectos recientes y creativos</p>
        </header>
        <section class="py-5 bg-white">
          <div class="container">
            <h2 class="text-center">Mis Trabajos</h2>
            <div class="row mt-4">
              <div class="col-md-4"><img src="https://via.placeholder.com/300x200" class="img-fluid rounded mb-2"><h6>Proyecto 1</h6></div>
              <div class="col-md-4"><img src="https://via.placeholder.com/300x200" class="img-fluid rounded mb-2"><h6>Proyecto 2</h6></div>
              <div class="col-md-4"><img src="https://via.placeholder.com/300x200" class="img-fluid rounded mb-2"><h6>Proyecto 3</h6></div>
            </div>
          </div>
        </section>
        <footer class="bg-dark text-white text-center py-3">
          <p>© 2025 Portafolio Creativo</p>
        </footer>
      `
    };
    editor.setComponents(templates[tipo]);
  };

  // 🧩 Guardado
  const modal = document.getElementById('save-modal');
  document.getElementById('save-btn').addEventListener('click', ()=> modal.style.display='flex');
  document.getElementById('modal-cancel').addEventListener('click', ()=> modal.style.display='none');
  document.getElementById('modal-confirm').addEventListener('click', ()=> {
    modal.style.display='none';
    const html = editor.getHtml() + "<style>" + editor.getCss() + "</style>";
    document.getElementById('input-html').value = html;
    document.getElementById('editor-form').submit();
    const toast=document.getElementById('toast');
    toast.style.display='block';
    setTimeout(()=>toast.style.display='none',2500);
  });
});
</script>

</body>
</html>
