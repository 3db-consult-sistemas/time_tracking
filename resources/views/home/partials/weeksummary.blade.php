<table class="table">
    <?php
    $total = 0;
    $totalEstimate = 0;
    $totalDiff = 0;
    ?>

    <thead>
        <tr>
            <th>Día</th>
            <th>Fecha</th>
            <th>Trabajado</th>
            <th>Teórico</th>
            <th>Diferencia</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($entries as $entry)
            <tr>
                <?php
                $total += $entry->secs;
                $totalEstimate += $entry->hoursToWork;
                $diff = $entry->secs - $entry->hoursToWork;
                $totalDiff += $diff;
                ?>

                <td>{{ date('l', strtotime($entry->_date)) }}</td>
                <td>{{ $entry->_date }}</td>
                <td>{{ formatSeconds($entry->secs) }}</td>
                <td>{{ formatSeconds($entry->hoursToWork) }}</td>
                <td class="{{ $diff < 0 ? 'danger' : 'success' }}">{{ formatSeconds($diff) }}</td>
            </tr>
        @endforeach
    </tbody>

    <tfoot style="border-top: 2px solid black;">
        <tr class="{{ $totalDiff < 0 ? 'danger' : 'success' }}">
            <td>Total</td>
            <td></td>
            <td>{{ formatSeconds($total)  }}</td>
            <td>{{ formatSeconds($totalEstimate)  }}</td>
            <td>{{ formatSeconds($totalDiff) }}</td>
        </tr>
    </tfoot>

</table>
