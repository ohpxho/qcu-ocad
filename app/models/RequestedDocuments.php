<?php


class RequestedDocuments {
	public function __construct() {
		$this->db = new Database();
	}

	public function getRequestFrequencyOfStudent($id) {
		$academic = $this->getRequestFrequencyOfStudentInAcademic($id);
		$goodmoral = $this->getRequestFrequencyOfStudentInGoodMoral($id);
		$account = $this->getRequestFrequencyOfStudentInStudentAccount($id);

		$result = new class {
			public $GRADESLIP; public $CTC; public $OTHERS; public $TOR; public $DIPLOMA; public $HONORABLE_DIMISSASL; public $GOOD_MORAL; public $SOA; public $ORDER_OF_PAYMENT;
		};

		if(is_object($academic) && is_object($goodmoral) && is_object($account)) {
			$result->GRADESLIP = $academic->GRADESLIP;
			$result->CTC = $academic->CTC;
			$result->OTHERS = $academic->OTHERS;
			$result->TOR = $academic->TOR;
			$result->DIPLOMA = $academic->DIPLOMA;
			$result->HONORABLE_DIMISSASL = $academic->HONORABLE_DISMISSAL;
			$result->GOOD_MORAL = $goodmoral->GOOD_MORAL;
			$result->SOA = $account->SOA;
			$result->ORDER_OF_PAYMENT = $account->ORDER_OF_PAYMENT;

			return $result;
		}

		return false;
	}


