@extends('layouts.app')

@section('content')


<div class="container">

    @if ($status['code'] == 'close')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @include('home.partials.checkin')
                    </div>
                </div>
            </div>
        </div>

    @elseif  ($status['code'] == 'open')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-sm-6">
                                @include('home.partials.checkout')
                            </div>

                            <div class="col-sm-6">
                                @include('home.partials.absence')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

    <div class="row">
        <div class="col-md-10 col-md-offset-1 hidden-xs">
            <div class="panel panel-default">
                <div class="panel-heading">Registro Semanal</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            @include('home.partials.weeksummary')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
