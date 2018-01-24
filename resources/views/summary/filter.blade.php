<form class="form-inline pull-right" method="GET" action="/summary">

    <div class="form-group">
        <select name="aggregate" class="form-control input-sm" onchange="this.form.submit()">
            <option value="day" {{ $data['aggregate'] == 'day' ? 'selected' : '' }}>Diario</option>
            <option value="week" {{ $data['aggregate'] == 'week' ? 'selected' : '' }}>Semanal</option>
            <option value="record" {{ $data['aggregate'] == 'record' ? 'selected' : '' }}>Registro</option>
        </select>
    </div>

</form>
