<form method="POST" action="{{ url('/check-out/' . $status['activeId']) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-danger btn-lg btn-block custom-btn-mobile">
            Check Out
        </button>
    </div>

    <div class="form-group" id="check_out_comment">
        <textarea name="check_out_comment"
                class="form-control"
                style="resize:none"
                rows="3"
                autocomplete="off"
                placeholder="Comentario...">{{ old('check_out_comment') }}</textarea>
    </div>
</form>
