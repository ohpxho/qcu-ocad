<?php


class Consultations {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($request) {
		
		$validate = $this->validateAddRequest($request);

		if(empty($validate)) {

			$this->db->query("INSERT INTO consultations (creator, purpose, problem, department, subject, adviser_id, adviser_name, preferred_date_for_gmeet, preferred_time_for_gmeet, shared_file_from_student) VALUES (:creator, :purpose, :problem, :department, :subject, :adviser_id, :adviser_name, :preferred_date, :preferred_time, :shared_file)");
			
			$this->db->bind(':creator', $request['creator']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':problem', $request['problem']);
			$this->db->bind(':department', $request['department']);
			$this->db->bind(':subject', $request['subject']);
			$this->db->bind(':adviser_id', $request['adviser-id']);
			$this->db->bind(':adviser_name', $request['adviser-name']);
			$this->db->bind(':preferred_date', $request['preferred-date']);
			$this->db->bind(':preferred_time', $request['preferred-time']);
			$this->db->bind(':shared_file', $request['document']);

			$result = $this->db->execute();

			if($result) {
				return '';
			}

			return 'Something went wrong, please try again.';

		} else {
			return $validate;
		}
	}
	
	public function edit($request) {
		$validate = $this->validateEditRequest($request);

		if(empty($validate)) {

			if(empty($request['document'])) {
				$this->db->query("UPDATE consultations SET purpose=:purpose, problem=:problem, department=:department, subject=:subject, adviser_id=:adviser_id, adviser_name=:adviser_name, preferred_date_for_gmeet=:preferred_date, preferred_time_for_gmeet=:preferred_time WHERE id=:id");
				
			} else {
				$this->db->query("UPDATE consultations SET purpose=:purpose, problem=:problem, department=:department, subject=:subject, adviser_id=:adviser_id, adviser_name=:adviser_name, preferred_date_for_gmeet=:preferred_date, preferred_time_for_gmeet=:preferred_time, shared_file_from_student=:shared_file WHERE id=:id");
				$this->db->bind(':shared_file', $request['document']);
			}

			$this->db->bind(':id', $request['id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':problem', $request['problem']);
			$this->db->bind(':department', $request['department']);
			$this->db->bind(':subject', $request['subject']);
			$this->db->bind(':adviser_id', $request['adviser-id']);
			$this->db->bind(':adviser_name', $request['adviser-name']);
			$this->db->bind(':preferred_date', $request['preferred-date']);
			$this->db->bind(':preferred_time', $request['preferred-time']);
			

			$result = $this->db->execute();

			if($result) {
				return '';
			}

			return 'Something went wrong, please try again.';

		} else {
			return $validate;
		}
	}

	public function drop($id) {
		$this->db->query("DELETE FROM consultations WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function findAllPendingRequestByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND status='pending'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllActiveRequestByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND status='active'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllActiveRequestByProfessorId($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='active'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findRequestById($id) {
		$this->db->query("SELECT * FROM consultations WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;
		return false;
	}

	private function validateAddRequest($request) {
		if(empty($request['creator'])) {
			return 'We cannot find your Student ID';
		}

		if(empty($request['purpose'])) {
			return 'Purpose cannot be empty';
		}

		if(empty($request['problem'])) {
			return 'Problem cannot be empty';
		}

		if(empty($request['department'])) {
			return 'Department cannot be emoty';
		}

		if($request['department'] != 'guidance' && empty($request['subject'])) {
			return 'Subject Code cannot be empty';
		}

		if($request['department'] != 'guidance' && empty($request['adviser-id'])) {
			return 'Adviser cannot be empty';
		}

		if(empty($request['preferred-date'])) {
			return 'Preferred Date cannot be empty';
		} 

		if(empty($request['preferred-time'])) {
			return 'Preferred Time cannot be empty';
		}
	}

	private function validateEditRequest($request) {

		if(empty($request['purpose'])) {
			return 'Purpose cannot be empty';
		}

		if(empty($request['problem'])) {
			return 'Problem cannot be empty';
		}

		if(empty($request['department'])) {
			return 'Department cannot be emoty';
		}

		if($request['department'] != 'guidance' && empty($request['subject'])) {
			return 'Subject Code cannot be empty';
		}

		if($request['department'] != 'guidance' && empty($request['adviser-id'])) {
			return 'Adviser cannot be empty';
		}

		if(empty($request['preferred-date'])) {
			return 'Preferred Date cannot be empty';
		} 

		if(empty($request['preferred-time'])) {
			return 'Preferred Time cannot be empty';
		}
	}
}

?>