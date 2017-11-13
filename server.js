var socket  = require( 'socket.io' );
var express = require('express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3000;

/*var connections = [];
var nicknames	= [];*/

var users = [];

server.listen(port, function () {
	console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {
	//console.log('Connected: %s sockets connected', users.length);
	
	//Connection 
	socket.on( 'join', function( data ) {
		
		if(users.indexOf(data.userID) != -1){
			users.splice(users.indexOf(data.userID), 1);
		}		
		users.push(data.userID);
		
		//Joing room
		socket.join(data.userID);	
		
		io.sockets.emit( 'connected', users);	

		//Disconnect
		socket.on('disconnect',function(){
			users.splice(users.indexOf(data.userID), 1);
			io.sockets.emit( 'connected', users );
		}); 
		
	});

	//New Message
	socket.on( 'new_message', function( data ) {
		socket.broadcast.to(data.sendTo).emit( 'new_message', data);
	});
	
	//Read Message
	socket.on( 'read_message', function( data ) {
		socket.broadcast.to(data.sendTo).emit( 'read_message', data);
	});
	
	//Typing Message
	socket.on( 'typing', function( data ) {
		socket.broadcast.to(data.sendTo).emit( 'typing', data);
	});
	
	//New request notification
	socket.on( 'server_new_request', function( data ) {
		io.sockets.emit( 'client_new_request', data );
	});
	
});
