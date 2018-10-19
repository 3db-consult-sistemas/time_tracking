<form class="form-inline pull-right" method="GET" action="{{ url('/users') }}">

    <div class="form-group">
        <select name="enabled" class="form-control input-sm" onchange="this.form.submit()">
            <option value="1" {{ $enabled == '1' ? 'selected' : '' }}>Activos</option>
            <option value="0" {{ $enabled== '0' ? 'selected' : '' }}>Desactivados</option>
        </select>
    </div>

</form>
