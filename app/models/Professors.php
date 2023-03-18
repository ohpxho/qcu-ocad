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

	public function findProfessorsByDepartment($dep) {
		$this->db->query("SELECT * FROM professors WHERE department=:department ORDER BY lname ASC");
		$this->db->bind(':department', $dep);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function add($details) {
		$validate = $this->validateAddInputs($details);

		if(empty($validate)) {
			$this->db->query("INSERT INTO professors (id, email, lname, fname, mname, contact, gender, department) VALUES (:id, :email, :lname, :fname, :mname, :contact, :gender, :department)");
			$this->db->bind(':id', $details['id']);
			$this->db->bind(':email', $details['email']);
			$this->db->bind(':lname', $details['lname']);
			$this->db->bind(':fname', $details['fname']);
			$this->db->bind(':mname', $details['mname']);
			$this->db->bind(':contact', $details['contact']);
			$this->db->bind(':gender', $details['gender']);
			$this->db->bind(':department', $details['department']);
		
			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while adding admin account, please try again';
		}

		return $validate;
	}

	public function update($details) {
		$validate = $this->validateUpdateInputs($details);

		if(empty($validate)) {
			$this->db->query("UPDATE professors SET lname=:lname, fname=:fname, mname=:mname, department=:department, gender=:gender, contact=:contact WHERE id=:id");
			$this->db->bind(':id', $details['id']);
			$this->db->bind(':lname', $details['lname']);
			$this->db->bind(':fname', $details['fname']);
			$this->db->bind(':mname', $details['mname']);
			$this->db->bind(':department', $details['department']);
			$this->db->bind(':gender', $details['gender']);
			$this->db->bind(':contact', $details['contact']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while updating profile, please try again';
		}

		return $validate;
	}

	public function delete($id) {
		$this->db->query('DELETE professors.*, users.* FROM professors INNER JOIN users ON professors.id = users.id WHERE professors.id=:id');
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function getAllProfessor() {
		$this->db->query("SELECT * FROM users INNER JOIN professors ON users.id = professors.id ORDER BY FIELD(status, 'for review', 'active', 'closed', 'blocked', 'declined')");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getProfessorRecords($id) {
		$this->db->query("SELECT * FROM users INNER JOIN professors ON users.id = professors.id WHERE users.id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function update_email($id, $email) {
		$this->db->query("UPDATE professors SET email=:email WHERE id=:id");
		$this->db->bind(':email', $email);
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	private function validateUpdateInputs($details) {
		if(empty($details['lname'])) return 'Lastname is required';
		
		if(empty($details['fname'])) return 'Firstname is required';
		
		if(empty($details['department'])) return 'Department is required';
		
		if(empty($details['gender'])) return 'Gender is required';

		if(empty($details['contact'])) return 'Contact is required';
		
		if(!is_numeric($details['contact']) || !preg_match('/^[0-9]{11}+$/', $details['contact'])) return 'Contact has wrong format.';

		return '';
	}
}

?>