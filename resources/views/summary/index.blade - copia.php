@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">

                    @include('summary.filter')

                    Ultimas entradas

                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Trabajador</th>
                                <th>Tipo</th>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Final</th>
                                <th>Diferencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                <tr>
                                    <td>{{ $entry->name }}</td>
                                    <td>{{ $entry->type }}</td>
                                    <td>{{ $entry->date }}</td>
                                    <td>{{ $entry->time_in }}</td>
                                    <td>{{ $entry->time_out }}</td>
                                    <td>{{ Helpers::formatSeconds($entry->secs)  }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $entries->links() }}

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
