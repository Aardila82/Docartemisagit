@extends('layouts.base')

@section('content')
    <h1>Editar Tipo Documental</h1>

    <form action="{{ route('tipos-documentales.update', $tipoDocumental['ID']) }}" method="POST"> {{-- Aquí por ahora no hay acción --}}
        @csrf
        @method('PUT')

        <div class="mb-3">
        <label>Código</label>
        <input type="text" name="SGD_TPR_CODIGO" class="form-control" value="{{ $tipoDocumental['SGD_TPR_CODIGO'] }}" required>
    </div>

    <div class="mb-3">
        <label>Descripción</label>
        <input type="text" name="SGD_TPR_DESCRIP" class="form-control" value="{{ $tipoDocumental['SGD_TPR_DESCRIP'] }}" required>
    </div>

    <div class="mb-3">
        <label>Término</label>
        <input type="number" name="SGD_TPR_TERMINO" class="form-control" value="{{ $tipoDocumental['SGD_TPR_TERMINO'] }}" required>
    </div>

    <div class="mb-3">
        <label>¿Numeración?</label>
        <select name="SGD_TPR_NUMERA" class="form-select" required>
            <option value="S" @if($tipoDocumental['SGD_TPR_NUMERA'] == 'S') selected @endif>Sí</option>
            <option value="N" @if($tipoDocumental['SGD_TPR_NUMERA'] == 'N') selected @endif>No</option>
        </select>
    </div>

    <div class="mb-3">
        <label>¿Radicación?</label>
        <select name="SGD_TPR_RADICA" class="form-select" required>
            <option value="S" @if($tipoDocumental['SGD_TPR_RADICA'] == 'S') selected @endif>Sí</option>
            <option value="N" @if($tipoDocumental['SGD_TPR_RADICA'] == 'N') selected @endif>No</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Estado</label>
        <select name="estado_id" class="form-select" required>
            @foreach($estados as $key => $estado)
                <option value="{{ $key }}" @if($tipoDocumental['estado_id'] == $key) selected @endif>{{ $estado }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@endsection
