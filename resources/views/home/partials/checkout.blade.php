<form method="POST" action="{{ url('/check-out/' . $status['activeId']) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-danger btn-lg btn-block custom-btn-mobile">
            Check Out
        </button>
    </div>
</form>
