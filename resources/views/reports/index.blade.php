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

                    <form class="form" method="GET" action="{{ url('/download') }}">
                        <div class="row">

                            <div class='col-xs-12'>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <!--
                                    <input name="userName" type="text" class="form-control" value="{{ old('userName') }}" placeholder="Nombre" autocomplete="off">
                                    -->
                                    <input list="userNames"
                                        name="userName"
                                        value="{{ old('userName') }}"
                                        class="form-control"
                                        placeholder="Nombre"
                                        autocomplete="off">

                                    <datalist id="userNames">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->username }}">{{ $user->name }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>

                            <div class='col-xs-12'>
                                <div class="form-group">
                                    <label>Año</label>
                                    <select name="year" class="form-control">
                                        @foreach (Helpers::lastYears() as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
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

@endsection

@push('head')

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

@endpush
