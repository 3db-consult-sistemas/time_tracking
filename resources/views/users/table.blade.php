<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Trabajador</th>
                <th>Perfil</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->email }}</td>
                    <td><a href="{{ route('users.edit', $user) }}">configurar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $users->links() }}
