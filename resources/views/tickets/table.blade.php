@if (count($tickets) > 0)

    <div class="table-responsive">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Trabajador</th>
                    <th>Tipo</th>
                    <th>Registro Id</th>
                    <th>Cerrado Por</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td><a href="{{ url('/summary?userName=' . $ticket->user->username . '&amp;aggregate=day') }}">{{ $ticket->user->name }}</a></td>
                        <td>{{ ucfirst(config('options.ticket_options')[$ticket->type]) }}</td>
                        <td>{{ $ticket->record_id ?? '-' }}</td>
                        <td>{{ $ticket->closedBy->name ?? '-' }}</td>
                        <td>
                            <span class="label {{ $ticket->status == 'open' ? 'label-danger' : 'label-info' }}">{{ $ticket->status }}</span>
                        </td>
                        <td>
                            <a class="btn btn-default btn-block btn-sm"
                               style="padding: 2px 10px;"
                               href="{{ route($ticket->status == 'open' ? 'tickets.edit' : 'tickets.show', $ticket) }}">Detalles</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $tickets->links() }}

@else
    <p>No hay tickets abiertos o cerrados para visualizar.</p>
@endif
