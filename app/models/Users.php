<?php

class Users {
	public function __construct() {
		$this->db = new Database();
	}

	public function login($data) {
		$this->db->query("SELECT * FROM users WHERE id=:id or email=:email");
		$this->db->bind(':id', $data['id']);
		$this->db->bind(':email', $data['id']);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			if(password_verify($data['pass'], $result->pass)) {
				return $result;
			}
		}

		return false;

	}

	public function register($data) {
		$this->db->query("INSERT INTO users (id, pass, email, block, createdAt) VALUES (:id, :pass, :email, 0, NOW())");
		$this->db->bind(':id', $data['id']);
		$this->db->bind(':pass', $data['pass']);
		$this->db->bind(':email', $data['email']);

		$userResult = $this->db->execute();

		$this->db->query("INSERT INTO student 
						  (id, email, lname, mname, fname, gender, contact, location, address, course, section, year, type)
						  VALUES 
						  (:id, :email, :lname, :mname, :fname, :gender, :contact, :location, :address, :course, :section, :year, :type)");
		
		$this->db->bind(':id', $data['id']);
		$this->db->bind(':email', $data['email']);
		$this->db->bind(':lname', $data['lname']);
		$this->db->bind(':mname', $data['mname']);
		$this->db->bind(':fname', $data['fname']);
		$this->db->bind(':gender', $data['gender']);
		$this->db->bind(':contact', $data['contact']);
		$this->db->bind(':location', $data['location']);
		$this->db->bind(':address', $data['address']);
		$this->db->bind(':course', $data['course']);
		$this->db->bind(':section', $data['section']);
		$this->db->bind(':year', $data['year']);
		$this->db->bind(':type', $data['type']);
	
		$studentResult = $this->db->execute();

		if($userResult && $studentResult) {
			return true;
		}

		return false;
	}

	public function findUserByEmail($email) {
		$this->db->query("SELECT * from users WHERE email=:email");
		$this->db->bind(':email', $email);
		$result = $this->db->getSingleResult();
		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function findUserById($id) {
		$this->db->query("SELECT * from users WHERE id=:id");
		$this->db->bind(':id', $id);
		$result = $this->db->getSingleResult();
		if(is_object($result)) {
			return $result;
		}

		return false;
	}
}

?>