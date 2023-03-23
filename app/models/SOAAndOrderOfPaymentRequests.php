<?php

class SOAAndOrderOfPaymentRequests {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($request) {
		$validate = $this->validateAddRequest($request);

		if(empty($validate)) {
			$this->db->query('INSERT INTO soa_requests (student_id, purpose, other_purpose, date_created, requested_document) VALUES (:student_id, :purpose, :other_purpose, NOW(), :requested_document)');
			$this->db->bind(':student_id', $request['student-id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':other_purpose', $request['other-purpose']);
			$this->db->bind(':requested_document', $request['requested-document']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Something went wrong, please try again';
		}

		return $validate;
	}

	public function findRequestById($id) {
		$this->db->query("SELECT * FROM soa_requests WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function findAllRequestByStudentId($id) {
		$this->db->query("SELECT * FROM soa_requests WHERE student_id=:id ORDER BY FIELD(status, 'pending') DESC");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function update($request) {
		$validate = $this->validateUpdateRequest($request);

		if(empty($validate)) {
			$this->db->query('UPDATE soa_requests SET purpose=:purpose, other_purpose=:other_purpose, requested_document=:requested_document WHERE id=:id');
			$this->db->bind(':id', $request['request-id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':other_purpose', $request['other-purpose']);
			$this->db->bind(':requested_document', $request['requested-document']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Something went wrong, please try again';
		}

		return $validate;
	}

	public function updateStatusAndRemarks($request) {
		$validate = $this->validateStatusUpdate($request);

		if(empty($validate)) {

			$this->db->query("UPDATE soa_requests SET status=:status, remarks=:remarks WHERE id=:id");
			$this->db->bind(':id', $request['request-id']);
			$this->db->bind(':status', $request['status']);
			$this->db->bind(':remarks', $request['remarks']);

			$result = $this->db->execute();
			
			if($result) return '';
			
			return 'Something went wrong, please try again';
		}

		return $validate;
	}

	public function drop($id) {
		$this->db->query("DELETE FROM soa_requests WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function cancel($id) {
		$this->db->query("UPDATE soa_requests SET status='cancelled' WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function findAllPendingRequest() {
		$this->db->query("SELECT * FROM soa_requests WHERE status='pending'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;		
	}

	public function findAllAcceptedRequest() {
		$this->db->query("SELECT * FROM soa_requests WHERE status='accepted'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;		
	}

	public function findAllInProcessRequest() {
		$this->db->query("SELECT * FROM soa_requests WHERE status='in process'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;		
	}

	public function findAllForClaimingRequest() {
		$this->db->query("SELECT * FROM soa_requests WHERE status='for claiming'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;		
	}

	public function findAllCompletedRequest() {
		$this->db->query("SELECT * FROM soa_requests WHERE status='completed'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;		
	}

	public function findAllDeclinedRequest() {
		$this->db->query("SELECT * FROM soa_requests WHERE status='rejected'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;		
	}

	public function findAllCancelledRequest() {
		$this->db->query("SELECT * FROM soa_requests WHERE status='cancelled'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;		
	}

	public function findAllRecordsByStudentId($id) {
		$this->db->query("SELECT * FROM soa_requests WHERE student_id=:id AND (status='completed' || status='rejected')");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsOfStudentsForAdmin() {
		$this->db->query("SELECT * FROM soa_requests ORDER BY FIELD(status, 'pending', 'accepted', 'in process', 'for claiming', 'declined', 'cancelled') ");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsOfStudentsForSystemAdmin() {
		$this->db->query("SELECT * FROM soa_requests ORDER BY FIELD(status, 'pending', 'accepted', 'in process', 'for claiming', 'declined', 'cancelled')");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getRequestsCount() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming FROM soa_requests");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequency($id) {
		$this->db->query("SELECT SUM(case when requested_document='soa' then 1 else 0 end) as SOA, SUM(case when requested_document='order of payment' then 1 else 0 end) as ORDER_OF_PAYMENT FROM soa_requests WHERE student_id=:id");
		
		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getStatusFrequency($id) {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for payment' then 1 else 0 end) as forpayment, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM soa_requests WHERE student_id=:id");
		
		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getRequestAvailability($id) {
		$this->db->query("SELECT SUM(case when requested_document='soa' then 1 else 0 end) as SOA, SUM(case when requested_document='order of payment' then 1 else 0 end) as ORDER_OF_PAYMENT FROM soa_requests WHERE student_id=:id AND (status!='completed' AND status!='rejected' AND status!='cancelled')");
		
		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	private function validateAddRequest($details) {

		if(empty($details['student-id'])) {
			return 'A problem occured, please try again';
		}

		$availability = $this->getRequestAvailability($details['student-id']);

		if(is_object($availability)) {
			if($availability->SOA > 0 && $details['requested-document'] == 'soa') {
				return 'You still have ongoing request for this document';
			}

			if($availability->ORDER_OF_PAYMENT > 0 && $details['requested-document'] == 'order of payment') {
				return 'You still have ongoing request for this document';
			}	
		}

		if(empty($details['requested-document'])) {
			return 'Specify the document to request';
		}

		if(empty($details['purpose'])) {
			return 'Purpose is required';
		}

		if($details['purpose'] == 'Others' && empty($details['other-purpose'])) {
			return 'You need to specify the reason for request';
		}

		return '';
	}

	private function validateUpdateRequest($details) {
		if(empty($details['request-id'])) {
			return 'A problem occured, please try again';
		}

		if(empty($details['requested-document'])) {
			return 'Specify the document to request';
		}

		if(empty($details['purpose'])) {
			return 'Purpose is required';
		}

		if($details['purpose'] == 'Others' && empty($details['other-purpose'])) {
			return 'You need to specify the reason for request';
		}

		return '';
	}

	private function validateStatusUpdate($details) {
		if(empty($details['request-id'])) {
			return 'A problem occured, please try again';
		}

		if(empty($details['status'])) {
			return 'Status is required';
		}

		return '';

	}
}



?>