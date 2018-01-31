@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Users</h3>
                </div>

                <div class="panel-body">
                    @include ('users.table')
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
