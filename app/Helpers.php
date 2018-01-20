<?php

function formatSeconds($seconds) {
    $hours = floor($seconds/3600);
    $minutes = floor(($seconds-($hours*3600))/60);
    $seconds = $seconds-($hours*3600)-($minutes*60);
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}
