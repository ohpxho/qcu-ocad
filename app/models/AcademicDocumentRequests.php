<?php


class AcademicDocumentRequests {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($data) {
		$this->db->query("INSERT INTO academic_document_requests 
			(student_id, 
			is_tor_included, 
			tor_last_academic_year_attended, 
			is_diploma_included, 
			diploma_year_graduated, 
			is_gradeslip_included, 
			gradeslip_academic_year, 
			gradeslip_semester, 
			is_ctc_included, 
			ctc_document,
			other_requested_document, 
			purpose_of_request, 
			is_RA11261_beneficiary, 
			barangay_certificate, 
			oath_of_undertaking,
			date_created) 
			VALUES 
			(:student_id, 
			:is_tor_included, 
			:tor_last_academic_year_attended, 
			:is_diploma_included, 
			:diploma_year_graduated,
			:is_gradeslip_included,
			:gradeslip_academic_year, 
			:gradeslip_semester, 
			:is_ctc_included,
			:ctc_document, 
			:other_requested_document, 
			:purpose_of_request, 
			:is_RA11261_beneficiary, 
			:barangay_certificate, 
			:oath_of_undertaking,
			NOW())");

		$this->db->bind(':student_id', $data['student-id']);
		$this->db->bind(':is_tor_included', $data['is-tor-included']);
		$this->db->bind(':tor_last_academic_year_attended', $data['tor-last-academic-year-attended']);
		$this->db->bind(':is_diploma_included', $data['is-diploma-included']);
		$this->db->bind(':diploma_year_graduated', $data['diploma-year-graduated']);
		$this->db->bind(':is_gradeslip_included', $data['is-gradeslip-included']);
		$this->db->bind(':gradeslip_academic_year', $data['gradeslip-academic-year']);
		$this->db->bind(':gradeslip_semester', $data['gradeslip-semester']);
		$this->db->bind(':is_ctc_included', $data['is-ctc-included']);
		$this->db->bind(':ctc_document', $data['ctc-document']);
		$this->db->bind(':other_requested_document', $data['other-requested-document']);
		$this->db->bind(':purpose_of_request', $data['purpose-of-request']);
		$this->db->bind(':is_RA11261_beneficiary', $data['is-RA11261-beneficiary']);
		$this->db->bind(':barangay_certificate', $data['barangay-certificate']);
		$this->db->bind(':oath_of_undertaking', $data['oath-of-undertaking']);

		$result = $this->db->execute();

		if($result) return true;
		return false; 
	}

	public function findAllRequestByStudentId($id) {
		$this->db->query("SELECT * FROM academic_document_requests WHERE student_id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();
		
		if(is_array($result)) {
			return $result;
		}

		return false;
	}

	public function findAllRequest() {
		$this->db->query("SELECT * FROM academic_document_requests");

		$result = $this->db->getAllResult();
		
		if(is_array($result)) {
			return $result;
		}

		return false;
	}

	public function findRequestById($id) {
		$this->db->query("SELECT * FROM academic_document_requests WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function drop($id) {
		$this->db->query("DELETE FROM academic_document_requests WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function updateStatusAndRemarks($request) {
		$this->db->query("UPDATE academic_document_requests SET status=:status, remarks=:remarks WHERE id=:id");
		$this->db->bind(':id', $request['request-id']);
		$this->db->bind(':status', $request['status']);
		$this->db->bind(':remarks', $request['remarks']);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}
}

?>