<form class="form-inline pull-right" method="GET" action="{{ url('/summary') }}">

    @if(Gate::check('checkrole', 'super_admin') || Gate::check('checkrole', 'admin'))
        <input list="userNames"
               id="userName"
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
			<option value="week" {{ $data['aggregate'] == 'week' ? 'selected' : '' }}>Semanal</option>
			<option value="day" {{ $data['aggregate'] == 'day' ? 'selected' : '' }}>Diario</option>
			<option value="record" {{ $data['aggregate'] == 'record' ? 'selected' : '' }}>Registro</option>
        </select>
    </div>

    <div class="form-group">
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Descargar <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @foreach (Helpers::lastYears() as $year)
                    <li><a href="{{ route('download', $year) }}" onclick="formatUrl(this);">{{ $year }}</a></li>
				@endforeach
            </ul>
        </div>
    </div>

</form>

<script>

	/**
	 * Modifico la URL cuando hay escrito un nombre de usuario.
	 */
	function formatUrl(obj) {
		let url = obj.getAttribute("href");
		let name = document.getElementById("userName").value;

		if (url.indexOf('?userName=') !== -1) { url = url.split('?userName=')[0]; }

		obj.setAttribute("href", name != ''
			? `${url}?userName=${document.getElementById("userName").value}`
			: url);
	}

</script>
