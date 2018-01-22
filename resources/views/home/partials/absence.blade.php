<form method="POST" action="{{ url('/absence/' . $status['activeId']) }}">
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-warning btn-lg btn-block">
            <i class="fa fa-clock-o" aria-hidden="true"></i> Ausencia
        </button>
    </div>

    <div class="form-group">
        <textarea name="comment" class="form-control" style="resize:none" rows="3" autocomplete="off" placeholder="Comentarios..."></textarea>
    </div>

    <div class="form-group">
        <div class="checkbox">
            <label data-toggle="collapse" data-target="#absenceOptions">
                <input type="checkbox"/> Ausencia programada
            </label>
        </div>
    </div>

    <div id="absenceOptions" class="panel-collapse collapse">
        <div class="form-group form-inline">
            <label>Duranción (minutos):</label>
            <input name="absenceTime" type="number" class="form-control" min="5" max="540">
        </div>
    </div>

</form>
