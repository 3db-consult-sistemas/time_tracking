<form method="POST" action="{{ route('users.projects', $user) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

	<?php $currentIds = array_pluck($user->projects->toArray(), 'id'); ?>

	<p>Mantener pulsado el boton <strong>Ctrl</strong> para seleccionar multiples opciones.</p>

    <div class="form-group">
		<select multiple name="projects[]" class="form-control" style="height: 350px">
			@foreach($projects as $project)
				<option value="{{ $project->id }}" {{ in_array($project->id, $currentIds) ? 'selected' : '' }}>{{ $project->name }}</option>
			@endforeach
		</select>
    </div>

    <hr>
    <button type="submit" class="btn btn-sm btn-primary custom-btn-width">OK</button>
</form>
