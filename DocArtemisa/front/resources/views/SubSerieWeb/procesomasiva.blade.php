@extends('layouts.base')

@section('content')
<div class="container-fluid">
    <h1></h1>Procesamiento de Archivo CSV</h1>

    <p>{{ $mensaje }}</p>
    @if(!empty($errors))
        <h3>Errores encontrados:</h3>
        <table id="tablaSeries" class="table bg-white text-dark">
            <thead>
                <tr>
                    <th>Fila CSV</th>
                    <th>Código Serie</th>
                    <th>Descripción Serie</th>

                    <th>Código SubSerie</th>
                    <th>Descripción SubSerie</th>
                    <th>Mensaje de Error</th>
                </tr>
            </thead>
            <tbody>
            @foreach($errors as $error)
                    <tr>
                        
                        <td>{{ $error->row_number ?? 'N/A' }}</td>
                        <td>{{ $error->row_data[0] ?? 'N/A' }}</td>
                        <td>{{ $error->row_data[1] ?? 'N/A' }}</td>
                        <td>{{ $error->row_data[2] ?? 'N/A' }}</td>
                        <td>{{ $error->row_data[3] ?? 'N/A' }}</td>

                        <td>
                            @if(isset($error->errors) && !empty($error->errors))
                                {{-- Obtener todos los mensajes de error --}}
                                @foreach((array) $error->errors as $mensaje)
                                    {{ print_r( $mensaje , true)}}<br>
                                @endforeach
                            @else
                                Sin mensaje
                            @endif
                        </td>
                    </tr>
            @endforeach
        </table>
    @endif   
</div>                   
@endsection