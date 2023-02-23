<?php

class Consultation extends Controller {
	public function __construct() {
		$this->Request = $this->model('Consultations');
		$this->Student = $this->model('Students');
		$this->Professor = $this->model('Professors');
		$this->Conversation = $this->model('Messages');
		$this->Subject = $this->model('SubjectCodes');

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
		$this->data['messages'] = $this->getAllMessagesById($id);  

		$this->view('consultation/view/index', $this->data);
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-200';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'creator' => trim($post['student-id']),
				'creator-name' => $this->getStudentName(trim($post['student-id'])),
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
				$this->data['flash-success-message'] = 'Consultation has been submitted';
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
				$this->data['flash-success-message'] = 'Consultation has been updated';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['request-data'] = $this->getRequestById($id);

		$this->view('consultation/edit/index', $this->data);
	}

	public function update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-200';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'request-id' => trim($post['request-id']),
				'student-id' => trim($post['student-id']),
				'status' => trim($post['status']),
				'remarks' => trim($post['remarks'])
			];
			
			$result = $this->Request->update($request);

			if(empty($result)) {
				$this->data['flash-success-message'] = 'Consultation has been updated.';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['pending-requests-data'] = $this->getAllPendingRequest();

		$this->view('consultation/request/index', $this->data);
	}

	public function resolve() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'request-id' => trim($post['request-id']),
				'student-id' => trim($post['student-id']),
				'status' => trim($post['status']),
				'remarks' => trim($post['remarks'])
			];

			$result = $this->Request->update($request);

			if(empty($result)) {
				echo json_encode('Consultation has been updated.');
				return;
			} 
		}

		echo json_encode('Something went wrong, please try again');
	}

	public function drop($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-200';

		$result = $this->Request->drop($id);

		if($result) {
			$this->data['flash-success-message'] = 'Consultation has been cancelled';
		} else {
			$this->data['flash-error-message'] = 'Consultation failed to cancel due to some error';
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

	public function upload() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'id' => trim($post['request-id']),
				'type' => trim($post['type']),
				'existing-documents' => trim($post['existing-files']),
				'new-documents' => $this->uploadAndGetPathOfUploadedDocuments()
			];

			$request['documents'] = $this->combineExistingAndNewDocuments($request['existing-documents'], $request['new-documents']);

			$areNewDocsExisting = $this->checkIfUPloadedDocumentsExist($request['existing-documents'], $request['new-documents']); 
			
			if($areNewDocsExisting) {
				echo json_encode('File/s already exists');
				return;
			}

			if($request['type'] == 'adviser') {
				$result = $this->Request->uploadDocumentsFromAdviser($request);
			} else {
				$result = $this->Request->uploadDocumentsFromStudent($request);
			}
			
			if($result) {
				echo json_encode('File/s uploaded');
				return;
			}
		}

		echo json_encode('File/s failed to upload, please try again.');
	}

	public function delete_document() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'id' => trim($post['id']),
				'type' => trim($post['type']),
				'existing-documents' => trim($post['existing-files']),
				'file-to-delete' => trim($post['file-to-delete'])
			];

			if($request['type'] == 'student') $result = $this->Request->deleteDocumentFromStudent($request);
			else $result = $this->Request->deleteDocumentFromAdviser($request); 

			if($result) {
				echo json_encode('File deleted');
				return;
			} 
		}

		echo json_encode('File failed to delete, please try again');
	}

	public function get_subject_codes_by_department() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$department = trim($post['department']);

			$result = $this->Subject->findSubjectsByDepartment($department);

			if(is_array($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode('Failed to get related subjects, please try again. If error persist contact the Admin');
	}

	public function get_professors_by_department() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$department = trim($post['department']);

			$result = $this->Professor->findProfessorsByDepartment($department);

			if(is_array($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode('Failed to get corresponding professors, please try again. If error persist contact the Admin');
	}

	private function combineExistingAndNewDocuments($existing, $new) {
		if(!empty($existing) && !empty($new)) {
			return $existing.','.$new;
		} else {
			return $new;
		}
	}

	private function checkIfUPloadedDocumentsExist($existing, $new) {
		if(!empty($existing) && !empty($new)) {
			$new = explode(',', $new);

			foreach($new as $doc) {
				if(str_contains($existing, $doc)) return true;				
			}
		}

		return false;
	}

	public function schedule() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'id' => trim($post['request-id']),
				'sched' => trim($post['sched']),
				'link' => trim($post['link'])
			];

			$update = $this->Request->updateSchedule($request);
		
			if($update) {
				echo json_encode('Schedule has been updated');
				return;
			}
		}

		echo json_encode('Something goes wrong, please try again.');
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

	private function getStudentName($id) {
		$student = $this->Student->findStudentById($id);

		if(is_object($student)) {
			$lastname = $student->lname;
			$firstname = $student->fname;

			return $firstname.' '.$lastname;
		}

		return '';
	}

	private function getCreatorName($id) {
		$student = $this->Student->findStudentById($id);

		if(is_object($student)) {
			$lastname = $student->lname;
			$firstname = $student->fname;

			return $firstname.' '.$lastname;
		}

		return '';
	}


	private function uploadAndGetPathOfUploadedDocuments() {
		if(!isset($_FILES['document']) ) return '';
		$path = uploadMultipleDocument($_FILES['document']);
		
		return $path;
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

	private function getAllMessagesById($id) {
		$result = $this->Conversation->findAllMessagesById($id);
		if(is_array($result)) return $result;
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
		} elseif($_SESSION['type'] == 'professor') {
			$result = $this->Request->findAllPendingRequestByProfessorId($_SESSION['id']);
		} else {
			$result = $this->Request->findAllPendingRequestOfGuidance();
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