<form class="form-inline pull-right" method="POST" action="{{ route('users.enable', $user) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <button type="submit"
            class="btn btn-block btn-sm {{ $user->enabled ? 'btn-danger' : 'btn-success' }}"
            href="{{ route('users.edit', $user->id) }}">
       {{ $user->enabled ? 'Desactivar': 'Activar' }}
    </button>

</form>
