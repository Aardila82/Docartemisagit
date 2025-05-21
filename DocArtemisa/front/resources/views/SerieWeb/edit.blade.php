@extends('layouts.base')

@section('content')
<div class="container text-white">
    <h2>Editar Serie</h2>

   <form action="{{ route('SerieWeb.update', $serie->id) }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="idversion" class="form-label">ID Versión</label>
        <input type="number" name="idversion" id="idversion" class="form-control @error('idversion') is-invalid @enderror"
               value="{{ old('idversion', $serie->idversion) }}" required>
        @error('idversion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="codigo" class="form-label">Código</label>
        <input type="number" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror"
               value="{{ old('codigo', $serie->codigo) }}" required>
        @error('codigo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
               value="{{ old('descripcion', $serie->descripcion) }}" required>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="fechainicio" class="form-label">Fecha Inicio</label>
            <input type="date" name="fechainicio" id="fechainicio" class="form-control @error('fechainicio') is-invalid @enderror"
                   value="{{ old('fechainicio', $serie->fechainicio) }}" required>
            @error('fechainicio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="fechafin" class="form-label">Fecha Fin</label>
            <input type="date" name="fechafin" id="fechafin" class="form-control @error('fechafin') is-invalid @enderror"
                   value="{{ old('fechafin', $serie->fechafin) }}" required>
            @error('fechafin')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 mt-3">
        <label for="estado_id" class="form-label">Estado</label>
        <select name="estado_id" id="estado_id" class="form-select @error('estado_id') is-invalid @enderror">
            <option value="">Seleccione un estado</option>
            @foreach($estados as $estado)
                <option value="{{ $estado->id }}" {{ (old('estado_id', $serie->estado_id) == $estado->id) ? 'selected' : '' }}>
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
        @error('estado_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
</div>

<script>
// Ejemplo básico para validación de Bootstrap 5
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
