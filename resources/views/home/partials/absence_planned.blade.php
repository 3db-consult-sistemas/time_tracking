<form method="POST" action="{{ url('/absence-planned/' . $status['activeId']) }}">
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-danger btn-lg btn-block">
            <i class="fa fa-window-close" aria-hidden="true"></i> Cancelar Ausencia Programada
        </button>
    </div>
</form>
