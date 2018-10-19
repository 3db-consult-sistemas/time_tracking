@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            @include ('layouts.errors')
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">

                    @include('users.filter')

                    <h3 class="panel-title" style="margin-top:.4em;">Users</h3>

                    <div class="clearfix"></div>

                </div>

                <div class="panel-body">
                    @include ('users.table')
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
