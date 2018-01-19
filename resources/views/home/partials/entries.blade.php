<div class="panel panel-default">
    <div class="panel-heading">Ultimas entradas</div>

    <div class="panel-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Hora Inicio</th>
                    <th>Hora Final</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($entries as $entry)
                    <tr>
                        <td>{{ $entry->type }}</td>
                        <td>{{ $entry->check_in }}</td>
                        <td>{{ $entry->check_out }}</td>
                        <!--<td>{{ gmdate("H:i:s", $item->secs)  }}</td>-->
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
</div>
