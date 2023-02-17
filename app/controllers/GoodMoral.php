<?php

class GoodMoral extends Controller {
	public function __construct() {
		$this->Request = $this->model('GoodMoralRequests');
		$this->Student = $this->model('Students');
	}	

	public function index() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'moral-nav-active' => 'bg-slate-200',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'record-nav-active' => '',
			'requests-data' => $this->getAllRequest()
		];

		$this->view('good-moral/index/index', $data);
	}

	public function details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$result = $this->Request->findRequestById($post['id']);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}

		}
		echo '';
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'moral-nav-active' => 'bg-slate-200',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'requests-data' => [],
			'student-details' => $this->getStudentDetails(),
			'request-frequency' => []
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'student-id' => trim($post['student-id']),
				'purpose' => trim($post['purpose']),
				'other-purpose' => trim($post['other-purpose']),
				'identification-document' => $this->uploadAndGetPathOfIndetificationDocument()
			];

			$result = $this->Request->add($request);
			
			if(empty($result)) {
				$data['flash-success-message'] = 'Added new good moral request successfully.';
			} else {
				$data['flash-error-message'] = $result;
			}
		}

		$data['requests-data'] = $this->getAllRequest();
		
		$this->view('good-moral/index/index', $data);
	}

	public function edit() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'moral-nav-active' => 'bg-slate-200',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'requests-data' => [],
			'student-details' => $this->getStudentDetails(),
			'request-frequency' => []
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'request-id' => trim($post['request-id']),
				'purpose' => trim($post['purpose']),
				'other-purpose' => trim($post['other-purpose']),
				'identification-document' => $this->uploadAndGetPathOfIndetificationDocument()
			];

			$result = $this->Request->edit($request);
			
			if(empty($result)) {
				$data['flash-success-message'] = 'Request updated successfully.';
			} else {
				$data['flash-error-message'] = $result;
			}
		}

		$data['requests-data'] = $this->getAllRequest();
		
		$this->view('good-moral/index/index', $data);
	}

	public function drop($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'moral-nav-active' => 'bg-slate-200',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'requests-data' => []
		];

		$drop = $this->Request->drop($id);

		if($drop) {
			$data['flash-success-message'] = 'Request deleted successfully.';
		} else {
			$data['flash-error-message'] = 'Request deleted failed.';
		}

		$data['requests-data'] = $this->getAllRequest();

		$this->view('good-moral/index/index', $data);
	} 

	public function multiple_drop() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'moral-nav-active' => 'bg-slate-200',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'requests-data' => []
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$ids = explode(',', trim($post['request-ids-to-drop']));

			foreach($ids as $id) {
				$drop = $this->Request->drop($id);
				if($drop) {
					$data['flash-success-message'] = 'Requests deleted successfully.';
				} else {
					$data['flash-success-message'] = '';
					$data['flash-error-message'] = 'Some Request failed to delete.';
					break;
				}
			}
		}

		$data['requests-data'] = $this->getAllRequest();
		
		$this->view('good-moral/index/index', $data);
	}
	
	public function update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'student-records-nav-active' => '',
			'moral-nav-active' => 'bg-slate-200',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'requests-data' => []
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'student-id' => trim($post['student-id']),
				'request-id' => trim($post['request-id']),
				'status' => trim($post['status']),
				'remarks' => trim($post['remarks']),
			];

			$result = $this->Request->updateStatusAndRemarks($request);
			
			if($result) {
				$data['flash-success-message'] = 'Request updated successfully.';
				
				$student = $this->Student->findStudentById($request['student-id']);
				
				if(is_object($student)) {
					$email = [
						'recipient' => $student->email,
						'name' => $student->fname,
						'message' => 'Your request is updated. Please visit QCU OCAD and see your request status. Thank You'
					];

					//sendSMS($student->contact, 'Your request is updated. Please visit QCU OCAD and see your request status. Thank You');
					//sendEmail($email);
				}
				

			} else {
				$data['flash-error-message'] = 'Request update failed.';
			}
		}

		$data['requests-data'] = $this->getAllRequest();

		$this->view('/good-moral/index/index', $data);
	}

	public function multiple_update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'student-records-nav-active' => '',
			'moral-nav-active' => 'bg-slate-200',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'requests-data' => []
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$requestIDs =  explode(',', trim($post['request-ids']));
			$studentIDs = explode(',', trim($post['student-ids']));

			foreach($requestIDs as $key => $id) {
				$request = [
					'student-id' => $studentIDs[$key],
					'request-id' => $id,
					'status' => trim($post['multiple-update-status']),
					'remarks' => trim($post['multiple-update-remarks']),
				];

				$result = $this->Request->updateStatusAndRemarks($request);
			
				if($result) {
					$data['flash-success-message'] = 'Requests updated successfully.';
					
					$student = $this->Student->findStudentById($request['student-id']);
					
					if(is_object($student)) {
						$email = [
							'recipient' => $student->email,
							'name' => $student->fname,
							'message' => 'Your request is updated. Please visit QCU OCAD and see your request status. Thank You'
						];

						//sendSMS($student->contact, 'Your request is updated. Please visit QCU OCAD and see your request status. Thank You');
						//sendEmail($email);
					}
					

				} else {
					$data['flash-success-message'] = '';
					$data['flash-error-message'] = 'Request update failed.';
					break;
				}
			}
		}

		$data['requests-data'] = $this->getAllRequest();

		$this->view('/good-moral/index/index', $data);
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

	private function getRequestFrequency() {

	}

	private function uploadAndGetPathOfIndetificationDocument() {
		$path = '';
		
		if(isset($_FILES['identification-document'])) {
			$path = uploadDocument($_FILES['identification-document']);
		}

		return $path;
	}

	private function getAllRequest() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllRequestByStudentId($_SESSION['id']);	
		} else {
			$result = $this->Request->findAllRequest();
		}
		
		if(is_array($result)) {
			return $result;
		}

		return [];
	}
}


?>