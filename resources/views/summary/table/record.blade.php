<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Trabajador</th>
                <th>Día</th>
                <th>Tipo</th>
                <th>Hora Inicio</th>
                <th>Hora Final</th>
                <th>Tiempo</th>
                <!--<th>Dirección IP</th>-->
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $entry)
                <tr>
                    <td>{{ $entry->name }}</td>
                    <td>{{ $entry->date }}</td>
                    <td>{{ $entry->type }}</td>
                    <td>{{ $entry->time_in }}</td>
                    <td>{{ $entry->time_out }}</td>
                    <td>{{ Helpers::formatSeconds($entry->secs) }}</td>
                    <!--<td>{{ $entry->ip }}</td>-->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $entries->links() }}
