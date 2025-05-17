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
            <h2 class="text-white">CRUD de INFORMACION Versionamiento TRD</h2>
        </div>
        <div>
            <a href="{{route('acta.create')}}" class="btn btn-primary">Crear Acta</a>
        </div>
    </div>

    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <tr class="text-secondary">
                <th>Acta Nro</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
            @foreach ($actas as $acta)
            <tr>
                <td class="fw-bold">{{$acta->title}}</td>
                <td>{{$acta->descripcion}}</td>
                <td>{{$acta->fecha}}</td>
                <td><span>{{$acta->estado}}</span>
                </td>
                <td>
                   <a href="acta/{{$acta->id}}/edit" class="btn btn-warning">Editar</a> 
                    <form action="" method="post" class="d-inline">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>

            @endforeach
        </table>
        {{$actas->links()}}
    </div>
</div>
@endsection