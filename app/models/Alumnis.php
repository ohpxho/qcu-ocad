<?php

class Alumnis {
	public function __construct() {
		$this->db = new Database();
	}

	public function getAlmuniById($id) {
		$this->db->query("SELECT * FROM alumnis WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;
		
		return false;
	}
}


?>