@extends('layouts/layout')

@section('content')
<div class="flex-center position-ref three-quarter-height">
	<div class="align-center">
		<div class="title">
	        Beer & Cheese
	    </div>
		<div class="row m-lr-md display-table">
			<div class="col-md-4 display-table-cell">
				<b><p class="font-sm">{{$pair->beer->brewery." ".$pair->beer->name }}</p></b>
				<p class="font-xs">{{ $pair->beer->comments }}</p>
			</div>

			<div class="col-md-4 b-color-1 display-table-cell">
				<b><p class="font-sm">Pairing notes</p></b>
				<p class="font-xs">{{ $pair->comments }}</p>
			</div>

			<div class="col-md-4 display-table-cell" >
				<b><p class="font-sm">{{$pair->cheese->maker." ".$pair->cheese->name }}</p></b>
				<p class="font-xs">{{ $pair->cheese->comments }}</p>
			</div>
		</div>
		<div class="row p-lr-md m-t-sm m-b-sm">
			<a class="btn btn-default" href="{{ url('beercheese/' . $prev) }}">Previous</a>
			<a class="btn btn-default" href="{{ url('beercheese/' . $next) }}">Next</a>
		</div>
	</div>
</div>
@stop