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
                <div class="panel-body">

                    @if ($status['code'] == 'close')
                        @include('home.partials.checkin')

                    @elseif  ($status['code'] == 'open')
                        <div class="row">
                            <div class="col-sm-6">
                                @include('home.partials.checkout')
                            </div>
                            <div class="col-sm-6 hidden-xs">
                                @include('home.partials.absence', ['action' => 'open'])
                            </div>
                        </div>

                    @elseif  ($status['code'] == 'absence')
                        <div class="row">
                            <div class="col-sm-6">
                                @include('home.partials.checkout')
                            </div>
                            <div class="col-sm-6">
                                @include('home.partials.absence', ['action' => 'close'])
                            </div>
                        </div>

                    @elseif ($status['code'] == 'absence-planned')
                        @include('home.partials.absence', ['action' => 'cancel'])
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (count($entries) > 0)
        <div class="row">
            <div class="col-md-10 col-md-offset-1 hidden-xs">
                <div class="panel panel-default">
                    <div class="panel-heading">Resumen</div>

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
    @endif

</div>

<script type="text/javascript">
    setInterval(() => {
        location.reload();
    }, 600000);
</script>

@endsection
