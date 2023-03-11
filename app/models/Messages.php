<?php

class Messages {
	public function __construct() {
		$this->db = new Database();
	}

	public function findAllMessagesById($id) {
		$this->db->query("SELECT * FROM messages WHERE consultation_id=:id ORDER BY datetime ASC");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function save($msg) {
		$this->db->query("INSERT INTO messages (consultation_id, sender, receiver, message) VALUES (:consultation_id, :sender, :receiver, :message)");
		$this->db->bind(':consultation_id', $msg['consultation-id']);
		$this->db->bind(':sender', $msg['sender']);
		$this->db->bind(':receiver', $msg['receiver']);
		$this->db->bind(':message', $msg['message']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function seen_unseen($id) {
		$this->db->query("UPDATE messages SET is_seen=1 WHERE consultation_id=:id");
		$this->db->bind(':id', $id);
		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function count_unseen($id) {
		$this->db->query("SELECT COUNT(id) as count FROM messages WHERE consultation_id=:id AND is_seen=0");
		$this->db->bind(':id', $id);
		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false; 
	}

	public function count_unseen_of_specific_receiver($consultation, $receiver) {
		$this->db->query("SELECT COUNT(id) as count FROM messages WHERE consultation_id=:id AND receiver=:receiver AND is_seen=0");
		$this->db->bind(':id', $consultation);
		$this->db->bind(':receiver', $receiver);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false; 
	}
}

?>