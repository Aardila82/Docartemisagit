@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h1>Eventos del Log</h1>

    @if (empty($eventos))
        <p>No hay eventos para mostrar.</p>
    @else
        <table id="logEventosTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha Evento</th>
                    <th>Usuario</th>
                    <th>Evento ID</th>
                    <th>Entidad ID</th>
                    <th>Comentario</th>
                    <th>Creado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventos as $evento)
                    <tr>
                        <td>{{ $evento['id'] ?? '-' }}</td>
                        <td>{{ $evento['fecha_evento'] ?? '-' }}</td>
                        <td>{{ $evento['usuario'] ?? '-' }}</td>
                        <td>{{ $evento['evento_id'] ?? '-' }}</td>
                        <td>{{ $evento['entidad_id'] ?? '-' }}</td>
                        <td>{{ $evento['comentario'] ?? '-' }}</td>
                        <td>{{ $evento['created_at'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#logEventosTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100]
        });
    });
</script>
@endsection
