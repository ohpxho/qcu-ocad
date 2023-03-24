<?php

class Subject extends Controller {
	public function __construct() {
		$this->Subject = $this->model('SubjectCodes');
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
			'setting-nav-active' => ''
		];
	}

	public function index() {
		$this->data['setting-nav-active'] = 'bg-slate-600';
		$this->data['subjects'] = [];

		$this->data['subjects'] = $this->getAllSubject();
		$this->view('subject/index', $this->data);
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		$this->data['setting-nav-active'] = 'bg-slate-600';
		$this->data['subjects'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'code' => strtoupper(trim($post['code'])),
				'title' => ucwords(trim($post['title'])),
				'department' => ucwords(trim($post['department']))
			];

			$result = $this->Subject->add($details);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'SUBJECT_MANAGEMENT',
					'description' => 'added new subject'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Subject has been added';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['subjects'] = $this->getAllSubject();
		$this->view('subject/index', $this->data);
	}


	public function update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		$this->data['setting-nav-active'] = 'bg-slate-600';
		$this->data['subjects'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'id' => trim($post['id']),
				'code' => strtoupper(trim($post['code'])),
				'title' => ucwords(trim($post['title'])),
				'department' => ucwords(trim($post['department']))
			];

			$result = $this->Subject->update($details);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'SUBJECT_MANAGEMENT',
					'description' => 'updated a subject'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Subject has been updated';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['subjects'] = $this->getAllSubject();
		$this->view('subject/index', $this->data);
	}

	public function delete($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		$this->data['setting-nav-active'] = 'bg-slate-600';
		$this->data['subjects'] = [];

		$result = $this->Subject->drop($id);

		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'SUBJECT_MANAGEMENT',
				'description' => 'deleted a subject'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Subject has been deleted';
		} else {
			$this->data['flash-error-message'] = $result;
		}
	
		$this->data['subjects'] = $this->getAllSubject();
		$this->view('subject/index', $this->data);
	}

	public function multiple_delete() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['setting-nav-active'] = 'bg-slate-600';
		$this->data['subjects'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$ids = explode(',', trim($post['subject-ids-to-drop']));

			foreach($ids as $id) {
				$drop = $this->Subject->drop($id);
				if($drop) {
					$action = [
						'actor' => $_SESSION['id'],
						'action' => 'SUBJECT_MANAGEMENT',
						'description' => 'deleted multiple subjects'
					];

					$this->addActionToActivities($action);
			
					$this->data['flash-success-message'] = 'Subjects has been deleted';
				} else {
					$this->data['flash-success-message'] = '';
					$this->data['flash-error-message'] = 'Some error occurred while deleting subjects, please try again';
					break;
				}
			}
		}

		$this->data['subjects'] = $this->getAllSubject();
		$this->view('subject/index', $this->data);
	}

	public function details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$id = trim($post['id']);

			$result = $this->Subject->findSubjectById($id);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}

	private function getAllSubject() {
		$result = $this->Subject->getAllSubject();

		if(is_array($result)) return $result;

		return [];
	}

}

?>