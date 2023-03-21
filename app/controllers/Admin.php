<?php

class Admin extends Controller {
	public function __construct() {
		$this->User = $this->model('Users');
		$this->Admin = $this->model('Admins');
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
			'document-declined-nav-active' => '',
			'document-completed-nav-active' => '',
			'document-cancelled-nav-active' => '',
			'document-records-nav-active' => '',
			'moral-nav-active' => '',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'consultation-resolved-nav-active' => '',
			'consultation-declined-nav-active' => '',
			'consultation-cancelled-nav-active' => '',
			'record-nav-active' => '',
			'student-nav-active' => '',
			'alumni-nav-active' => '',
			'professor-nav-active' => '',
			'admin-nav-active' => '',
			'setting-nav-active' => '',
		];
	}

	public function login() {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');

		$this->data['credentials'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$credentials = [
				'id' => trim($post['id']),
				'pass' => trim($post['password'])
			];

			$this->data['credentials'] = $credentials;

			if($this->isLoginDetailsValid($credentials)) {
				$user = $this->User->loginAdmin($credentials);

				if(is_object($user)) {
					if($user->status == 'blocked') {
						$this->data['flash-error-message'] = 'Your account is blocked';
					} else if($user->status == 'closed') {
						$this->data['flash-error-message'] = 'Your account is closed';
					} else {
						$this->createUserSession($user);	
						header('location:'.URLROOT.'/user/dashboard');
					} 
				} else {
					$this->data['flash-error-message'] = 'Incorrect ID/Email or Password';
				}
			} else {
				$this->data['flash-error-message'] = 'Invalid input, please try again';
			}
		}
		$this->view('admin/login/index', $this->data);
	}

	public function add() {
		$this->data['admin-nav-active'] = 'bg-slate-600';
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
				'type' => trim($post['department'])
			];

			$this->data['input-details'] = $details;

			$addToUserModel = $this->User->add($details);
			$addToAdminModel = $this->Admin->add($details);

			if(empty($addToUserModel) && empty($addToAdminModel)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'USER_ACCOUNT',
					'description' => 'added new admin account'
				];

				$this->addActionToActivities($action);

				$this->data['input-details'] = [];
				$this->data['flash-success-message'] = 'Added new admin account';
			} else {
				if(!empty($addToUserModel)) $this->data['flash-error-message'] = $addToUserModel;
				else $this->data['flash-error-message'] = $addToAdminModel;
			}
		}

		$this->view('admin/add/index', $this->data);
	}

	public function records($id) {
		$this->data['admin-nav-active'] = 'bg-slate-600';
		$this->data['records'] = $this->getAdminRecords($id);
		$this->data['consultation-frequency'] = $this->getConsultationFrequency($id);
		$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($id);
		$this->view('admin/records/index', $this->data);
	}

	private function createUserSession($user) {
		$admin = $this->Admin->findAdminById($user->id);
		
		$_SESSION['id'] = $user->id;
		$_SESSION['email'] = $user->email;
		$_SESSION['fname'] = $admin->fname;		
		$_SESSION['lname'] = $admin->lname;
		$_SESSION['type'] = $user->type;
		$_SESSION['pic'] = $user->pic;
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

	private function getAdminRecords($id) {
		$records = $this->Admin->getAdminRecords($id);

		if(is_object($records)) return $records;

		return [];
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}

	private function isLoginDetailsValid($data) {
		if(empty($data['id'])) return false;
		if(empty($data['pass'])) return false;
		return true;
	}
}

?>