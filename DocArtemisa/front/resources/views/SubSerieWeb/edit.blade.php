@extends('layouts.base')

@section('content')
<div class="container text-black">
    <h2>Editar Subserie</h2>

    <form action="{{ route('SubSerieWeb.update', $subSerie->id) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        <!-- Campos principales -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="id_codigo_serie" class="form-label">Código de Serie</label>
                <input type="text" name="id_codigo_serie" id="id_codigo_serie"
                       class="form-control @error('id_codigo_serie') is-invalid @enderror"
                       value="{{ old('id_codigo_serie', $subSerie->id_codigo_serie) }}" required>
                @error('id_codigo_serie')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="codigo_subserie" class="form-label">Código de Subserie</label>
                <input type="text" name="codigo_subserie" id="codigo_subserie"
                       class="form-control @error('codigo_subserie') is-invalid @enderror"
                       value="{{ old('codigo_subserie', $subSerie->codigo_subserie) }}" required>
                @error('codigo_subserie')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="version" class="form-label">Versión</label>
                <input type="text" name="version" id="version"
                       class="form-control @error('version') is-invalid @enderror"
                       value="{{ old('version', $subSerie->version) }}" required>
                @error('version')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $subSerie->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Fechas -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio"
                       class="form-control @error('fecha_inicio') is-invalid @enderror"
                       value="{{ old('fecha_inicio', $subSerie->fecha_inicio) }}" required>
                @error('fecha_inicio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="fecha_final" class="form-label">Fecha Final</label>
                <input type="date" name="fecha_final" id="fecha_final"
                       class="form-control @error('fecha_final') is-invalid @enderror"
                       value="{{ old('fecha_final', $subSerie->fecha_final) }}" required>
                @error('fecha_final')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Opciones de gestión documental -->
        <div class="row g-3 mb-4">
    <div class="col-md-3">
        <input type="hidden" name="archivo_gestion" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="archivo_gestion" id="archivo_gestion"
                   value="1" {{ old('archivo_gestion', $subSerie->archivo_gestion) ? 'checked' : '' }}>
            <label class="form-check-label" for="archivo_gestion">Archivo de Gestión</label>
        </div>
    </div>
    <div class="col-md-3">
        <input type="hidden" name="archivo_central" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="archivo_central" id="archivo_central"
                   value="1" {{ old('archivo_central', $subSerie->archivo_central) ? 'checked' : '' }}>
            <label class="form-check-label" for="archivo_central">Archivo Central</label>
        </div>
    </div>
    <div class="col-md-3">
        <input type="hidden" name="conservacion_total" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="conservacion_total" id="conservacion_total"
                   value="1" {{ old('conservacion_total', $subSerie->conservacion_total) ? 'checked' : '' }}>
            <label class="form-check-label" for="conservacion_total">Conservación Total</label>
        </div>
    </div>
    <div class="col-md-3">
        <input type="hidden" name="eliminacion" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="eliminacion" id="eliminacion"
                   value="1" {{ old('eliminacion', $subSerie->eliminacion) ? 'checked' : '' }}>
            <label class="form-check-label" for="eliminacion">Eliminación</label>
        </div>
    </div>
</div>

<!-- Más opciones -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <input type="hidden" name="microfilmacion" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="microfilmacion" id="microfilmacion"
                   value="1" {{ old('microfilmacion', $subSerie->microfilmacion) ? 'checked' : '' }}>
            <label class="form-check-label" for="microfilmacion">Microfilmación</label>
        </div>
    </div>
    <div class="col-md-3">
        <input type="hidden" name="seleccion" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="seleccion" id="seleccion"
                   value="1" {{ old('seleccion', $subSerie->seleccion) ? 'checked' : '' }}>
            <label class="form-check-label" for="seleccion">Selección</label>
        </div>
    </div>
</div>


        <!-- Procedimiento -->
        <div class="mb-3">
            <label for="procedimiento" class="form-label">Procedimiento</label>
            <textarea name="procedimiento" id="procedimiento" rows="3"
                      class="form-control @error('procedimiento') is-invalid @enderror">{{ old('procedimiento', $subSerie->procedimiento) }}</textarea>
            @error('procedimiento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label for="estado_id" class="form-label">Estado</label>
            <select name="estado_id" id="estado_id" class="form-select @error('estado_id') is-invalid @enderror" required>
                <option value="">Seleccione un estado</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado['id'] }}" {{ old('estado_id', $subSerie->estado_id) == $estado['id'] ? 'selected' : '' }}>
                        {{ $estado['nombre'] }}
                    </option>
                @endforeach
            </select>
            @error('estado_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('SubSerieWeb.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar Subserie</button>
        </div>
    </form>
</div>

<script>
// Validación de Bootstrap
(() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})();
</script>
@endsection
