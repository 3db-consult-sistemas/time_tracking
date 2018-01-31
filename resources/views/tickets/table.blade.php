@if (count($tickets) > 0)

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Estado</th>
                <th>Trabajador</th>
                <th>Tipo</th>
                <th>Inicio de Registro</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>
                        <span class="label {{ $ticket->status == 'open' ? 'label-danger' : 'label-info' }}">{{ $ticket->status }}</span>
                    </td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>{{ $ticket->record->type }}</td>
                    <td>{{ $ticket->record->check_in }}</td>
                    <td><a class="btn btn-default btn-block btn-sm" href="{{ route('tickets.edit', $ticket) }}">Detalles</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $tickets->links() }}

@else
    <p>No hay ticketsabiertos o cerrados para visualizar.</p>
@endif
