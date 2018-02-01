<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Trabajador</th>
                <th>Perfil</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="{{ $user->class }}">
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->email }}</td>
                    <td><a class="btn btn-default btn-block btn-sm" href="{{ route('users.edit', $user->id) }}">configurar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
