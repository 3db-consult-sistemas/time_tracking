@extends('errors.template')

@section('content')
	<div class="title"><strong>Error 403, Forbidden</strong></div>
	<div class="message">{{ $exception->getMessage() }}</div>
@endsection
