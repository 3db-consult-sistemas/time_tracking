@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">

            <ol class="index breadcrumb" style="background-color: transparent;">
                <li><a href="#exmaples">Ejemplos</a></li>
                <li><a href="#schema">Diagrama de Estados</a></li>
                <li><a href="#access">Primer acceso</a></li>
            </ol>

            <div id="exmaples" class="panel panel-default">
                <div class="panel-body">
                    <h3>Ejemplos</h3>
                    <hr>

                    <p><strong>Jornada normal</strong></p>
                    <table>
                        <thead><tr><th>Hora</th><th>Comentario</th><th>Acción</th></tr></thead>
                        <tbody>
                                <tr><td>08:30</td><td>Entrar</td><td>Check In</td></tr>
                                <tr><td>11:30</td><td>Descanso</td><td>Check Out</td></tr>
                                <tr><td>12:00</td><td>Fin descanso</td><td>Check In</td></tr>
                                <tr><td>14:30</td><td>Comida</td><td>Check Out</td></tr>
                                <tr><td>15:30</td><td>Vuelta de comer</td><td>Check In</td></tr>
                                <tr><td>18:15</td><td>Salida</td><td>Check Out</td></tr>
                        </tbody>
                    </table>

                    <p>Si se tiene que realizar una <strong>asusencia justificada a media mañana</strong>, como por ejemplo ir al médico, la ausencia puede tener una duración indefinida terminando cuando se le pulse al botón "Terminar Ausencia"</p>
                    <table>
                        <thead><tr><th>Hora</th><th>Comentario</th><th>Acción</th></tr></thead>
                        <tbody>
                                <tr><td>08:30</td><td>Entrar</td><td>Check In</td></tr>
                                <tr><td>10:30</td><td>Ir al médico</td><td>Ausencia</td></tr>
                                <tr><td>11:15</td><td>Volver del médico</td><td>Terminar Ausencia</td></tr>
                                <tr><td>11:30</td><td>Descanso</td><td>Check Out</td></tr>
                                <tr><td colspan="3">...</td></tr>
                        </tbody>
                    </table>

                    <p><strong>Asusencia justificada antes de la hora de comer o de finalizar la jornada.</strong> Pulsar "Ausencia Programada" y mantener la fecha vacía, la ausencia comenzará en el momento de pulsar el botón "Ausencia" y durará los minutos indicados en duración, una vez pasado ese tiempo se hará un "Check Out" automático. Si al final la ausencia dura menos de 1 hora y vuelves al puesto de trabajo, al darle a "Cancelar Ausencia Programada" el tiempo de la ausencia se ajustará al tiempo empleado.</p>
                    <table>
                        <thead><tr><th>Hora</th><th>Comentario</th><th>Acción</th></tr></thead>
                        <tbody>
                                <tr><td>08:30</td><td>Entrar</td><td>Check In</td></tr>
                                <tr><td>11:30</td><td>Descanso</td><td>Check Out</td></tr>
                                <tr><td>12:00</td><td>Fin Descanso</td><td>Check In</td></tr>
                                <tr><td>13:30</td><td>Ir al médico</td><td>Ausencia programada de 1hora</td></tr>
                                <tr><td>15:30</td><td>Vuelta de comer</td><td>Check In</td></tr>
                                <tr><td colspan="3">...</td></tr>
                        </tbody>
                    </table>

                    <p><strong>El día siguiente se entrará mas tarde.</strong> En vez de salir con "Check Out", se programa una ausencia indicando la fecha de inicio de la jornada siguiente y la duración que tendrá esta. En la duración tirar por lo alto para no quedaros cortos, cuando volvais y le deis a "Cancelar Ausencia Programada" se ajustara al tiempo empleado.</p>
                    <table>
                        <thead><tr><th>Hora</th><th>Comentario</th><th>Acción</th></tr></thead>
                        <tbody>
                                <tr><td colspan="3">...</td></tr>
                                <tr><td>15:30</td><td>Vuelta de comer</td><td>Check In</td></tr>
                                <tr><td>18:15</td><td>Salida</td><td>Ausencia programada de 1hora para el siguiente día.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="schema" class="panel panel-default">
                <div class="panel-body">
                    <h3>Diagrama de Estados</h3>
                    <hr>
                    <img class="img-responsive center-block" src="{!! asset('images/esquema_funcionamiento.png') !!}" alt="imagen" >
                </div>
            </div>

            <div id="access" class="panel panel-default">
                <div class="panel-body">
                    <h3>Primer acceso</h3>
                    <hr>
                    <p>El usuario y contraseña es el mismo empleado para acceder a los quipos dentro de 3dB. Por ejemplo, siendo el nombre 'XXXX', y el apellido 'YYYY', el usuario de acceso a la herramienta sería 'XXXX.YYYY'.</p>
                    <p>Cuando se entra por primera vez, al nuevo usuario se le asigna un horario de lunes a jueves de 8:15 horas, y los viernes de 7 horas. De tenerse otro horario, debido a reducción de jornada u otro motivo habría que comunicárselo a alguno de los administradores para que actualicen el horario.</p>
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

<style>
table {
    border-collapse: collapse;
    margin-top: 1em;
    margin-bottom: 2em;
}
td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 5px;
    min-width: 150px;
}
</style>
@endpush
