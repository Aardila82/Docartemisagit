@extends('layouts.base')

@section('content')
<div>
  <h1>Listado de Sub Series</h1>

  <!-- Botón para abrir el modal -->
  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalSubserie">
    Agregar Sub Serie
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

  @if(empty($subSeries))
  <div class="alert alert-warning">
    No se tienen datos.
  </div>
  @else
  <table id="tablaSeries" class="table bg-white text-dark">
    <thead>
      <tr>
        <th>Versión</th>
        <th>Serie</th>
        <th>Código Subserie</th>
        <th>Descripción</th>
        <th>Fecha Inicio</th>
        <th>Fecha Final</th>
        <th>Archivo Gestión</th>
        <th>Archivo Central</th>
        <th>Conservación Total</th>
        <th>Eliminación</th>
        <th>Microfilmación</th>
        <th>Selección</th>
        <th>Procedimiento</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($subSeries as $subSerie)
      <tr class="{{ $subSerie->estado_id == 2 ? 'text-danger font-weight-bolder' : '' }}">
        <td>{{ $subSerie->version }}</td>
        <td>{{ $subSerie->serie_version->descripcion }} - {{ $subSerie->serie_version->codigo }}</td>
        <td>{{ $subSerie->codigo_subserie }}</td>
        <td>{{ $subSerie->descripcion }}</td>
        <td>{{ $subSerie->fecha_inicio }}</td>
        <td>{{ $subSerie->fecha_final }}</td>
        <td>{{ $subSerie->archivo_gestion ? 'Sí' : 'No' }}</td>
        <td>{{ $subSerie->archivo_central ? 'Sí' : 'No' }}</td>
        <td>{{ $subSerie->conservacion_total ? 'Sí' : 'No' }}</td>
        <td>{{ $subSerie->eliminacion ? 'Sí' : 'No' }}</td>
        <td>{{ $subSerie->microfilmacion ? 'Sí' : 'No' }}</td>
        <td>{{ $subSerie->seleccion ? 'Sí' : 'No' }}</td>
        <td>{{ $subSerie->procedimiento }}</td>
        <td>{{ $subSerie->estado->nombre }}</td>

        <td>
          @if($subSerie->estado_id != 2)
          <a href="{{ route('SerieWeb.edit', $subSerie->id) }}" class="text-dark me-2">
            <i class="fas fa-edit"></i>
          </a>
          @endif

          @if($subSerie->estado_id != 2)
          <a href="#" class="text-dark" title="Eliminar"
            onclick="confirmarEliminacion({{ $subSerie->id }})">
            <i class="bi bi-trash-fill"></i>
          </a>
          @endif

          <form id="delete-serie-{{ $subSerie->id }}" action="{{ route('SubSerieWeb.destroy', $subSerie->id) }}" method="POST" style="display: none;">
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

  <div class="modal fade" id="modalSubserie" tabindex="-1" aria-labelledby="modalSubserieLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSubserieLabel">Agregar Nueva Subserie</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <form action="{{ route('SubSerieWeb.store') }}" method="POST">
          @csrf

          <div class="modal-body row">
            <div class="col-md-6 mb-3">
              <label for="id_codigo_serie" class="form-label">Serie</label>
              <select class="form-select" id="id_codigo_serie" name="id_codigo_serie" required>
                <option value="">Seleccione una serie</option>
                @foreach ($series as $serie)
                <option value="{{ $serie->id }}">{{ $serie->codigo }} - {{ $serie->descripcion }}</option>
                @endforeach
              </select>
            </div>


            <div class="col-md-6 mb-3">
              <label for="codigo_subserie" class="form-label">Código Subserie</label>
              <input type="number" class="form-control" id="codigo_subserie" name="codigo_subserie" required>
            </div>

            <div class="col-12 mb-3">
              <label for="descripcion" class="form-label">Descripción</label>
              <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="fecha_inicio" class="form-label">Fecha inicio</label>
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="fecha_final" class="form-label">Fecha fin</label>
              <input type="date" class="form-control" id="fecha_final" name="fecha_final" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="archivo_gestion" class="form-label">Archivo Gestión</label>
              <select class="form-control" name="archivo_gestion" id="archivo_gestion" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="archivo_central" class="form-label">Archivo Central</label>
              <select class="form-control" name="archivo_central" id="archivo_central" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="conservacion_total" class="form-label">Conservación Total</label>
              <select class="form-control" name="conservacion_total" id="conservacion_total">
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="eliminacion" class="form-label">Eliminación</label>
              <select class="form-control" name="eliminacion" id="eliminacion">
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="microfilmacion" class="form-label">Microfilmación</label>
              <select class="form-control" name="microfilmacion" id="microfilmacion">
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="seleccion" class="form-label">Selección</label>
              <select class="form-control" name="seleccion" id="seleccion">
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>

            <div class="col-12 mb-3">
              <label for="procedimiento" class="form-label">Procedimiento</label>
              <textarea class="form-control" id="procedimiento" name="procedimiento" rows="3"></textarea>
            </div>

            <div class="col-md-6 mb-3">
              <label for="version" class="form-label">Versión</label>
              <input type="number" class="form-control" id="version" name="version">
            </div>
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