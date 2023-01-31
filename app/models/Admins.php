<?php

class Admins {
	public function __construct() {
		$this->db = new Database();
	}

	public function findAdminById($id) {
		$this->db->query("SELECT * FROM admin WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}
}


?>