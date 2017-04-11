function moveTile(tile) {

	var clickedSpace = parseInt(tile.getAttribute('name'));

	var spaces = document.getElementById("board").getElementsByTagName("div");
	
	var emptySpace = parseInt(document.getElementById("empty").getAttribute('name'));

	//click on empty space, do nothing
	if (clickedSpace == emptySpace) return;


	//empty space in same row as tile
	if (Math.floor(emptySpace/4) == Math.floor(clickedSpace/4)) {

		//empty space to the right of tile
		if (emptySpace - clickedSpace > 0) {
			for (var i = emptySpace; i > clickedSpace; i--) {
				spaces[i].innerHTML = spaces[i - 1].innerHTML;
			}
		}
		
		//empty space to the left of tile
		if (clickedSpace - emptySpace > 0) {
			for (var i = emptySpace; i < clickedSpace; i++) {
				spaces[i].innerHTML = spaces[i + 1].innerHTML;
			}
		}

		//set new empty space
		spaces[emptySpace].setAttribute('id', '');
		spaces[clickedSpace].setAttribute('id', 'empty');
		spaces[clickedSpace].innerHTML = "";

		$.post("/projects/puzzle/move", {name: $("input").val(), board: $("#board").html()});
		//socket.emit('TileMoved', {name: $("input").val(), board: $("#board").html()});
		return;
	}

	//empty space in same column as tile
	if (clickedSpace % 4 == emptySpace % 4) {

		//empty space below tile
		if (emptySpace > clickedSpace) {
			for (var i = emptySpace; i > clickedSpace; i -= 4) {
				spaces[i].innerHTML = spaces[i - 4].innerHTML;
			}
		}
		
		//empty space above tile
		if (emptySpace < clickedSpace) {
			for (var i = emptySpace; i < clickedSpace; i += 4) {
				spaces[i].innerHTML = spaces[i + 4].innerHTML;
			}
		}

		//set new empty space
		spaces[emptySpace].setAttribute('id', '');
		spaces[clickedSpace].setAttribute('id', 'empty');
		spaces[clickedSpace].innerHTML = "";

		$.post("/projects/puzzle/move", {name: $("input").val(), board: $("#board").html()});
		//socket.emit('TileMoved', {name: $("input").val(), board: $("#board").html()});

		return;
	}

}

function randomize() {

	var arr = Array(16);

	for (var i = 0; i < 16; i++) {
		arr[i] = i + 1;
	}

	for (var i = 15; i > 0; i--) {
		var x = Math.floor(Math.random() * (i+1));
		var tmp = arr[x];
		arr[x] = arr[i];
		arr[i] = tmp;
	}

	var spaces = $('#board').children('div');
	spaces.attr('id', '');

	for (var num = 0; num < 16; num++) {
		if (arr[num] == 16) {
			spaces[num].setAttribute('id', 'empty');
		}
		else {
			spaces[num].innerHTML = arr[num];
		}
	}
}

function distance(pos, num) {
	
	var row = Math.floor(pos / 4);
	
	var col = pos % 4;

	var goalRow = Math.floor(num / 4);

	var goalCol = num % 4;

	return Math.abs(row - goalRow) + Math.abs(col - goalCol);
}