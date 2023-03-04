<?php

class GoodMoralRequests {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($request) {
		$validate = $this->validateAddRequest($request);
		
		if(empty($validate)) {
			$this->db->query("INSERT INTO good_moral_requests (student_id, purpose, other_purpose) VALUES (:student_id, :purpose, :other_purpose)");
			
			$this->db->bind(':student_id', $request['student-id']);
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

	public function edit($request) {
		$validate = $this->validateEditRequest($request);

		if(empty($validate)) {
			$this->db->query("UPDATE good_moral_requests SET purpose=:purpose, other_purpose=:other_purpose WHERE id=:id");
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

	public function findAllPendingRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='pending' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllAcceptedRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='accepted' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllInProcessRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='in process' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllForClaimingRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='for claiming' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsByStudentId($id) {
		$this->db->query("SELECT * FROM good_moral_requests WHERE student_id=:id AND (status='completed' || status='rejected')");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsOfStudents($id) {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='completed' || status='rejected'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getRequestsCount() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming FROM good_moral_requests");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	private function validateAddRequest($request) {
		if(empty($request['purpose'])) {
			return 'Purpose is required';
		}

		if($request['purpose'] == 'Others' && empty($request['other-purpose'])) {
			return 'You need to specify the reason for request.';
		}

		return '';
	}

	private function validateEditRequest($request) {
		if(empty($request['purpose'])) {
			return 'Purpose is required';
		}

		if($request['purpose'] == 'Others' && empty($request['other-purpose'])) {
			return 'You need to specify the reason for request';
		}

		return '';
	}
}

?>