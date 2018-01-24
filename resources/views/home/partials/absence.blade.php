<form method="POST" action="{{ url('/absence/' . $status['activeId']) }}">
    {{ csrf_field() }}

    <input type="hidden" name="action" value="{{ $action }}">

    @if ($action == 'close')
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-lg btn-block">
                <i class="fa fa-times" aria-hidden="true"></i> Terminar Ausencia
            </button>
        </div>

    @elseif ($action == 'cancel')
        <div class="form-group">
            <button type="submit" class="btn btn-danger btn-lg btn-block">
                <i class="fa fa-times" aria-hidden="true"></i> Cancelar Ausencia Programada
            </button>
        </div>

    @elseif ($action == 'open')
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-lg btn-block">
                <i class="fa fa-clock-o" aria-hidden="true"></i> Ausencia
            </button>
        </div>

        <div class="form-group">
            <textarea name="comments"
                      class="form-control"
                      style="resize:none"
                      rows="3"
                      autocomplete="off"
                      placeholder="Comentarios...">{{ old('comments') }}</textarea>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label data-toggle="collapse" data-target="#absenceOptions">
                    <input id="planned" name="planned" type="checkbox" @if(old('planned')=='on') checked @endif/> Ausencia programada
                </label>
            </div>
        </div>

        <div id="absenceOptions" class="panel-collapse collapse">

            <div class="form-group">
                <label>Desde:</label>
				<div class='input-group date' id='dtpFrom'>
					<input name="from" id="idFrom" type='text' class="form-control" value="{{ old('from') }}" placeholder="Ahora"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>

            <div class="form-group">
                <label>Duranción (minutos):</label>
                <input name="duration" id="idDuration" type="number" value="{{ old('duration', 5) }}" class="form-control" min="1" max="540">
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

                // Si es una validación fallida y ausencia programada esta seleccionado,
                // expando las opciones de ausencia.
                if ($('#planned').is(':checked')) $('#absenceOptions').collapse('show');

                // Al deseleccionar la ausencia programada reinicio los input.
                $('#absenceOptions').on('hidden.bs.collapse', function () {
                    $('#idDuration').val('5');
                    $('#idFrom').val('');
                })
            });
        </script>
    @endif
</form>
