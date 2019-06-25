<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="3dB Consult">
	<link rel="icon" href="{!! asset('images/favicon.ico') !!}">

	<script type="text/javascript">
        window.__BREAK_TIME = @json(config('options.break_duration'));
        window.__ABSENCE_MIN = @json(config('options.absence_duration.min'));
		window.__ABSENCE_MAX = @json(config('options.absence_duration.max'));
    </script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>3dB Control Horario</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">
        if (typeof window.orientation !== 'undefined') {
            window.location = '{{ url('mobile') }}';
        }
    </script>

    @stack('head')
</head>

<body>
    <div id="app">
        @include ('layouts.navbar')
        @yield('content')
    </div>

    @stack('bottom')
</body>

</html>
