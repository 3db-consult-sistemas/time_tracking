<form method="POST" action="{{ url('/check-out/' . $status['activeId']) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-danger btn-lg btn-block">
            <i class="fa fa-sign-out" aria-hidden="true"></i> Check Out
        </button>
    </div>
</form>
