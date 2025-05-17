@extends('layouts.base')

@section('content')
<div class="row">

@if (Session::get('success'))
    <div class="alert alert-success mt-2">
        <strong> {{Session::get('success')}}</strong>
    </div>
@endif
    <div class="col-12">
        <div>
            <h2 class="text-white">Version Series</h2>
        </div>
        <div>
            <a href="{{route('serieTrd.create')}}" class="btn btn-primary">Registra Serie</a>
        </div>
    </div>

    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <tr class="text-secondary" align="center">
                <th>Versi&oacute;n No</th>
                <th>codigo</th>
                <th>Descripci&oacute;n</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin </th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            @foreach ($seriesTrd as $version)
            <tr>
                <td>{{$version->idversion}}</td>
                <td>{{$version->codigo}}</td>
                <td>{{$version->descripcion}}</td>
                <td>{{$version->fechainicio}}</td>
                <td>{{$version->fechafin}}</td>
                <td><span>{{$version->estado}}</span>
                </td>
                <td>
                    @if($version->estado == 'Activo' || $version->estado == 'Registrado'|| $version->estado == 'registrado')  
                        <a href="{{route('serieTrd.edit',$version->id)}}" class="btn btn-warning">Editar</a>    
                    @endif
                    
                </td>
            </tr>

            @endforeach
        </table>
        {{$seriesTrd->links()}}
    </div>
</div>
@endsection