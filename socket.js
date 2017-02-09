var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
// var Redis = require('ioredis');
// var redis = new Redis();

io.on('connection', function(socket){
	console.log('connected');
	socket.on('TileMoved', function(message) {
		console.log(message.board);
		io.emit('UpdateBoard', {name: message.name, board: message.board});
	});
});
/*redis.subscribe('TileDidMove', function(err, count) {
	console.log('subscribed');
});*/

/*redis.on('message', function(channel, message) {
	console.log("Message received: " + message);
	message = JSON.parse(message);
	io.emit(channel + ':' + message.event, message.data);
});*/

http.listen(8000, function() {
	console.log('Listening on Port 8000');
});