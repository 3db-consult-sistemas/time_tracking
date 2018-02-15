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

                    @include('summary.filter')

                    <h3 class="panel-title" style="margin-top:.4em;">Resumen</h3>

                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    @if (count($entries) > 0)
                        @if ($data['aggregate'] == 'day')
                            @include ('summary.table.day')
                        @elseif  ($data['aggregate'] == 'week')
                            @include ('summary.table.week')
                        @elseif  ($data['aggregate'] == 'record')
                            @include ('summary.table.record')
                        @endif
                    @else
                        No hay datos para el filtro actual.
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
