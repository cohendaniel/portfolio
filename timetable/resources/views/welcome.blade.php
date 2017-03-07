@extends('layouts.timetable')

@section('content')

<div class="jumbotron">
    <div>
        <h1>Welcome to TimeTable</h1>
        <h2 class="text-muted">An automated event scheduler</h2>
    </div>
    <div class='container'>
        <a href="{{ url('/timetable/login') }}" class='btn btn-lg'>Login</a>
    </div>
    <div class='container mt-sm'>
        <a href="{{ url('/timetable/register') }}" class='btn btn-lg'>Register</a>
    </div>
</div>
<div class="jumbotron bc-bold">
    <div id="home-semi-circle">
    </div>
    <div>
        <h2>Save the headaches</h2>
        <h3 class="mx-50">Efficiently schedule your volunteers, employees or resources with a click of a button</h3>
    </div>
    <div class='container'>
        <a href="{{ url('/timetable/demo') }}" class='btn btn-lg'>Learn More</a>
    </div>
</div>

@endsection