@extends('layouts.layout')

@section('head')
	<script src="{{ asset('js/script.js') }}" type="text/javascript"></script>

	<link href="/css/15-puzzle.css" rel="stylesheet">
@stop

@section('content')

<h2>15 Puzzle</h2>
	<div id="name">
		<input type="text" placeholder="Name">
	</div>
	<div id="board">
		<div name="0" onclick="moveTile(this)">1</div>
		<div name="1" onclick="moveTile(this)">2</div>
		<div name="2" onclick="moveTile(this)">3</div>
		<div name="3" onclick="moveTile(this)">4</div>
		<div name="4" onclick="moveTile(this)">5</div>
		<div name="5" onclick="moveTile(this)">6</div>
		<div name="6" onclick="moveTile(this)">7</div>
		<div name="7" onclick="moveTile(this)">8</div>
		<div name="8" onclick="moveTile(this)">9</div>
		<div name="9" onclick="moveTile(this)">10</div>
		<div name="10" onclick="moveTile(this)">11</div>
		<div name="11" onclick="moveTile(this)">12</div>
		<div name="12" onclick="moveTile(this)">13</div>
		<div name="13" onclick="moveTile(this)">14</div>
		<div name="14" onclick="moveTile(this)">15</div>
		<div id="empty" name="15" onclick="moveTile(this)"></div>
	</div> 
	<p id="message">
		No one has made a move.
	</p>

@stop

@section('footer')
	<!--<script src="http://localhost:3000/socket.io/socket.io.js"></script>-->
	<script src="http://daniel-cohen.com:3000/socket.io/socket.io.js"></script>
	<script>
		//var socket = io('http://localhost:3000');
		var socket = io('http://daniel-cohen.com:3000')
		socket.on("TileDidMove:App\\Events\\TileMoved", function(msg){
			$("#message").text(msg.data.name + " moved a tile");
			$("#board").html(msg.data.board);
		});
	</script>
@stop