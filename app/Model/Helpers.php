<?php

namespace App\Model;

use Carbon\Carbon;

trait Helpers
{
	/**
     * Convierto la fecha de entrada a una instancia de Carbon.
     *
     * @param  $date
     * @param  $format
     * @return Carbon
     */
    public function toCarbon($date, $format = 'Y-m-d H:i')
	{
        if ($date == null) return null;

        return Carbon::createFromFormat($format, $date);
    }

	/**
     * Doy formato de H:m:s a los segundos de entrada.
     *
     * @param  $seconds
     * @return string
     */
    public static function formatSeconds($seconds) {
        $symbol = $seconds < 0 ? '-' : '';
        $seconds = abs($seconds);
        $hours = floor($seconds/3600);
        $minutes = floor(($seconds-($hours*3600))/60);
        $seconds = $seconds-($hours*3600)-($minutes*60);
        return sprintf("%s%02d:%02d:%02d", $symbol, $hours, $minutes, $seconds);
    }

    /**
     * Doy formato decimal los segundos de entrada.
     *
     * @param  $seconds
     * @return string
     */
    public static function formatSecondsToDecimal($seconds) {
        $symbol = $seconds < 0 ? '-' : '';
        $seconds = abs($seconds);
        $hours = $seconds/3600;
        return sprintf("%s%.2f", $symbol, $hours);
    }

    /**
     * Obtengo la IP del cliente.
     *
     * @return ip
     */
    public static function getIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }

}
