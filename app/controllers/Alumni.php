<?php

class Alumni extends Controller {
	public function __construct() {
		$this->Alumni = $this->model('Alumnis');
		$this->Request = $this->model('AcademicDocumentRequests');
		$this->Activity = $this->model('Activities');

		$this->data = [
			'flash-error-message' => '',
			'flash-success-message' => ''
		];
	}

	public function index() {
		$this->view('alumni/index/index', $this->data);
	}

	public function add() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'id' => trim($post['id']),
				'email' => trim($post['email']),
				'lname' => ucwords(trim($post['lastname'])),
				'fname' => ucwords(trim($post['firstname'])),
				'mname' => ucwords(trim($post['middlename'])),
				'gender' => trim($post['gender']),
				'contact' => trim($post['contact']),
				'location' => trim($post['location']), 
				'address' => trim($post['address']),
				'course' => strtoupper(trim($post['course'])),
				'section' => strtoupper(trim($post['section'])),
				'year-graduated' => trim($post['year-graduated']),
				'identification' => $this->uploadAlumniIdentification()
			];

			$result = $this->Alumni->add($details);

			if(empty($result)) {
				echo json_encode('');
				return;
			}

			echo json_encode($result);
			return;
		}

		echo json_encode('Something went wrong, please try again');
	}

	public function profile() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST,  FILTER_SANITIZE_STRING);

			$details = [
				'id' => trim($post['id']),
				'email' => trim($post['email']),
				'lname' => ucwords(trim($post['lname'])),
				'fname' => ucwords(trim($post['fname'])),
				'mname' => ucwords(trim($post['mname'])),
				'gender' => trim($post['gender']),
				'contact' => trim($post['contact']),
				'location' => trim($post['location']), 
				'address' => trim($post['address']),
				'course' => strtoupper(trim($post['course'])),
				'section' => strtoupper(trim($post['section'])),
				'year-graduated' => trim($post['year-graduated']),
				'identification' => $this->uploadAlumniIdentification()
			];

			$result = $this->Alumni->update($details);

			if(empty($result)) {
				$action = [
					'actor' => $details['id'],
					'action' => 'ALUMNI',
					'description' => 'updated profile'
				];

				$this->addActionToActivities($action);
				echo json_encode('');
				return;
			} else {
				echo json_encode($result);
				return;
			}
		}

		$this->view('alumni/profile/index', $this->data);
	}

	public function new_request() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'student-id' => trim($post['id']),
				'is-tor-included' => (trim($post['requested-document'])=='TOR')? 1 : 0,
				'tor-last-academic-year-attended' => trim($post['tor-last-academic-year-attended']),
				'is-diploma-included' => (trim($post['requested-document'])=='Diploma')? 1 : 0,
				'diploma-year-graduated' => trim($post['diploma-year-graduated']),
				'is-honorable-dismissal-included' => (trim($post['requested-document']) == 'Honorable Dismissal')? 1 : 0,
				'purpose-of-request' => trim($post['purpose-of-request']),
				'is-RA11261-beneficiary' => trim($post['is-RA11261-beneficiary']),
				'barangay-certificate' => $this->uploadAngGetPathOfBarangayCertificateDoc(),
				'oath-of-undertaking' => $this->uploadAndGetPathOfOathDoc()
			];

			$result = $this->Request->addRequestOfAlumni($request);

			if(empty($result)) {
				$action = [
					'actor' => $request['student-id'],
					'action' => 'ACADEMIC_DOCUMENT_REQUEST',
					'description' => 'added new academic document request'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Request has been submitted';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->view('alumni/request/index', $this->data);
	}

	public function edit_request() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'request-id' => trim($post['request-id']),
				'student-id' => trim($post['student-id']),
				'is-tor-included' => (trim($post['requested-document'])=='TOR')? 1 : 0,
				'tor-last-academic-year-attended' => trim($post['tor-last-academic-year-attended']),
				'is-diploma-included' => (trim($post['requested-document'])=='Diploma')? 1 : 0,
				'diploma-year-graduated' => trim($post['diploma-year-graduated']),
				'is-honorable-dismissal-included' => (trim($post['requested-document']) == 'Honorable Dismissal')? 1 : 0,
				'purpose-of-request' => trim($post['purpose-of-request']),
				'is-RA11261-beneficiary' => trim($post['is-RA11261-beneficiary']),
				'barangay-certificate' => $this->uploadAngGetPathOfBarangayCertificateDoc(),
				'oath-of-undertaking' => $this->uploadAndGetPathOfOathDoc()
			];

			$result = $this->Request->updateRequestOfAlumni($request);

			if(empty($result)) {
				$action = [
					'actor' => $request['student-id'],
					'action' => 'ACADEMIC_DOCUMENT_REQUEST',
					'description' => 'updated academic document request'
				];

				$this->addActionToActivities($action);

				echo json_encode('');
				return;
			} 

			echo json_encode($result);
			return;
		}

		echo json_encode('Some error occured while updating request, please try again');
	}

	public function cancel_request() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$id = trim($post['id']);

			$result = $this->Request->drop($id);

			if($result) {
				$action = [
					'actor' => $id,
					'action' => 'ACADEMIC_DOCUMENT_REQUEST',
					'description' => 'cancelled a academic document request'
				];

				$this->addActionToActivities($action);

				echo json_encode('');
				return;
			}

			echo json_encode('Some error occured while cancelling request, please try again');
		}
	}
	
	public function records($id) {
		$this->data['requests-data'] = $this->getAlumniRecords($id);
		$this->view('alumni/records/index', $this->data);
	}

	public function get_alumni_by_id() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$id = trim($post['id']);

			$result = $this->Alumni->findAlumniById($id);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}

			echo json_encode(false);
		}
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}

	private function getAlumniRecords($id) {
		$result = $this->Request->findAllRequestByStudentId(trim($id));

		if(is_array($result)) return $result;

		return [];
	}

	private function uploadAlumniIdentification() {
		$path = '';
		if(isset($_FILES['identification'])) $path = uploadDocument($_FILES['identification']);
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

	public function get_request_frequency($id) {
		$freq = $this->Request->getRequestFrequencyOfAlumni($id);

		if(is_object($freq)) {
			echo json_encode($freq);
			return;
		}  

		echo json_encode([]);	
	}

	public function get_request_availability($id) {
		$freq = $this->Request->getRequestAvailabilityOfAlumni($id);

		if(is_object($freq)) {
			echo json_encode($freq);
			return;
		}

		echo json_encode([]);
	}

}

?>