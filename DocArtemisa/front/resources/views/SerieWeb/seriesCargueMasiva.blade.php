@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Cargue Masivo</h2>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Botón Descargar CSV -->
        <a href="{{ route('SerieWeb.exportar') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Descargar CSV
        </a>

        <!-- Área de subida de archivos -->
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


    <table id="tablaMasiva" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Cantidad de Registros</th>
                <th>Nombre del Archivo</th>
                <th>Nombre de Usuario</th>
                <th>Peso (MB)</th>
                <th>Mensaje de Error</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->cantidad_registros }}</td>
                <td>{{ $item->nombre_archivo }}</td>
                <td>{{ $item->nombre_usuario }}</td>
                <td>{{ number_format($item->peso / 1024, 2) }} MB</td> <!-- Convertir KB a MB -->
                <td>{{ $item->mensaje_error }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<!-- Inicialización de DataTables -->
<script>
    $(document).ready(function() {
        $('#tablaMasiva').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });

        // Exportar a CSV
        $('#descargarCSV').click(function(e) {
            e.preventDefault();

            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Cantidad de Registros,Nombre del Archivo,Nombre de Usuario,Peso (MB)\n";

            $('#tablaMasiva tbody tr').each(function() {
                const row = $(this).find('td').map(function() {
                    return $(this).text().trim();
                }).get().join(",");
                csvContent += row + "\n";
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "cargue_masivo.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });

    document.getElementById('csv_file').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '!!!Ningún archivo seleccionado';
        document.getElementById('file-name').textContent = fileName;

        // Habilitar el botón de enviar si hay un archivo seleccionado
        document.getElementById('submit-btn').disabled = !e.target.files[0];
    });
</script>
@endsection