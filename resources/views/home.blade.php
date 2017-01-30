@extends('layouts.layout')
@section('content')
<div class="flex-center position-ref three-quarter-height">

    <div class="align-center">
        <div class="title m-b-md">
            Daniel Cohen
        </div>
        <div class="links">
            <a href= "{{ url('/cs') }}">Computer Science</a>
            <a href="img/resume.pdf">Resume</a>
            <a href="{{ url('/beercheese') }}">Beer & Cheese</a>
        </div>
        <p class="m-t-md"><em>--"More than just an average beard"</em></p>
    </div>
</div>
@stop
