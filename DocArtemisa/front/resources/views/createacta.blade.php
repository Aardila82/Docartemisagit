@extends('layouts.base')

@section('content')


<div class="row">

@if ($errors->any())
    <div class="alert alert-danger mt-2">
        <strong>Error para el registr de infroamcion</strong> Algo fue mal..<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="col-12">
        <div>
            <h2>Crear Acta</h2>
        </div>
        <div>
            <a href="{{route('acta.index')}}" class="btn btn-primary">Volver</a>
        </div>
    </div>

    <form action="{{route('acta.store')}}" method="POST">
        @csrf <!--token de seguridad -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Acta:</strong>
                    <input type="text" name="title" class="form-control" placeholder="N&uacute;mero acta" >
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Descripción / nombre Acta:</strong>
                    <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripci&oacute;n..."></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Fecha límite:</strong>
                    <input type="date" name="fecha" class="form-control" id="">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Estado (inicial):</strong>
                    <select name="estado" class="form-select" id="">
                        <option value="">-- Elige el status --</option>
                        <option value="Registrado">Registrado</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </div>
    </form>
</div>
@endsection