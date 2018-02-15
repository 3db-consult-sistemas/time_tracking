<form method="POST" action="{{ url('/check-in') }}">
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg btn-block custom-btn-mobile">
            Check In
        </button>
    </div>
</form>
