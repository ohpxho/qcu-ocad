<?php

class Consultation extends Controller {
	public function __construct() {
		$this->Request = $this->model('Consultations');
		$this->Student = $this->model('Students');
		$this->Professor = $this->model('Professors');
		
		$this->data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'moral-nav-active' => '',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'record-nav-active' => '',
			'request-data' => []
		];
	}	

	public function request() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-200';
		$this->data['pending-requests-data'] = $this->getAllPendingRequest();

		$this->view('consultation/request/index', $this->data);
	}

	public function active() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-active-nav-active'] = 'bg-slate-200';
		$this->data['active-requests-data'] = $this->getAllActiveRequest();

		$this->view('consultation/active/index', $this->data);
	}

	public function show($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-active-nav-active'] = 'bg-slate-200';
		$this->data['request-data'] = $this->getRequestById($id);

		$this->view('consultation/view/index', $this->data);
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-200';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'creator' => trim($post['student-id']),
				'purpose' => trim($post['purpose']),
				'problem' => $post['problem'],
				'department' => trim($post['department']),
				'subject' => trim($post['subject']),
				'adviser-id' => trim($post['adviser-id']),
				'adviser-name' => $this->getAdviserName(trim($post['adviser-id'])),
				'preferred-date' => trim($post['preferred-date']),
				'preferred-time' => trim($post['preferred-time']),
				'document' => $this->uploadAndGetPathOfUploadedDocuments()
			];

			$this->data['request-data'] = $request;

			$result = $this->Request->add($request);

			if(empty($result)) {
				$this->data['flash-success-message'] = 'Request added successfully.';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->view('consultation/add/index', $this->data);
	}

	public function edit($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-200';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'id' => trim($post['request-id']),
				'purpose' => trim($post['purpose']),
				'problem' => $post['problem'],
				'department' => trim($post['department']),
				'subject' => trim($post['subject']),
				'adviser-id' => trim($post['adviser-id']),
				'adviser-name' => $this->getAdviserName(trim($post['adviser-id'])),
				'preferred-date' => trim($post['preferred-date']),
				'preferred-time' => trim($post['preferred-time']),
				'document' => $this->uploadAndGetPathOfUploadedDocuments()
			];
			
			$result = $this->Request->edit($request);

			if(empty($result)) {
				$this->data['flash-success-message'] = 'Request updated successfully.';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['request-data'] = $this->getRequestById($id);

		$this->view('consultation/edit/index', $this->data);
	}

	public function drop($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-200';

		$result = $this->Request->drop($id);

		if($result) {
			$this->data['flash-success-message'] = 'Request deleted successfully';
		} else {
			$this->data['flash-error-message'] = 'Reuqest deleted failed';
		}

		$this->data['pending-requests-data'] = $this->getAllPendingRequest();

		$this->view('consultation/request/index', $this->data);
	}

	public function details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$result = $this->Request->findRequestById(trim($post['id']));

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}

		}
		echo '';
	}

	private function getAdviserName($id) {
		$adviser = $this->Professor->findProfessorById($id);

		if(is_object($adviser)) {
			$lastname = $adviser->lname;
			$firstname = $adviser->fname;

			return $firstname.' '.$lastname;
		}

		return '';
	}

	private function uploadAndGetPathOfUploadedDocuments() {
		if(isset($_FILES['document']) ) return '';
		
		$path = [];
		
		foreach($_FILES['document'] as $file) {
			array_push($path, uploadDocument($_FILES['identification-document']));
		}

		return implode(',', $path);
	}

	private function getStudentDetails() {
		if(isset($_SESSION['id'])) {
			$details = $this->Student->findStudentById($_SESSION['id']); 
			if(is_object($details)) {
				return $details;
			}
		}
		return [];
	}

	private function getRequestById($id) {
		$result = $this->Request->findRequestById($id);
		if(is_object($result)) {
			return $result;
		}

		return [];
	} 

	private function getAllPendingRequest() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllPendingRequestByStudentId($_SESSION['id']);	
		} else {
			$result = $this->Request->findAllPendingRequest();
		}
		
		if(is_array($result)) {
			return $result;
		}

		return [];
	}

	private function getAllActiveRequest() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllActiveRequestByStudentId($_SESSION['id']);	
		} elseif($_SESSION['type'] == 'professor') {
			$result = $this->Request->findAllActiveRequestByProfessorId($_SESSION['id']);
		} else {
			$result = $this->Request->findAllPendingRequest();
		}
		
		if(is_array($result)) {
			return $result;
		}

		return [];
	}
}


?>