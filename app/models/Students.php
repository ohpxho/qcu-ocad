<?php

class Students {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($details) {
		$validate = $this->validateAddInputs($details);

		if(empty($validate)) {
			$this->db->query("INSERT INTO student 
						  (id, email, lname, mname, fname, gender, contact, location, address, course, section, year, type)
						  VALUES 
						  (:id, :email, :lname, :mname, :fname, :gender, :contact, :location, :address, :course, :section, :year, :type)");
		
			$this->db->bind(':id', $details['id']);
			$this->db->bind(':email', $details['email']);
			$this->db->bind(':lname', $details['lname']);
			$this->db->bind(':mname', $details['mname']);
			$this->db->bind(':fname', $details['fname']);
			$this->db->bind(':gender', $details['gender']);
			$this->db->bind(':contact', $details['contact']);
			$this->db->bind(':location', $details['location']);
			$this->db->bind(':address', $details['address']);
			$this->db->bind(':course', $details['course']);
			$this->db->bind(':section', $details['section']);
			$this->db->bind(':year', $details['year']);
			$this->db->bind(':type', $details['type-of-student']);
		
			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while adding student, please try again';
		}

		return $validate;
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
		$this->db->query('DELETE FROM student WHERE id=:id');
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function update($details) {
		$validate = $this->validateUpdateInputs($details);

		if(empty($validate)) {
			
			$this->db->query("UPDATE student SET lname=:lname, fname=:fname, location=:location, address=:address, gender=:gender, course=:course, year=:year, section=:section, contact=:contact, type=:type WHERE id=:id");

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

	// public function import($spreadsheet) {
	// 	$worksheet = $spreadsheet->getActiveSheet();
	// 	$highestRow = $worksheet->getHighestDataRow();
	// 	$highestColumn = $worksheet->getHighestDataColumn();

	// 	if($highestColumn != 'M') return 'There is an error in excel file. Make sure that you follow the required format';

	// 	for ($row = 3; $row < $highestRow; $row++) {
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
	// 	    	'location' => $rowData[7],
	// 	    	'address' => $rowData[8],
	// 	    	'course' => $rowData[9],
	// 	    	'section' => $rowData[10],
	// 	    	'year' => $rowData[11],
	// 	    	'type' => $rowData[12]
	// 	    ];
			
	// 	    $validate = $this->validateAddInputsFromImport($details, $row);

	// 	    if(empty($validate)) {
	// 	    	$pass = password_hash('asdasdasd', PASSWORD_DEFAULT);
	// 		    $this->db->query("INSERT INTO users (id, pass, email, createdAt, status, type) VALUES (:id, :pass, :email, NOW(), 'active', 'student')");
				
	// 			$this->db->bind(':id', $details['id']);
	// 			$this->db->bind(':email', $details['email']);
	// 			$this->db->bind(':pass', $pass);

	// 			$account = $this->db->execute();

	// 			$this->db->query("INSERT INTO student 
	// 					  (id, email, lname, mname, fname, gender, contact, location, address, course, section, year, type)
	// 					  VALUES 
	// 					  (:id, :email, :lname, :mname, :fname, :gender, :contact, :location, :address, :course, :section, :year, :type)");
		
	// 			$this->db->bind(':id', $details['id']);
	// 			$this->db->bind(':email', $details['email']);
	// 			$this->db->bind(':lname', $details['lname']);
	// 			$this->db->bind(':mname', $details['mname']);
	// 			$this->db->bind(':fname', $details['fname']);
	// 			$this->db->bind(':gender', $details['gender']);
	// 			$this->db->bind(':contact', $details['contact']);
	// 			$this->db->bind(':location', $details['location']);
	// 			$this->db->bind(':address', $details['address']);
	// 			$this->db->bind(':course', $details['course']);
	// 			$this->db->bind(':section', $details['section']);
	// 			$this->db->bind(':year', $details['year']);
	// 			$this->db->bind(':type', $details['type']);
				
	// 			$personal = $this->db->execute();
				
	// 			if(!$account || !$personal) {
	// 				$this->db->query('DELETE student.*, users.* FROM users INNER JOIN student ON users.id = student.id WHERE users.id=:id');
	// 				$this->db->bind($rowData[0]);	
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

		if(!preg_match('/^\d{2}-\d{4}$/', $details['id'])) return 'The ID in row '.$row.' has wrong format';
		
		if(empty($details['email'])) return 'The Email in row '.$row.' not found';

		if(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)) return 'The Email in row '.$row.' has wrong format';

		$domain = explode('@', $details['email'])[1];
		if($domain !== 'gmail.com') return 'The Email in row '.$row.' is not a valid gmail';
		

		$forid = $this->findUserById($details['id']);
		if(is_object($forid)) {
			if($forid->id == $details['id']) {
				if($forid->type=='alumni') return 'The records in row '.$row.' is registered as alumni';
				else if($forid->type=='student') return 'The student in row '.$row.' already exists';
				else return 'The records in row '.$row.' is registered as admin';
			}
		}

		$foremail = $this->findUserByEmail($details['email']);

		if(is_object($foremail)) return 'The Email in row '.$row.' already in use';

		if(empty($details['lname'])) return 'The Lastname in row '.$row.' not found';
		
		if(empty($details['fname'])) return 'The Firstname in row '.$row.' not found';
		
		if(empty($details['location'])) return 'The Location in row '.$row.' not found';
		
		if(empty($details['address'])) return 'The Address in row '.$row.' not found';
		
		if(empty($details['gender'])) return 'The Gender in row '.$row.' not found';
		
		if(empty($details['course'])) return 'The Course in row '.$row.' not found';
		
		if(empty($details['year'])) return 'The Year in row '.$row.' not found';
	
		if(empty($details['section'])) return 'The Section in row '.$row.' not found';
		
		if(empty($details['contact'])) return 'The Contact in row '.$row.' not found';
		
		if(!is_numeric($details['contact']) || !preg_match('/^[0-9]{11}+$/', $details['contact'])) return 'The Contact in row '.$row.' has wrong format';
		
		if(empty($details['type'])) return 'The Type in row '.$row.' not found';
		
		return '';
	}

	private function validateAddInputs($details) {
		if(empty($details['id'])) return 'The ID is required';

		if(!preg_match('/^\d{2}-\d{4}$/', $details['id'])) return 'The ID has wrong format';
		
		if(empty($details['email'])) return 'The Email is required';

		if(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)) return 'The Email has wrong format';

		$domain = explode('@', $details['email'])[1];
		if($domain !== 'gmail.com') return 'The Email is not a valid gmail';
		
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
		
		if(empty($details['type-of-student'])) return 'Type is required';
		
		return '';
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