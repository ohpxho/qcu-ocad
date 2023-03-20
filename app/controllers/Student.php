<?php


class Student extends Controller {
	public function __construct() {
		$this->Student = $this->model('Students');
		$this->RequestedDocument = $this->model('RequestedDocuments');
		$this->Consultation = $this->model('Consultations');

		$this->data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'profile-nav-active' => '',
			'notification-nav-active' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'document-pending-nav-active' => '',
			'document-accepted-nav-active' => '',
			'document-inprocess-nav-active' => '',
			'document-forclaiming-nav-active' => '',
			'document-records-nav-active' => '',
			'moral-nav-active' => '',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'record-nav-active' => '',
			'student-nav-active' => '',
			'alumni-nav-active' => '',
			'professor-nav-active' => '',
			'admin-nav-active' => '',
			'setting-nav-active' => '',
		];
	}

	public function details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$result = $this->Student->findStudentById($post['id']);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}

		}
		echo '';
	}

	public function records($id) {
		$this->data['student-nav-active'] = 'bg-slate-600';
		$this->data['records'] = $this->getStudentRecords($id);
		$this->data['request-frequency'] = $this->getRequestFrequency($id);
		$this->data['status-frequency'] = $this->getStatusFrequency($id);
		$this->data['consultation-frequency'] = $this->getConsultationFrequency($id);
		$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($id);
		$this->view('student/records/index', $this->data);
	}

	private function getRequestFrequency($id) {
		$freq = $this->RequestedDocument->getRequestFrequencyOfStudent($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getStatusFrequency($id) {
		$freq = $this->RequestedDocument->getStatusFrequencyOfStudent($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getConsultationFrequency($id) {
		$freq = $this->Consultation->getConsultationFrequencyOfStudent($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getUpcomingConsultation($id) {
		$freq = $this->Consultation->findUpcomingConsultationOfStudent($id);

		if(is_array($freq)) return $freq;

		return [];
	}

	private function getStudentRecords($id) {
		$records = $this->Student->getStudentRecords($id);

		if(is_object($records)) return $records;

		return [];
	}
}


?>