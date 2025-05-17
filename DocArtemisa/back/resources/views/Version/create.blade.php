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
            <h2>Crear Version</h2>
        </div>
        <div>
            <a href="{{route('versionTrd.index')}}" class="btn btn-primary">Volver</a>
        </div>
    </div>

    <form action="{{route('versionTrd.store')}}" method="POST">
        @csrf <!--token de seguridad -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Versi&oacute;n:</strong>
                    <input type="text" name="descripcion" class="form-control" placeholder="N&uacute;mero version" >
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Fecha Inicio:</strong>
                    <input type="date" name="fechainicio" class="form-control" id="">
                </div>

                <div class="form-group">
                    <strong>Fecha Inicio:</strong>
                    <input type="date" name="fechafin" class="form-control" id="">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Estado:</strong>
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