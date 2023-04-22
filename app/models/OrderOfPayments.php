<?php

class OrderOfPayments {
	public function __construct() {
		$this->db = new Database();
	}

	public function findOrderOfPayment($no) {
		$this->db->query("SELECT * FROM order_of_payments WHERE id=:id");
		$this->db->bind(':id', $no);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function add($details) {
		$this->db->query("INSERT INTO order_of_payments (id, type, request_id) VALUES (:id, :type, :request_id)");
		$this->db->bind(':id', $details['transaction-no']);
		$this->db->bind(':type', $details['type']);
		$this->db->bind(':request_id', $details['request-id']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

}


?>