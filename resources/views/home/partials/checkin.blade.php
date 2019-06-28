<form method="POST" action="{{ url('/check-in') }}">
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg btn-block custom-btn-mobile">
            Check In
		</button>
	</div>

	<select name="project" class="form-control input-sm">
		@foreach($projects as $project)
			<option value="{{ $project->id }}" {{ $project->id == (isset($lastRecord) ? $lastRecord->project_id : -1) ? 'selected' : '' }}>{{ $project->name }}</option>
		@endforeach
	</select>
</form>
