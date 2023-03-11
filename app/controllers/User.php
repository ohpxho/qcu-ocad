<?php

class User extends Controller {
	public function __construct() {
		$this->User = $this->model('Users');
		$this->Student = $this->model('Students');
		$this->Admin = $this->model('Admins');
		$this->Professor = $this->model('Professors');
		$this->Activity = $this->model('Activities');
		$this->Request = $this->model('RequestedDocuments');
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
			'setting-nav-active' => ''
		];
	}

	public function dashboard() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		$this->data['dashboard-nav-active'] = 'bg-slate-200';
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['status-frequency'] = $this->getStatusFrequency($_SESSION['id']);
		$this->data['consultation-frequency'] =  $this->getConsultationFrequency($_SESSION['id']);
		$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($_SESSION['id']);
		$this->data['recent-activity'] = $this->getRecentActivities($_SESSION['id']);
		$this->view('user/dashboard/index', $this->data);
	}

	private function getRecentActivities($actor) {
		$activities = $this->Activity->findRecentActivitiesByActor($actor);

		if(is_array($activities)) return $activities;

		return [];
	}

	private function getUpcomingConsultation($id) {
		if($_SESSION['type'] == 'student') {
			$result = $this->Consultation->findUpcomingConsultationOfStudent($id);
		} else {
			$result = $this->Consultation->findUpcomingConsultationOfAdviser($id);
		}

		if(is_array($result)) return $result;

		return [];
	}

	private function getConsultationFrequency($id) {
		if($_SESSION['type'] == 'student') {
			$freq = $this->Consultation->getConsultationFrequencyOfStudent($id);
		} else {
			$freq = $this->Consultation->getConsultationFrequencyOfAdviser($id);
		}

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getRequestFrequency($id) {

		switch($_SESSION['type']) {
			case 'student':
				$freq = $this->Request->getRequestFrequencyOfStudent($id);
				break;
			case 'guidance':
				$freq = $this->Request->getRequestFrequencyOfGuidance();
				break;
			case 'finance':
				$freq = $this->Request->getRequestFrequencyOfFinance();
				break;
			case 'registrar':
				$freq = $this->Request->getRequestFrequencyOfRegistrar();
				break;
			default:
				$freq = false;
		}
		
		if(is_object($freq)) return $freq;

		return [];
	}

	private function getStatusFrequency($id) {
		switch($_SESSION['type']) {
			case 'student':
				$freq = $this->Request->getStatusFrequencyOfStudent($id);
				break;
			case 'guidance':
				$freq = $this->Request->getStatusFrequencyOfGuidance();
				break;
			case 'finance':
				$freq = $this->Request->getStatusFrequencyOfFinance();
				break;
			case 'registrar':
				$freq = $this->Request->getStatusFrequencyOfRegistrar();
				break;
			default:
				$freq = false;
		}

		if(is_object($freq)) return $freq;

		return [];
	}

	public function profile($action='', $type='') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['profile-nav-active'] = 'bg-slate-200';
		$this->data['profile'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$result = 'Some error occured while updating profile, please try again';

			if($action == 'update') {
				switch($type) {
					case 'account_details':
						$result = $this->updateAccountDetails($post);
						$this->updateEmailFromPersonalDetails(trim($post['id']), trim($post['email']));
						break;
					case 'personal_details':
						$result = $this->updatePersonalDetails($post);
						break;
				}
			}

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => strtoupper($_SESSION['type']),
					'description' => 'updated profile'
				];

				$this->addActionToActivities($action);
				
				$this->data['flash-success-message'] = 'Profile has been updated';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['personal-details'] = $this->getUserDetails($_SESSION['id'], $_SESSION['type']);
		$this->data['account-details'] = $this->getAccountDetails($_SESSION['id']);

		$this->view('user/profile/index', $this->data);
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}

	private function updateAccountDetails($post) {
		$details = [
			'id' => trim($post['id']),
			'email' => trim($post['email']),
			'old-pass' => trim($post['old-pass']),
			'new-pass' => trim($post['new-pass']),
			'confirm-new-pass' => trim($post['confirm-new-pass']),
			'profile-pic' =>  $this->uploadProfilePicture()
		];

		return $this->User->update($details);

	}

	private function updatePersonalDetails($post) {

		switch($_SESSION['type']) {
			case 'student':
				$details = [
					'id' => trim($post['id']),
					'lname' => trim($post['lname']),
					'fname' => trim($post['fname']),
					'mname' => trim($post['mname']),
					'gender' => trim($post['gender']),
					'contact' => trim($post['contact']),
					'location' => trim($post['location']),
					'course' => trim($post['course']),
					'section' => trim($post['section']),
					'year' => trim($post['year']),
					'address' => trim($post['address']),
					'type' => trim($post['type']),
					'identification' => $this->uploadIdentification()
				];

				return $this->Student->update($details);
			case 'professor': 
				$details = [
					'id' => trim($post['id']),
					'lname' => trim($post['lname']),
					'fname' => trim($post['fname']),
					'mname' => trim($post['mname']),
					'department' => trim($post['department']),
					'contact' => trim($post['contact']),
					'gender' => trim($post['gender']),
				];
				
				return $this->Professor->update($details);
			default:
				$details = [
					'id' => trim($post['id']),
					'lname' => trim($post['lname']),
					'fname' => trim($post['fname']),
					'mname' => trim($post['mname']),
					'department' => trim($post['department']),
					'contact' => trim($post['contact']),
					'gender' => trim($post['gender']),
				];
				
				return $this->Admin->update($details);	
		}

		return '';
	}

	private function updateEmailFromPersonalDetails($id, $email) {
		switch($_SESSION['type']) {
			case 'student':
				return $this->Student->update_email($id, $email);
			case 'professor': 
				return $this->Professor->update_email($id, $email);
			default:
				return $this->Admin->update_email($id, $email);
			
		}
	}

	private function uploadProfilePicture() {
		$path = '';
		if(isset($_FILES['profile-pic'])) $path = uploadDocument($_FILES['profile-pic']);
		return $path;
	}

	private function uploadIdentification() {
		$path = '';
		if(isset($_FILES['identification'])) $path = uploadDocument($_FILES['identification']);
		return $path;
	}

	private function getUserDetails($id, $type) {
		
		switch($type) {
			case 'student':
				$profile = $this->Student->findStudentById($id);
				break;
			case 'professor':
				$profile = $this->Professor->findProfessorById($id);
				break;
			default:	
				$profile = $this->Admin->findAdminById($id);
		}

		if(is_object($profile)) return $profile;

		return [];
	}

	private function getAccountDetails($id) {
		
		$details = $this->User->findUserById($id);

		if(is_object($details)) return $details;

		return [];
	}
}

?>