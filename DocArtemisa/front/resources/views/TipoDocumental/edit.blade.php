@extends('layouts.base')

@section('content')
<div class="container mt-4">
  <h2>Editar Tipo Documental</h2>

  <form>
    <div class="mb-3">
      <label class="form-label">Código</label>
      <input type="text" class="form-control" value="{{ $tipoDocumental['codigo'] }}" readonly>
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <input type="text" class="form-control" value="{{ $tipoDocumental['descripcion'] }}">
    </div>

    <div class="mb-3">
      <label class="form-label">Término</label>
      <input type="number" class="form-control" value="{{ $tipoDocumental['termino'] }}">
    </div>

    <div class="mb-3">
      <label class="form-label">Numeración</label>
      <select class="form-select">
        <option {{ $tipoDocumental['numeracion'] === 'Sí' ? 'selected' : '' }}>Sí</option>
        <option {{ $tipoDocumental['numeracion'] === 'No' ? 'selected' : '' }}>No</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Radicación</label>
      <select class="form-select">
        <option {{ $tipoDocumental['radicacion'] === 'Sí' ? 'selected' : '' }}>Sí</option>
        <option {{ $tipoDocumental['radicacion'] === 'No' ? 'selected' : '' }}>No</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select class="form-select">
        <option {{ $tipoDocumental['estado'] === 'registrado' ? 'selected' : '' }}>registrado</option>
        <option {{ $tipoDocumental['estado'] === 'inactivo' ? 'selected' : '' }}>inactivo</option>
      </select>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
  </form>
</div>
@endsection
