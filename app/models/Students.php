<?php

class Students {
	public function __construct() {
		$this->db = new Database();
	}

	public function findStudentById($id) {
		$this->db->query("SELECT * FROM student WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}
}


?>