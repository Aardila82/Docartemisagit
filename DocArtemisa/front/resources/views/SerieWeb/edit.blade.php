@extends('layouts.base')

@section('content')
<div class="container text-white">
    <h2>Editar Serie</h2>

    <form action="{{ route('SerieWeb.update', $serie->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="number" class="form-control" id="codigo" name="codigo" value="{{ $serie->codigo }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $serie->descripcion }}" required>
        </div>

        <div class="mb-3">
            <label for="fechainicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control" id="fechainicio" name="fechainicio" value="{{ $serie->fechainicio }}" required>
        </div>

        <div class="mb-3">
            <label for="fechafin" class="form-label">Fecha Fin</label>
            <input type="date" class="form-control" id="fechafin" name="fechafin" value="{{ $serie->fechafin }}" required>
        </div>

        <div class="mb-3">
            <label for="estado_id" class="form-label">Estado</label>
            <select class="form-control" id="estado_id" name="estado_id">
                <option value="">Seleccione</option>
                <option value="1" {{ $serie->estado_id == 1 ? 'selected' : '' }}>Activo</option>
                <option value="2" {{ $serie->estado_id == 2 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('SerieWeb.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
