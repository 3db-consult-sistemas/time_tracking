<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Close After
    |--------------------------------------------------------------------------
    |
    | Numero de minutos entre la hora de check_in y la de cierre para determinar
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

    /*
    |--------------------------------------------------------------------------
    | Absence options
    |--------------------------------------------------------------------------
    |
    | Opciones en el desplegable para hacer una ausencia.
    |
    */

    'absence_options' => [
        'descanso' => 'descanso',
        'medico' => 'consulta médica',
        'otros' => 'otros',
    ],


    /*
    |--------------------------------------------------------------------------
    | Lunch Duration
    |--------------------------------------------------------------------------
    |
    | Duración del tiempo de la commida en segundos.
    |
    */

    'lunch_time' => 3600,


    /*
    |--------------------------------------------------------------------------
    | Break Duration
    |--------------------------------------------------------------------------
    |
    | Duración del tiempo de descanso en minutos.
    |
    */

    'break_duration' => 15,


    /*
    |--------------------------------------------------------------------------
    | Absence Duration
    |--------------------------------------------------------------------------
    |
    | Duración mínima de la ausencia.
    |
    */

	'absence_duration' => [
		'min' => 10,
		'max' => 540
	],


	/*
    |--------------------------------------------------------------------------
    | Night Shift
    |--------------------------------------------------------------------------
    |
    | Inicio y final del turno nocturno. Usado en los reportes.
    |
    */

    'night_shift' => [
		'start' => '22:00',
		'end' => '6:00'
	],


	/*
    |--------------------------------------------------------------------------
    | Number Paginate
    |--------------------------------------------------------------------------
    |
    | Numero de elementos a visualizar cuando se realicen filtros con paginación.
    |
    */

    'paginate_number_items' => 17,

];
