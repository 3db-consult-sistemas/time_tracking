@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include ('layouts.errors')
        </div>
    </div>

    <div class="row">

        <?php
            $canDelete = True;
            $canCreateUpdate = True;

            if (isset($ticket)) {
                // Editando un ticket
                if ($ticket->type == 'auto') {
                    $canDelete = False;
                    $canCreateUpdate =False;
                }

                $actionText = 'update';
                $record = $ticket->record;
                $recordProyect = $ticket->record->project->name;
                $comments = $ticket->comments;
                $url = url('/tickets');
            } else {
                // Creando un ticket nuevo
                $canDelete = False;
                $actionText = 'create';
                $recordProyect = $record->project;
                $comments = null;
                $url = url('summary?userName' . auth()->user()->username . '&aggregate=record');
            }
        ?>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" style="margin-top:.2em;">Solicitud de cambio</h3>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">

                    @if ($actionText == 'update')
                        <form id="formCreateUpdate" method="POST" action="{{ route('tickets', [$ticket, 'update']) }}">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                        </form>

                        <form id="formDelete" method="POST" action="{{ url('/tickets', $ticket) }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                        </form>

                    @elseif ($actionText == 'create')
                        <form id="formCreateUpdate" method="POST" action="{{ url('/tickets') }}">
                            {{ csrf_field() }}
                        </form>

                    @endif

					<p>Inserte un comentario describiendo lo que deseas modificar del registro:</p>
                    <p style="margin-left: 2em;"><strong>- Id Registro:</strong> {{ $record->id }}</p>
					<p style="margin-left: 2em;"><strong>- Check-In:</strong> {{ $record->check_in }}</p>
					<p style="margin-left: 2em;"><strong>- Check-Out:</strong> {{ $record->check_out }}</p>
					<p style="margin-left: 2em;"><strong>- Proyecto:</strong> {{ $recordProyect }}</p>

                    <input type="hidden" name="record_id" value="{{ $record->id }}" form="formCreateUpdate">
                    <input type="hidden" name="user_id" value="{{ $record->user_id }}" form="formCreateUpdate">
                    <input type="hidden" name="type" value="update_record" form="formCreateUpdate">

                    <hr>

                    <div class="form-group" style="margin-top:2em;">
                        <label>Comentario:</label>
                        <textarea name="comments"
                            form="formCreateUpdate"
                            class="form-control"
                            style="resize:none;"
                            rows="3"
                            autocomplete="off"
                            maxlength="191"
                            placeholder="Solicitud...">{{ $comments }}</textarea>
                    </div>

                    <hr>

                    <div class="form-group">
                        @if ($canDelete)
                            <button type="submit" class="btn btn-danger" form="formDelete">
                                <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                            </button>
                        @endif

                        <div class="pull-right">
                            <a class="btn btn-default" href="{{ url($url) }}">Cancelar</a>

                            @if ($canCreateUpdate)
                            <button type="submit" class="btn btn-primary" form="formCreateUpdate">
                                <i class="fa fa-ticket" aria-hidden="true"></i> {{ $actionText == 'create' ? 'Crear' : 'Actualizar' }}
                            </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
