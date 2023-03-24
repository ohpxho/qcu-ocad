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

	public function findSubjectById($id) {
		$this->db->query("SELECT * FROM subject_codes WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getAllSubject() {
		$this->db->query("SELECT * FROM subject_codes");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function add($details) {
		$validate = $this->validateAddInputs($details);

		if(empty($validate)) {
			$this->db->query("INSERT INTO subject_codes (code, title, department) VALUES (:code, :title, :department)");
			$this->db->bind(':code', $details['code']);
			$this->db->bind(':title', $details['title']);
			$this->db->bind(':department', $details['department']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while adding subject, please try again';
		}

		return $validate;
	}

	public function update($details) {
		$validate = $this->validateUpdateInputs($details);

		if(empty($validate)) {
			$this->db->query("UPDATE subject_codes SET code=:code, title=:title, department=:department WHERE id=:id");
			$this->db->bind(':code', $details['code']);
			$this->db->bind(':title', $details['title']);
			$this->db->bind(':department', $details['department']);
			$this->db->bind(':id', $details['id']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while updating subject, plesae try again';
		}

		return $validate;
	}

	public function drop($id) {
		$this->db->query("DELETE FROM subject_codes WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	private function validateAddInputs($details) {
		if(empty($details['code'])) return 'Subject code is required';

		if(empty($details['title'])) return 'Subject title is required';

		if(empty($details['department'])) return 'Department is required';

		return '';
	}

	private function validateUpdateInputs($details) {
		if(empty($details['id'])) return 'A problem occured, please try again';

		if(empty($details['code'])) return 'Subject code is required';

		if(empty($details['title'])) return 'Subject title is required';

		if(empty($details['department'])) return 'Department is required';

		return '';
	}
}


?>