<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Actualizar Perfil</h3></div>
    <div class="panel-body">
        <form method="POST" action="{{ route('users.update.role', $user) }}">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}

            <div class="form-group">
                <select name="role" class="form-control input-sm">
                    <option value="user" {{ $user['role'] == 'user' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ $user['role'] == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="super_admin" {{ $user['role'] == 'super_admin' ? 'selected' : '' }}>Super Administrador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
        </form>
    </div>
</div>
