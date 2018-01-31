<form method="POST" action="{{ route('users.update.role', $user) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="form-inline form-group">
        <label>Nuevo Perfil:</label>
        <select name="role" class="form-control">
            <option value="user" {{ $user['role'] == 'user' ? 'selected' : '' }}>Usuario</option>
            <option value="admin" {{ $user['role'] == 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="super_admin" {{ $user['role'] == 'super_admin' ? 'selected' : '' }}>Super Administrador</option>
        </select>
    </div>

    <hr>
    <button type="submit" class="btn btn-sm btn-primary custom-btn-width">OK</button>
</form>
