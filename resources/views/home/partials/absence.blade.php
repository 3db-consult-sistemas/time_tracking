<form method="POST" action="{{ url('/absence/' . $status['activeId']) }}">
    {{ csrf_field() }}

    <input type="hidden" name="action" value="{{ $action }}">

    @if ($action == 'close')
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-lg btn-block">
                <i class="fa fa-window-close" aria-hidden="true"></i> Terminar Ausencia
            </button>
        </div>

    @elseif ($action == 'cancel')
        <div class="form-group">
            <button type="submit" class="btn btn-danger btn-lg btn-block">
                <i class="fa fa-window-close" aria-hidden="true"></i> Cancelar Ausencia Programada
            </button>
        </div>

    @elseif ($action == 'open')
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-lg btn-block">
                <i class="fa fa-clock-o" aria-hidden="true"></i> Ausencia
            </button>
        </div>

        <div class="form-group">
            <textarea name="comments" class="form-control" style="resize:none" rows="3" autocomplete="off" placeholder="Comentarios..."></textarea>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label data-toggle="collapse" data-target="#absenceOptions">
                    <input name="planned" type="checkbox"/> Ausencia programada
                </label>
            </div>
        </div>

        <div id="absenceOptions" class="panel-collapse collapse">
            <div class="form-group form-inline">
                <label>Duranción (minutos):</label>
                <input name="duration" type="number" value="5" class="form-control" min="1" max="540">
            </div>
        </div>

    @endif
</form>
