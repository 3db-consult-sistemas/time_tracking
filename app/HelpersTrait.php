<?php

namespace App;

use Carbon\Carbon;

trait HelpersTrait
{
	/**
     * Convierto la fecha de entrada a una instancia de Carbon.
     *
     * @return Carbon
     */
	public function dateToCarbon($date, $format = 'Y-m-d H:i')
	{
        if ($date == null) {
            return null;
        }

        return Carbon::createFromFormat($format, $date, 'Europe/Madrid');
	}
}