	public function getRequestFrequencyOfStudentInAcademic($id) {
		$this->db->query("SELECT SUM(case when is_tor_included = 1 then 1 else 0 end) as TOR, SUM(case when is_diploma_included = 1 then 1 else 0 end) as DIPLOMA, SUM(case when is_honorable_dismissal_included = 1 then 1 else 0 end) as HONORABLE_DISMISSAL, SUM(case when is_gradeslip_included = 1 then 1 else 0 end) as GRADESLIP, SUM(case when is_ctc_included = 1 then 1 else 0 end) as CTC, SUM(case when (other_requested_document != '' OR other_requested_document != NULL) then 1 else 0 end) as OTHERS FROM academic_document_requests WHERE student_id=:id");
		
		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getRequestFrequencyOfStudentInGoodMoral($id) {
		$this->db->query("SELECT COUNT(id) as GOOD_MORAL FROM good_moral_requests WHERE student_id=:id");
		
		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getRequestFrequencyOfStudentInStudentAccount($id) {
		$this->db->query("SELECT SUM(case when requested_document='soa' then 1 else 0 end) as SOA, SUM(case when requested_document='order of payment' then 1 else 0 end) as ORDER_OF_PAYMENT FROM soa_requests WHERE student_id=:id");
		
		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getRequestFrequencyOfAlumni($id) {
		$this->db->query("SELECT SUM(case when academic_document_requests.is_tor_included=1 then 1 else 0 end) as TOR, SUM(case when academic_document_requests.is_diploma_included=1 then 1 else 0 end) as DIPLOMA, SUM(case when academic_document_requests.is_honorable_dismissal_included=1 then 1 else 0 end) as HONORABLE_DISMISSAL, COUNT(good_moral_requests.id) as GOOD_MORAL FROM academic_document_requests INNER JOIN good_moral_requests ON academic_document_requests.student_id = good_moral_requests.student_id WHERE academic_document_requests.student_id=:id;");

		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequencyForSystemAdmin() {
		$academic = $this->getRequestFrequencyOfRegistrar();
		$goodmoral = $this->getRequestFrequencyOfGuidance();
		$account = $this->getRequestFrequencyOfFinance();

		$result = new class {
			public $GRADESLIP; public $CTC; public $OTHERS; public $TOR; public $DIPLOMA; public $HONORABLE_DIMISSASL; public $GOOD_MORAL; public $SOA; public $ORDER_OF_PAYMENT;
		};

		if(is_object($academic) && is_object($goodmoral) && is_object($account)) {
			$result->GRADESLIP = $academic->GRADESLIP;
			$result->CTC = $academic->CTC;
			$result->OTHERS = $academic->OTHERS;
			$result->TOR = $academic->TOR;
			$result->DIPLOMA = $academic->DIPLOMA;
			$result->HONORABLE_DIMISSASL = $academic->HONORABLE_DISMISSAL;
			$result->GOOD_MORAL = $goodmoral->GOOD_MORAL;
			$result->SOA = $account->SOA;
			$result->ORDER_OF_PAYMENT = $account->ORDER_OF_PAYMENT;

			return $result;
		}

		return false;
	}

	public function getRequestFrequencyOfGuidance() {
		$this->db->query("SELECT COUNT(id) as GOOD_MORAL FROM good_moral_requests");

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequencyOfFinance() {
		$this->db->query("SELECT SUM(case when requested_document='soa' then 1 else 0 end) as SOA, SUM(case when requested_document='order of payment' then 1 else 0 end) as ORDER_OF_PAYMENT FROM soa_requests");
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
		$this->db->query("SELECT SUM(pending) as pending, SUM(accepted) as accepted, SUM(rejected) as rejected, SUM(inprocess) as inprocess, SUM(forclaiming) as forclaiming, SUM(completed) as completed, SUM(cancelled) as cancelled FROM((SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM academic_document_requests WHERE student_id=:id)UNION ALL(SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM good_moral_requests WHERE student_id=:id)UNION ALL(SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM soa_requests WHERE student_id=:id)) t1");
		
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequencyOfAlumni($id) {
		$this->db->query("SELECT SUM(pending) as pending, SUM(accepted) as accepted, SUM(rejected) as rejected, SUM(inprocess) as inprocess, SUM(forclaiming) as forclaiming, SUM(completed) as completed, SUM(cancelled) as cancelled FROM((SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM academic_document_requests WHERE student_id=:id)UNION ALL(SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM good_moral_requests WHERE student_id=:id)) t1");
		
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}


	public function getStatusFrequencyForSystemAdmin() {
		$this->db->query("SELECT SUM(pending) as pending, SUM(accepted) as accepted, SUM(rejected) as rejected, SUM(inprocess) as inprocess, SUM(forclaiming) as forclaiming, SUM(completed) as completed, SUM(forpayment) as forpayment, SUM(cancelled) as cancelled FROM((SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='for payment' then 1 else 0 end) as forpayment, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM academic_document_requests)UNION ALL(SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='for payment' then 1 else 0 end) as forpayment, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM good_moral_requests)UNION ALL(SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='for payment' then 1 else 0 end) as forpayment, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM soa_requests)) t1");

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequencyOfGuidance() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM good_moral_requests");
	
		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequencyOfFinance() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM soa_requests");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getStatusFrequencyOfRegistrar() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='for payment' then 1 else 0 end) as forpayment, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='in process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM academic_document_requests");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	//summary of completed request

	public function getRequestFrequencyOfStudentByStatus($id, $status) {
		$academic = $this->getRequestFrequencyOfStudentInAcademicByStatus($id, $status);
		$goodmoral = $this->getRequestFrequencyOfStudentInGoodMoralByStatus($id, $status);
		$account = $this->getRequestFrequencyOfStudentInStudentAccountByStatus($id, $status);

		$result = new class {
			public $GRADESLIP; public $CTC; public $OTHERS; public $TOR; public $DIPLOMA; public $HONORABLE_DIMISSASL; public $GOOD_MORAL; public $SOA; public $ORDER_OF_PAYMENT;
		};

		if(is_object($academic) && is_object($goodmoral) && is_object($account)) {
			$result->GRADESLIP = $academic->GRADESLIP;
			$result->CTC = $academic->CTC;
			$result->OTHERS = $academic->OTHERS;
			$result->TOR = $academic->TOR;
			$result->DIPLOMA = $academic->DIPLOMA;
			$result->HONORABLE_DIMISSASL = $academic->HONORABLE_DISMISSAL;
			$result->GOOD_MORAL = $goodmoral->GOOD_MORAL;
			$result->SOA = $account->SOA;
			$result->ORDER_OF_PAYMENT = $account->ORDER_OF_PAYMENT;

			return $result;
		}

		return false;
	}


	public function getRequestFrequencyOfStudentInAcademicByStatus($id, $status) {
		$this->db->query("SELECT SUM(case when is_tor_included = 1 then 1 else 0 end) as TOR, SUM(case when is_diploma_included = 1 then 1 else 0 end) as DIPLOMA, SUM(case when is_honorable_dismissal_included = 1 then 1 else 0 end) as HONORABLE_DISMISSAL, SUM(case when is_gradeslip_included = 1 then 1 else 0 end) as GRADESLIP, SUM(case when is_ctc_included = 1 then 1 else 0 end) as CTC, SUM(case when (other_requested_document != '' OR other_requested_document != NULL) then 1 else 0 end) as OTHERS FROM academic_document_requests WHERE student_id=:id AND status=:status");
		
		$this->db->bind(':id', $id);
		$this->db->bind(':status', $status);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getRequestFrequencyOfStudentInGoodMoralByStatus($id, $status) {
		$this->db->query("SELECT COUNT(id) as GOOD_MORAL FROM good_moral_requests WHERE student_id=:id AND status=:status");
		
		$this->db->bind(':id', $id);
		$this->db->bind(':status', $status);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getRequestFrequencyOfStudentInStudentAccountByStatus($id, $status) {
		$this->db->query("SELECT SUM(case when requested_document='soa' then 1 else 0 end) as SOA, SUM(case when requested_document='order of payment' then 1 else 0 end) as ORDER_OF_PAYMENT FROM soa_requests WHERE student_id=:id AND status=:status");
		
		$this->db->bind(':id', $id);
		$this->db->bind(':status', $status);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getRequestFrequencyForSystemAdminByStatus($status) {
		$academic = $this->getRequestFrequencyOfRegistrarByStatus($status);
		$goodmoral = $this->getRequestFrequencyOfGuidanceByStatus($status);
		$account = $this->getRequestFrequencyOfFinanceByStatus($status);

		$result = new class {
			public $GRADESLIP; public $CTC; public $OTHERS; public $TOR; public $DIPLOMA; public $HONORABLE_DIMISSASL; public $GOOD_MORAL; public $SOA; public $ORDER_OF_PAYMENT;
		};

		if(is_object($academic) && is_object($goodmoral) && is_object($account)) {
			$result->GRADESLIP = $academic->GRADESLIP;
			$result->CTC = $academic->CTC;
			$result->OTHERS = $academic->OTHERS;
			$result->TOR = $academic->TOR;
			$result->DIPLOMA = $academic->DIPLOMA;
			$result->HONORABLE_DIMISSASL = $academic->HONORABLE_DISMISSAL;
			$result->GOOD_MORAL = $goodmoral->GOOD_MORAL;
			$result->SOA = $account->SOA;
			$result->ORDER_OF_PAYMENT = $account->ORDER_OF_PAYMENT;

			return $result;
		}

		return false;
	}

	public function getRequestFrequencyOfGuidanceByStatus($status) {
		$this->db->query("SELECT COUNT(id) as GOOD_MORAL FROM good_moral_requests WHERE status=:status");

		$this->db->bind(':status', $status);

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequencyOfFinanceByStatus($status) {
		$this->db->query("SELECT SUM(case when requested_document='soa' then 1 else 0 end) as SOA, SUM(case when requested_document='order of payment' then 1 else 0 end) as ORDER_OF_PAYMENT FROM soa_requests WHERE status=:status");

		$this->db->bind(':status', $status);

		$result = $this->db->getSingleResult();
			
		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequencyOfRegistrarByStatus($status) {
		$this->db->query("SELECT SUM(case when is_tor_included=1 then 1 else 0 end) as TOR, SUM(case when is_gradeslip_included=1 then 1 else 0 end) as GRADESLIP, SUM(case when is_ctc_included=1 then 1 else 0 end) as CTC, SUM(other_requested_document != '' AND other_requested_document != NULL) as OTHERS, SUM(case when is_honorable_dismissal_included=1 then 1 else 0 end) as HONORABLE_DISMISSAL, SUM(case when is_diploma_included=1 then 1 else 0 end) as DIPLOMA FROM academic_document_requests WHERE status=:status");

		$this->db->bind(':status', $status);

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) return $result;

		return false;
	}

}


?>