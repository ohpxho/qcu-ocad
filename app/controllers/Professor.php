<?php

class Professor extends Controller {
	public function __construct() {
		$this->User = $this->model('Users');
		$this->Professor = $this->model('Professors');
		$this->RequestedDocument = $this->model('RequestedDocuments');
		$this->Consultation = $this->model('Consultations');
		$this->Activity = $this->model('Activities');

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

	public function add() {
		$this->data['admin-nav-active'] = 'bg-slate-200';
		$this->data['input-details'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'id' => trim($post['id']),
				'email' => trim($post['email']),
				'pass' => trim($post['pass']),
				'confirm-pass' => trim($post['confirm-pass']),
				'lname' => trim($post['lname']),
				'fname' => trim($post['fname']),
				'mname' => trim($post['mname']),
				'gender' => trim($post['gender']),
				'contact' => trim($post['contact']),
				'department' => trim($post['department']),
				'type' => trim($post['type'])
			];

			$this->data['input-details'] = $details;

			$addToUserModel = $this->User->add($details);
			$addToProfessorModel = $this->Professor->add($details);

			if(empty($addToUserModel) && empty($addToProfessorModel)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'USER_ACCOUNT',
					'description' => 'added new professor account'
				];

				$this->addActionToActivities($action);

				$this->data['input-details'] = [];
				$this->data['flash-success-message'] = 'Added new professor account';
			} else {
				if(!empty($addToUserModel)) $this->data['flash-error-message'] = $addToUserModel;
				else $this->data['flash-error-message'] = $addToProfessorModel;
			}
		}

		$this->view('professor/add/index', $this->data);
	}

	public function records($id) {
		$this->data['professor-nav-active'] = 'bg-slate-200';
		$this->data['records'] = $this->getProfessorRecords($id);
		$this->data['consultation-frequency'] = $this->getConsultationFrequency($id);
		$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($id);
		$this->view('professor/records/index', $this->data);
	}

	private function getConsultationFrequency($id) {
		$freq = $this->Consultation->getConsultationFrequencyOfAdviser($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getUpcomingConsultation($id) {
		$freq = $this->Consultation->findUpcomingConsultationOfAdviser($id);

		if(is_array($freq)) return $freq;

		return [];
	}

	private function getProfessorRecords($id) {
		$records = $this->Professor->getProfessorRecords($id);

		if(is_object($records)) return $records;

		return [];
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}
}

?>