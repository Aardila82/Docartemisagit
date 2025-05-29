@extends('layouts.base')


@section('content')
    <h1>Tipos Documentales</h1>

    <!-- Botón para abrir el modal -->
  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTipoDocumental">
    Agregar Tipo Documental
  </button>

  <!-- Modal -->
  <!-- Modal con formulario -->
<div class="modal fade" id="modalTipoDocumental" tabindex="-1" aria-labelledby="modalTipoDocumentalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Formulario al inicio del modal -->
      <form action="{{ route('tipos-documentales.store') }}" method="POST">
  @csrf

  <div class="modal-body">

    <div class="mb-3">
      <label class="form-label">Código</label>
      <input type="text" class="form-control" name="SGD_TPR_CODIGO" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <input type="text" class="form-control" name="SGD_TPR_DESCRIP" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Término</label>
      <input type="number" class="form-control" name="SGD_TPR_TERMINO" required>
    </div>

    <div class="mb-3">
      <label class="form-label">¿Numeración?</label>
      <select class="form-select" name="SGD_TPR_NUMERA">
        <option value="S">Sí</option>
        <option value="N">No</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">¿Radicación?</label>
      <select class="form-select" name="SGD_TPR_RADICA">
        <option value="S">Sí</option>
        <option value="N">No</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select class="form-select" name="estado_id">
        <option value="1">Activo</option>
        <option value="2">Inactivo</option>
        <option value="3">Archivado</option>
      </select>
    </div>

    <!-- Campos requeridos por la API -->
    <input type="hidden" name="SGD_TPR_ESTADO" value="1">
    <input type="hidden" name="idversion" value="1.00">

  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-success">Guardar</button>
  </div>
</form>

    </div>
  </div>
</div>

    <table class="table table-bordered" id="tablaTiposDocumentales" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Término</th>
                <th>Númera</th>
                <th>Radica</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tiposDocumentales as $tipo)
                <tr>
                    <td>{{ $tipo['ID'] }}</td>
                    <td>{{ $tipo['SGD_TPR_CODIGO'] }}</td>
                    <td>{{ $tipo['SGD_TPR_DESCRIP'] }}</td>
                    <td>{{ $tipo['SGD_TPR_TERMINO'] }}</td>
                    <td>{{ $tipo['SGD_TPR_NUMERA'] }}</td>
                    <td>{{ $tipo['SGD_TPR_RADICA'] }}</td>
                    <td>{{ $estados[$tipo['estado_id']] ?? 'Desconocido' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    @if (session('success'))
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#198754'
      });
    @endif

    @if (session('error'))
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#dc3545'
      });
    @endif
  });
</script>

<script>
  $(document).ready(function () {
    $('#tablaTiposDocumentales').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
      }
    });
  });
</script>
@endsection
