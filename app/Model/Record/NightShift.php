<?php

namespace App\Model\Record;

use Carbon\Carbon;
use App\Model\Helpers;
use App\Model\Record\Record;

class NightShift
{
	/**
	 * Calculo el tiempo trabajado en horario nocturno en segundos.
	 *
	 */
	public static function getTimeInSeconds(Carbon $checkIn, Carbon $checkOut)
	{
		$diffDay = $checkIn->day !== $checkOut->day;
		$checkIn = Helpers::timeToSeconds($checkIn->format('H:i:s'));
		$checkOut = Helpers::timeToSeconds($checkOut->format('H:i:s'));

		// Comienzo y final del horario nocturno (incluidas)
		$start = Helpers::timeToSeconds(config('options.night_shift.start'));	// 22:00
		$end = Helpers::timeToSeconds(config('options.night_shift.end'));		// 06:00

		// Empiezo en horario nocturno (noche)
		if ($checkIn >= $start) {
			// 23:15 - 23:45
			if ($checkOut >= $start) { return $checkOut - $checkIn; }

			// 23:15 - 02:00
			if ($checkOut <= $end) { return (86400 - $checkIn) + $checkOut; }

			// 23:15 - 06:05
			return (86400 - $checkIn) + $end;
		}

		// Empiezo en horario diurno
		if ($checkIn > $end) {
			// 09:00 - 23:15 (Termino en horario nocturno)
			if ($checkOut >= $start) { return $checkOut - $start; }

			// 09:00 - 02:15 (Termino en horario nocturno de madrugada)
			if ($checkOut <= $end) { return (86400 - $start) + $checkOut; }

			// 09:00 - 18:00 Empieza y termina en horario diurno (puede ser del mismo dia o diferente)
			return $diffDay ? (86400 - $start) + $end : 0;
		}

		// Empiezo en horario nocturno (madrugada)
		// 01:15 - 02:00
		if ($checkOut <= $end) { return $checkOut - $checkIn; }

		// 05:00 - 23:00
		if ($checkOut >= $start) { return ($end - $checkIn) + ($checkOut - $start); }

		// 05:00 - 11:00
		return $end - $checkIn;
	}
}
