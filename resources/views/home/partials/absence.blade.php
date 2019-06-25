<form method="POST" action="{{ url('/absence/' . $status['activeId']) }}">
    {{ csrf_field() }}

    <input type="hidden" name="action" value="{{ $action }}">

    @if ($action == 'close')
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-lg btn-block">
                Terminar Ausencia
            </button>
        </div>

    @elseif ($action == 'cancel')
        <div class="form-group">
            <button type="submit" class="btn btn-danger btn-lg btn-block">
                Cancelar Ausencia Programada
            </button>
        </div>

    @elseif ($action == 'open')
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-lg btn-block">
                Ausencia
            </button>
        </div>

        <div class="form-group">
            <select name="absence_type" id="absence_type" class="form-control input-sm">
                @foreach(config('options.absence_options') as $key => $value)
                    <option value="{{ $key }}" {{ old('absence_type') == $key ? 'selected' : '' }}>{{ ucfirst($value) }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" id="comments" style="display: none;">
            <textarea name="comments"
                    class="form-control"
                    style="resize:none"
                    rows="3"
                    autocomplete="off"
                    placeholder="Motivo de ausencia  (OBLIGATORIO)">{{ old('comments') }}</textarea>
        </div>

        <div id="absenceOptions" style="display: none;">
            <div class="form-group">
                <div class="checkbox">
                    <label data-toggle="collapse" data-target="#absenceTimeOptions">
                        <input id="planned" name="planned" type="checkbox" @if(old('planned')=='on') checked @endif/> Ausencia programada
                    </label>
                </div>
            </div>

            <div id="absenceTimeOptions" class="panel-collapse collapse">

                <div class="form-group">
                    <label>Desde:</label>
                    <div class='input-group date' id='dtpFrom'>
                        <input name="from" id="idFrom" type='text' class="form-control" value="{{ old('from') }}" placeholder="Ahora"/>
                        <span class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Duranción (minutos):</label>
                    <input name="duration"
						   id="idDuration"
						   type="number"
						   class="form-control"
						   value="{{ old('duration', config('options.absence_duration.min')) }}"
						   min="{{ config('options.absence_duration.min') }}"
						   max="{{ config('options.absence_duration.max') }}">
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function () {
                $('#dtpFrom').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm',
                    icons: { time: "fa fa-clock-o", date: "fa fa-calendar", up: "fa fa-arrow-up", down: "fa fa-arrow-down" },
                    minDate: moment(),
                    showClear: true
                });


                // Por defecto el cuadro de comentario esta oculto, si el tipo es 'otros' lo visualizo.
                if ($("#absence_type option:selected").val() == 'otros') {
                    $('#comments').show();
                }

                if ($("#absence_type option:selected").val() != 'descanso') {
                    $('#absenceOptions').show();
                }

                $('#absence_type').on('change', function () {
                    if ($("#absence_type option:selected").val() == 'otros') {
                        $('#comments').show();
                    } else {
                        $('#comments').hide();
                    }

                    if ($("#absence_type option:selected").val() == 'descanso') {
                        $('#absenceOptions').hide();
                    } else {
                        $('#absenceOptions').show();
                    }
                });

                // Si es una validación fallida y ausencia programada esta seleccionado,
                // expando las opciones de ausencia.
                if ($('#planned').is(':checked')) $('#absenceTimeOptions').collapse('show');

                // Al deseleccionar la ausencia programada reinicio los input.
                $('#absenceTimeOptions').on('hidden.bs.collapse', function () {
                    $('#idDuration').val(window.__ABSENCE_MIN);
                    $('#idFrom').val('');
                })
            });
        </script>
    @endif
</form>
