<?php

class Alumnis {
	public function __construct() {
		$this->db = new Database();
	}

	public function findAlumniById($id) {
		$this->db->query("SELECT * FROM alumnis WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;
		
		return false;
	}

	public function getAllAlumni() {
		$this->db->query("SELECT * FROM users INNER JOIN alumnis ON users.id = alumnis.id ORDER BY FIELD(status, 'for review', 'active', 'closed', 'blocked', 'declined')");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAlumniByEmail($email) {
		$this->db->query("SELECT * FROM alumnis WHERE email=:email");
		$this->db->bind(':email', $email);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function add($details) {
		$validate = $this->validateAddRequest($details);

		if(empty($validate)) {
			$this->db->query("INSERT INTO alumnis (id, email, lname, fname, mname, gender, contact, location, course, section, address, year_graduated, identification) VALUES (:id, :email, :lname, :fname, :mname, :gender, :contact, :location, :course, :section, :address, :year_graduated, :identification)");
			$this->db->bind(':id', $details['id']);
			$this->db->bind(':email', $details['email']);
			$this->db->bind(':lname', $details['lname']);
			$this->db->bind(':fname', $details['fname']);
			$this->db->bind(':mname', $details['mname']);
			$this->db->bind(':gender', $details['gender']);
			$this->db->bind(':contact', $details['contact']);
			$this->db->bind(':location', $details['location']);
			$this->db->bind(':course', $details['course']);
			$this->db->bind(':section', $details['section']);
			$this->db->bind(':address', $details['address']);
			$this->db->bind(':year_graduated', $details['year-graduated']);
			$this->db->bind(':identification', $details['identification']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Something went wrong, please try again';
		} 

		return $validate;
	}

	public function getAlumniRecords($id) {
		$this->db->query("SELECT * FROM users INNER JOIN alumnis ON users.id = alumnis.id WHERE users.id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function update($details) {
		$validate = $this->validateUpdateRequest($details);

		if(empty($validate)) {
			if(!empty($details['identification'])) {
				$this->db->query("UPDATE alumnis SET lname=:lname, fname=:fname, mname=:mname, gender=:gender, contact=:contact, location=:location, course=:course, section=:section, address=:address, year_graduated=:year_graduated, identification=:identification WHERE id=:id");
				$this->db->bind(':identification', $details['identification']);
			} else {
				$this->db->query("UPDATE alumnis SET lname=:lname, fname=:fname, mname=:mname, gender=:gender, contact=:contact, location=:location, course=:course, section=:section, address=:address, year_graduated=:year_graduated WHERE id=:id");
			}

			$this->db->bind(':id', $details['id']);
			$this->db->bind(':lname', $details['lname']);
			$this->db->bind(':fname', $details['fname']);
			$this->db->bind(':mname', $details['mname']);
			$this->db->bind(':gender', $details['gender']);
			$this->db->bind(':contact', $details['contact']);
			$this->db->bind(':location', $details['location']);
			$this->db->bind(':course', $details['course']);
			$this->db->bind(':section', $details['section']);
			$this->db->bind(':address', $details['address']);
			$this->db->bind(':year_graduated', $details['year-graduated']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while updating profile, please try again';
		}

		return $validate;
	}

	public function update_email($id, $email) {
		$this->db->query("UPDATE alumnis SET email=:email WHERE id=:id");
		$this->db->bind(':email', $email);
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function delete($id) {
		$this->db->query('DELETE alumnis.*, users.* FROM alumnis INNER JOIN users ON alumnis.id = users.id WHERE alumnis.id=:id');
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	private function validateAddRequest($details) {

		if(empty($details['id'])) return 'ID is required';

		if($this->isIdExistingAsStudent($details['id'])) return 'This ID is registered as student';

		if($this->isIdExisting($details['id'])) return 'Alumni already exists';

		if(empty($details['email'])) return 'Email is required';
		
		if($this->isEmailExisting($details['email'])) return 'Email is already in used';

		if(empty($details['lname'])) return 'Lastname is required';

		if(empty($details['fname'])) return 'Firstname is required';

		if(empty($details['gender'])) return 'Gender is required';

		if(empty($details['contact'])) return 'Phone number is required';

		if(empty($details['location'])) return 'Location is required';

		if(empty($details['course'])) return 'Course is required';

		if(empty($details['section'])) return 'Section is required';

		if(empty($details['address'])) return 'Address is required';

		if(empty($details['year-graduated'])) return 'Year Graduated is required';

		if(empty($details['identification'])) return 'You need to upload your University ID or Last registration form';

		return '';
	}

	private function validateUpdateRequest($details) {

		if(empty($details['id'])) return 'ID is not found';

		$existing = $this->findAlumniById($details['id']);

		if(empty($details['lname'])) return 'Lastname is required';

		if(empty($details['fname'])) return 'Firstname is required';

		if(empty($details['gender'])) return 'Gender is required';

		if(empty($details['contact'])) return 'Phone number is required';

		if(empty($details['location'])) return 'Location is required';

		if(empty($details['course'])) return 'Course is required';

		if(empty($details['section'])) return 'Section is required';

		if(empty($details['address'])) return 'Address is required';

		if(empty($details['year-graduated'])) return 'Year Graduated is required';

		return '';
	
	}

	private function isIdExistingAsStudent($id) {
		$this->db->query("SELECT id FROM student WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	private function isIdExisting($id) {
		return $this->findAlumniById($id);
	}

	private function isEmailExisting($email) {
		return $this->findAlumniByEmail($email);
	}
}


?>