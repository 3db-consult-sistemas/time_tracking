@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Indice</h4>
                    <hr>
                    <nav class="index">
                        <ul class="">
                            <li><a href="#access">Primer acceso</a></li>
                            <li><a href="#schema">Esquema de funcionamiento</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div id="access" class="panel panel-default">
                <div class="panel-body">
                    <h4>Primer acceso</h4>
                    <hr>
                    <p>El usuario y contraseña es el mismo empleado para acceder a los quipos dentro de 3dB. Por ejemplo, siendo el nombre 'XXXX', y el apellido 'YYYY', el usuario de acceso a la herramienta sería 'XXXX.YYYY'.</p>
                    <p>Cuando se entra por primera vez, al nuevo usuario se le asigna un horario de lunes a jueves de 8:15 horas, y los viernes de 7 horas. De tenerse otro horario, debido a reducción de jornada u otro motivo habría que comunicárselo a alguno de los administradores para que actualicen tu horario.</p>
                </div>
            </div>

            <div id="schema" class="panel panel-default">
                <div class="panel-body">
                    <h4>Funcionamiento</h4>
                    <hr>
                    <img class="img-responsive center-block" src="{!! asset('images/esquema_funcionamiento.png') !!}" alt="imagen" >
                </div>
            </div>


        </div>
    </div>
</div>

@endsection

@push('head')
<script>
$(document).ready(function(){
    // Add smooth scrolling to all links in navbar + footer link
    $(".index a").on('click', function(event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();
            var hash = this.hash;

            // Specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 900, function() {
                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        }
    });
})
</script>
@endpush
