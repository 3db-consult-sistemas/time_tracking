<div class="table-responsive">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>Desde</th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miercoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
                <th>Sabado</th>
                <th>Domingo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->timetables as $timetable)
                <tr>
                    <td>{{ $timetable->date }}</td>
                    <td class="{{ $timetable->monday > 0 ? 'success' : ''}}">{{ Helpers::formatSeconds($timetable->monday) }}</td>
                    <td class="{{ $timetable->tuesday > 0 ? 'success' : ''}}">{{ Helpers::formatSeconds($timetable->tuesday) }}</td>
                    <td class="{{ $timetable->wednesday > 0 ? 'success' : ''}}">{{ Helpers::formatSeconds($timetable->wednesday) }}</td>
                    <td class="{{ $timetable->thursday > 0 ? 'success' : ''}}">{{ Helpers::formatSeconds($timetable->thursday) }}</td>
                    <td class="{{ $timetable->friday > 0 ? 'success' : ''}}">{{ Helpers::formatSeconds($timetable->friday) }}</td>
                    <td class="{{ $timetable->saturday > 0 ? 'success' : ''}}">{{ Helpers::formatSeconds($timetable->saturday) }}</td>
                    <td class="{{ $timetable->sunday > 0 ? 'success' : ''}}">{{ Helpers::formatSeconds($timetable->sunday) }}</td>
                    <td>
                        <form method="POST" action="{{ url('timetable/' . $timetable->id) }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
							<button type="submit"
									class="btn btn-danger btn-sm btn-block btn-delete"
									style="padding: 2px 10px;">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(function () {
        $('.btn-delete').click(function(e){
            if (! confirm('¿Seguro que desea eliminar el horario?')) {
                e.preventDefault();
            }
        });
    });
</script>
