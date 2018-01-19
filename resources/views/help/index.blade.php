@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Esquema de Estados</div>

                <div class="panel-body">
                    <img class="img-responsive center-block" src="{!! asset('images/esquema_funcionamiento.png') !!}" alt="imagen" >
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
