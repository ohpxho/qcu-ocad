<?php

class GoodMoralRequests {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($request) {
		$validate = $this->validateAddRequest($request);
		
		if(empty($validate)) {
			$this->db->query("INSERT INTO good_moral_requests (student_id, purpose, other_purpose, identification_document) VALUES (:student_id, :purpose, :other_purpose, :identification_document)");
			
			$this->db->bind(':student_id', $request['student-id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':other_purpose', $request['other-purpose']);
			$this->db->bind(':identification_document', $request['identification-document']);

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
			if(empty($request['identification-document'])) {
				$this->db->query("UPDATE good_moral_requests SET purpose=:purpose, other_purpose=:other_purpose WHERE id=:id");
			} else {
				$this->db->query("UPDATE good_moral_requests SET purpose=:purpose, other_purpose=:other_purpose, identification_document=:identification_document WHERE id=:id");
				$this->db->bind(':identification_document', $request['identification-document']);	
			} 

			$this->db->bind(':id', $request['request-id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':other_purpose', $request['other-purpose']);
			
			$result = $this->db->execute();

			if($result) {
				return '';
			}

			return 'Something went wrong, please try again.';

		} else {
			return $validate;
		}
	}

	public function findAllRequestByStudentId($id) {
		$this->db->query("SELECT * FROM good_moral_requests WHERE student_id=:id ORDER BY FIELD(status, 'pending') DESC");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();
		
		if(is_array($result)) {
			return $result;
		}

		return false;
	}

	public function findRequestById($id) {
		$this->db->query("SELECT * FROM good_moral_requests WHERE id=:id ORDER BY FIELD(status, 'pending') DESC");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function findAllRequest() {
		$this->db->query("SELECT * FROM good_moral_requests ORDER BY FIELD(status, 'pending') DESC");
		
		$result = $this->db->getAllResult();
		
		if(is_array($result)) {
			return $result;
		}

		return false;
	}

	public function updateStatusAndRemarks($request) {
		$this->db->query("UPDATE good_moral_requests SET status=:status, remarks=:remarks WHERE id=:id");
		$this->db->bind(':id', $request['request-id']);
		$this->db->bind(':status', $request['status']);
		$this->db->bind(':remarks', $request['remarks']);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function drop($id) {
		$this->db->query("DELETE FROM good_moral_requests WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	private function validateAddRequest($request) {
		if(empty($request['purpose'])) {
			return 'Purpose cannot be empty.';
		}

		if($request['purpose'] == 8 && empty($request['other-purpose'])) {
			return 'You need to specify the reason for request.';
		}

		if(empty($request['identification-document'])) {
			return 'Upload scanned copy of registration form or ID.';
		}

		return '';
	}

	private function validateEditRequest($request) {
		if(empty($request['purpose'])) {
			return 'Purpose cannot be empty.';
		}

		if($request['purpose'] == 8 && empty($request['other-purpose'])) {
			return 'You need to specify the reason for request.';
		}

		return '';
	}
}

?>