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
                <div class="panel-heading">Reportes</div>
                <div class="panel-body">

                    <form class="form" method="GET" action="/download">
                        <div class="row">

                            <div class='col-xs-12'>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input name="userName" type="text" class="form-control" placeholder="Nombre" value="{{ old('userName') }}">
                                </div>
                            </div>

                            <div class='col-xs-12'>
                                <div class="form-group">
                                    <label>Agregado</label>
                                    <select name="aggregate" class="form-control">
                                        <option value="day" {{ old('aggregate') == 'day' ? 'selected' : '' }}>Diario</option>
                                        <option value="week" {{ old('aggregate') == 'week' ? 'selected' : '' }}>Semanal</option>
                                        <option value="month" {{ old('aggregate') == 'month' ? 'selected' : '' }}>Mensual</option>
                                        <option value="record" {{ old('aggregate') == 'record' ? 'selected' : '' }}>Sin agregar</option>
                                    </select>
                                </div>
                            </div>

                            <div class='col-xs-12'>
                                <div class="form-group">
                                    <label>Desde</label>
                                    <div class='input-group date' id='dtpFrom'>
                                        <input name="from" type='text' class="form-control" value="{{ old('from') }}"/>
                                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-12'>
                                <div class="form-group">
                                    <label>Hasta</label>
                                    <div class='input-group date' id='dtpTo'>
                                        <input name="to" type='text' class="form-control" value="{{ old('to') }}"/>
                                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-12'>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-download" aria-hidden="true"></i> Descargar
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#dtpFrom').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate:  moment().subtract(1, 'months')
        });
        $('#dtpTo').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: moment(),
        });

        $("#dtpFrom").on("dp.change", function (e) {
            $('#dtpTo').data("DateTimePicker").minDate(e.date);
        });
        $("#dtpTo").on("dp.change", function (e) {
            $('#dtpFrom').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>

@endsection
