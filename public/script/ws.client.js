const ID = <?php echo json_encode($_SESSION['id']) ?>;

const conn = new WebSocket('ws://localhost:8082/client?id=' + encodeURIComponent(ID));

conn.onopen = function(e) {
    console.log("Connection established!");
    broadcastOnlineToAllOnlineUsers(ID);
};

function broadcastOnlineToAllOnlineUsers(id) {
	const msg = {
		action: 'BROADCAST_IM_ONLINE',
		id: id
	};

	conn.send(JSON.stringify(msg));
}