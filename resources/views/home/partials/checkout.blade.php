<form method="POST" action="{{ url('/check-out/' . $status['activeId']) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="form-group">
        <button type="submit" class="btn btn-danger btn-lg btn-block custom-btn-mobile">
            Check Out
        </button>
    </div>

	@if ($status['code'] == 'open')
		<div class="row">
			<div class="col-xs-12 col-sm-7">
				<div class="form-group">
					<select name="project" id="select-change-project" class="form-control input-sm"  onchange="toggleButton();">

					<option value="-1">NA (temporal)</option>
						@foreach($projects as $project)
							<option value="{{ $project->id }}" {{ $project->id == (isset($lastRecord) ? $lastRecord->project_id : -1) ? 'selected' : '' }}>{{ $project->name }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="col-xs-12 col-sm-5">
				<div class="form-group">
					<button id="btn-change-project"
							type="submit"
							class="btn btn-primary btn-sm btn-block"
							formaction="{{ url('/change-project/' . $status['activeId']) }}"
							style="display:none">
						Cambiar Proyecto
					</button>
				</div>
			</div>
		</div>
	@endif

    <div class="form-group" id="check_out_comment">
        <textarea name="check_out_comment"
                class="form-control"
                style="resize:none"
                rows="3"
                autocomplete="off"
                placeholder="Comentario...">{{ old('check_out_comment') }}</textarea>
    </div>
</form>

<script>
// Obtengo el proyecto actual
let lastRecord = @json($lastRecord);
var currentProject = (lastRecord != null) ? lastRecord.project_id : '-1';
if (currentProject == null) { currentProject = '-1'; }

/**
 * Modifico la visibilidad del boton de cambio de proyecto.
 */
function toggleButton() {
	let select = document.getElementById("select-change-project");
	let project = select.options[select.selectedIndex].value;

	document.getElementById("btn-change-project").style.display = currentProject != project
		? 'block'
		: 'none';
}
</script>
