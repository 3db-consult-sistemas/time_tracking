<div class="table-responsive">
    <table class="table table-condensed">

        <?php $total = 0; $totalNightShift = 0; $totalEstimate = 0; $totalDiff = 0; ?>

        <thead>
            <tr>
                <th>Trabajador</th>
                <th>Fecha</th>
                <th>Día</th>
				<th>Trabajado</th>
				<th>Nocturnas</th>
                <th>Teórico</th>
                <th>Diferencia</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($entries as $entry)
                <tr>
                    <?php
					$total += $entry->secs;
					$totalNightShift += $entry->night_shift;
                    $totalEstimate += $entry->hoursToWork;
                    $diff = $entry->secs - $entry->hoursToWork;
                    $totalDiff += $diff;
                    ?>

                    <td>{{ $entry->user_name }}</td>
                    <td>{{ $entry->_date }}</td>
                    <td>{{ date('l', strtotime($entry->_date)) }}</td>
					<td>{{ Helpers::formatSeconds($entry->secs) }}</td>
					<td>{{ $entry->night_shift > 0 ? Helpers::formatSeconds($entry->night_shift) : '-' }}</td>
                    <td>{{ Helpers::formatSeconds($entry->hoursToWork) }}</td>
                    <td class="{{ $diff < 0 ? 'danger' : 'success' }}">{{ Helpers::formatSeconds($diff) }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot style="border-top: 2px solid black;">
            <tr class="{{ $totalDiff < 0 ? 'danger' : 'success' }}">
                <td></td>
                <td></td>
                <td></td>
				<td>{{ Helpers::formatSeconds($total) }}</td>
				<td>{{ Helpers::formatSeconds($totalNightShift) }}</td>
                <td>{{ Helpers::formatSeconds($totalEstimate) }}</td>
                <td>{{ Helpers::formatSeconds($totalDiff) }}</td>
            </tr>
        </tfoot>

    </table>
</div>
