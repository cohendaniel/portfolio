@extends('layouts/layout')

@section('content')
	<h1>This is the beer cheese pairing page</h1>

	<ul>
		@foreach ($pairs as $pair)
			<li>{{ $pair->beer->name }} and {{ $pair->cheese->name }}</li>
		@endforeach
	</ul>
@stop