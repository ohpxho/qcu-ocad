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

	public function loginStudent($data) {
		$this->db->query("SELECT * FROM users WHERE (id=:id or email=:email) AND type='student'");
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

	public function loginAlumni($data) {
		$this->db->query("SELECT * FROM users WHERE (id=:id or email=:email) AND type='alumni'");
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

	public function loginProfessor($data) {
		$this->db->query("SELECT * FROM users WHERE (id=:id or email=:email) AND type='professor'");
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

	public function loginAdmin($data) {
		$this->db->query("SELECT * FROM users WHERE (id=:id or email=:email) AND (type!='alumni' AND type!='professor' AND type!='student')");
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

	public function add($details) {
		$validate = $this->validateAddInputs($details);

		if(empty($validate)) {
			$this->db->query("INSERT INTO users (id, email, pass, type, createdAt, status) VALUES (:id, :email, :pass, :type, NOW(), 'active')");
			$this->db->bind(':id', $details['id']);
			$this->db->bind(':email', $details['email']);
			$this->db->bind(':pass', password_hash($details['pass'], PASSWORD_DEFAULT));
			$this->db->bind(':type', $details['type']);
			
			$result = $this->db->execute();

			if($result) return '';

			return 'Something went wrong while adding admin account, please try again';
		} 

		return $validate;
	}

	public function registerStudent($data) {
		$this->db->query("INSERT INTO users (id, pass, email, createdAt, status, type) VALUES (:id, :pass, :email, NOW(), 'for review', 'student')");
		$this->db->bind(':id', $data['id']);
		$this->db->bind(':pass', $data['pass']);
		$this->db->bind(':email', $data['email']);

		$userResult = $this->db->execute();

		$this->db->query("INSERT INTO student 
						  (id, email, lname, mname, fname, gender, contact, location, address, course, section, year, type, identification)
						  VALUES 
						  (:id, :email, :lname, :mname, :fname, :gender, :contact, :location, :address, :course, :section, :year, :type, :identification)");
		
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
		$this->db->bind(':identification', $data['identification']);
	
		$studentResult = $this->db->execute();

		if($userResult && $studentResult) {
			return true;
		}

		return false;
	}

	public function studentResubmission($data) {
		$validate = $this->validateStudentResubmission($data);

		if(empty($validate)) {
			$this->db->query("UPDATE users SET id=:id, email=:email, status='for review', type='student' WHERE id=:oldid");
			$this->db->bind(':oldid', $data['old-id']);
			$this->db->bind(':id', $data['id']);
			$this->db->bind(':email', $data['email']);

			$userResult = $this->db->execute();

			if(!empty($data['identification'])) {
				$this->db->query("UPDATE student SET id=:id, email=:email, lname=:lname, mname=:mname, fname=:fname, gender=:gender, contact=:contact, location=:location, address=:address, course=:course, section=:section, year=:year, type=:type, identification=:identification WHERE id=:id");
				$this->db->bind(':identification', $data['identification']);
			} else {
				$this->db->query("UPDATE student SET id=:id, email=:email, lname=:lname, mname=:mname, fname=:fname, gender=:gender, contact=:contact, location=:location, address=:address, course=:course, section=:section, year=:year, type=:type WHERE id=:oldid");
			}

			$this->db->bind(':oldid', $data['old-id']);		  
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

			if($userResult && $studentResult) return '';

			return 'Some error occured while resubmitting application, please try again';
		} 

		return $validate;
	}

	public function registerAlumni($data) {
		$this->db->query("INSERT INTO users (id, pass, email, createdAt, status, type) VALUES (:id, :pass, :email, NOW(), 'for review', 'alumni')");
		$this->db->bind(':id', $data['id']);
		$this->db->bind(':pass', $data['pass']);
		$this->db->bind(':email', $data['email']);

		$userResult = $this->db->execute();

		$this->db->query("INSERT INTO alumnis
						  (id, email, lname, mname, fname, gender, contact, location, address, course, section, year_graduated, identification)
						  VALUES 
						  (:id, :email, :lname, :mname, :fname, :gender, :contact, :location, :address, :course, :section, :year, :identification)");
		
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
		$this->db->bind(':year', $data['year-graduated']);
		$this->db->bind(':identification', $data['identification']);
	
		$studentResult = $this->db->execute();

		if($userResult && $studentResult) {
			return true;
		}

		return false;
	}

	public function alumniResubmission($data) {
		$validate = $this->validateAlumniResubmission($data);

		if(empty($validate)) {
			$this->db->query("UPDATE users SET id=:id, email=:email, status='for review', type='alumni' WHERE id=:oldid");
			$this->db->bind(':oldid', $data['old-id']);
			$this->db->bind(':id', $data['id']);
			$this->db->bind(':email', $data['email']);

			$userResult = $this->db->execute();

			if(!empty($data['identification'])) {
				$this->db->query("UPDATE alumnis SET id=:id, email=:email, lname=:lname, mname=:mname, fname=:fname, gender=:gender, contact=:contact, location=:location, address=:address, course=:course, section=:section, year_graduated=:year, identification=:identification WHERE id=:id");
				$this->db->bind(':identification', $data['identification']);
			} else {
				$this->db->query("UPDATE alumnis SET id=:id, email=:email, lname=:lname, mname=:mname, fname=:fname, gender=:gender, contact=:contact, location=:location, address=:address, course=:course, section=:section, year_graduated=:year WHERE id=:oldid");
			}

			$this->db->bind(':oldid', $data['old-id']);		  
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
			$this->db->bind(':year', $data['year-graduated']);

			$alumniResult = $this->db->execute();

			if($userResult && $alumniResult) return '';

			return 'Some error occured while resubmitting application, please try again';
		} 

		return $validate;
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

	public function findStudentById($id) {
		$this->db->query("SELECT student.*, users.* FROM users INNER JOIN student ON users.id=student.id WHERE users.id=:id ");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function findAlumniById($id) {
		$this->db->query("SELECT alumnis.*, users.* FROM users INNER JOIN alumnis ON users.id=alumnis.id WHERE users.id=:id ");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

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

	public function approval($details) {
		if(!empty($details['approval'])) {
			$this->db->query("UPDATE users SET status=:status, remarks=:remarks WHERE id=:id");
			$this->db->bind(':status', $details['approval']);
			$this->db->bind(':remarks', $details['remarks']);
			$this->db->bind(':id', $details['id']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while updating account, please try again';
		}

		return 'Status is required';
	}

	public function close($id) {
		$this->db->query("UPDATE users SET status='closed' WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function open($id) {
		$this->db->query("UPDATE users SET status='active' WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function block($details) {
		$this->db->query("UPDATE users SET status='blocked', remarks=:remarks WHERE id=:id");
		$this->db->bind(':id', $details['id']);
		$this->db->bind(':remarks', $details['remarks']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function unblock($id) {
		$this->db->query("UPDATE users SET status='active', remarks='' WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	private function validateStudentResubmission($data) {
		if(empty($data['id'])) {
			return 'ID is required';
		}

		if(!is_numeric($data['id'])) {
			return 'ID has wrong format';
		}

		if(empty($data['email'])) {
			return 'Email is required';
		}

		if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return 'Email is invalid, please try again';
		}

		$domain = explode('@', $data['email'])[1];
		if($domain !== 'gmail.com') {
			return 'Gmail is required for email';
		}

		$forid = $this->findUserById($data['id']);

		if(is_object($forid)) {
			if($forid->id != $data['old-id']) {
				if($forid->type=='alumni') return 'An existing alumni account is using this ID';
				return 'Student already exist';
			}
		}

		$foremail = $this->findUserByEmail($data['email']);

		if(is_object($foremail)) {
			if($foremail->id != $data['old-id']) {
				return 'Email is already in use';
			}
		}

		return '';

		if(empty($data['lname'])) {
			return 'Lastname is required';
		}

		if(empty($data['fname'])) {
			return 'Firstname is required';
		}

		if(empty($data['location'])) {
			return 'Location is required';
		}

		if(empty($data['address'])) {
			return 'Address is required';
		}

		if(empty($data['gender'])) {
			return 'Gender is required';
		}

		if(empty($data['course'])) {
			return 'Course is required';
		}

		if(empty($data['year'])) {
			return 'Year is required';
		}

		if(empty($data['section'])) {
			return 'Section is required';
		}

		if(empty($data['contact'])) {
			return 'Contact is required';
		}

		if(!is_numeric($data['contact']) || !preg_match('/^[0-9]{11}+$/', $data['contact'])) {
			return 'Contact has wrong format';
		}

		if(empty($data['type'])) {
			return 'Type is required';
		}
	}

	private function validateAlumniResubmission($data) {
		if(empty($data['id'])) {
			return 'ID is required';
		}

		if(!is_numeric($data['id'])) {
			return 'ID has wrong format';
		}

		if(empty($data['email'])) {
			return 'Email is required';
		}

		if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return 'Email is invalid, please try again';
		}

		$domain = explode('@', $data['email'])[1];
		if($domain !== 'gmail.com') {
			return 'Gmail is required for email';
		}

		$forid = $this->findUserById($data['id']);

		if(is_object($forid)) {
			if($forid->id != $data['old-id']) {
				if($forid->type=='alumni') return 'An existing alumni account is using this ID';
				return 'Alumni already exist';
			}
		}

		$foremail = $this->findUserByEmail($data['email']);

		if(is_object($foremail)) {
			if($foremail->id != $data['old-id']) {
				return 'Email is already in use';
			}
		}

		return '';

		if(empty($data['lname'])) {
			return 'Lastname is required';
		}

		if(empty($data['fname'])) {
			return 'Firstname is required';
		}

		if(empty($data['location'])) {
			return 'Location is required';
		}

		if(empty($data['address'])) {
			return 'Address is required';
		}

		if(empty($data['gender'])) {
			return 'Gender is required';
		}

		if(empty($data['course'])) {
			return 'Course is required';
		}

		if(empty($data['year'])) {
			return 'Year graduated is required';
		}

		if(empty($data['section'])) {
			return 'Section is required';
		}

		if(empty($data['contact'])) {
			return 'Contact is required';
		}

		if(!is_numeric($data['contact']) || !preg_match('/^[0-9]{11}+$/', $data['contact'])) {
			return 'Contact has wrong format';
		}

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

	private function validateAddInputs($details) {
		if(empty($details['id'])) return 'Id is required';

		if($this->isUserExists($details['id'])) return 'Admin already exists';

		if(empty($details['email'])) return 'Email is required';

		if(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)) return 'Email is invalid';
		
		$domain = explode('@', $details['email'])[1];
		if($domain !== 'gmail.com') return 'Gmail is required for email';

		if($this->isEmailInUse($details['email'])) return 'Email is in use';
		
		if(empty($details['pass'])) return 'Password is required';

		if(empty($details['confirm-pass'])) return 'Confirm password is required';

		if(strlen($details['pass']) < 8) return 'Password should be atleast 8 character long. Alpanumeric';

		if($details['pass'] !== $details['confirm-pass']) return "Password and Confirm password don't match";

		return '';
	}

	private function isUserExists($id) {
		$find = $this->findUserById($id);

		if(is_object($find)) return true;

		return false;
	}

	private function isEmailInUse($email) {
		$find = $this->findUserByEmail($email);

		if(is_object($find)) return true;

		return false;
	} 


}

?>