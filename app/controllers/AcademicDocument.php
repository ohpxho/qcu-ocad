<?php

class AcademicDocument extends Controller {
	public function __construct() {
		$this->Request = $this->model('AcademicDocumentRequests'); 
		$this->Student = $this->model('Students');
		$this->Activity = $this->model('Activities');
		$this->RequestedDocument = $this->model('RequestedDocuments');

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

	public function index() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		
		$this->data['document-nav-active'] = 'bg-slate-600';
		$this->data['requests-data'] = $this->findAllRequest();
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['activity'] = $this->getAllActivities();

		$this->view('academic-document/index/index', $this->data);
	}

	public function records() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-600';
		$this->data['document-nav-active'] = 'bg-slate-600';
		$this->data['requests-data'] = $this->getAllRecords();
		$this->data['request-frequency'] = $this->getRequestFrequencyOfRegistrar();

		$this->view('academic-document/records/index', $this->data);
	}

	private function getAllActivities() {
		$details = [
			'actor' => $_SESSION['id'],
			'action' => 'ACADEMIC_DOCUMENT_REQUEST'
		];

		$activities = $this->Activity->findAllActivitiesByActorAndAction($details);

		if(is_array($activities)) return $activities;

		return [];
	}

	public function pending($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-pending-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			switch($action) {
				case 'single':
					$request = [
						'student-id' => trim($post['student-id']),
						'request-id' => trim($post['request-id']),
						'status' => trim($post['status']),
						'remarks' => trim($post['remarks']),
					];

					$this->update($request);
					break;

				case 'multiple':
					$request = [
						'student-ids' => trim($post['student-ids']),
						'request-ids' => trim($post['request-ids']),
						'status' => trim($post['multiple-update-status']),
						'remarks' => trim($post['multiple-update-remarks']),
					];

					$this->multiple_update($request);
					break;
			}	

		}

		$this->data['requests-data'] = $this->findAllPendingRequest();

		$this->view('academic-document/pending/index', $this->data);
	}

	public function accepted($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-accepted-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			switch($action) {
				case 'single':
					$request = [
						'student-id' => trim($post['student-id']),
						'request-id' => trim($post['request-id']),
						'status' => trim($post['status']),
						'remarks' => trim($post['remarks']),
					];

					$this->update($request);
					break;

				case 'multiple':
					$request = [
						'student-ids' => trim($post['student-ids']),
						'request-ids' => trim($post['request-ids']),
						'status' => trim($post['multiple-update-status']),
						'remarks' => trim($post['multiple-update-remarks']),
					];

					$this->multiple_update($request);
					break;
			}	

		}

		$this->data['requests-data'] = $this->findAllAcceptedRequest();

		$this->view('academic-document/accepted/index', $this->data);
	}

	public function inprocess($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-inprocess-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			switch($action) {
				case 'single':
					$request = [
						'student-id' => trim($post['student-id']),
						'request-id' => trim($post['request-id']),
						'status' => trim($post['status']),
						'remarks' => trim($post['remarks']),
					];

					$this->update($request);
					break;

				case 'multiple':
					$request = [
						'student-ids' => trim($post['student-ids']),
						'request-ids' => trim($post['request-ids']),
						'status' => trim($post['multiple-update-status']),
						'remarks' => trim($post['multiple-update-remarks']),
					];

					$this->multiple_update($request);
					break;
			}	

		}

		$this->data['requests-data'] = $this->findAllInProcessRequest();

		$this->view('academic-document/in-process/index', $this->data);
	}

	public function forclaiming($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-forclaiming-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			switch($action) {
				case 'single':
					$request = [
						'student-id' => trim($post['student-id']),
						'request-id' => trim($post['request-id']),
						'status' => trim($post['status']),
						'remarks' => trim($post['remarks']),
					];

					$this->update($request);
					break;

				case 'multiple':
					$request = [
						'student-ids' => trim($post['student-ids']),
						'request-ids' => trim($post['request-ids']),
						'status' => trim($post['multiple-update-status']),
						'remarks' => trim($post['multiple-update-remarks']),
					];

					$this->multiple_update($request);
					break;
			}	

		}

		$this->data['requests-data'] = $this->findAllForClaimingRequest();

		$this->view('academic-document/for-claiming/index', $this->data);
	}

	public function edit($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-nav-active'] = 'bg-slate-600';
		$this->data['student-details'] = $this->getStudentDetails();
		$this->data['input-details'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'request-id' => trim($post['request-id']),
				'student-id' => trim($post['student-id']),
				'is-gradeslip-included' => isset($post['is-gradeslip-included'])? 1 : 0,
				'gradeslip-academic-year' => trim($post['gradeslip-academic-year']),
				'gradeslip-semester' => trim($post['gradeslip-semester']),
				'is-ctc-included' => isset($post['is-ctc-included'])? 1 : 0,
				'ctc-document' => $this->uploadAngGetPathOfCTCDoc(),
				'other-requested-document' => trim($post['other-requested-document']),
				'purpose-of-request' => trim($post['purpose-of-request'])
			];

			$result = $this->Request->update($request);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'ACADEMIC_DOCUMENT_REQUEST',
					'description' => 'updated an academic document request'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Academic document request has been updated';
			} else {
				$this->data['flash-error-message'] = $result;
			}

		} 
	
		$this->data['input-details'] = $this->findRequestById($id);
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);
		$this->data['activity'] = $this->getAllActivities();

		$this->view('academic-document/edit/index', $this->data);
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		
		$this->data['document-nav-active'] = 'bg-slate-600';
		$this->data['student-details'] = $this->getStudentDetails();
		$this->data['input-details'] = [];
		$this->data['request-availability'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'student-id' => trim($post['student-id']),
				'is-gradeslip-included' => isset($post['is-gradeslip-included'])? 1 : 0,
				'gradeslip-academic-year' => trim($post['gradeslip-academic-year']),
				'gradeslip-semester' => trim($post['gradeslip-semester']),
				'is-ctc-included' => isset($post['is-ctc-included'])? 1 : 0,
				'ctc-document' => $this->uploadAngGetPathOfCTCDoc(),
				'other-requested-document' => trim($post['other-requested-document']),
				'purpose-of-request' => trim($post['purpose-of-request'])
			];

			$this->data['input-details'] = $request;
			
			$result = $this->Request->addRequestOfStudent($request);
			
			if(empty($result)) {
				$this->data['input-details'] = [];
				
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'ACADEMIC_DOCUMENT_REQUEST',
					'description' => 'created new academic document request'
				];

				$this->addActionToActivities($action);
				
				$this->data['data-changes-flag'] = true;
				$this->data['flash-success-message'] = 'Request has been submitted';
			} else {
				$this->data['flash-error-message'] = $result;
			}
				
		}

		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);

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

	public function cancel($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-nav-active'] = 'bg-slate-600';
		
		$drop = $this->Request->cancel($id);

		if($drop) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'ACADEMIC_DOCUMENT_REQUEST',
				'description' => 'cancelled an academic document request'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Request has been cancelled';
		} else {
			$this->data['flash-error-message'] = 'Some error occurs while cancelling request, please try again';
		}

		$this->data['requests-data'] = $this->findAllRequest();
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['activity'] = $this->getAllActivities();
		$this->view('academic-document/index/index', $this->data);
	}

	public function delete($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-600';

		$drop = $this->Request->drop($id);

		if($drop) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'ACADEMIC_DOCUMENT_REQUEST',
				'description' => 'deleted an academic document request'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Request has been deleted';
		} else {
			$this->data['flash-error-message'] = 'Some error occurs while deleting request, please try again';
		}

		$this->data['requests-data'] = $this->getAllRecords();
		$this->data['request-frequency'] = $this->getRequestFrequencyOfRegistrar();

		$this->view('academic-document/records/index', $this->data);
	} 

	public function multiple_delete() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-600';
		$this->data['document-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$ids = explode(',', trim($post['request-ids-to-drop']));

			foreach($ids as $id) {
				$drop = $this->Request->drop($id);
				if($drop) {
					$action = [
						'actor' => $_SESSION['id'],
						'action' => 'ACADEMIC_DOCUMENT_REQUEST',
						'description' => 'deleted multiple academic document request'
					];

					$this->addActionToActivities($action);
			
					$this->data['flash-success-message'] = 'Requests has been deleted';
				} else {
					$this->data['flash-success-message'] = '';
					$this->data['flash-error-message'] = 'Some error occurs while deleting requests, please try again';
					break;
				}
			}
		}

		$this->data['requests-data'] = $this->getAllRecords();
		$this->data['request-frequency'] = $this->getRequestFrequencyOfRegistrar();
		
		$this->view('academic-document/records/index', $this->data);
	}

	public function update($request) {
		$result = $this->Request->updateStatusAndRemarks($request);
		
		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'ACADEMIC_DOCUMENT_REQUEST',
				'description' => 'updated an academic document request'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Request has been updated';
			$this->sendSMSAndEMailNotification($request);
		} else {
			$this->data['flash-error-message'] = 'Some error occurs while updating request, please try again';
		}
	}

	public function multiple_update($request) {
		$requestIDs =  explode(',', trim($request['request-ids']));
		$studentIDs = explode(',', trim($request['student-ids']));

		foreach($requestIDs as $key => $id) {
			$request = [
				'student-id' => $studentIDs[$key],
				'request-id' => $id,
				'status' => trim($request['status']),
				'remarks' => trim($request['remarks']),
			];

			$result = $this->Request->updateStatusAndRemarks($request);
		
			if($result) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'ACADEMIC_DOCUMENT_REQUEST',
					'description' => 'updated multiple academic document request'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Request has been updated';
				$this->sendSMSAndEMailNotification($request);	
			} else {
				$this->data['flash-success-message'] = '';
				$this->data['flash-error-message'] = 'Some error occurs while updating request, please try again';
				break;
			}
		}
	}

	public function get_requests_count() {
		$result = $this->Request->getRequestsCount();
	
		if(is_object($result)) {
			echo json_encode($result);
			return;
		}

		echo json_encode('');

	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
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

	private function getAllRecords() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllRecordsByStudentId($_SESSION['id']);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$result = $this->Request->findAllRecordsOfStudentsForSystemAdmin();
		} else {
			$result = $this->Request->findAllRecordsOfStudentsForAdmin();
		}

		if(is_array($result)) return $result;

		return [];
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

	private function findAllPendingRequest() {
		$result  = $this->Request->findAllPendingRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function findAllAcceptedRequest() {
		$result  = $this->Request->findAllAcceptedRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function findAllInProcessRequest() {
		$result  = $this->Request->findAllInProcessRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function findAllForClaimingRequest() {
		$result  = $this->Request->findAllForClaimingRequest();

		if(is_array($result)) return $result;

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

	private function getRequestFrequency($id) {
		$freq = $this->Request->getRequestFrequency($id);

		if(is_object($freq)) return $freq;

		return [];	
	}

	private function getRequestFrequencyOfRegistrar() {
		$freq = $this->RequestedDocument->getRequestFrequencyOfRegistrar();

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getRequestAvailability($id) {
		$freq = $this->Request->getRequestAvailability($id);

		if(is_object($freq)) return $freq;

		return [];
	}

}

?>