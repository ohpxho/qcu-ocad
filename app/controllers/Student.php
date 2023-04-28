<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Student extends Controller {
	public function __construct() {
		$this->Student = $this->model('Students');
		$this->RequestedDocument = $this->model('RequestedDocuments');
		$this->Consultation = $this->model('Consultations');
		$this->User = $this->model('Users');
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
			'consultation-schedule-nav-active' => '',
			'record-nav-active' => '',
			'student-nav-active' => '',
			'alumni-nav-active' => '',
			'professor-nav-active' => '',
			'admin-nav-active' => '',
			'audit-trail-nav-active' => '',
			'setting-nav-active' => '',
		];
	}

	public function login() {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');

		$this->data['credentials'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$credentials = [
				'id' => trim($post['id']),
				'pass' => trim($post['password'])
			];

			$this->data['credentials'] = $credentials;

			if($this->isLoginDetailsValid($credentials)) {
				$user = $this->User->loginStudent($credentials);

				if(is_object($user)) {
					if($user->status == 'for review') {
						$this->data['flash-error-message'] = 'Your account is awaiting approval';
					} else if($user->status == 'blocked') {
						$this->data['flash-error-message'] = 'Your account is blocked';
					} else if($user->status == 'closed') {
						$this->data['flash-error-message'] = 'Your account is closed';
					} else if($user->status == 'declined') {
						header('location:'.URLROOT.'/student/declined/'.$user->id);
					} else {
						$this->createUserSession($user);	
						header('location:'.URLROOT.'/user/dashboard');
					} 
				} else {
					$this->data['flash-error-message'] = 'Incorrect ID/Email or Password';
				}
			} else {
				$this->data['flash-error-message'] = 'Invalid input, please try again';
			}
		}

		$this->view('student/login/index', $this->data);
	}

	public function history() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-600';

		$this->view('student/history/index', $this->data);
	}

	public function register() {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$details = [
				'id' => trim($post['id']),
				'email' => trim($post['email']),
				'pass' => password_hash(trim($post['pass']), PASSWORD_DEFAULT),
				'lname' => ucwords(strtolower(trim($post['lname']))),
				'fname' => ucwords(strtolower(trim($post['fname']))),
				'mname' => ucwords(strtolower(trim($post['mname']))),
				'gender' => trim($post['gender']),
				'contact' => trim($post['contact']),
				'location' => trim($post['location']),
				'address' => ucwords(strtolower(trim($post['address']))),
				'course' => strtoupper(trim($post['course'])),
				'year' => trim($post['year']),
				'section' => strtoupper(trim($post['section'])),
				'type' => trim($post['type']),
				'identification' => $this->uploadIdentification()
			];

			$result = $this->User->registerStudent($details);

			if($result) {
				$this->data['flash-success-message'] = 'Application has been submitted';
			} else {
				$this->data['flash-error-message'] = 'Some error occured while registration, please try again.';
			}
			
		}

		$this->view('student/register/index', $this->data);		
	}

	public function add() {
		$this->data['student-nav-active'] = 'bg-slate-600';
		$this->data['input-details'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'id' => trim($post['id']),
				'email' => trim($post['email']),
				'pass' => trim($post['pass']),
				'lname' => ucwords(strtolower(trim($post['lname']))),
				'fname' => ucwords(strtolower(trim($post['fname']))),
				'mname' => ucwords(strtolower(trim($post['mname']))),
				'gender' => trim($post['gender']),
				'contact' => trim($post['contact']),
				'location' => trim($post['location']),
				'address' => ucwords(strtolower(trim($post['address']))),
				'course' => strtoupper(trim($post['course'])),
				'year' => trim($post['year']),
				'section' => strtoupper(trim($post['section'])),
				'type-of-student' => trim($post['type-of-student']),
				'type' => trim($post['type']),
			];

			$this->data['input-details'] = $details;

			$account = $this->User->add($details);
			$personal = $this->Student->add($details);

			if(empty($account) && empty($personal)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'USER_ACCOUNT',
					'description' => 'added new student account'
				];

				$this->addActionToActivities($action);

				$this->sendSMSAndEmailNotification($details);

				$this->data['input-details'] = [];
				$this->data['flash-success-message'] = 'Added new student account';
			} else {
				$this->Student->delete($details['id']);
				$this->User->delete($details['id']);

				if(!empty($account)) $this->data['flash-error-message'] = $account;
				else $this->data['flash-error-message'] = $personal;
			}
		}

		$this->view('student/add/index', $this->data);
	}

	public function import() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($_FILES['excel-file']['name']) {
			    $fileName = $_FILES['excel-file']['tmp_name'];
			    $spreadsheet = new Spreadsheet();
			    $reader = new Xlsx();
	
			    try {
			    	$spreadsheet = $reader->load($fileName);
				} catch(PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
					$this->data['flash-error-message'] = 'Error loading file: ' . $e->getMessage();
				}

				if(empty($this->data['flash-error-message'])) {

					$worksheet = $spreadsheet->getActiveSheet();
					$highestRow = $worksheet->getHighestDataRow();
					$highestColumn = $worksheet->getHighestDataColumn();

					if($highestColumn != 'M') {
						$this->data['flash-error-message'] =  'There is an error in excel file. Make sure that you follow the required format';	
					} else {
						for ($row = 3; $row <= $highestRow; $row++) {
						    $rowData = array();
						    for ($col = 'A'; $col <= $highestColumn; $col++) {
						        $value = $worksheet->getCell($col . $row)->getValue();
						        $rowData[] = $value;
						    }

						     $details = [
						    	'id' => trim($rowData[0]),
						    	'email' => trim($rowData[1]),
						    	'pass' => trim(generateRandomPassword()),
						    	'lname' => ucwords(strtolower(trim($rowData[2]))),
						    	'fname' => ucwords(strtolower(trim($rowData[3]))),
						    	'mname' => ucwords(strtolower(trim($rowData[4]))),
						    	'gender' => trim($rowData[5]),
						    	'contact' => trim($rowData[6]),
						    	'location' => trim($rowData[7]),
						    	'address' => ucwords(strtolower(trim($rowData[8]))),
						    	'course' => strtoupper(trim($rowData[9])),
						    	'section' => strtoupper(trim($rowData[10])),
						    	'year' => trim($rowData[11]),
						    	'type-of-student' => trim($rowData[12]),
						    	'type' => trim('student'),
						    ];

						    $isStudentExistInBothTable = $this->checkStudentIfExistingInBothTable($details['id']);
						    $ADD_FLAG = 1;

							if($isStudentExistInBothTable) {
								$ADD_FLAG = 0;
								$account = '';
								$personal = $this->Student->update($details);
							} else {
								$ADD_FLAG = 1;
								$account = $this->User->add($details);
								$personal = $this->Student->add($details);
							} 

							if(empty($account) && empty($personal)) {
								if($ADD_FLAG) {
									$this->sendSMSAndEmailNotification($details);
								}

								$this->data['flash-success-message'] = 'Data has been imported';						
							} else {
								if($ADD_FLAG) {
									$this->Student->delete($details['id']);
									$this->User->delete($details['id']);
								}

								if(!empty($account)) $result = $account;
								else $result = $personal;

								$this->data['flash-success-message'] = '';
								$this->data['flash-error-message'] = 'ROW '.$row.': '.$result;
								break;
							}
						}
					}
				}

			} else {
				$this->data['flash-error-message'] = 'Excel file is not found';
			}
		}

		$this->data['student-nav-active'] = 'bg-slate-600';
		$this->data['students'] = $this->getAllStudent(); 
		$this->view('user/student/index', $this->data);
	}

	public function declined($id) {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'id' => trim($post['id']),
				'old-id' => trim($post['old-id']),
				'email' => trim($post['email']),
				'lname' => trim($post['lname']),
				'fname' => trim($post['fname']),
				'mname' => trim($post['mname']),
				'gender' => trim($post['gender']),
				'contact' => trim($post['contact']),
				'location' => trim($post['location']),
				'address' => trim($post['address']),
				'type' => trim($post['type']),
				'course' => trim($post['course']),
				'year' => trim($post['year']),
				'section' => trim($post['section']),
				'identification' => $this->uploadIdentification()
			];

			$result = $this->User->studentResubmission($details);

			if(empty($result)) {
				$this->data['flash-success-message'] = 'Application has been resubmitted';
			} else {
				$this->data['flash-error-message'] = $result;
			}

		}

		$this->checkAccountIfDeclined($id);
		$this->data['details'] = $this->getStudentDetails($id);

		$this->view('student/declined/index', $this->data);
	}

	public function validate_account_details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$details = [
			'id' => trim($post['id']),
			'email' => trim($post['email']),
			'pass' => trim($post['pass']),
			'cpass' => trim($post['cpass'])
			];

			echo json_encode($this->validateAccountDetails($details));
			return;
		}
	}

	public function validate_personal_details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'lname' => trim($post['lname']),
				'fname' => trim($post['fname']),
				'mname' => trim($post['mname']),
				'gender' => trim($post['gender']),
				'contact' => trim($post['contact']),
				'location' => trim($post['location']),
				'address' => trim($post['address']),
				'course' => trim($post['course']),
				'year' => trim($post['year']),
				'section' => trim($post['section']),
				'type' => trim($post['type'])
			];

			echo json_encode($this->validatePersonalDetails($details));
			return;
		}

	}

	public function details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$result = $this->Student->findStudentById($post['id']);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}

		}
		echo '';
	}

	public function records($id) {
		$this->data['student-nav-active'] = 'bg-slate-600';
		$this->data['records'] = $this->getStudentRecords($id);
		$this->data['request-frequency'] = $this->getRequestFrequency($id);
		$this->data['status-frequency'] = $this->getStatusFrequency($id);
		$this->data['consultation-frequency'] = $this->getConsultationFrequency($id);
		$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($id);
		$this->data['activities'] = $this->getAllActivities($id);
		$this->view('student/records/index', $this->data);
	}

	public function terminate($id) {
		$records = $this->User->findUserById($id);

		if(is_object($records)) {
			if($records->status != 'declined') {
				$this->data['flash-error-message'] = 'This account is not available for termination';
			} else {
				$result = $this->Student->delete($id);

				if($result) {
					$this->data['flash-success-message'] = 'Application has been terminated';
				} else {
					$this->data['flash-error-message'] = 'Some error occured while terminating application, please try again';
				}
			}
		} else {
			$this->data['flash-error-message'] = 'An erro occured';
		}

		$this->view('student/login/index', $this->data);
	}

	public function confirm($id) {
		$id = base64_decode($id);

		$result = $this->User->open($id);

		if($result) {
			$this->data['flash-success-message'] = 'Account has been activated';
		} else {
			$this->data['flash-error-message'] = 'Account failed to activate';
		}

		$this->view('home/index', $this->data);
	}

	private function sendSMSAndEmailNotification($info) {
		$id = $info['id'];

		$email = [
			'recipient' => $info['email'],
			'name' => $info['fname'].' '.$info['lname'],
			'message' => $info['pass'],
			'link' => URLROOT.'/student/confirm/'.base64_encode($id)
		];

		$contentOfEmail = formatEmailForAccountConfirmation($email);

		$email['message'] = $contentOfEmail;

		//sendSMS($student->contact, $info['message']);
		sendEmail($email);
	
	}

	private function checkStudentIfExistingInBothTable($id) {
		$account = $this->User->findUserById($id);
		$personal = $this->Student->findStudentById($id);

		if(is_object($account) && is_object($personal)) return true;

		return false;
	}

	private function getAllActivities($id) {
		$result = $this->Activity->findAllActivitiesByActor($id);

		if(is_array($result)) return $result;

		return [];
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}

	private function checkAccountIfDeclined($id) {
		$result = $this->User->findUserById($id);

		if(is_object($result)) {
			if($result->status != 'declined') header('location:'.URLROOT.'/student/login');
		} else {
			header('location:'.URLROOT.'/student/login');
		}
	}

	private function uploadIdentification() {
		$path = '';
		if(isset($_FILES['identification'])) $path = uploadDocument($_FILES['identification']);
		return $path;
	}


	private function createUserSession($user) {
		$student = $this->Student->findStudentById($user->id);
		
		$_SESSION['id'] = $user->id;
		$_SESSION['email'] = $user->email;
		$_SESSION['fname'] = $student->fname;		
		$_SESSION['lname'] = $student->lname;
		$_SESSION['type'] = $user->type;
		$_SESSION['pic'] = $user->pic;
	}

	private function getRequestFrequency($id) {
		$freq = $this->RequestedDocument->getRequestFrequencyOfStudent($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getStatusFrequency($id) {
		$freq = $this->RequestedDocument->getStatusFrequencyOfStudent($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getConsultationFrequency($id) {
		$freq = $this->Consultation->getConsultationFrequencyOfStudent($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getUpcomingConsultation($id) {
		$freq = $this->Consultation->findUpcomingConsultationOfStudent($id);

		if(is_array($freq)) return $freq;

		return [];
	}

	private function getStudentRecords($id) {
		$records = $this->Student->getStudentRecords($id);

		if(is_object($records)) return $records;

		return [];
	}

	private function getStudentDetails($id) {
		$records = $this->User->findStudentById($id);

		if(is_object($records)) return $records;

		return [];
	}

	private function getAllStudent() {
		$students = $this->Student->getAllStudent();

		if(is_array($students)) return $students;

		return [];
	}

	private function isLoginDetailsValid($data) {
		if(empty($data['id'])) return false;
		if(empty($data['pass'])) return false;
		return true;
	}

	private function validateAccountDetails($data) {
		if(empty($data['id'])) {
			return 'ID is required';
		}

		if(!is_numeric($data['id'])) {
			return 'ID has wrong format';
		}

		if(empty($data['email'])) {
			return 'Email is required';
		}

		if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return 'Email is invalid, please try again';
		}

		$domain = explode('@', $data['email'])[1];
		if($domain !== 'gmail.com') {
			return 'Gmail is required for email';
		}

		if(empty($data['pass'])) {
			return 'Password is required';
		}

		if(empty($data['cpass'])) {
			return 'Confirm password is required';
		}

		if(strlen($data['pass']) < 8) {
			return 'Password should be atlest 8 characters long. Alphanumeric';
		}

		if($data['cpass'] != $data['pass']) {
			return 'Password and Confirm Password don\'t match.';
		}

		$existing = $this->User->findUSerById($data['id']);

		if(is_object($existing)) {
			if($existing->type=='alumni') return 'An existing alumni account is using this ID';
			return 'Student already exist';
		}

		if($this->User->findUSerByEmail($data['email'])) {
			return 'Email is already in use';
		}

		return '';
	}

	private function validatePersonalDetails($data) {
		if(empty($data['lname'])) {
			return 'Lastname is required';
		}

		if(empty($data['fname'])) {
			return 'Firstname is required';
		}

		if(empty($data['location'])) {
			return 'Location is required';
		}

		if(empty($data['address'])) {
			return 'Address is required';
		}

		if(empty($data['gender'])) {
			return 'Gender is required';
		}

		if(empty($data['course'])) {
			return 'Course is required';
		}

		if(empty($data['year'])) {
			return 'Year is required';
		}

		if(empty($data['section'])) {
			return 'Section is required';
		}

		if(empty($data['contact'])) {
			return 'Contact is required';
		}

		if(!is_numeric($data['contact']) || !preg_match('/^[0-9]{11}+$/', $data['contact'])) {
			return 'Contact has wrong format';
		}

		if(empty($data['type'])) {
			return 'Type is required';
		}

		if(!file_exists($_FILES['identification']['tmp_name']) || !is_uploaded_file($_FILES['identification']['tmp_name'])) {
			return 'Identification document is required';
		} 

		return '';	
	}
}


?>