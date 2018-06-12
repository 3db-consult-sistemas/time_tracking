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

                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Trabajador:</strong> {{ $ticket->user->name }}</p>
                            <p><strong>Tipo:</strong> {{ $ticket->record->type }}</p>
                            <p><strong>Check In:</strong> {{ $ticket->record->check_in }}</p>

                            @if ($ticket->status == 'close')
                                <p><strong>Check Out:</strong> {{ $ticket->record->check_out }}</p>
                            @endif
                        </div>

                        @if ($ticket->status == 'close')
                            <div class="col-xs-12 col-sm-6">
                                <p><strong>Fecha de Cierre:</strong> {{ $ticket->updated_at }}</p>
                                <p><strong>Cerrado por:</strong> {{ $ticket->closedBy->name ?? '-' }}</p>
                            </div>

                            <div class="col-xs-12">
                                <hr>
                                <p><strong>Comentarios del Ticket:</strong></p><p>{{ $ticket->comments ?? '-' }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($ticket->status == 'open')
                        <hr>
                        <form method="POST" action="{{ url('/tickets', $ticket) }}">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label>Check Out:</label>
                                <div class='input-group date' id='dtp'>
                                    <input name="check_out" id="dtp" type='text' class="form-control" value="{{ old('check_out') }}" autocomplete="off"/>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea name="comments"
                                    class="form-control"
                                    style="resize:none"
                                    rows="3"
                                    autocomplete="off"
                                    placeholder="Comentarios...">{{ old('comments') }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-ticket" aria-hidden="true"></i> Cerrar Ticket
                                </button>
                            </div>
                        </form>

                        <script type="text/javascript">
                            $(function () {
                                $('#dtp').datetimepicker({
                                    format: 'YYYY-MM-DD HH:mm',
                                    icons: { time: "fa fa-clock-o", date: "fa fa-calendar", up: "fa fa-arrow-up", down: "fa fa-arrow-down" },
                                    minDate: moment('{{ $ticket->record->check_in }}'),
                                    maxDate: moment(),
                                    showClear: true
                                });
                            });
                        </script>
                    @endif

                </div>
            </div>

            <div class="form-group pull-right">
                <a class="btn btn-default" href="{{ url('/tickets') }}">Volver</a>
            </div>

        </div>
    </div>
</div>

@endsection
