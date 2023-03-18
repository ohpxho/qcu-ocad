<?php


class RequestedDocuments {
	public function __construct() {
		$this->db = new Database();
	}

	public function getRequestFrequencyOfStudent($id) {
		$this->db->query("SELECT SUM(case when academic_document_requests.is_tor_included=1 then 1 else 0 end) as TOR, SUM(case when academic_document_requests.is_gradeslip_included=1 then 1 else 0 end) as GRADESLIP, SUM(case when academic_document_requests.is_ctc_included=1 then 1 else 0 end) as CTC, SUM(academic_document_requests.other_requested_document != '' AND academic_document_requests.other_requested_document != NULL) as OTHERS, COUNT(good_moral_requests.id) as GOOD_MORAL, COUNT(soa_requests.id) as SOA FROM academic_document_requests INNER JOIN good_moral_requests ON academic_document_requests.student_id = good_moral_requests.student_id  INNER JOIN soa_requests ON good_moral_requests.student_id = soa_requests.student_id WHERE academic_document_requests.student_id=:id;");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequencyOfAlumni($id) {
		$this->db->query("SELECT SUM(case when is_tor_included=1 then 1 else 0 end) as TOR, SUM(case when is_diploma_included=1 then 1 else 0 end) as DIPLOMA, SUM(case when is_honorable_dismissal_included=1 then 1 else 0 end) as HONORABLE_DISMISSAL FROM academic_document_requests WHERE student_id=:id;");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequencyForSystemAdmin() {
		$this->db->query("SELECT SUM(case when academic_document_requests.is_tor_included=1 then 1 else 0 end) as TOR, SUM(case when academic_document_requests.is_diploma_included=1 then 1 else 0 end) as DIPLOMA, SUM(case when academic_document_requests.is_honorable_dismissal_included=1 then 1 else 0 end) as HONORABLE_DISMISSAL, SUM(case when academic_document_requests.is_gradeslip_included=1 then 1 else 0 end) as GRADESLIP, SUM(case when academic_document_requests.is_ctc_included=1 then 1 else 0 end) as CTC, SUM(academic_document_requests.other_requested_document != '' AND academic_document_requests.other_requested_document != NULL) as OTHERS, COUNT(good_moral_requests.id) as GOOD_MORAL, COUNT(soa_requests.id) as SOA FROM academic_document_requests INNER JOIN good_moral_requests ON academic_document_requests.student_id = good_moral_requests.student_id  INNER JOIN soa_requests ON good_moral_requests.student_id = soa_requests.student_id;");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequencyOfGuidance() {
		$this->db->query("SELECT COUNT(id) as GOOD_MORAL FROM good_moral_requests");

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequencyOfFinance() {
		$this->db->query("SELECT COUNT(id) as SOA FROM soa_requests");
		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequencyOfRegistrar() {
		$this->db->query("SELECT SUM(case when is_tor_included=1 then 1 else 0 end) as TOR, SUM(case when is_gradeslip_included=1 then 1 else 0 end) as GRADESLIP, SUM(case when is_ctc_included=1 then 1 else 0 end) as CTC, SUM(other_requested_document != '' AND other_requested_document != NULL) as OTHERS, SUM(case when is_honorable_dismissal_included=1 then 1 else 0 end) as HONORABLE_DISMISSAL, SUM(case when is_diploma_included=1 then 1 else 0 end) as DIPLOMA FROM academic_document_requests");

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequencyOfStudent($id) {
		$this->db->query("SELECT SUM(pending) as pending, SUM(accepted) as accepted, SUM(rejected) as rejected, SUM(inprocess) as inprocess, SUM(forclaiming) as forclaiming, SUM(completed) as completed FROM((SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM academic_document_requests WHERE student_id=:id)UNION ALL(SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM good_moral_requests WHERE student_id=:id)UNION ALL(SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM soa_requests WHERE student_id=:id)) t1");
		
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequencyOfAlumni($id) {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM academic_document_requests WHERE student_id=:id");
		
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}


	public function getStatusFrequencyForSystemAdmin() {
		$this->db->query("SELECT SUM(pending) as pending, SUM(accepted) as accepted, SUM(rejected) as rejected, SUM(inprocess) as inprocess, SUM(forclaiming) as forclaiming, SUM(completed) as completed FROM((SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM academic_document_requests)UNION ALL(SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM good_moral_requests)UNION ALL(SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM soa_requests)) t1");

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequencyOfGuidance() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM good_moral_requests");
	
		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequencyOfFinance() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM soa_requests");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequencyOfRegistrar() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed FROM academic_document_requests");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

}


?>