<?php

class Admin extends Controller {

	public function __construct() {
		$this->Admin = $this->model('Admins');
		
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

	private function addActionToActivities($details) {
		$this->Admin->add($details);
	}

	private function AddAdmin() {
		if(is_array($result)) {
			return $result;
		}

		return [];
	}
	public function details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$result = $this->Admin->findRequestById($post['id']);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo '';
	}

	public function new() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['admin-nav-active'] = 'bg-slate-200';
		$this->view('/user/admin/add/index', $this->data);
	}


	public function add() {

		$this->data['admin-nav-active'] = 'bg-slate-200';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$new = [
				'id' => trim($post['id']),
				'lname' => trim($post['lname']),
				'fname' => trim($post['fname']),
				'mname' => trim($post['mname']),
				'email' => trim($post['email']),
				'department' => trim($post['department']),
				'contact' => trim($post['cnumber']),
				'address' => trim($post['address']),
				'pword' => trim($post['pword']),
				'gender' => trim($post['gender'])
			];

			$result = $this->Admin->add($new);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'admin',
					'description' => 'New admin account created'
				];

				$this->addActionToActivities($action);

				$this->data['data-changes-flag'] = true;
				$this->data['flash-success-message'] = 'New admin account added succesfully';
			} else {
				$this->data['flash-error-message'] = $result;
			}

		}
		$this->view('user/admin/add/index', $this->data); 
	}
}			
?>

