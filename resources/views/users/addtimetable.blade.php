<form method="POST" action="{{ url('/timetable') }}">
    {{ csrf_field() }}

    <input name="user_id" type="hidden" value="{{ $user->id }}">

    <p>Minutos a trabajar en cada uno de los días a partir de la fecha indicada.</p>

    <div class="form-inline form-group">
        <label>Inicio del nuevo horario (incluido):</label>
        <div class='input-group date' id='dtp'>
            <input name="from_date" id="dtp" type='text' class="form-control" value="{{ old('from_date') }}"/>
            <span class="input-group-addon">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table custom-table-timetable">
            <thead>
                <tr>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miercoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sabado</th>
                    <th>Domingo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input name="monday" type="number" class="form-control" value="{{ old('monday', 495) }}" autocomplete="off" min="0" max="600"></td>
                    <td><input name="tuesday" type="number" class="form-control" value="{{ old('tuesday', 495) }}" autocomplete="off" min="0" max="600"></td>
                    <td><input name="wednesday" type="number" class="form-control" value="{{ old('wednesday', 495) }}" autocomplete="off" min="0" max="600"></td>
                    <td><input name="thursday" type="number" class="form-control" value="{{ old('thursday', 495) }}" autocomplete="off" min="0" max="600"></td>
                    <td><input name="friday" type="number" class="form-control" value="{{ old('friday', 495) }}" autocomplete="off" min="0" max="600"></td>
                    <td><input name="saturday" type="number" class="form-control" value="{{ old('saturday', 0) }}" autocomplete="off" min="0" max="600"></td>
                    <td><input name="sunday" type="number" class="form-control" value="{{ old('sunday', 0) }}" autocomplete="off" min="0" max="600"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <p><strong>08:15</strong> = 495 minutos / <strong>07:00</strong> = 420 minutos / <strong>05:00</strong> = 300 minutos</p>

    <hr>
    <button type="submit" class="btn btn-sm btn-primary custom-btn-width">Ok</button>
</form>


<script type="text/javascript">
    $(function () {
        $('#dtp').datetimepicker({
            format: 'YYYY-MM-DD',
            icons: { time: "fa fa-clock-o", date: "fa fa-calendar", up: "fa fa-arrow-up", down: "fa fa-arrow-down" },
            showClear: true
        });
    });
</script>
