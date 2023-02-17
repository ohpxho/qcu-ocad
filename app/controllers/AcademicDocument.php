<?php

class AcademicDocument extends Controller {
	public function __construct() {
		$this->Request = $this->model('AcademicDocumentRequests'); 
		$this->Student = $this->model('Students');
		
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
			'record-nav-active' => ''
		];
		
	}

	public function index() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		
		$this->data['document-nav-active'] = 'bg-slate-200';
		$this->data['requests-data'] = $this->findAllRequest();
		
		$this->view('academic-document/index/index', $this->data);
	}

	public function edit($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-nav-active'] = 'bg-slate-200';
		$this->data['student-details'] = $this->getStudentDetails();
		$this->data['input-details'] = [];
		$this->data['request-frequency'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'request-id' => trim($post['request-id']),
				'student-id' => trim($post['student-id']),
				'is-tor-included' => isset($post['is-tor-included'])? 1 : 0,
				'tor-last-academic-year-attended' => trim($post['tor-last-academic-year-attended']),
				'is-diploma-included' => isset($post['is-diploma-included'])? 1 : 0,
				'diploma-year-graduated' => trim($post['diploma-year-graduated']),
				'is-gradeslip-included' => isset($post['is-gradeslip-included'])? 1 : 0,
				'gradeslip-academic-year' => trim($post['gradeslip-academic-year']),
				'gradeslip-semester' => trim($post['gradeslip-semester']),
				'is-ctc-included' => isset($post['is-ctc-included'])? 1 : 0,
				'ctc-document' => $this->uploadAngGetPathOfCTCDoc(),
				'other-requested-document' => trim($post['other-requested-document']),
				'purpose-of-request' => trim($post['purpose-of-request']),
				'is-RA11261-beneficiary' => trim($post['is-RA11261-beneficiary']),
				'barangay-certificate' => $this->uploadAngGetPathOfBarangayCertificateDoc(),
				'oath-of-undertaking' => $this->uploadAndGetPathOfOathDoc()
			];

			$result = $this->Request->update($request);

			if(empty($result)) {
				$this->data['flash-success-message'] = 'Request updated successfully';
			} else {
				$this->data['flash-error-message'] = $result;
			}

		} 
	
		$this->data['input-details'] = $this->findRequestById($id);
		$this->data['request-frequency'] = $this->getStatusFrequency($this->data['student-details']->id); 
		
		$this->view('academic-document/edit/index', $this->data);
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		
		$this->data['document-nav-active'] = 'bg-slate-200';
		$this->data['student-details'] = $this->getStudentDetails();
		$this->data['input-details'] = [];
		$this->data['request-frequency'] = [];

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
				'ctc-document' => $this->uploadAngGetPathOfCTCDoc(),
				'other-requested-document' => trim($post['other-requested-document']),
				'purpose-of-request' => trim($post['purpose-of-request']),
				'is-RA11261-beneficiary' => trim($post['is-RA11261-beneficiary']),
				'barangay-certificate' => $this->uploadAngGetPathOfBarangayCertificateDoc(),
				'oath-of-undertaking' => $this->uploadAndGetPathOfOathDoc()
			];

			$this->data['input-details'] = $request;

			$result = $this->Request->add($request);

			if(empty($result)) {
				$this->data['flash-success-message'] = 'Request added successfully';
			} else {
				$this->data['flash-error-message'] = $result;
			}
				
		}

		$this->data['request-frequency'] = $this->getStatusFrequency($this->data['student-details']->id); 

		$this->view('academic-document/add/index', $this->data);
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

		$this->data['document-nav-active'] = 'bg-slate-200';

		$drop = $this->Request->drop($id);

		if($drop) {
			$this->data['flash-success-message'] = 'Request deleted successfully.';
		} else {
			$this->data['flash-error-message'] = 'Request deleted failed.';
		}

		$this->data['requests-data'] = $this->findAllRequest();

		$this->view('academic-document/index/index', $this->data);
	} 

	public function multiple_drop() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-nav-active'] = 'bg-slate-200';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$ids = explode(',', trim($post['request-ids-to-drop']));

			foreach($ids as $id) {
				$drop = $this->Request->drop($id);
				if($drop) {
					$this->data['flash-success-message'] = 'Requests deleted successfully.';
				} else {
					$this->data['flash-success-message'] = '';
					$this->data['flash-error-message'] = 'Some Request failed to delete.';
					break;
				}
			}
		}

		$this->data['requests-data'] = $this->findAllRequest();
		
		$this->view('academic-document/index/index', $this->data);
	}

	public function update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-nav-active'] = 'bg-slate-200';
		
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
				$this->data['flash-success-message'] = 'Request updated successfully.';
				$this->sendSMSAndEMailNotification($request);
			} else {
				$this->data['flash-error-message'] = 'Request update failed.';
			}
		}

		$this->data['requests-data'] = $this->findAllRequest();

		$this->view('/academic-document/index/index', $this->data);
	}

	public function multiple_update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-nav-active'] = 'bg-slate-200';

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
					$this->data['flash-success-message'] = 'Requests updated successfully.';
					$this->sendSMSAndEMailNotification($request);	
				} else {
					$this->data['flash-success-message'] = '';
					$this->data['flash-error-message'] = 'Request update failed.';
					break;
				}
			}
		}

		$this->data['requests-data'] = $this->findAllRequest();

		$this->view('/academic-document/index/index', $this->data);
	}

	private function sendSMSAndEMailNotification($info) {
		$student = $this->Student->findStudentById($info['student-id']);
				
		if(is_object($student)) {
			$email = [
				'recipient' => $student->email,
				'name' => $student->fname,
				'message' => 'Your request is updated. Please visit QCU OCAD and see your request status. Thank You'
			];

			//sendSMS($student->contact, 'Your request is updated. Please visit QCU OCAD and see your request status. Thank You');
			//sendEmail($email);
		}
	}

	private function uploadAngGetPathOfCTCDoc() {
		$path = '';
		if(isset($_FILES['ctc-document'])) $path = uploadDocument($_FILES['ctc-document']);
		return $path;
	}

	private function uploadAngGetPathOfBarangayCertificateDoc() {
		$path = '';
		if(isset($_FILES['barangay-certificate'])) $path = uploadDocument($_FILES['barangay-certificate']);
		return $path;
	}

	private function uploadAndGetPathOfOathDoc() {
		$path = '';
		if(isset($_FILES['oath-of-undertaking'])) $path = uploadDocument($_FILES['oath-of-undertaking']);
		return $path;	
	}

	private function findRequestById($id) {
		$request = $this->Request->findRequestById($id); 

		if(is_object($request)) {
			return $request;
		}
		
		return [];
	}

	private function findAllRequest() {
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


	private function getStudentDetails() {
		if(isset($_SESSION['id'])) {
			$details = $this->Student->findStudentById($_SESSION['id']); 
			if(is_object($details)) {
				return $details;
			}
		}
		return [];
	}

	private function getStatusFrequency($id) {
		$frequency = $this->Request->getStatusFrequency($id);
		if(is_object($frequency) || is_array($frequency)) {
			return $frequency;
		}

		return [];
	}

}

?>