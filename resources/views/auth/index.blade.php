@extends('layouts.layout')
@section('content')
<div class="flex-center position-ref three-quarter-height">
    <div class="row container">
    	<a href="{{ url('beercheese/admin') }}">Beercheese</a>
    	<a href="{{ url('blog/admin') }}">Blog</a>
    </div>
</div>
@stop
