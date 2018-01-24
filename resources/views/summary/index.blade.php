@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">

                    @include('summary.filter')

                    Resumen del Mes

                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    @if ($data['aggregate'] == 'day')
                        @include ('summary.table.day')
                    @elseif  ($data['aggregate'] == 'week')
                        @include ('summary.table.week')
                    @elseif  ($data['aggregate'] == 'record')
                        @include ('summary.table.record')
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
