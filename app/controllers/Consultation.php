<?php

class Consultation extends Controller {
	public function __construct() {
		$this->Request = $this->model('Consultations');
		$this->Student = $this->model('Students');
		$this->Professor = $this->model('Professors');
		$this->Conversation = $this->model('Messages');
		$this->Subject = $this->model('SubjectCodes');
		$this->Admin = $this->model('Admins');
		$this->User = $this->model('Users');
		$this->Activity = $this->model('Activities');
		$this->Schedule = $this->model('Schedules');

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
			'document-declined-nav-active' => '',
			'document-completed-nav-active' => '',
			'document-cancelled-nav-active' => '',
			'moral-nav-active' => '',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-resolved-nav-active' => '',
			'consultation-declined-nav-active' => '',
			'consultation-cancelled-nav-active' => '',
			'consultation-records-nav-active' => '',
			'consultation-schedule-nav-active' => '',
			'record-nav-active' => '',
			'student-nav-active' => '',
			'alumni-nav-active' => '',
			'professor-nav-active' => '',
			'admin-nav-active' => '',
			'setting-nav-active' => '',
			'request-data' => [],
			'data-changes-flag' => false
		];
	}	

	public function request() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-600';
		$this->data['pending-requests-data'] = $this->getAllPendingRequest();

		$this->view('consultation/request/index', $this->data);
	}

	public function active() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-active-nav-active'] = 'bg-slate-600';
		$this->data['active-requests-data'] = $this->getAllActiveRequest();

		$this->view('consultation/active/index', $this->data);
	}

	public function resolved() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-resolved-nav-active'] = 'bg-slate-600';
		$this->data['resolved-requests-data'] = $this->getAllResolvedRequest();

		$this->view('consultation/resolved/index', $this->data);
	}

	public function declined() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-declined-nav-active'] = 'bg-slate-600';
		$this->data['declined-requests-data'] = $this->getAllDeclinedRequest();

		$this->view('consultation/declined/index', $this->data);
	}

	public function cancelled() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-cancelled-nav-active'] = 'bg-slate-600';
		$this->data['cancelled-requests-data'] = $this->getAllCancelledRequest();

		$this->view('consultation/cancelled/index', $this->data);
	}

	public function records() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-records-nav-active'] = 'bg-slate-600';
		$this->data['requests-data'] = $this->getAllRecords();
		//$this->data['consultation-frequency'] = $this->getConsultationFrequency($_SESSION['id']);
		$this->data['annual-consultation-status-frequency'] = $this->getAnnualConsultationStatusFrequency($_SESSION['id']);
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		//$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($_SESSION['id']);
		$this->data['activity'] = $this->getAllActivities();

		$this->view('consultation/records/index', $this->data);
	}

	public function schedule() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-schedule-nav-active'] = 'bg-slate-600';
		
		$advisor = '';
		if($_SESSION['type'] == 'professor') $advisor = $_SESSION['id'];
		if($_SESSION['type'] == 'guidance') $advisor = 'guidance';
		if($_SESSION['type'] == 'clinic') $advisor = 'clinic';

		$this->data['schedule'] = $this->getScheduleByAdvisor($advisor);
		$this->view('consultation/schedule/index', $this->data);
	}

	private function getScheduleByAdvisor($id) {
		$sched = $this->Schedule->findScheduleByAdvisor($id);
		
		if(is_object($sched)) return $sched;

		return [];
	}

	private function getAllActivities() {
		$details = [
			'actor' => $_SESSION['id'],
			'action' => 'CONSULTATION'
		];

		$activities = $this->Activity->findAllActivitiesByActorAndAction($details);

		if(is_array($activities)) return $activities;

		return [];
	}

	private function getAllRecords() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllRecordsByStudentId($_SESSION['id']);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$result = $this->Request->findAllRecordsOfStudents();
		} else {
			$result = $this->Request->findAllRecordsByAdviserId($_SESSION['id']);
		}

		if(is_array($result)) return $result;

		return [];
	}

	public function show($page, $id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($page == 'active') {
			$this->data['consultation-active-nav-active'] = 'bg-slate-600';
		
		} else {
			$this->data['consultation-records-nav-active'] = 'bg-slate-600';
		}

		$this->data['page'] = $page;
		$this->data['id'] = $id;
		$this->data['request-data'] = $this->getRequestById($id);
		$this->data['messages'] = $this->getAllMessagesById($id);
		$this->data['adviser-profile-pic'] = $this->getUserProfilePicture($this->data['request-data']->adviser_id);
		$this->data['student-profile-pic'] = $this->getUserProfilePicture($this->data['request-data']->creator);

		$this->view('consultation/view/index', $this->data);
	}

	private function getUserProfilePicture($id) {
		$user = $this->User->findUSerById($id);

		if(is_object($user)) return $user->pic;

		return '';
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-600';
		
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
				'adviser-name' => $this->getProfessorName(trim($post['adviser-id'])),
				'schedule' => trim($post['schedule']),
				'start-time' => trim($post['start-time']),
				'mode' => trim($post['mode']),
				'document' => $this->uploadAndGetPathOfUploadedDocuments()
			];

			$this->data['request-data'] = $request;

			$result = $this->Request->add($request);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'CONSULTATION',
					'description' => 'added new consultation request'
				];

				$this->addActionToActivities($action);

				if($request['department'] != 'guidance' && $request['department'] != 'clinic') {

					$mail = [
						'email' => $this->getProfessorEmail($request['adviser-id']),
						'name' => $request['adviser-name'],
						'message' => 'I hope this message finds you well. I am writing to inform you that you have received a new request for online consultation from a student. Thank you!',
						'contact' => $this->getProfessorContact($request['adviser-id'])
						
					];
					
					$this->sendSMSAndEmailNotification($mail);
				}

				$this->data['data-changes-flag'] = true;
				$this->data['flash-success-message'] = 'Consultation has been submitted';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}
		$this->view('consultation/add/index', $this->data);
	}

	public function edit($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$problem = htmlspecialchars($_POST['problem']);

			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'id' => trim($post['request-id']),
				'purpose' => trim($post['purpose']),
				'problem' => trim($problem),
				'department' => trim($post['department']),
				'subject' => trim($post['subject']),
				'adviser-id' => trim($post['adviser-id']),
				'adviser-name' => $this->getProfessorName(trim($post['adviser-id'])),
				'schedule' => trim($post['schedule']),
				'mode' => trim($post['mode']),
				'start-time' => trim($post['start-time']),
				'existing-documents' => trim($post['existing-documents']),
				'new-document' => $this->uploadAndGetPathOfUploadedDocuments(),
				'document' => ''
			];
			
			if(!empty($request['existing-documents']) && !empty($request['new-document'])) $request['document'] = $request['existing-documents'].','.$request['new-document'];
			if(!empty($request['new-document']) && empty($request['existing-documents'])) $request['document'] = $request['new-document'];
			if(empty($request['new-document']) && !empty($request['existing-documents'])) $request['document'] = $request['existing-documents'];  

			$result = $this->Request->edit($request);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'CONSULTATION',
					'description' => 'updated a consultation request'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Consultation has been updated';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['request-data'] = $this->getRequestById($id);

		$this->view('consultation/edit/index', $this->data);
	}

	public function update_link($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-active-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$details = [
				'id' => trim($post['request-id']),
				'link' => trim($post['link'])
			];

			$result = $this->Request->updateLink($details);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'CONSULTATION',
					'description' => 'updated a gmeet link of consultation'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Gmeet link has been updated';
			}

			$this->data['flash-error-message'] = $result;
		}

		$this->show('active', $id);	
	}

	public function update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'request-id' => trim($post['request-id']),
				'student-id' => trim($post['student-id']),
				'status' => trim($post['status']),
				'remarks' => trim($post['remarks']),
				'adviser-id' => trim($post['adviser-id']),
				'adviser-name' => $this->getAdminName(trim($post['adviser-id']))
			];

			if($_SESSION['type'] == 'professor') {
				$result = $this->Request->updateByProfessor($request);
			} else {
				$result = $this->Request->updateByAdmin($request);				
			}
			
			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'CONSULTATION',
					'description' => 'updated a consultation'
				];

				$this->addActionToActivities($action);
				
				$this->setupEmailThenSend($request);
				
				$this->data['flash-success-message'] = 'Consultation has been updated.';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['pending-requests-data'] = $this->getAllPendingRequest();

		$this->view('consultation/request/index', $this->data);
	}

	private function setupEmailThenSend($request) {

		$student = $this->getStudentDetails($request['student-id']);

		if($request['status'] == 'active') {
			$message = 'I hope this message finds you well. I am pleased to inform you that your request for an online consultation has been approved. We look forward to providing you with valuable insights and solutions to your queries.';
		} else if($request['status'] == 'cancel') {
			$message = 'I hope this message finds you well. I am writing to inform you that your online consultation has been cancelled. We apologize for any inconvenience this may cause and we appreciate your understanding.';
		} else if($request['status'] == 'resolved') {
			$message = 'I hope this message finds you well. I am writing to inform you that your online consultation has been completed. It was a pleasure serving you and we hope that we were able to provide you with valuable insights and solutions to your queries.';
		} else {
			$message = 'I hope this message finds you well. I am writing to inform you that your request for an online consultation has been declined. We appreciate your interest in our services and apologize for any inconvenience this may cause.';
		}

		$mail = [
			'email' => $student->email,
			'name' => $student->fname.' '.$student->lname,
			'message' => $message,
			'contact' => $student->contact
		];

		$this->sendSMSAndEmailNotification($mail);

	} 

	public function multiple_update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-request-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$request = [
				'student-ids' => trim($post['student-ids']),
				'request-ids' => trim($post['request-ids']),
				'status' => trim($post['multiple-update-status']),
				'remarks' => trim($post['multiple-update-remarks']),
				'adviser-id' => trim($post['adviser-id']),
				'adviser-name' => $this->getAdminName(trim($post['adviser-id']))
			];

			$requestIDs =  explode(',', trim($request['request-ids']));
			$studentIDs = explode(',', trim($request['student-ids']));

			foreach($requestIDs as $key => $id) {

				$request = [
					'adviser-id' => trim($request['adviser-id']),
					'adviser-name' => trim($request['adviser-name']),
					'student-id' => $studentIDs[$key],
					'request-id' => $id,
					'status' => trim($request['status']),
					'remarks' => trim($request['remarks']),
				];

				$result = $this->Request->update($request);
			
					if(empty($result)) {
						$action = [
						'actor' => $_SESSION['id'],
						'action' => 'CONSULTATION',
						'description' => 'updated a multiple consultation'
					];

					$this->addActionToActivities($action);

					$this->setupEmailThenSend($request);

					$this->data['flash-success-message'] = 'Consultations has been updated';
					//$this->sendSMSAndEMailNotification($request);	
				} else {
					$this->data['flash-success-message'] = '';
					$this->data['flash-error-message'] = 'Some error occurs while updating consultations, please try again';
					break;
				}
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
				
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'CONSULTATION',
					'description' => $request['status'].' a consultation'
				];

				$this->addActionToActivities($action);

				$this->setupEmailThenSend($request);

				echo json_encode('Consultation has been updated.');
				return;
			} 
		}

		echo json_encode('Something went wrong, please try again');
	}

	public function cancel($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-records-nav-active'] = 'bg-slate-600';

		$result = $this->Request->cancel($id);

		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'CONSULTATION',
				'description' => 'cancelled a consultation request'
			];

			$this->addActionToActivities($action);

			$this->data['data-changes-flag'] = true;
			$this->data['flash-success-message'] = 'Consultation has been cancelled';
		} else {
			$this->data['flash-error-message'] = 'Consultation failed to cancel due to some error';
		}

		$this->data['requests-data'] = $this->getAllRecords();

		$this->view('consultation/records/index', $this->data);
	}

	public function delete($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-records-nav-active'] = 'bg-slate-600';

		$result = $this->Request->drop($id);

		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'CONSULTATION',
				'description' => 'deleted a consultation'
			];

			$this->addActionToActivities($action);

			$this->data['data-changes-flag'] = true;
			$this->data['flash-success-message'] = 'Consultation has been deleted';
		} else {
			$this->data['flash-error-message'] = 'Some error occurs while deleting consultation, please try again';
		}

		$this->data['requests-data'] = $this->getAllRecords();
		$this->data['consultation-frequency'] = $this->getConsultationFrequency($_SESSION['id']);
		$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($_SESSION['id']);
		$this->data['annual-consultation-status-frequency'] = $this->getAnnualConsultationStatusFrequency($_SESSION['id']);
		$this->data['history'] = $this->getHistory($_SESSION['id']);

		$this->view('consultation/records/index', $this->data);
	}

	public function multiple_delete() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-records-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$ids = explode(',', trim($post['request-ids-to-drop']));

			foreach($ids as $id) {
				$drop = $this->Request->drop($id);
				if($drop) {
					$action = [
						'actor' => $_SESSION['id'],
						'action' => 'CONSULTATION',
						'description' => 'deleted a multiple consultation'
					];

					$this->addActionToActivities($action);

					$this->data['flash-success-message'] = 'Consultations has been deleted';
				} else {
					$this->data['flash-success-message'] = '';
					$this->data['flash-error-message'] = 'Some error occurs while deleting consultations, please try again';
					break;
				}
			}
		}

		$this->data['requests-data'] = $this->getAllRecords();
		$this->data['consultation-frequency'] = $this->getConsultationFrequency($_SESSION['id']);
		$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($_SESSION['id']);
		$this->data['annual-consultation-status-frequency'] = $this->getAnnualConsultationStatusFrequency($_SESSION['id']);
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		
		$this->view('consultation/records/index', $this->data);
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

	public function reschedule($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-active-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$details = [
				'request-id' => trim($post['request-id']),
				'schedule' => trim($post['schedule']),
				'start-time' => trim($post['start-time'])
			];

			$result = $this->Request->reschedule($details);

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'CONSULTATION',
					'description' => 'rescheduled a consultation'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Consultation has been rescheduled';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->show('active', $id);
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
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'CONSULTATION',
					'description' => 'shared a document'
				];

				$this->addActionToActivities($action);

				echo json_encode('File/s uploaded');
				return;
			}
		}

		echo json_encode('File/s failed to upload, please try again.');
	}

	public function get_all_active_consultation_of_advisor() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$advisor = trim($post['advisor']);
			
			if($advisor=='guidance' || $advisor=='clinic') {
				$result = $this->Request->findAllActiveConsultationOfDepartment($advisor);
			} else {
				$result = $this->Request->findAllActiveConsultationOfAdvisor($advisor);
			}

			if(is_array($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);
	}

	public function get_consultation_acceptance_by_advisor() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$advisor = trim($post['advisor']);
			
			$result = $this->Request->findConsultationAcceptanceByAdvisor($advisor);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);
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
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'CONSULTATION',
					'description' => 'deleted a shared document'
				];

				$this->addActionToActivities($action);

				echo json_encode('File deleted');
				return;
			} 
		}

		echo json_encode('File failed to delete, please try again');
	}

	public function start() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-schedule-nav-active'] = 'bg-slate-600';

		$advisor = '';

		if($_SESSION['type'] == 'professor') $advisor = $_SESSION['id'];
		if($_SESSION['type'] == 'guidance') $advisor = 'guidance';
		if($_SESSION['type'] == 'clinic') $advisor = 'clinic';

		$result = $this->Request->start($advisor);

		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'CONSULTATION',
				'description' => 'opened consultation'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'You are open now for consultations';
		} else {
			$this->data['flash-error-message'] = 'Some error occured while updating status, please try again';
		}

		$this->data['schedule'] = $this->getScheduleByAdvisor($advisor);

		$this->view('consultation/schedule/index', $this->data);
	}
	
	public function stop() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-schedule-nav-active'] = 'bg-slate-600';

		$advisor = '';

		if($_SESSION['type'] == 'professor') $advisor = $_SESSION['id'];
		if($_SESSION['type'] == 'guidance') $advisor = 'guidance';
		if($_SESSION['type'] == 'clinic') $advisor = 'clinic';

		$result = $this->Request->stop($advisor);

		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'CONSULTATION',
				'description' => 'closed consultation'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'You are closed now for consultations';
		} else {
			$this->data['flash-error-message'] = 'Some error occured while updating status, please try again';
		}

		$this->data['schedule'] = $this->getScheduleByAdvisor($advisor);

		$this->view('consultation/schedule/index', $this->data);
	}

	public function get_consultation_acceptance_status() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$advisor = trim($post['advisor']);

			$result = $this->Request->findConsultationAcceptanceStatus($advisor);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);
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

	public function get_guidance_request_count() {
		$result = $this->Request->getGuidanceRequestsCount();
	
		if(is_object($result)) {
			echo json_encode($result);
			return;
		}

		echo json_encode('');
	}

	public function get_clinic_request_count() {
		$result = $this->Request->getClinicRequestsCount();
	
		if(is_object($result)) {
			echo json_encode($result);
			return;
		}

		echo json_encode('');
	}

	public function get_professor_request_count() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$id = trim($post['id']);	
			
			$result = $this->Request->getProfessorRequestsCount($id);
		
			if(is_object($result)) {
				echo json_encode($result);
				return;
			}

			echo json_encode('');
		}
	}

	public function check_all_consultation_if_has_unseen_messages() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$id = trim($post['id']);
			$role = trim($post['role']);
			
			if($role == 'student') {
				$result = $this->Request->findAllActiveRequestByStudentId($id);
			} else {
				$result = $this->Request->findAllActiveRequestByAdviserId($id);
			}

			if(is_array($result)) {
				foreach($result as $key => $row) {

					$count = $this->Conversation->count_unseen_of_specific_receiver($row->id, $id);

					if(is_object($count) && $count->count > 0) {
						echo json_encode(true);
						return;
					}
				}
			}
		}	
		echo json_encode(false);
	}

	public function check_consultation_if_has_unseen_messages() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$consultation = trim($post['consultation']);
			$user = trim($post['user']);

			$count = $this->Conversation->count_unseen_of_specific_receiver($consultation, $user);

			if(is_object($count) && $count->count > 0) {
				echo json_encode(true);
				return;
			}
		
			
		}	

		echo json_encode(false);
	}

	private function getStudentDetails($id) {
		$result = $this->Student->findStudentById($id);

		if(is_object($result)) return $result;

		return [];
	}

	private function sendSMSAndEmailNotification($info) {
		$email = [
			'recipient' => $info['email'],
			'name' => $info['name'],
			'message' => $info['message'],
			'link' => URLROOT.'/consultation/request'
		];

		$contentOfEmail = formatEmailForConsultation($email);

		$email['message'] = $contentOfEmail;

		//sendSMS($info['contact'], $email['message']);
		sendEmail($email);
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

	// public function schedule() {
	// 	if($_SERVER['REQUEST_METHOD'] == 'POST') {
	// 		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	// 		$request = [
	// 			'id' => trim($post['request-id']),
	// 			'sched' => trim($post['sched']),
	// 			'link' => trim($post['link'])
	// 		];

	// 		$update = $this->Request->updateSchedule($request);
		
	// 		if($update) {
	// 			echo json_encode('Schedule has been updated');
	// 			return;
	// 		}
	// 	}

	// 	echo json_encode('Something goes wrong, please try again.');
	// }

	private function getUpcomingConsultation($id) {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findUpcomingConsultationOfStudent($id);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$result = $this->Request->findUpcomingConsultationForSystemAdmin();
		} else {
			$result = $this->Request->findUpcomingConsultationOfAdviser($id);
		}

		if(is_array($result)) return $result;

		return [];
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}

	private function getProfessorName($id) {
		$professor = $this->Professor->findProfessorById($id);

		if(is_object($professor)) {
			$lastname = $professor->lname;
			$firstname = $professor->fname;

			return $firstname.' '.$lastname;
		}

		return '';
	}

	private function getProfessorEmail($id) {
		$professor = $this->Professor->findProfessorById($id);

		if(is_object($professor)) return $professor->email;		

		return '';
	}

	private function getProfessorContact($id) {
		$professor = $this->Professor->findProfessorById($id);

		if(is_object($professor)) return $professor->contact;		

		return '';
	}

	private function getAdminName($id) {
		$admin = $this->Admin->findAdminById($id);

		if(is_object($admin)) {
			$lastname = $admin->lname;
			$firstname = $admin->fname;

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

	private function getAdminDetails($id) {
		$admin = $this->Admin->findAdminById($id);

		if(is_object($admin)) return $admin;

		return [];
	}

	private function getProfessorDetails($id) {
		$professor = $this->Professor->findProfessorById($id);

		if(is_object($professor)) return $professor;
		
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
		} elseif($_SESSION['type'] == 'guidance') {
			$result = $this->Request->findAllPendingRequestOfGuidance();
		} else {
			$result = $this->Request->findAllPendingRequestOfClinic();
		}
		
		if(is_array($result)) {
			return $result;
		}

		return [];
	}

	private function getAllActiveRequest() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllActiveRequestByStudentId($_SESSION['id']);	
		} else {
			$result = $this->Request->findAllActiveRequestByAdviserId($_SESSION['id']);
		}
		
		if(is_array($result)) {
			return $result;
		}

		return [];
	}

	private function getAllResolvedRequest() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllResolvedRequestByStudentId($_SESSION['id']);	
		} else {
			$result = $this->Request->findAllResolvedRequestByAdviserId($_SESSION['id']);
		}
		
		if(is_array($result)) {
			return $result;
		}

		return [];
	}

	private function getAllDeclinedRequest() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllDeclinedRequestByStudentId($_SESSION['id']);	
		} else {
			$result = $this->Request->findAllDeclinedRequestByAdviserId($_SESSION['id']);
		}
		
		if(is_array($result)) {
			return $result;
		}

		return [];
	}

	private function getAllCancelledRequest() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllCancelledRequestByStudentId($_SESSION['id']);	
		} else {
			$result = $this->Request->findAllCancelledRequestByAdviserId($_SESSION['id']);
		}
		
		if(is_array($result)) {
			return $result;
		}

		return [];
	}

	private function getConsultationFrequency($id) {
		if($_SESSION['type'] == 'student') {
			$freq = $this->Request->getConsultationFrequencyOfStudent($id);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$freq = $this->Request->getConsultationFrequencyForSystemAdmin();
		} else {
			$freq = $this->Request->getConsultationFrequencyOfAdviser($id);
		}

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getAnnualConsultationStatusFrequency($id) {
		if($_SESSION['type'] == 'student') {
			$freq = $this->Request->getAnnualConsultationStatusFrequencyOfStudent($id);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$freq = $this->Request->getAnnualConsultationStatusFrequencyOfSysAdmin();
		} else {
			$freq = $this->Request->getAnnualConsultationStatusFrequencyOfAdviser($id);
		}

		if(is_array($freq)) return $freq;

		return [];
	}

	private function getHistory($id) {
		if($_SESSION['type'] == 'student') {
			$freq = $this->Request->getHistoryOfStudent($id);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$freq = $this->Request->getHistoryOfSysAdmin();
		} else {
			$freq = $this->Request->getHistoryOfAdviser($id);
		}

		if(is_array($freq)) return $freq;

		return [];
	}
}


?>