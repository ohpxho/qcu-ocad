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

	public function findProfessorByEmail($email) {
		$this->db->query("SELECT * FROM professors WHERE email=:email");
		$this->db->bind(':email', $email);

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
			$this->db->query("UPDATE professors SET email=:email, lname=:lname, fname=:fname, mname=:mname, department=:department, gender=:gender, contact=:contact WHERE id=:id");
			$this->db->bind(':id', $details['id']);
			$this->db->bind(':email',$details['email']);
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

	// public function import($spreadsheet) {
	// 	$worksheet = $spreadsheet->getActiveSheet();
	// 	$highestRow = $worksheet->getHighestDataRow();
	// 	$highestColumn = $worksheet->getHighestDataColumn();

	// 	if($highestColumn != 'H') return 'There is an error in excel file. Make sure that you follow the required format';

	// 	for ($row = 2; $row < $highestRow; $row++) {
	// 	    $rowData = array();
	// 	    for ($col = 'A'; $col <= $highestColumn; $col++) {
	// 	        $value = $worksheet->getCell($col . $row)->getValue();
	// 	        $rowData[] = $value;
	// 	    }

	// 		// if(empty($rowData[0]) || !isset($rowData[2]) || !isset($rowData[3]) || !isset($rowData[5]) || !isset($rowData[6]) || !isset($rowData[7]) || !isset($rowData[8]) || !isset($rowData[9]) || !isset($rowData[10]) || !isset($rowData[11]) || !isset($rowData[1]) || !isset($rowData[12])) return 'There is an error in excel file. Make sure that you follow the required format';

	//         $details = [
	// 	    	'id' => $rowData[0],
	// 	    	'email' => $rowData[1],
	// 	    	'lname' => $rowData[2],
	// 	    	'fname' => $rowData[3],
	// 	    	'mname' => $rowData[4],
	// 	    	'gender' => $rowData[5],
	// 	    	'contact' => $rowData[6],
	// 	    	'department' => $rowData[7]
	// 	    ];
			
	// 	    $validate = $this->validateAddInputsFromImport($details, $row);

	// 	    if(empty($validate)) {
	// 	    	$pass = password_hash('asdasdasd', PASSWORD_DEFAULT);

	// 		    $this->db->query("INSERT INTO users (id, pass, email, createdAt, status, type) VALUES (:id, :pass, :email, NOW(), 'active', 'professor')");
				
	// 			$this->db->bind(':id', $details['id']);
	// 			$this->db->bind(':email', $details['email']);
	// 			$this->db->bind(':pass', $pass);

	// 			$account = $this->db->execute();

	// 			$this->db->query("INSERT INTO professors
	// 					  (id, email, lname, mname, fname, gender, contact, department)
	// 					  VALUES 
	// 					  (:id, :email, :lname, :mname, :fname, :gender, :contact, :department)");
		
	// 			$this->db->bind(':id', $details['id']);
	// 			$this->db->bind(':email', $details['email']);
	// 			$this->db->bind(':lname', $details['lname']);
	// 			$this->db->bind(':mname', $details['mname']);
	// 			$this->db->bind(':fname', $details['fname']);
	// 			$this->db->bind(':gender', $details['gender']);
	// 			$this->db->bind(':contact', $details['contact']);
	// 			$this->db->bind(':department', $details['department']);
				
	// 			$personal = $this->db->execute();
				
	// 			if(!$account || !$personal) {
	// 				$this->db->query('DELETE professors.*, users.* FROM users INNER JOIN professors ON users.id = professors.id WHERE users.id=:id');
	// 				$this->db->bind(':id', $details['id']);	
	// 				return 'Some error occured while importing data, please try again';
	// 			}

	// 		} else {
	// 			return $validate;
	// 		}
	// 	}

	// 	return '';

	// }

	private function findUserById($id) {
		$this->db->query("SELECT * from users WHERE id=:id");
		$this->db->bind(':id', $id);
		$result = $this->db->getSingleResult();
		if(is_object($result)) {
			return $result;
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

	private function validateAddInputsFromImport($details, $row) {
		if(empty($details['id'])) return 'The ID in row '.$row.' not found';
		
		if(empty($details['email'])) return 'The Email in row '.$row.' not found';

		if(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)) return 'The Email in row '.$row.' has wrong format';

		$domain = explode('@', $details['email'])[1];
		if($domain !== 'gmail.com') return 'The Email in row '.$row.' is not a valid gmail';
		

		$forid = $this->findUserById($details['id']);
		if(is_object($forid)) {
			if($forid->id == $details['id']) {
				if($forid->type=='student') return 'The records in row '.$row.' is registered as student';
				else if($forid->type=='alumni') return 'The records in row '.$row.' is registered as alumni';
				else if($forid->type=='professor') return 'The professor in row '.$row.' already exists';
				else return 'The records in row '.$row.' is registered as admin';
			}
		}

		$foremail = $this->findUserByEmail($details['email']);

		if(is_object($foremail)) return 'The Email in row '.$row.' already in use';

		if(empty($details['lname'])) return 'The Lastname in row '.$row.' not found';
		
		if(empty($details['fname'])) return 'The Firstname in row '.$row.' not found';
		
		if(empty($details['gender'])) return 'The Gender in row '.$row.' not found';
		
		if(empty($details['department'])) return 'The Department in row '.$row.' not found';
	
		if(empty($details['contact'])) return 'The Contact in row '.$row.' not found';
		
		if(!is_numeric($details['contact']) || !preg_match('/^[0-9]{11}+$/', $details['contact'])) return 'The Contact in row '.$row.' has wrong format';
		
		return '';
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

		if($this->isProfessorExists($details['id'])) return 'Teacher already exists';

		if(empty($details['email'])) return 'Email is required';

		if(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)) return 'Email is invalid';
		
		$domain = explode('@', $details['email'])[1];
		if($domain !== 'gmail.com') return 'Gmail is required for email';

		if($this->isEmailInUse($details['email'])) return 'Email is in use';
		
		if(empty($details['pass'])) return 'Password is required';

		if(strlen($details['pass']) < 8) return 'Password should be atleast 8 character long. Alpanumeric';

		if(empty($details['lname'])) return 'Lastname is required';
		
		if(empty($details['fname'])) return 'Firstname is required';
		
		if(empty($details['department'])) return 'Department is required';
		
		if(empty($details['gender'])) return 'Gender is required';

		if(empty($details['contact'])) return 'Contact is required';
		
		if(!is_numeric($details['contact']) || !preg_match('/^[0-9]{11}+$/', $details['contact'])) return 'Contact has wrong format.';

		return '';
	}

	private function isProfessorExists($id) {
		$result = $this->findProfessorById($id);

		if(is_object($result)) return true;

		return false;
	}

	private function isEmailInUse($email) {
		$result = $this->findProfessorByEmail($email);

		$result = $this->db->execute();

		if(is_object($result)) return true;

		return false;
	}
}

?>