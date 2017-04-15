@extends('layouts.layout')
@section('content')
<div class="flex-center position-ref three-quarter-height">
    <div class="row container align-center">
    	<div class="col-md-4">
        	<a href="{{ url('/projects/puzzle') }}"><img src="\img\puzzle.JPG" height="300px"></a>
        	<p class="font-md no-margin">15-Puzzle</p>
        </div>
        <div class="col-md-4">
        	<a href="{{ url('/projects/senate') }}"><img src="\img\senate.JPG" height="300px"></a>
        	<p class="font-md no-margin">SenaTwitter</p>
        </div>
        <div class="col-md-4">
            <a href="https://github.com/cohendaniel/music-rec-lastfm"><img src="\img\music.png" height="300px"></a>
            <p class="font-md no-margin">MusicRec</p>
        </div>     
    </div>
</div>
@stop
