<?php


class SubjectCodes {
	public function __construct() {
		$this->db = new Database();
	}

	public function findSubjectsByDepartment($dep) {
		$this->db->query("SELECT * FROM subject_codes WHERE department=:department ORDER BY code ASC");
		$this->db->bind(':department', $dep);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}
}


?>