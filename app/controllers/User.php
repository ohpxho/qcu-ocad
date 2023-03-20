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
		$this->Alumni = $this->model('Alumnis');

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
		$this->data['dashboard-nav-active'] = 'bg-slate-600';
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['status-frequency'] = $this->getStatusFrequency($_SESSION['id']);
		$this->data['consultation-frequency'] =  $this->getConsultationFrequency($_SESSION['id']);
		$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($_SESSION['id']);
		$this->data['recent-activity'] = $this->getRecentActivities($_SESSION['id']);
		$this->view('user/dashboard/index', $this->data);
	}

	public function student() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['student-nav-active'] = 'bg-slate-600';
		$this->data['students'] = $this->getAllStudent(); 

		$this->view('user/student/index', $this->data);
	}

	public function alumni() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['alumni-nav-active'] = 'bg-slate-600';
		$this->data['alumnis'] = $this->getAllAlumni();

		$this->view('user/alumni/index', $this->data);
	}

	public function admin() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['admin-nav-active'] = 'bg-slate-600';
		$this->data['admins'] = $this->getAllAdmin();

		$this->view('user/admin/index', $this->data);
	}

	public function professor() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['professor-nav-active'] = 'bg-slate-600';
		$this->data['professors'] = $this->getAllProfessor();

		$this->view('user/professor/index', $this->data);
	}

	public function close($type, $id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		
		$result = $this->User->close($id);
		
		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'USER_ACCOUNT',
				'description' => 'closed an account'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Account has been closed';
		} else {
			$this->data['flash-error-message'] = 'Some error occured while closing account, please try again';
		}

		$this->setViewToDisplay($type, $this->data);
	}

	public function open($type, $id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		
		$result = $this->User->open($id);
		
		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'USER_ACCOUNT',
				'description' => 'opened an account'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Account has been opened';
		} else {
			$this->data['flash-error-message'] = 'Some error occured while opening account, please try again';
		}

		$this->setViewToDisplay($type, $this->data);
	}

	public function block() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'id' => trim($post['id']),
				'type' => trim($post['type']),
				'remarks' => trim($post['remarks'])
			];

			$result = $this->User->block($details);

			if($result) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'USER_ACCOUNT',
					'description' => 'blocked an account'
				];

				$this->addActionToActivities($action);
				$this->data['flash-success-message'] = 'Account has been blocked';
			} else {
				$this->data['flash-error-message'] = 'Some error occured while blocking account, please try again';
			}
		}

		$this->setViewToDisplay($details['type'], $this->data);
	}

	public function unblock($type, $id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$result = $this->User->unblock($id);

		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'USER_ACCOUNT',
				'description' => 'unblocked an account'
			];

			$this->addActionToActivities($action);
			$this->data['flash-success-message'] = 'Account has been unblocked';
		} else {
			$this->data['flash-error-message'] = 'Some error occured while unblocking account, please try again';
		}
	
		$this->setViewToDisplay($type, $this->data);
	}

	public function delete($type, $id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		switch($type) {
			case 'student':
				$result = $this->Student->delete($id);
				break;
			case 'alumni':
				$result = $this->Alumni->delete($id);
				break;
			case 'admin':
				$result = $this->Admin->delete($id);
				break;
			case 'professor':
				$result = $this->Professor->delete($id);
				break;
		}

		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'USER_ACCOUNT',
				'description' => 'deleted an account'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Account has been deleted';
		} else {
			$this->data['flash-error-message'] = 'Some error occured while deleting account, please try again';
		}

		$this->setViewToDisplay($type, $this->data);
	}

	public function multiple_delete() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$ids = explode(',', trim($post['ids-to-drop']));
			$type = trim($post['type']);

			foreach($ids as $id) {

				switch($type) {
					case 'student':
						$result = $this->Student->delete($id);
						break;
					case 'alumni':
						$result = $this->Alumni->delete($id);;
						break;
					case 'admin':
						$result = $this->Admin->delete($id);;
						break;
					case 'professor':
						$result = $this->Professor->delete($id);;
						break;
				}

				if($result) {
					$action = [
						'actor' => $_SESSION['id'],
						'action' => 'USER_ACCOUNT',
						'description' => 'deleted multiple student account'
					];

					$this->addActionToActivities($action);
			
					$this->data['flash-success-message'] = 'Accounts has been deleted';
				} else {
					$this->data['flash-success-message'] = '';
					$this->data['flash-error-message'] = 'Some error occurs while deleting accounts, please try again';
					break;
				}
			}
		}

		$this->setViewToDisplay($type, $this->data);
	}

	private function setViewToDisplay($type, $data) {
		switch($type) {
			case 'student':
				$data['student-nav-active'] = 'bg-slate-600';
				$data['students'] = $this->getAllStudent();
				$this->view('user/student/index', $data);
				break;
			case 'alumni':
				$data['alumni-nav-active'] = 'bg-slate-600';
				$data['alumnis'] = $this->getAllAlumni();
				$this->view('user/alumni/index', $data);
				break;
			case 'admin':
				$data['admin-nav-active'] = 'bg-slate-600';
				$data['admins'] = $this->getAllAdmin();
				$this->view('user/admin/index', $data);
				break;
			case 'professor':
				$data['professor-nav-active'] = 'bg-slate-600';
				$data['professors'] = $this->getAllProfessor();
				$this->view('user/professor/index', $data);
				break;
		}
	}

	public function get_student_details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$id = trim($post['id']);

			$result = $this->Student->getStudentRecords($id);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);
	}

	public function get_alumni_details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$id = trim($post['id']);

			$result = $this->Alumni->getAlumniRecords($id);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);
	}

	private function getAllStudent() {
		$students = $this->Student->getAllStudent();

		if(is_array($students)) return $students;

		return [];
	}

	private function getAllAlumni() {
		$alumnis = $this->Alumni->getAllAlumni();

		if(is_array($alumnis)) return $alumnis;

		return [];
	}

	private function getAllAdmin() {
		$admins = $this->Admin->getAllAdmin();

		if(is_array($admins)) return $admins;

		return [];
	}

	private function getAllProfessor() {
		$professors = $this->Professor->getAllProfessor();

		if(is_array($professors)) return $professors;

		return [];
	}

	private function getRecentActivities($actor) {
		$activities = $this->Activity->findRecentActivitiesByActor($actor);

		if(is_array($activities)) return $activities;

		return [];
	}

	private function getUpcomingConsultation($id) {
		if($_SESSION['type'] == 'student') {
			$result = $this->Consultation->findUpcomingConsultationOfStudent($id);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$result = $this->Consultation->findUpcomingConsultationForSystemAdmin();
		} else {
			$result = $this->Consultation->findUpcomingConsultationOfAdviser($id);
		}

		if(is_array($result)) return $result;

		return [];
	}

	private function getConsultationFrequency($id) {
		if($_SESSION['type'] == 'student') {
			$freq = $this->Consultation->getConsultationFrequencyOfStudent($id);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$freq = $this->Consultation->getConsultationFrequencyForSystemAdmin();
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
			case 'sysadmin':
				$freq = $this->Request->getRequestFrequencyForSystemAdmin();
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
			case 'sysadmin':
				$freq = $this->Request->getStatusFrequencyForSystemAdmin();
				break;
			default:
				$freq = false;
		}

		if(is_object($freq)) return $freq;

		return [];
	}

	public function approval() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'id' => trim($post['id']),
				'type' => trim($post['type']),
				'approval' => trim($post['status']),
				'remarks' => trim($post['remarks'])
			];

			$result = $this->User->approval($details);

			if($result) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'USER_ACCOUNT',
					'description' => 'perform account approval'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Account has been updated';
			} else {
				$this->data['flash-error-message'] = 'Some error occured while updating, please try again';
			}
		}

		$this->setViewToDisplay($details['type'], $this->data);
	}

	public function profile($action='', $type='') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['profile-nav-active'] = 'bg-slate-600';
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