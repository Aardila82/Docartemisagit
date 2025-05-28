@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Cargue Masivo</h2>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Botón Descargar CSV -->
        <a href="{{ route('SubSerieWeb.exportar') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Descargar CSV
        </a>

        <!-- Área de subida de archivos -->
        <div class="file-upload-area">
            <form action="{{ route('SubSerieWeb.procesarMasiva') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-wrap align-items-center gap-3 mb-4">
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
            <tr>
    <td>120</td>
    <td>archivo_1.csv</td>
    <td>alexander</td>
    <td>{{ number_format(2048 / 1024, 2) }} MB</td>
    <td>Sin errores</td>
    <td>{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
</tr>
<tr>
    <td>85</td>
    <td>archivo_2.csv</td>
    <td>usuario_demo</td>
    <td>{{ number_format(1024 / 1024, 2) }} MB</td>
    <td>Faltan columnas</td>
    <td>{{ \Carbon\Carbon::now()->subDay()->format('d/m/Y H:i') }}</td>
</tr>
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
