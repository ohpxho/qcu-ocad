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

	public function findAdminByEmail($email) {
		$this->db->query("SELECT * FROM admin WHERE email=:email");
		$this->db->bind(':email', $email);

		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function add($details) {
		$validate = $this->validateAddInputs($details);

		if(empty($validate)) {
			$this->db->query("INSERT INTO admin (id, email, lname, fname, mname, contact, gender, department) VALUES (:id, :email, :lname, :fname, :mname, :contact, :gender, :department)");
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
			$this->db->query("UPDATE admin SET lname=:lname, fname=:fname, mname=:mname, department=:department, gender=:gender, contact=:contact WHERE id=:id");
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

	public function update_email($id, $email) {
		$this->db->query("UPDATE admin SET email=:email WHERE id=:id");
		$this->db->bind(':email', $email);
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function getAllAdmin() {
		$this->db->query("SELECT * FROM users INNER JOIN admin ON users.id = admin.id WHERE users.type!='sysadmin' ORDER BY FIELD(status, 'for review', 'active', 'closed', 'blocked', 'declined')");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getAdminRecords($id) {
		$this->db->query("SELECT * FROM users INNER JOIN admin ON users.id = admin.id WHERE users.id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function delete($id) {
		$this->db->query('DELETE admin.*, users.* FROM admin INNER JOIN users ON admin.id = users.id WHERE admin.id=:id');
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

	private function validateAddInputs($details) {
		if(empty($details['id'])) return 'Id is required';

		if($this->isAdminExists($details['id'])) return 'Admin already exists';

		if(empty($details['email'])) return 'Email is required';

		if(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)) return 'Email is invalid';
		
		$domain = explode('@', $details['email'])[1];
		if($domain !== 'gmail.com') return 'Gmail is required for email';

		if($this->isEmailInUse($details['email'])) return 'Email is in use';
		
		if(empty($details['pass'])) return 'Password is required';

		if(empty($details['confirm-pass'])) return 'Confirm password is required';

		if(strlen($details['pass']) < 8) return 'Password should be atleast 8 character long. Alpanumeric';

		if($details['pass'] !== $details['confirm-pass']) return "Password and Confirm password don't match";

		if(empty($details['lname'])) return 'Lastname is required';
		
		if(empty($details['fname'])) return 'Firstname is required';
		
		if(empty($details['department'])) return 'Department is required';
		
		if(empty($details['gender'])) return 'Gender is required';

		if(empty($details['contact'])) return 'Contact is required';
		
		if(!is_numeric($details['contact']) || !preg_match('/^[0-9]{11}+$/', $details['contact'])) return 'Contact has wrong format.';

		return '';
	}

	private function isAdminExists($id) {
		$find = $this->findAdminById($id);

		if(is_object($find)) return true;

		return false;
	}

	private function isEmailInUse($email) {
		$find = $this->findAdminByEmail($email);

		if(is_object($find)) return true;

		return false;
	} 
}


?>