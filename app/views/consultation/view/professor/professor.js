$(document).ready(function() {
	
	$(window).load(function() {
		var conn = new WebSocket('ws://localhost:8082');
		conn.onopen = function(e) {
		    console.log("Connection established!");
		};
	});

	$('#chat-btn').click(function() {
		
	});
});