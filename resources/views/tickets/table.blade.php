@if (count($tickets) > 0)

<div class="table-responsive">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Estado</th>
                <th>Trabajador</th>
                <th>Tipo</th>
                <th>Check In</th>
                <th>Cerrado Por</th>
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
                    <td><a href="{{ url('/summary?userName=' . $ticket->user->username . '&amp;aggregate=day') }}">{{ $ticket->user->name }}</a></td>
                    <td>{{ $ticket->record->type }}</td>
                    <td>{{ $ticket->record->check_in }}</td>
                    <td>{{ $ticket->closedBy->name ?? '-' }}</td>
					<td><a class="btn btn-default btn-block btn-sm"
						   style="padding: 2px 10px;"
						   href="{{ route('tickets.edit', $ticket) }}">Detalles</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $tickets->links() }}

@else
    <p>No hay tickets abiertos o cerrados para visualizar.</p>
@endif
