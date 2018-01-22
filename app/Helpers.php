<?php

function formatSeconds($seconds) {
    $symbol = $seconds < 0 ? '-' : '';
    $seconds = abs($seconds);
    $hours = floor($seconds/3600);
    $minutes = floor(($seconds-($hours*3600))/60);
    $seconds = $seconds-($hours*3600)-($minutes*60);
    return sprintf("%s%02d:%02d:%02d", $symbol, $hours, $minutes, $seconds);
}
