@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include ('layouts.errors')
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" style="margin-top:.4em;">Solicitud de cambio</h3>

                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">

					<p>Inserte un comentario describiendo lo que deseas modificar del registro:</p>

					<p style="margin-left: 2em;"><strong>- Check-In:</strong> {{ $record->check_in }}</p>
					<p style="margin-left: 2em;"><strong>- Check-Out:</strong> {{ $record->check_out }}</p>
					<p style="margin-left: 2em;"><strong>- Proyecto:</strong> {{ $record->project }}</p>

					<form method="POST" action="{{ url('/tickets') }}">
						{{ csrf_field() }}

						<input type="hidden" name="record_id" value="{{ $record->id }}">
						<input type="hidden" name="user_id" value="{{ $record->user_id }}">

						<div class="form-group" style="margin-top:2em;">
							<label>Comentario:</label>
							<textarea name="comments"
								class="form-control"
								style="resize:none;"
								rows="3"
								autocomplete="off"
								maxlength="191"
								placeholder="Solicitud...">{{ old('comments') }}</textarea>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-ticket" aria-hidden="true"></i> Crear Ticket
							</button>
						</div>
					</form>


                </div>
            </div>

            <div class="form-group pull-right">
                <?php $urlText = '/summary?userName=' . $record->user->username . '&aggregate=record'; ?>
                <a class="btn btn-default" href="{{ url($urlText) }}">Volver</a>
            </div>

        </div>
    </div>
</div>

@endsection
