<?php


class AcademicDocumentRequests {
	public function __construct() {
		$this->db = new Database();
	}

	public function addRequestOfStudent($data) {
		$validate = $this->validateAddRequest($data);

		if(empty($validate)) {
			$this->db->query("INSERT INTO academic_document_requests (student_id, is_tor_included, tor_last_academic_year_attended, is_gradeslip_included, gradeslip_academic_year, gradeslip_semester, is_ctc_included, ctc_document, other_requested_document, purpose_of_request, is_RA11261_beneficiary, barangay_certificate, oath_of_undertaking, date_created, type) VALUES (:student_id, :is_tor_included, :tor_last_academic_year_attended, :is_gradeslip_included, :gradeslip_academic_year, :gradeslip_semester, :is_ctc_included, :ctc_document, :other_requested_document, :purpose_of_request, :is_RA11261_beneficiary, :barangay_certificate, :oath_of_undertaking, NOW(), :type)");

			$this->db->bind(':student_id', $data['student-id']);
			$this->db->bind(':is_tor_included', $data['is-tor-included']);
			$this->db->bind(':tor_last_academic_year_attended', $data['tor-last-academic-year-attended']);
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
			$this->db->bind(':type', 'student');

			$result = $this->db->execute();

			if($result) return '';
			return 'Something went wrong, please try again'; 

		} else {
			return $validate;
		}
	}

	public function findAllRequestByStudentId($id) {
		$this->db->query("SELECT * FROM academic_document_requests WHERE student_id=:id ORDER BY FIELD(status, 'pending') DESC");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();
		
		if(is_array($result)) {
			return $result;
		}

		return false;
	}

