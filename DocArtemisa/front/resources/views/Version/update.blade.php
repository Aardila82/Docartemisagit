@extends('layouts.base')

@section('content')


<div class="row">

@if ($errors->any())
    <div class="alert alert-danger mt-2">
        <strong>Error para el registro de informacion</strong> Algo fue mal..<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="col-12">
        <div>
            <h2>Actualizar Version TRD {{$versionTrd->descripcion}}</h2>
        </div>
        <div>
            <a href="{{route('versionTrd.index')}}" class="btn btn-primary">Volver</a>
        </div>
    </div>

    <form action="{{route('versionTrd.update',$versionTrd)}}" method="POST">
        @csrf <!-- token de seguridad -->
        @method('PUT')
        <div class="row">
            <div class="col-xs-5 col-sm-5 col-md-5 mt-2">
                <div class="form-group">
                    <strong>Version:</strong>
                    <input type="text" name="descripcion" class="form-control" placeholder="N&uacute;mero acta" value="{{$versionTrd->descripcion}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Fecha inicio:</strong>
                    <input type="date" name="fechainicio" class="form-control" id="">
                    <!--script>
                        $('#fechainicio').val({{$versionTrd->fechainicio}});
                    </script-->
                </div>
                <div class="form-group">
                    <strong>Fecha final:</strong>
                    <input type="date" name="fechafin" class="form-control" value="{{$versionTrd->fechafin}}" id="">
                </div>

                <div class="form-group">
                    <strong>Estado (inicial):</strong>
                    <select name="estado" class="form-select" id="">
                        <option value="Registrado" @selected("Regsitrado"==$versionTrd->estado)>Registrado</option>
                        <option value="Activo" @selected("Activo"==$versionTrd->estado)>Activo</option>
                        <option value="Inactivo" @selected("Inactivo"==$versionTrd->estado)>Inactivo</option>
                    </select>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection