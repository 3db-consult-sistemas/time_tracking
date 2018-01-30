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
                    <h3 class="panel-title" >Tickets</h3>
                </div>

                <div class="panel-body">
                    @include ('tickets.table')
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
