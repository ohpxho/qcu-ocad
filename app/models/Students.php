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

	public function getAllStudent() {
		$this->db->query("SELECT * FROM users INNER JOIN student ON users.id = student.id ORDER BY FIELD(status, 'for review', 'active', 'closed', 'blocked', 'declined')");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getStudentRecords($id) {
		$this->db->query("SELECT * FROM users INNER JOIN student ON users.id = student.id WHERE users.id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function delete($id) {
		$this->db->query('DELETE student.*, users.* FROM student INNER JOIN users ON student.id = users.id WHERE student.id=:id');
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function update($details) {
		$validate = $this->validateUpdateInputs($details);

		if(empty($validate)) {
			if(!empty($details['identification'])) {
				$this->db->query("UPDATE student SET lname=:lname, fname=:fname, location=:location, address=:address, gender=:gender, course=:course, year=:year, section=:section, contact=:contact, type=:type, identification=:identification WHERE id=:id");
				$this->db->bind(':identification', $details['identification']);
			} else {
				$this->db->query("UPDATE student SET lname=:lname, fname=:fname, location=:location, address=:address, gender=:gender, course=:course, year=:year, section=:section, contact=:contact, type=:type WHERE id=:id");
			}

			$this->db->bind(':id', $details['id']);
			$this->db->bind(':fname', $details['fname']);
			$this->db->bind(':lname', $details['lname']);
			$this->db->bind(':location', $details['location']);
			$this->db->bind(':address', $details['address']);
			$this->db->bind(':gender', $details['gender']);
			$this->db->bind(':course', $details['course']);
			$this->db->bind(':year', $details['year']);
			$this->db->bind(':section', $details['section']);
			$this->db->bind(':contact', $details['contact']);
			$this->db->bind(':type', $details['type']);

			$result = $this->db->execute();

			if($result) return '';
			else return 'Some error occured while updating profile, please try again';
		}

		return $validate;
	}

	public function update_email($id, $email) {
		$this->db->query("UPDATE student SET email=:email WHERE id=:id");
		$this->db->bind(':email', $email);
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	private function validateUpdateInputs($details) {
		if(empty($details['lname'])) return 'Lastname is required';
		
		if(empty($details['fname'])) return 'Firstname is required';
		
		if(empty($details['location'])) return 'Location is required';
		
		if(empty($details['address'])) return 'Address is required';
		
		if(empty($details['gender'])) return 'Gender is required';
		
		if(empty($details['course'])) return 'Course is required';
		
		if(empty($details['year'])) return 'Year is required';
	
		if(empty($details['section'])) return 'Section is required';
		
		if(empty($details['contact'])) return 'Contact is required';
		
		if(!is_numeric($details['contact']) || !preg_match('/^[0-9]{11}+$/', $details['contact'])) return 'Contact has wrong format.';
		
		if(empty($details['type'])) return 'Type is required';
		
		return '';	
	}
}


?>