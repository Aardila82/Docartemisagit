@extends('layouts.base')

@section('content')
<div class="container">
  <h1>Listado de Series</h1>

  <!-- Botón para abrir el modal -->
  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalSerie">
    Agregar Serie
  </button>

  {{-- <a href="{{ route('SerieWeb.masiva') }}" class="btn btn-warning mb-3">Masiva</a> --}}

  @if(session()->has('success'))
  <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
    {{ session('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  @if(session('error'))
  <div class="alert alert-danger">
    {{ session('message') }}
  </div>
  @endif

  @if($errors->any())
  <div class="alert alert-warning">
    <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if(empty($series))
  <div class="alert alert-warning">
    No se tienen datos.
  </div>
  @else
  <table id="tablaSeries" class="table bg-white text-dark">
    <thead>
      <tr>
        <th>Id Versión</th>
        <th>Código</th>
        <th>Descripción</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($series as $serie)
      <tr class="{{ $serie->estado_id == 2 ? 'text-danger font-weight-bolder' : '' }}">
        <td>{{ $serie->idversion }}</td>
        <td>{{ $serie->codigo }}</td>
        <td>{{ $serie->descripcion }}</td>
        <td>{{ $serie->fechainicio }}</td>
        <td>{{ $serie->fechafin }}</td>
        <td>
          @if($serie->estado_id != 2)
          <a href="{{ route('SerieWeb.edit', $serie->id) }}" class="text-dark me-2">
            <i class="fas fa-edit"></i>
          </a>
          @endif

          @if($serie->estado_id != 2)
          <a href="#" class="text-dark" title="Eliminar"
            onclick="confirmarEliminacion({{ $serie->id }})">
            <i class="bi bi-trash-fill"></i>
          </a>
          @endif

          <form id="delete-serie-{{ $serie->id }}" action="{{ route('SerieWeb.destroy', $serie->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
          </form>

        </td>
      </tr>

      @endforeach
    </tbody>
  </table>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if(session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: "{{ session('error') }}",
      confirmButtonColor: '#d33'
    });
  </script>
  @endif

  @if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Éxito',
      text: "{{ session('success') }}",
      confirmButtonColor: '#3085d6'
    });
  </script>
  @endif

  @endif
  <!-- Modal -->
  <!-- Modal -->
  <div class="modal fade" id="modalSerie" tabindex="-1" aria-labelledby="modalSerieLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSerieLabel">Agregar Nueva Serie</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <form action="{{ route('SerieWeb.store') }}" method="POST">
          @csrf

          <div class="modal-body">
            <!-- <div class="mb-3">
            <label for="idversion" class="form-label">Id Versión</label>
            <input type="number" class="form-control" id="idversion" name="idversion" required>
          </div> -->

            <div class="mb-3">
              <label for="codigo" class="form-label">Código</label>
              <input type="number" class="form-control" id="codigo" name="codigo" required>
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción</label>
              <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>

            <div class="mb-3">
              <label for="fechainicio" class="form-label">Fecha inicio</label>
              <input type="date" class="form-control" id="fechainicio" name="fechainicio" required>
            </div>

            <div class="mb-3">
              <label for="fechafin" class="form-label">Fecha fin</label>
              <input type="date" class="form-control" id="fechafin" name="fechafin" required>
            </div>

            {{-- <div class="mb-3">
              <label for="estado_id" class="form-label">Estado (opcional)</label>
              <select class="form-control" id="estado_id" name="estado_id">
                <option value="">Seleccione</option>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
              </select>
            </div> --}}
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script>
    $(document).ready(function() {
      $('#tablaSeries').DataTable({
        language: {
          url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
      });
    });

    function confirmarEliminacion(id) {
      Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-serie-' + id).submit();
        }
      });
    }
  </script>

  @if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Éxito',
      text: "{{ session('success') }}", // Aquí se imprime el mensaje de la clave 'success'
      confirmButtonColor: '#3085d6'
    });
  </script>
  @endif

  @if(session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: "{{ session('error') }}", // Aquí se imprime el mensaje de la clave 'error'
      confirmButtonColor: '#d33'
    });
  </script>
  @endif
  @endsection