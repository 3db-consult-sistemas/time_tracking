<form method="POST" action="{{ url('/check-in') }}">
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg btn-block">
            <i class="fa fa-sign-in" aria-hidden="true"></i> Check In
        </button>
    </div>
</form>
