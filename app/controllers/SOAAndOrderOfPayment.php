<?php

class SOAAndOrderOfPayment extends Controller {

	public function __construct() {
		$this->Request = $this->model('SOAAndOrderOfPaymentRequests');
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
			'document-records-nav-active' => '',
			'moral-nav-active' => '',
			'student-records-nav-active' => '',
			'soa-nav-active' => 'bg-slate-200',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'record-nav-active' => '',
			'student-nav-active' => '',
			'alumni-nav-active' => '',
			'professor-nav-active' => '',
			'admin-nav-active' => '',
			'setting-nav-active' => '',
			'data-changes-flag' => false
		];
	}

	public function index() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		
		$this->data['requests-data'] = $this->getStudentRequestRecords();
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);

		$this->view('soa-and-order-of-payment/index/index', $this->data);
	}

	public function records() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-200';
		$this->data['request-frequency'] = $this->getRequestFrequencyOfFinance();
		$this->data['requests-data'] = $this->getAllRecords();

		$this->view('soa-and-order-of-payment/records/index', $this->data);
	}

	public function pending($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-pending-nav-active'] = 'bg-slate-200';
		
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

		$this->data['requests-data'] = $this->getAllPendingRequest();

		$this->view('soa-and-order-of-payment/pending/index', $this->data);
	}

	public function accepted($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-accepted-nav-active'] = 'bg-slate-200';
		
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

		$this->data['requests-data'] = $this->getAllAcceptedRequest();

		$this->view('soa-and-order-of-payment/accepted/index', $this->data);
	}

	public function inprocess($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-inprocess-nav-active'] = 'bg-slate-200';
		
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

		$this->data['requests-data'] = $this->getAllInProcessRequest();

		$this->view('soa-and-order-of-payment/in-process/index', $this->data);
	}

	public function forclaiming($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-forclaiming-nav-active'] = 'bg-slate-200';
		
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

		$this->data['requests-data'] = $this->getAllForClaimingRequest();

		$this->view('soa-and-order-of-payment/for-claiming/index', $this->data);
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['requests-data'] = [];
		$this->data['student-details'] = $this->getStudentDetails();
		$this->data['request-availability'] = [];
		$this->data['request-frequency'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'student-id' => trim($post['student-id']),
				'purpose' => trim($post['purpose']),
				'other-purpose' => trim($post['other-purpose'])
			];

			$result = $this->Request->add($request);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'SOA_DOCUMENT_REQUEST',
					'description' => 'created new statement of account document request'
				];

				$this->addActionToActivities($action);

				$this->data['data-changes-flag'] = true;
				$this->data['flash-success-message'] = 'Request has been submitted';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['requests-data'] = $this->getStudentRequestRecords();
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);
		$this->date['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);

		$this->view('soa-and-order-of-payment/index/index', $this->data);
	}

	public function edit() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['requests-data'] = [];
		$this->data['student-details'] = $this->getStudentDetails();
		$this->data['request-availability'] = [];
		$this->data['request-frequency'] = [];
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'request-id' => trim($post['request-id']),
				'purpose' => trim($post['purpose']),
				'other-purpose' => trim($post['other-purpose'])
			];

			$result = $this->Request->update($request);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'SOA_DOCUMENT_REQUEST',
					'description' => 'updated statement of account document request'
				];

				$this->addActionToActivities($action);

				$this->data['data-changes-flag'] = true;
				$this->data['flash-success-message'] = 'Request has been updated';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['requests-data'] = $this->getStudentRequestRecords();
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);

		$this->view('soa-and-order-of-payment/index/index', $this->data);
	}

	public function cancel($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['requests-data'] = [];
		$this->data['student-details'] = $this->getStudentDetails();
		$this->data['request-availability'] = [];
		$this->data['request-frequency'] = [];

		$drop = $this->Request->drop($id);

		if($drop) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'SOA_DOCUMENT_REQUEST',
				'description' => 'cancelled a statement of account document request'
			];

			$this->addActionToActivities($action);

			$this->data['data-changes-flag'] = true;
			$this->data['flash-success-message'] = 'Request has been cancelled';
		} else {
			$this->data['flash-error-message'] = 'Some error occurred while cancelling request, please try again';
		}

		$this->data['requests-data'] = $this->getStudentRequestRecords();
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);

		$this->view('soa-and-order-of-payment/index/index', $this->data);
	}

	public function update($request) {
		$result = $this->Request->updateStatusAndRemarks($request);
		
		if(empty($result)) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'SOA_DOCUMENT_REQUEST',
				'description' => 'updated a statement of account document request'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Request has been updated';
			
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
			$this->data['flash-error-message'] = 'Some error occurred while updating request, please try again';
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
		
			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'SOA_DOCUMENT_REQUEST',
					'description' => 'updated a multiple statement of account document request'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Requests has been updated';
				
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
				$this->data['flash-success-message'] = '';
				$this->data['flash-error-message'] = 'Some error occurred while updating requests, please try again';
				break;
			}
		}
	}

	public function delete($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-200';

		$drop = $this->Request->drop($id);

		if($drop) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'SOA_DOCUMENT_REQUEST',
				'description' => 'deleted a statement of account document request'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Request has been deleted';
		} else {
			$this->data['flash-error-message'] = 'Some error occurred while deleting request, please try again';
		}

		$this->data['requests-data'] = $this->getAllRecords();

		$this->view('soa-and-order-of-payment/records/index', $this->data);
	}

	public function multiple_delete() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-200';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$ids = explode(',', trim($post['request-ids-to-drop']));

			foreach($ids as $id) {
				$drop = $this->Request->drop($id);
				if($drop) {
					$action = [
						'actor' => $_SESSION['id'],
						'action' => 'SOA_DOCUMENT_REQUEST',
						'description' => 'deleted multiple statement of account document request'
					];

					$this->addActionToActivities($action);

					$this->data['flash-success-message'] = 'Requests has been deleted';
				} else {
					$this->data['flash-success-message'] = '';
					$this->data['flash-error-message'] = 'Some error occurred while deleting requests, please try again';
					break;
				}
			}
		}

		$this->data['requests-data'] = $this->getAllRecords();
		
		$this->view('soa-and-order-of-payment/records/index', $this->data);
	}

	private function setRequestData($page) {
		switch($page) {
			case 'pending': return $this->getAllPendingRequest();
			case 'accepted': return $this->getAllAcceptedRequest();
			case 'in-process': return $this->getAllInProcessRequest();
			case 'for-claiming': return $this->getAllForClaimingRequest();
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

	private function getAllPendingRequest() {
		$result = $this->Request->findAllPendingRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function getAllAcceptedRequest() {
		$result = $this->Request->findAllAcceptedRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function getAllInProcessRequest() {
		$result = $this->Request->findAllInProcessRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function getAllForClaimingRequest() {
		$result = $this->Request->findAllForClaimingRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function getStudentRequestRecords() {
		$result = $this->Request->findAllRequestByStudentId($_SESSION['id']);

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

	private function getRequestFrequencyOfFinance() {
		$freq = $this->RequestedDocument->getRequestFrequencyOfFinance();

		if(is_object($freq)) return $freq;

		return false;
	}

	private function getRequestAvailability($id) {
		$freq = $this->Request->getRequestAvailability($id);

		if(is_object($freq)) return $freq;

		return [];
	}
}

?>