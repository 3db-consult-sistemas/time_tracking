<?php

namespace App\Model\Record;

use Carbon\Carbon;
use App\Model\Helpers;
use App\Model\Record\Record;

class NightShift
{
	/**
	 * Calculo el tiempo trabajado en horario nocturno en segundos.
	 */
	public static function getTimeInSeconds(Carbon $checkIn, Carbon $checkOut)
	{
		$start = Helpers::timeToSeconds(config('options.night_shift.start'));	// 22:00
		$end = Helpers::timeToSeconds(config('options.night_shift.end'));		// 06:00
		$checkIn = Helpers::timeToSeconds($checkIn->format('H:i:s'));
		$checkOut = Helpers::timeToSeconds($checkOut->format('H:i:s'));

		if ($checkIn >= $end && $checkIn <= $start) {
			// 09:00 - 18:00 (Horario normal)
			if ($checkOut >= $end && $checkOut <= $start) { return 0; }

			// 09:00 - 23:15 (Termino en horario nocturno)
			if ($checkOut > $start) { return $checkOut - $start; }

			// 09:00 - 02:15 (Termino en horario nocturno de madrugada)
			return (86400 - $start) + $checkOut;
		}

		if ($checkIn > $start) {
			// 23:15 - 23:45
			if ($checkOut > $start) { return $checkOut - $checkIn; }

			// 23:15 - 02:00
			return (86400 - $checkIn) + $checkOut;
		}

		// 05:00 - 11:00 (Empiezo en horario nocturno)
		if ($checkIn <= $end && ($checkOut > $end && $checkOut < $start)) { return $end - $checkIn; }

		// 01:15 - 02:00
		return $checkOut- $checkIn;
	}
}
