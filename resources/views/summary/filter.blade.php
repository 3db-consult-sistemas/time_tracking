<form class="form-inline pull-right" method="GET" action="/summary">

    @if(Gate::check('checkrole', 'super_admin') || Gate::check('checkrole', 'admin'))
        <div class="form-group">
            <input name="name" id="idName" type="text" class="form-control input-sm" placeholder="Nombre" value="{{ $data['name'] ?? '' }}" autofocus>
        </div>
    @endif

    <div class="form-group">
        <select name="aggregate" class="form-control input-sm" onchange="this.form.submit()">
            <option value="day" {{ $data['aggregate'] == 'day' ? 'selected' : '' }}>Diario</option>
            <option value="week" {{ $data['aggregate'] == 'week' ? 'selected' : '' }}>Semanal</option>
            <option value="record" {{ $data['aggregate'] == 'record' ? 'selected' : '' }}>Sin agregar</option>
        </select>
    </div>

    <script>
        document.getElementById('idName').onkeypress = function(e) {
            var event = e || window.event;
            var charCode = event.which || event.keyCode;

            if ( charCode == '13' )
                this.form.submit();
        }
    </script>
</form>
