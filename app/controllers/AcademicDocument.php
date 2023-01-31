<?php

class AcademicDocument extends Controller {
	public function __construct() {
		$this->Request = $this->model('AcademicDocumentRequests'); 
		$this->Student = $this->model('Students');
	}

	public function index() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => 'bg-slate-200',
			'moral-nav-active' => '',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'ongoing-nav-active' => '',
			'transaction-nav-active' => '',
			'record-nav-active' => '',
			'requests-data' => []
		];
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllRequestByStudentId($_SESSION['id']);	
		} else {
			$result = $this->Request->findAllRequest();
		}
		
		if(is_array($result)) {
			$data['requests-data'] = $result;
		}

		$this->view('document-request/index', $data);
	}

	public function edit($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => 'bg-slate-200',
			'moral-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'ongoing-nav-active' => '',
			'transaction-nav-active' => '',
			'record-nav-active' => '',
			'student-details' => $this->getStudentDetails(),
			'input-details' => []
		];
		
		$request = $this->Request->findRequestById($id); 

		if(is_object($request)) {
			$data['input-details'] = $request;
		}

		$this->view('document-request/action/edit', $data);
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => 'bg-slate-200',
			'moral-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'ongoing-nav-active' => '',
			'transaction-nav-active' => '',
			'record-nav-active' => '',
			'student-details' => $this->getStudentDetails(),
			'input-details' => []
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'student-id' => trim($post['student-id']),
				'is-tor-included' => isset($post['is-tor-included'])? 1 : 0,
				'tor-last-academic-year-attended' => trim($post['tor-last-academic-year-attended']),
				'is-diploma-included' => isset($post['is-diploma-included'])? 1 : 0,
				'diploma-year-graduated' => trim($post['diploma-year-graduated']),
				'is-gradeslip-included' => isset($post['is-gradeslip-included'])? 1 : 0,
				'gradeslip-academic-year' => trim($post['gradeslip-academic-year']),
				'gradeslip-semester' => trim($post['gradeslip-semester']),
				'is-ctc-included' => isset($post['is-ctc-included'])? 1 : 0,
				'ctc-document' => '',
				'other-requested-document' => trim($post['other-requested-document']),
				'purpose-of-request' => trim($post['purpose-of-request']),
				'is-RA11261-beneficiary' => trim($post['is-RA11261-beneficiary']),
				'barangay-certificate' => '',
				'oath-of-undertaking' => ''
			];

			$data['input-details'] = $request;

			$validate = $this->validateRequest($request);

			if(empty($validate)) {
				if(isset($_FILES['ctc-document'])) {
					$path = uploadDocument($_FILES['ctc-document']);
					$request['ctc-document'] = $path;
				}

				if(isset($_FILES['barangay-certificate'])) {
					$path = uploadDocument($_FILES['barangay-certificate']);
					$request['barangay-certificate'] = $path;
				}

				if(isset($_FILES['oath-of-undertaking'])) {
					$path = uploadDocument($_FILES['oath-of-undertaking']);
					$request['oath-of-undertaking'] = $path;
				}

				$result = $this->Request->add($request);

				if($result) {
					$data['flash-success-message'] = 'Added new academic document request successfully.';
					$data['input-details'] = [];
				} else {
					$data['flash-error-message'] = 'Something went wrong. Please try again.';
				}

			} else {
				$data['flash-error-message'] = $validate;
			}
		}
		$this->view('document-request/action/add', $data);
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


	public function drop($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => 'bg-slate-200',
			'moral-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'ongoing-nav-active' => '',
			'transaction-nav-active' => '',
			'record-nav-active' => '',
			'requests-data' => []
		];

		$drop = $this->Request->drop($id);

		if($drop) {
			$data['flash-success-message'] = 'Request deleted successfully.';
		} else {
			$data['flash-error-message'] = 'Request deleted failed.';
		}

		$result = $this->Request->findAllRequestByStudentId($_SESSION['id']);

		if(is_array($result)) {
			$data['requests-data'] = $result;
		}

		$this->view('document-request/index', $data);
	} 

	public function update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => 'bg-slate-200',
			'student-records-nav-active' => '',
			'moral-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'ongoing-nav-active' => '',
			'transaction-nav-active' => '',
			'record-nav-active' => '',
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
					sendEmail($email);
				}
				

			} else {
				$data['flash-error-message'] = 'Request update failed.';
			}
		}

		$requests = $this->Request->findAllRequest();

		if(is_array($requests)) {
			$data['requests-data'] = $requests;
		}

		$this->view('/document-request/index', $data);
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

	private function validateRequest($request) {
		if(empty($request['student-id'])) {
			return 'Student Id cannot be empty.';
		}
		
		if(!$request['is-tor-included'] && !$request['is-diploma-included'] && !$request['is-ctc-included'] && !$request['is-gradeslip-included'] && empty($request['other-requested-document'])) {
			return 'You need to choose an academic document to request';
		}

		if(!$request['is-tor-included'] && !empty($request['tor-last-academic-year-attended'])) {
			return 'You need to check TOR (undergraduate) option.';
		}

		if($request['is-tor-included'] && empty($request['tor-last-academic-year-attended'])) {
			return 'Last academic year attended cannot be empty.';
		}

		if(!$request['is-diploma-included'] && !empty($request['diploma-year-graduated'])) {
			return 'You need to check TOR / Diploma option.';
		}

		if($request['is-diploma-included'] && empty($request['diploma-year-graduated'])) {
			return 'Year graduated cannot be empty.';
		}

		if(!$request['is-gradeslip-included'] && (!empty($request['gradeslip-academic-year']) || !empty($request['gradeslip-semester']))) {
			return 'You need to check Gradeslip option.';
		}

		if($request['is-gradeslip-included'] && (empty($request['gradeslip-academic-year']) || empty($request['gradeslip-semester']))) {
			return 'Academic year and Semester cannot be empty.';
		}	

		if($request['is-ctc-included'] && !is_uploaded_file($_FILES['ctc-document']['tmp_name'])) {
			return 'You need to provide a clear copy of document.';
		}

		if(!$request['is-ctc-included'] && is_uploaded_file($_FILES['ctc-document']['tmp_name'])) {
			return 'No need to provide a document for CTC';
		}

		if(empty($request['purpose-of-request'])) {
			return 'Purpose of request cannot be empty.';
		}

		if(empty($request['is-RA11261-beneficiary'])) {
			return "You need to specify if you're a RA11261 beneficiary.";
		}

		if($request['is-RA11261-beneficiary'] == 'yes' && (!is_uploaded_file($_FILES['barangay-certificate']['tmp_name']) || !is_uploaded_file($_FILES['oath-of-undertaking']['tmp_name']))) {
			return 'You need to provide a Barangay Certificate and Oath of Undertaking.';
		}

		if($request['is-RA11261-beneficiary'] == 'no' && (is_uploaded_file($_FILES['barangay-certificate']['tmp_name']) || is_uploaded_file($_FILES['oath-of-undertaking']['tmp_name']))) {
			return 'No need to provide Barangay Certificate and Oath of Undertaking';
		}
	}
}

?>