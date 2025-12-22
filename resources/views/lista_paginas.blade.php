<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Páginas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container py-5">
    <h1 class="mb-4 text-primary">📄 Páginas editables</h1>

    <a href="{{ route('paginas.create') }}" class="btn btn-success mb-3">➕ Nueva página</a>

    @if ($paginas->isEmpty())
      <div class="alert alert-info">
        No hay páginas creadas todavía.
      </div>
    @else
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Título</th>
            <th>Slug</th>
            <th>Creado</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($paginas as $pagina)
            <tr>
              <td>{{ $pagina->id }}</td>
              <td>{{ $pagina->nombre }}</td>
              <td>{{ $pagina->titulo }}</td>
              <td>{{ $pagina->slug }}</td>
              <td>{{ $pagina->created_at->format('Y-m-d') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

</body>
</html>
