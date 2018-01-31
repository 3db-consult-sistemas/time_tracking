<div class="table-responsive">
    <table class="table">
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
