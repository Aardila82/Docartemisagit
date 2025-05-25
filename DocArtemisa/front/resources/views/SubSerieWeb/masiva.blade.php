@extends('layouts.base')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-3">Vista Masiva - Series CSV</h2>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('SerieWeb.exportar') }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Descargar CSV
                </a>
                
                <div class="file-upload-area">
                <form action="{{ route('SerieWeb.procesarMasiva') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    @csrf

                    <label for="csv_file" class="btn btn-primary mb-0">
                        <i class="bi bi-upload"></i> Subir CSV
                        <input type="file" name="csv_file" id="csv_file" accept=".csv" class="d-none" required>
                    </label>

                    <span id="file-name" class="text-muted">Ningún archivo seleccionado</span>

                    <button type="submit" class="btn btn-success" id="submit-btn" disabled>
                        <i class="bi bi-check-circle"></i> Procesar
                    </button>
                </form>

                </div>
            </div>
            
            @if(!empty($csvData))
            <div>
                <table id="tablaSeries" class="table bg-white text-dark">
                    <thead>
                        <tr>
                            @foreach($csvData[0] as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(array_slice($csvData, 1) as $fila)
                            <tr>
                                @foreach($fila as $celda)
                                    <td>{{ $celda }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                No hay datos CSV para mostrar. Sube un archivo CSV para comenzar.
            </div>
            @endif
        </div>
    </div>
</div>

@endsection