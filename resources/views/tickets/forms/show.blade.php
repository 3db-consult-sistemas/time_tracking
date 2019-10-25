@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h3 class="panel-title">Ticket
                        <div class="pull-right">
                        <span class="label label-info">close</span>
                        </div>
                    </h3>
                </div>

                <div class="panel-body">

                    <div class="form-horizontal">
                        <div class="row">
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
                                    <div class="col-sm-7">{{ $ticket->record_id }}</div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5">Cerrado por:</label>
                                    <div class="col-sm-7">{{ $ticket->closedBy->name }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-4">Proyecto:</label>
                                    <div class="col-sm-8">{{ $ticket->record->project->name }}</div>
                                </div>
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

                    <hr>

                    <label>Comentario:</label>
                    <div class="form-group">
                        <textarea readonly
                            style="resize:none;width:100%;padding: 6px 12px;border: 1px solid #ccd0d2;"
                            rows="3">{{ $ticket->comments }}</textarea>
                    </div>

                </div>
            </div>

            <div class="form-group pull-right">
                <a class="btn btn-default" href="{{ url('/tickets') }}">Volver</a>
            </div>

        </div>
    </div>
</div>

@endsection
