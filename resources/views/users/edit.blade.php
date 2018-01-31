@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">{{ $user->name }}</h3></div>
                <div class="panel-body">
                    @include ('users.timetables')
                </div>
            </div>

            @include ('layouts.errors')

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Añadir nuevo horario</h3></div>
                <div class="panel-body">
                    @include ('users.addtimetable')
                </div>
            </div>

            @can ('checkrole', 'super_admin')
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Actualizar Perfil</h3></div>
                    <div class="panel-body">
                        @include ('users.updaterole')
                    </div>
                </div>
            @endcan

        </div>
    </div>
</div>

@endsection
