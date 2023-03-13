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
						  (id, email, lname, mname, fname, gender, contact, location, address, course, section, year, type, approved)
						  VALUES 
						  (:id, :email, :lname, :mname, :fname, :gender, :contact, :location, :address, :course, :section, :year, :type, 0)");
		
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

	public function update($details) {
		$validate = $this->validateUpdateInputs($details);

		if(empty($validate)) {
			
			if(empty($details['old-pass']) && empty($details['profile-pic'])) {
				$this->db->query("UPDATE users SET email=:email WHERE id=:id");
			} 

			if(!empty($details['old-pass']) && empty($details['profile-pic'])) {
				$this->db->query("UPDATE users SET pass=:pass, email=:email WHERE id=:id");
				$this->db->bind(':pass', password_hash($details['new-pass'], PASSWORD_DEFAULT));
			}

			if(empty($details['old-pass']) && !empty($details['profile-pic'])) {
				$this->db->query("UPDATE users SET pic=:pic, email=:email WHERE id=:id");
				$this->db->bind(':pic', $details['profile-pic']);
			}

			if(!empty($details['old-pass']) && !empty($details['profile-pic'])) {
				$this->db->query("UPDATE users SET pic=:pic, pass=:pass, email=:email WHERE id=:id");
				$this->db->bind(':pic', $details['profile-pic']);
				$this->db->bind(':pass', password_hash($details['new-pass'], PASSWORD_DEFAULT));	
			}

			$this->db->bind(':email', $details['email']);
			$this->db->bind(':id', $details['id']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while updating profile, please try again';
		}

		return $validate;
	}

	private function validateUpdateInputs($details) {
		$records = $this->findUserById($details['id']);

		if(empty($details['email'])) return 'Email is required';

		if(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)) return 'Email is invalid';
		
		$domain = explode('@', $details['email'])[1];
		if($domain !== 'gmail.com') return 'Gmail is required for email';	

		if($details['email'] != $records->email && $this->findUSerByEmail($details['email'])) return 'Email is already in use';
		
		$isUserChangePassword = (!empty($details['old-pass']) || !empty($details['new-pass']) || !empty($details['confirm-new-pass']));

		if($isUserChangePassword) {

			if(empty($details['old-pass'])) return 'Old password is required';

			if(empty($details['new-pass'])) return 'New password is required';

			if(empty($details['confirm-new-pass'])) return 'Confirm new password is required';

			if(!password_verify($details['old-pass'], $records->pass)) return "Old password don't match to registered password";

			if(strlen($details['new-pass']) < 8) return 'Password should be atleast 8 character long. Alpanumeric';

			if($details['new-pass'] !== $details['confirm-new-pass']) return "Password and Confirm password don't match"; 
		}

		return '';
	}
}

?>