	public function findAllRequest() {
		$this->db->query("SELECT * FROM academic_document_requests ORDER BY FIELD(status, 'pending') DESC");

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

	public function findAllPendingRequest() {
		$this->db->query("SELECT * FROM academic_document_requests WHERE status='pending' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllAcceptedRequest() {
		$this->db->query("SELECT * FROM academic_document_requests WHERE status='accepted' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllInProcessRequest() {
		$this->db->query("SELECT * FROM academic_document_requests WHERE status='in process' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllForClaimingRequest() {
		$this->db->query("SELECT * FROM academic_document_requests WHERE status='for claiming' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

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

	public function update($request) {
		$validate = $this->validateEditRequest($request);
		
		if(empty($validate)) {
			$this->db->query("UPDATE academic_document_requests SET is_tor_included=:is_tor_included, tor_last_academic_year_attended=:tor_last_academic_year_attended,  is_gradeslip_included=:is_gradeslip_included, gradeslip_academic_year=:gradeslip_academic_year, gradeslip_semester=:gradeslip_semester, is_ctc_included=:is_ctc_included, other_requested_document=:other_requested_document, purpose_of_request=:purpose_of_request, is_RA11261_beneficiary=:is_RA11261_beneficiary WHERE id=:id");

			$this->db->bind(':id', $request['request-id']);
			$this->db->bind(':is_tor_included', $request['is-tor-included']);
			$this->db->bind(':tor_last_academic_year_attended', $request['tor-last-academic-year-attended']);
			$this->db->bind(':is_gradeslip_included', $request['is-gradeslip-included']);
			$this->db->bind(':gradeslip_academic_year', $request['gradeslip-academic-year']);
			$this->db->bind(':gradeslip_semester', $request['gradeslip-semester']);
			$this->db->bind(':is_ctc_included', $request['is-ctc-included']);
			$this->db->bind(':other_requested_document', $request['other-requested-document']);
			$this->db->bind(':purpose_of_request', $request['purpose-of-request']);
			$this->db->bind(':is_RA11261_beneficiary', $request['is-RA11261-beneficiary']);

			$result = $this->db->execute();

			if(!$result) return 'Something went wrong, please try again';

			if(!empty($request['ctc-document'])) {
				if(!$this->updateCTCDocuments($request['request-id'], $request['ctc-document'])) return 'CTC document failed to upload';
			}

			if(!empty($request['barangay-certificate']) && !empty($request['oath-of-undertaking'])) {
				if(!$this->updateBeneficiaryDocuments($request['request-id'], $request['barangay-certificate'], $request['oath-of-undertaking'])) return 'RA11261 Beneficiary document/s failed to upload';
			}
			
			return ''; 
	
		} else {
			return $validate;
		}

	}

	public function updateCTCDocuments($id, $document) {
		$this->db->query("UPDATE academic_document_requests SET ctc_document=:ctc_document WHERE id=:id");
		$this->db->bind(':ctc_document', $document);
		$this->db->bind(':id', $id);
		$result = $this->db->execute();
		if($result) return true;
		return false;
	}

	public function updateBeneficiaryDocuments($id, $barangay, $oath) {
		$this->db->query("UPDATE academic_document_requests SET barangay_certificate=:barangay_certificate, oath_of_undertaking=:oath_of_undertaking WHERE id=:id");
		$this->db->bind(':id', $id);
		$this->db->bind(':barangay_certificate', $barangay);
		$this->db->bind(':oath_of_undertaking', $oath);
		$result = $this->db->execute();
		if($result) return true;
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

	public function findAllRecordsByStudentId($id) {
		$this->db->query("SELECT * FROM academic_document_requests WHERE student_id=:id AND (status='completed' || status='rejected')");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsOfStudents($id) {
		$this->db->query("SELECT * FROM academic_document_requests WHERE status='completed' || status='rejected'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getRequestsCount() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming FROM academic_document_requests");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequency($id) {
		$this->db->query("SELECT SUM(case when is_tor_included = 1 then 1 else 0 end) as TOR, SUM(case when is_gradeslip_included = 1 then 1 else 0 end) as GRADESLIP, SUM(case when is_diploma_included = 1 then 1 else 0 end) as DIPLOMA, SUM(case when is_ctc_included = 1 then 1 else 0 end) as CTC FROM academic_document_requests WHERE student_id=:id AND status!='rejected'");
		
		$this->db->bind(':id', $id);
		
		$result = $this->db->getAllResult();

		if(is_object($result) || is_array($result)) {
			return $result;
		}

		return false;
	}

	private function validateAddRequest($request) {
		if(empty($request['student-id'])) {
			return 'A problem occured, please try again';
		}
		
		if(!$request['is-tor-included'] && !$request['is-ctc-included'] && !$request['is-gradeslip-included'] && empty($request['other-requested-document'])) {
			return 'You need to choose an academic document to request';
		}

		if(!$request['is-tor-included'] && !empty($request['tor-last-academic-year-attended'])) {
			return 'You need to check TOR (undergraduate) option';
		}

		if($request['is-tor-included'] && empty($request['tor-last-academic-year-attended'])) {
			return 'Last academic year attended is required';
		}

		if(!$request['is-gradeslip-included'] && (!empty($request['gradeslip-academic-year']) || !empty($request['gradeslip-semester']))) {
			return 'You need to check Gradeslip option';
		}

		if($request['is-gradeslip-included'] && (empty($request['gradeslip-academic-year']) || empty($request['gradeslip-semester']))) {
			return 'Academic year and Semester is required';
		}	

		if($request['is-ctc-included'] && empty($request['ctc-document'])) {
			return 'You need to provide a clear copy of document';
		}

		if(!$request['is-ctc-included'] && !empty($request['ctc-document'])) {
			return 'No need to provide a document for CTC';
		}

		if(empty($request['purpose-of-request'])) {
			return 'Purpose of request is required';
		}

		if(empty($request['is-RA11261-beneficiary'])) {
			return "You need to specify if you're a RA11261 beneficiary";
		}

		if($request['is-RA11261-beneficiary'] == 'yes' && (empty($request['barangay-certificate']) || empty($request['oath-of-undertaking']))) {
			return 'You need to provide a Barangay Certificate and Oath of Undertaking';
		}

		if($request['is-RA11261-beneficiary'] == 'no' && (!empty($request['barangay-certificate']) || !empty($request['oath-of-undertaking']))) {
			return 'No need to provide Barangay Certificate and Oath of Undertaking';
		}
	}

	private function validateEditRequest($request) {
		$record = $this->findRequestById($request['request-id']); 

		if(!is_object($record)) {
			return 'A problem occured, please try again';
		}

		if(empty($request['student-id'])) {
			return 'A problem occured, please try again';
		}
		
		if(!$request['is-tor-included'] && !$request['is-ctc-included'] && !$request['is-gradeslip-included'] && empty($request['other-requested-document'])) {
			return 'You need to choose an academic document to request';
		}

		if(!$request['is-tor-included'] && !empty($request['tor-last-academic-year-attended'])) {
			return 'You need to check TOR (undergraduate) option';
		}

		if($request['is-tor-included'] && empty($request['tor-last-academic-year-attended'])) {
			return 'Last academic year attended is required';
		}

		if(!$request['is-gradeslip-included'] && (!empty($request['gradeslip-academic-year']) || !empty($request['gradeslip-semester']))) {
			return 'You need to check Gradeslip option';
		}

		if($request['is-gradeslip-included'] && (empty($request['gradeslip-academic-year']) || empty($request['gradeslip-semester']))) {
			return 'Academic year and Semester is required';
		}	

		if($request['is-ctc-included'] && empty($request['ctc-document'])) {
			if(empty($record->ctc_document)) return 'You need to provide a clear copy of document';
		}

		if(!$request['is-ctc-included'] && !empty($request['ctc-document'])) {
			return 'No need to provide a document for CTC';
		}

		if(empty($request['purpose-of-request'])) {
			return 'Purpose of request is required';
		}

		if(empty($request['is-RA11261-beneficiary'])) {
			return "You need to specify if you're a RA11261 beneficiary";
		}

		if($request['is-RA11261-beneficiary'] == 'yes' && (empty($request['barangay-certificate']) || empty($request['oath-of-undertaking']))) {
			if(empty($record->barangay_certificate) || empty($record->oath_of_undertaking)) return 'You need to provide a Barangay Certificate and Oath of Undertaking';
		}

		if($request['is-RA11261-beneficiary'] == 'no' && (!empty($request['barangay-certificate']) || !empty($request['oath-of-undertaking']))) {
			return 'No need to provide Barangay Certificate and Oath of Undertaking';
		}
	}
}

?>