<form method="POST" action="{{ url('/absence-finish/' . $status['activeId']) }}">
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-warning btn-lg btn-block">
            <i class="fa fa-window-close" aria-hidden="true"></i> Terminar Ausencia
        </button>
    </div>
</form>
