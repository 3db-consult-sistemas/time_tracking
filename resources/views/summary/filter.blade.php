<form class="form-inline pull-right" method="GET" action="{{ url('/summary') }}">

    @if(Gate::check('checkrole', 'super_admin') || Gate::check('checkrole', 'admin'))

        <input list="userNames"
               name="userName"
               value="{{ isset($data['userName']) ? $data['userName'] : '' }}"
               placeholder="Nombre"
               class="form-control input-sm"
               autocomplete="off">

        <datalist id="userNames">
            @foreach ($users as $user)
                <option value="{{ $user->username }}">{{ $user->name }}</option>
            @endforeach
        </datalist>

    @endif

    <div class="form-group">
        <select name="aggregate" class="form-control input-sm" onchange="this.form.submit()">
            <option value="day" {{ $data['aggregate'] == 'day' ? 'selected' : '' }}>Diario</option>
            <option value="week" {{ $data['aggregate'] == 'week' ? 'selected' : '' }}>Semanal</option>
            <option value="record" {{ $data['aggregate'] == 'record' ? 'selected' : '' }}>Sin agregar</option>
        </select>
    </div>

</form>
