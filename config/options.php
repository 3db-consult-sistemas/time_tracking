<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Close After
    |--------------------------------------------------------------------------
    |
    | Numero de minutos entre la hora de check_in y la de cirre para determinar
    | si a de cerrarse la entrada y crear un ticket de revision.
    |
    | Para 300 minutos, las entradas abiertas con una diferencia de 5 horas
    | respecto a la de cierre y sin check_out, se cerraran y se generara un ticket
    | asociado.
    |
    */

    'close_after' => 300,


    /*
    |--------------------------------------------------------------------------
    | Add Seconds To Aggregate
    |--------------------------------------------------------------------------
    |
    | Numero de minutos que se suma al agregado por dia para compesar el inicio
    | de sesión.
    |
    */

    'add_seconds_to_aggregate' => 300,

];
