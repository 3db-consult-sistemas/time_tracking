@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @include ('layouts.errors')
        </div>
    </div>

    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h3 class="panel-title">Ticket
                        <div class="pull-right">
                            <span class="label {{ $ticket->status == 'open' ? 'label-danger' : 'label-info' }}">
                                {{ $ticket->status }}
                            </span>
                        </div>
                    </h3>
                </div>

                <div class="panel-body">

					@if ($ticket->status == 'open')

						<form  method="POST" action="{{ url('/tickets', $ticket) }}">
							{{ method_field('PATCH') }}
							{{ csrf_field() }}

							<div class="row form-horizontal">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="col-sm-5">Trabajador:</label>
										<div class="col-sm-7">{{ $ticket->user->name }}</div>
									</div>
									<div class="form-group">
										<label class="col-sm-5">Proyecto:</label>
										<div class="col-sm-7">
											<select name="project" class="form-control input-sm">
												@foreach($projects as $project)
													<option value="{{ $project->id }}" {{ $project->id == $ticket->record->project_id ? 'selected' : '' }}>{{ $project->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="col-sm-4">Check In:</label>
										<div class="col-sm-8">
											<input class="form-control input-sm" type="text" name="check_in"
												   value="{{ old('check_in', $ticket->record->check_in) }}"
												   placeholder="yyyy-mm-dd HH:mm"
												   pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}(:[0-9]{2}){1,2}"
												   required>
											<span class="validity"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4">Check Out:</label>
										<div class="col-sm-8">
											<input class="form-control input-sm" type="text" name="check_out"
												   value="{{ old('check_out', $ticket->record->check_out) }}"
												   placeholder="yyyy-mm-dd HH:mm"
												   pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}(:[0-9]{2}){1,2}"
												   required>
											<span class="validity"></span>
										</div>
									</div>
								</div>
							</div>

							<label>Comentario</label>
							<div class="form-group">
								<textarea name="comments"
									class="form-control"
									style="resize:none"
									rows="3"
									autocomplete="off"
									maxlength="191"
									placeholder="Comentario... (OBLIGATORIO)">{{ old('comments', $ticket->comments) }}</textarea>
							</div>

							<hr>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-ticket" aria-hidden="true"></i> Cerrar Ticket
                                </button>
                            </div>
						</form>

					@elseif ($ticket->status == 'close')

						<div class="form-horizontal">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="col-sm-5">Trabajador:</label>
										<div class="col-sm-7">{{ $ticket->user->name }}</div>
									</div>
									<div class="form-group">
										<label class="col-sm-5">Proyecto:</label>
										<div class="col-sm-7">{{ $ticket->record->project->name }}</div>
									</div>
									<div class="form-group">
										<label class="col-sm-5">Cerrado por:</label>
										<div class="col-sm-7">{{ $ticket->closedBy->name ?? '-' }}</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="col-sm-4">Check In:</label>
										<div class="col-sm-8">{{ $ticket->record->check_in }}</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4">Check Out:</label>
										<div class="col-sm-8">{{ $ticket->record->check_out }}</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4">Cerrado el:</label>
										<div class="col-sm-8">{{ $ticket->updated_at }}</div>
									</div>
								</div>
							</div>
						</div>

						<label>Comentario:</label>
						<div class="form-group">
							<textarea readonly
								style="resize:none;width:100%;padding: 6px 12px;border: 1px solid #ccd0d2;"
								rows="3">{{ $ticket->comments }}</textarea>
						</div>
					@endif
                </div>
            </div>

            <div class="form-group pull-right">
                <a class="btn btn-default" href="{{ url('/tickets') }}">Volver</a>
            </div>

        </div>
    </div>
</div>



<style>

/*
 * Simbolo de validacion en un input (usado en el campo from de la pestaña principal).
 */
.datetime-input input:invalid + span {
  position: relative;
}

.datetime-input input:invalid + span:after {
  content: '✖';
  position: relative;
  right: 15px;
  top: -30px;
  float: right;
}

.datetime-input input:valid + span {
  position: relative;
}

.datetime-input input:valid + span:after {
  content: '✓';
  position: relative;
  right: 15px;
  top: -30px;
  float: right;
}
</style>

@endsection
