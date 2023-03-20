<?php

class Alumni extends Controller {
	public function __construct() {
		$this->Alumni = $this->model('Alumnis');
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

	public function records($id) {
		$this->data['alumni-nav-active'] = 'bg-slate-600';
		$this->data['records'] = $this->getAlumniRecords($id);
		$this->data['request-frequency'] = $this->getRequestFrequency($id);
		$this->data['status-frequency'] = $this->getStatusFrequency($id);
		$this->view('alumni/records/index', $this->data);
	}

	private function getRequestFrequency($id) {
		$freq = $this->RequestedDocument->getRequestFrequencyOfAlumni($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getStatusFrequency($id) {
		$freq = $this->RequestedDocument->getStatusFrequencyOfAlumni($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getAlumniRecords($id) {
		$records = $this->Alumni->getAlumniRecords($id);

		if(is_object($records)) return $records;

		return [];
	}

}

?>