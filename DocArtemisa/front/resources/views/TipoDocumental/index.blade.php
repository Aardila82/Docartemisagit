@extends('layouts.base')

@section('content')
<div class="container mt-4">
  <h1>Listado de Tipos Documentales</h1>

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
      <form>
        <div class="modal-header">
          <h5 class="modal-title" id="modalTipoDocumentalLabel">Nuevo Tipo Documental</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" required>
          </div>

          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
          </div>

          <div class="mb-3">
            <label for="termino" class="form-label">Término (número)</label>
            <input type="number" class="form-control" id="termino" name="termino">
          </div>

          <div class="mb-3">
            <label for="numeracion" class="form-label">¿Numeración?</label>
            <select class="form-select" id="numeracion" name="numeracion">
              <option value="Si">Sí</option>
              <option value="No">No</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="radicacion" class="form-label">¿Radicación?</label>
            <select class="form-select" id="radicacion" name="radicacion">
              <option value="Si">Sí</option>
              <option value="No">No</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado">
              <option value="registrado">Registrado</option>
              <option value="inactivo">Inactivo</option>
            </select>
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
</div>

<table id="tablaTiposDocumentales" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Código</th>
      <th>Descripción</th>
      <th>Término</th>
      <th>Numeración</th>
      <th>Radicación</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>001</td>
      <td>Actas de reunión</td>
      <td>12</td>
      <td>Sí</td>
      <td>No</td>
      <td>registrado</td>
      <td>
        <button class="btn btn-sm btn-warning" title="Editar">
          <i class="bi bi-pencil-square"></i>
        </button>
        <button class="btn btn-sm btn-danger" title="Eliminar">
          <i class="bi bi-trash-fill"></i>
        </button>
      </td>
    </tr>
    <tr>
      <td>002</td>
      <td>Contratos</td>
      <td>60</td>
      <td>No</td>
      <td>Sí</td>
      <td>inactivo</td>
      <td>
        <button class="btn btn-sm btn-warning" title="Editar">
          <i class="bi bi-pencil-square"></i>
        </button>
        <button class="btn btn-sm btn-danger" title="Eliminar">
          <i class="bi bi-trash-fill"></i>
        </button>
      </td>
    </tr>
    <tr>
      <td>003</td>
      <td>Correspondencia</td>
      <td>24</td>
      <td>Sí</td>
      <td>Sí</td>
      <td>registrado</td>
      <td>
        <a href="{{ route('tipoDocumental.edit', ['codigo' => '001']) }}" class="btn btn-sm btn-warning" title="Editar">
            <i class="bi bi-pencil-square"></i>
        </a>
        <button class="btn btn-sm btn-danger" title="Eliminar">
          <i class="bi bi-trash-fill"></i>
        </button>
      </td>
    </tr>
  </tbody>
</table>


@endsection

@section('scripts')
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
