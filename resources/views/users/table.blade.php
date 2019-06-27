<div class="table-responsive">
    <table class="table table-condensed">
        <thead>
            <tr>
				<th>Trabajador</th>
                <th>Usuario</th>
                <th>Perfil</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="{{ $user->class }}">
					<td><a href="{{ url('/summary?userName=' . $user->username . '&amp;aggregate=record') }}">{{ $user->name }}</a></td>
					<td>{{ $user->username }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->email }}</td>
					<td><a class="btn btn-default btn-block btn-sm"
						   style="padding: 2px 10px;"
						   href="{{ route('users.edit', $user->id) }}">configurar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
