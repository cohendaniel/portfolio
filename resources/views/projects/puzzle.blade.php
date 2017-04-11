@extends('layouts.layout')

@section('head')
	<link href="/css/15-puzzle.css" rel="stylesheet">
	<script src="//js.pusher.com/4.0/pusher.min.js"></script>
@stop

@section('content')
<div class="col-md-4">
	<div id="info">
		<p>
			This is a classic game that I used to play with a lot as a kid. Instead of the fragile plastic typically used, I decided to make a (hopefully) less breakable version. Currently, I have constructed the moving of tiles and am working on event-driven, real time communication so that multiple people can play the same board at the same time. 
		</p>
		<p>
			<em><b>Try it out: open two browser windows and put a different name in the text field for each window. Play the game. The pieces will move around on both boards.</b></em>
		</p>
		<p>
			Update: I have included a solver using the A* algorithm. The solver is effective when a small number of moves are made (~10 or less). The solver does not find solutions in a reasonable amount of time for heavily shuffled boards. My next steps are to test different heuristics to improve efficiency.
		</p>
	</div>
</div>
<div class="col-md-8">
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
	<div class="center">
		<div id="solve" class="btn btn-primary center">Solve</div>
	</div>
</div>

@stop

@section('footer')

	<script src="{{ asset('js/script.js') }}" type="text/javascript"></script>

	<script>

		//randomize();

		var pusher = new Pusher('04f3027d475b3b5e7b4f', {
			encrypted: true
		});
		var channel = pusher.subscribe('TileDidMove');
		channel.bind('App\\Events\\TileMoved', function(msg) {
			$("#message").text(msg.data.name + " moved a tile");
			$("#board").html(msg.data.board);
		});

		$("#solve").on('click', function() {
			$("#empty").html("16");
			var boardArray = $("#board div").map(function() {
				return $(this).text();
			}).get();
			$("#empty").html('');
			
			$.post("/projects/puzzle/solve", {board: boardArray}, function(path) {
				console.log(path);
				for (var i = path.length - 1; i >= 0; i--) {
					wait(i, path);
				}
			});
		});

		function wait(i, path) {
			setTimeout(function() {
				updateBoard(path[i]);
			}, i * 1000);
		}

		function updateBoard(arr) {
			console.log(arr);
			$('#board div').each(function(i, e) {
				if (arr[i] == 16) {
					$(this).attr('id', 'empty');
					$(this).html('');
				}
				else {
					$(this).attr('id','');
					$(this).html(arr[i]);
				}
			});
		}
	</script>

@stop