@extends('layouts.app')

@section('content')
<div id="grapesjs-editor-container" style="height:100vh; width:100%; overflow:hidden;">

  <!-- PANEL SUPERIOR -->
  <div id="panel-top" style="background:#343a40;color:white;padding:8px;display:flex;justify-content:space-between;align-items:center;">
    <div>
      <button id="btn-undo">↩️</button>
      <button id="btn-redo">↪️</button>
      <button id="btn-clear">🧹</button>
      <button id="btn-preview">👁️</button>
    </div>
    <div>
      <button id="save-btn">💾 Guardar</button>
    </div>
  </div>

  <!-- CONTENEDOR PRINCIPAL -->
  <div id="editor-wrapper" style="display:flex; height:calc(100vh - 50px); width:100%;">
    <!-- BLOQUES -->
    <div id="blocks" style="width:230px; background:#f0f0f0; border-right:1px solid #ccc; overflow-y:auto;"></div>

    <!-- CANVAS -->
    <div id="gjs" style="flex:1; background:white;"></div>

    <!-- PANEL DERECHO -->
    <div id="panel-right" style="width:320px;background:#f8f9fa;border-left:1px solid #ccc;display:flex;flex-direction:column;">
      <div class="tabs" style="display:flex;background:#e9ecef;border-bottom:1px solid #ccc;">
        <button id="btn-layers" class="active" style="flex:1;padding:8px;border:none;background:#fff;font-weight:bold;">Capas</button>
        <button id="btn-styles" style="flex:1;padding:8px;border:none;background:none;cursor:pointer;font-weight:bold;">Estilos</button>
        <button id="btn-traits" style="flex:1;padding:8px;border:none;background:none;cursor:pointer;font-weight:bold;">Atributos</button>
      </div>

      <div id="layers-container" class="tab-content" style="flex:1;overflow:auto;padding:5px;"></div>
      <div id="styles-container" class="tab-content" style="flex:1;overflow:auto;padding:5px;display:none;"></div>
      <div id="traits-container" class="tab-content" style="flex:1;overflow:auto;padding:5px;display:none;"></div>
    </div>
  </div>

  <!-- MODAL GUARDADO -->
  <div id="save-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);justify-content:center;align-items:center;z-index:9999;">
    <div style="background:white;padding:20px;border-radius:6px;">
      <p>¿Deseas guardar los cambios?</p>
      <button id="modal-confirm">Sí, guardar</button>
      <button id="modal-cancel">Cancelar</button>
    </div>
  </div>

  <!-- TOAST -->
  <div id="toast" style="display:none;position:fixed;bottom:20px;right:20px;background:#28a745;color:white;padding:10px 20px;border-radius:6px;z-index:9999;">
    ✅ Guardado correctamente
  </div>

  <form id="editor-form" method="POST" action="{{ route('editar_home_post') }}" style="display:none;">
    @csrf
    <input type="hidden" name="contenido_html" id="input-html">
  </form>
</div>

<!-- === LIBRERÍAS GRAPESJS === -->
<script src="https://unpkg.com/grapesjs@0.21.4/dist/grapes.min.js"></script>
<script src="https://unpkg.com/grapesjs-blocks-basic"></script>
<script src="https://unpkg.com/grapesjs-plugin-forms"></script>
<script src="https://unpkg.com/grapesjs-plugin-export"></script>
<script src="https://unpkg.com/grapesjs-preset-webpage"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  // ==== RECUPERAR CONTENIDO GUARDADO ====
  const savedHtmlContent = @json($pagina->contenido_html ?? '');
  let htmlPart = savedHtmlContent || '';
  let cssPart = '';

  const styleMatch = htmlPart.match(/<style[^>]*>([\s\S]*?)<\/style>/i);
  if (styleMatch) {
    cssPart = styleMatch[1];
    htmlPart = htmlPart.replace(styleMatch[0], '');
  }
  htmlPart = htmlPart.replace(/<\/?body[^>]*>/gi, '').trim();

  // ==== INICIALIZAR EDITOR ====
  const editor = grapesjs.init({
    container: '#gjs',
    height: '100%',
    fromElement: false,
    storageManager: false,
    blockManager: { appendTo: '#blocks' },
    layerManager: { appendTo: '#layers-container' },
    styleManager: { appendTo: '#styles-container' },
    traitManager: { appendTo: '#traits-container' },
    canvas: {
      styles: [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'
      ]
    },
    plugins: [
      'gjs-blocks-basic',
      'grapesjs-plugin-forms',
      'grapesjs-plugin-export',
      'grapesjs-preset-webpage'
    ],
    pluginsOpts: {
      'gjs-blocks-basic': { flexGrid: true },
      'grapesjs-preset-webpage': { modalImportTitle: 'Importar HTML/CSS' }
    }
  });

  // Cargar contenido
  if (htmlPart.trim() !== '') {
    editor.setComponents(htmlPart);
    editor.setStyle(cssPart);
  }

  // ==== BOTONES ====
  document.getElementById('btn-undo').onclick = () => editor.runCommand('core:undo');
  document.getElementById('btn-redo').onclick = () => editor.runCommand('core:redo');
  document.getElementById('btn-clear').onclick = () => {
    if (confirm('¿Seguro que deseas limpiar el lienzo?')) editor.DomComponents.clear();
  };
  document.getElementById('btn-preview').onclick = () => editor.runCommand('preview');

  // ==== GUARDADO ====
  const modal = document.getElementById('save-modal');
  const toast = document.getElementById('toast');
  document.getElementById('save-btn').onclick = () => modal.style.display = 'flex';
  document.getElementById('modal-cancel').onclick = () => modal.style.display = 'none';
  document.getElementById('modal-confirm').onclick = () => {
    modal.style.display = 'none';
    const html = editor.getHtml() + "<style>" + editor.getCss() + "</style>";
    document.getElementById('input-html').value = html;
    document.getElementById('editor-form').submit();
    toast.style.display = 'block';
    setTimeout(() => toast.style.display = 'none', 2500);
  };

  // ==== PANEL DERECHO ====
  const tabs = {
    'btn-layers': 'layers-container',
    'btn-styles': 'styles-container',
    'btn-traits': 'traits-container'
  };
  Object.keys(tabs).forEach(id => {
    document.getElementById(id).addEventListener('click', e => {
      Object.keys(tabs).forEach(k => {
        document.getElementById(k).classList.remove('active');
        document.getElementById(tabs[k]).style.display = 'none';
      });
      e.target.classList.add('active');
      document.getElementById(tabs[id]).style.display = 'block';
    });
  });
});
</script>
@endsection
