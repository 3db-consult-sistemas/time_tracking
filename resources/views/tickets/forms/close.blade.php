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

                    <?php
                        $action = 'update';
                        $actionName = 'Actualizar';

                        if (Gate::check('checkrole', 'super_admin') || Gate::check('checkrole', 'admin')) {
                            $action = 'close';
                            $actionName = 'Cerrar';
                        }

                        $projectId = null;
                        $checkIn = null;
                        $checkOut = null;

                        if (isset($ticket->record)) {
                            $projectId = $ticket->record->project_id;
                            $checkIn = $ticket->record->check_in;
                            $checkOut = $ticket->record->check_out;
                        }
                    ?>

                    <form id="formUpdate" method="POST" action="{{ route('tickets', [$ticket, $action]) }}">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                    </form>

                    <form id="formDelete" method="POST" action="{{ url('/tickets', $ticket) }}">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                    </form>

                    <div class="row form-horizontal">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-5">Trabajador:</label>
                                <div class="col-sm-7">{{ $ticket->user->name }}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5">Tipo Ticket:</label>
                                <div class="col-sm-7">{{ ucfirst(config('options.ticket_options')[$ticket->type]) }}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5">Registro ID:</label>
                                <div class="col-sm-7">{{ $ticket->record_id ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                <label class="col-sm-4">Proyecto:</label>
                                <div class="col-sm-8">
                                    <select name="project" class="form-control input-sm" form="formUpdate">
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ $project->id == $projectId ? 'selected' : '' }}>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4">Check In:</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm" type="text" name="check_in"
                                            form="formUpdate"
                                            value="{{ old('check_in', $checkIn) }}"
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
                                            form="formUpdate"
                                            value="{{ old('check_out', $checkOut) }}"
                                            placeholder="yyyy-mm-dd HH:mm"
                                            pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}(:[0-9]{2}){1,2}"
                                            required>
                                    <span class="validity"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <label>Comentario</label>
                    <div class="form-group">
                        <textarea name="comments"
                            form="formUpdate"
                            class="form-control"
                            style="resize:none"
                            rows="3"
                            autocomplete="off"
                            maxlength="191"
                            placeholder="Comentario... (OBLIGATORIO)">{{ old('comments', $ticket->comments) }}</textarea>
                    </div>

                    <hr>

                    <div class="form-group">
                        @if ($ticket->type != 'auto')
                            <button type="submit" class="btn btn-danger" form="formDelete">
                                <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                            </button>
                        @endif

                        <div class="pull-right">
                            <a class="btn btn-default" href="{{ url('/tickets') }}">Cancelar</a>

                            <button type="submit" class="btn btn-primary" form="formUpdate">
                                <i class="fa fa-ticket" aria-hidden="true"></i> {{ $actionName }}
                            </button>
                        </div>
                    </div>

                </div>
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
