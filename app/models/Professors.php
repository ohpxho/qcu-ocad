<?php


class Professors {
	public function __construct() {
		$this->db = new Database();
	}

	public function findProfessorById($id) {
		$this->db->query("SELECT * FROM professors WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}
}

?>