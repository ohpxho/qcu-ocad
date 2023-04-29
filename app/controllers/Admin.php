<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Admin extends Controller {
	public function __construct() {
		$this->User = $this->model('Users');
		$this->Admin = $this->model('Admins');
		$this->RequestedDocument = $this->model('RequestedDocuments');
		$this->Consultation = $this->model('Consultations');
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
				$user = $this->User->loginAdmin($credentials);

				if(is_object($user)) {
					if($user->status == 'blocked') {
						$this->data['flash-error-message'] = 'Your account is blocked';
					} else if($user->status == 'closed') {
						$this->data['flash-error-message'] = 'Your account is closed';
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
		$this->view('admin/login/index', $this->data);
	}

	public function add() {
		$this->data['admin-nav-active'] = 'bg-slate-600';
		$this->data['input-details'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'id' => trim($post['id']),
				'email' => trim($post['email']),
				'pass' => trim($post['pass']),
				'lname' => trim($post['lname']),
				'fname' => trim($post['fname']),
				'mname' => trim($post['mname']),
				'gender' => trim($post['gender']),
				'contact' => trim($post['contact']),
				'department' => trim($post['department']),
				'type' => trim($post['department'])
			];

			$this->data['input-details'] = $details;

			$addToUserModel = $this->User->add($details);
			$addToAdminModel = $this->Admin->add($details);

			if(empty($addToUserModel) && empty($addToAdminModel)) {
				$action = [
					'actor' => $_SESSION['id'],
					'name' => $_SESSION['fname'].' '.$_SESSION['lname'],
					'type' => $_SESSION['type'],
					'action' => 'USER_ACCOUNT',
					'description' => 'added new admin account'
				];

				$this->addActionToActivities($action);

				$this->sendSMSAndEmailNotification($details);

				$this->data['input-details'] = [];
				$this->data['flash-success-message'] = 'Added new admin account';
			} else {
				if(!empty($addToUserModel)) $this->data['flash-error-message'] = $addToUserModel;
				else $this->data['flash-error-message'] = $addToAdminModel;
			}
		}

		$this->view('admin/add/index', $this->data);
	}

	public function records($id) {
		$this->data['admin-nav-active'] = 'bg-slate-600';
		$this->data['records'] = $this->getAdminRecords($id);
		$this->data['consultation-frequency'] = $this->getConsultationFrequency($id);
		$this->data['upcoming-consultation'] = $this->getUpcomingConsultation($id);
		$this->data['activities'] = $this->getAllActivities($id);
		$this->view('admin/records/index', $this->data);
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

					if($highestColumn != 'H') {
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
						    	'pass' => trim(generateRandomPassword()),
						    	'email' => trim($rowData[1]),
						    	'lname' => ucwords(strtolower(trim($rowData[2]))),
						    	'fname' => ucwords(strtolower(trim($rowData[3]))),
						    	'mname' => ucwords(strtolower(trim($rowData[4]))),
						    	'gender' => trim($rowData[5]),
						    	'contact' => trim($rowData[6]),
						    	'department' => trim($rowData[7]),
						    	'type' => trim($rowData[7])
						    ];

						    $isAdminExistInBothTable = $this->checkAdminIfExistingInBothTable($details['id']);
						    $ADD_FLAG = 1;

							if($isAdminExistInBothTable) {
								$ADD_FLAG = 0;
								$account = '';
								$personal = $this->Admin->update($details);
							} else {
								$ADD_FLAG = 1;
								$account = $this->User->add($details);
								$personal = $this->Admin->add($details);
							} 

							if(empty($account) && empty($personal)) {
								if($ADD_FLAG) {
									$this->sendSMSAndEmailNotification($details);
								}

								$this->data['flash-success-message'] = 'Data has been imported';						
							} else {
								if($ADD_FLAG) {
									$this->Admin->delete($details['id']);
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

		$this->data['admin-nav-active'] = 'bg-slate-600';
		$this->data['admins'] = $this->getAllAdmin(); 
		$this->view('user/admin/index', $this->data);
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

	public function update($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['admin-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$details = [
				'id' => trim($post['id']),
				'email' => trim($post['email']),
				'lname' => ucwords(strtolower(trim($post['lname']))),
				'fname' => ucwords(strtolower(trim($post['fname']))),
				'mname' => ucwords(strtolower(trim($post['mname']))),
				'gender' => trim($post['gender']),
				'contact' => trim($post['contact']),
				'department' => trim($post['department'])
			];	

			$account = $this->User->updateEmail($details);
			$personal = $this->Admin->update($details);

			if(empty($account) && empty($personal)) {
				$action = [
					'actor' => $_SESSION['id'],
					'name' => $_SESSION['fname'].' '.$_SESSION['lname'],
					'type' => $_SESSION['type'],
					'action' => 'USER_ACCOUNT',
					'description' => 'updated admin account'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Account has been updated';
			} else {
				if(!empty($account)) $this->data['flash-error-message'] = $account;
				else $this->data['flash-error-message'] = $personal;
			}

		}

		$this->data['records'] = $this->getAdminRecords($id);

		$this->view('admin/edit/index', $this->data);
	}

	private function sendSMSAndEmailNotification($info) {
		$id = $info['id'];

		$email = [
			'recipient' => $info['email'],
			'name' => $info['fname'].' '.$info['lname'],
			'message' => $info['pass'],
			'link' => URLROOT.'/admin/confirm/'.base64_encode($id)
		];

		$contentOfEmail = formatEmailForAccountConfirmation($email);

		$email['message'] = $contentOfEmail;

		//sendSMS($student->contact, $info['message']);
		sendEmail($email);
	
	}

	private function checkAdminIfExistingInBothTable($id) {
		$account = $this->User->findUserById($id);
		$personal = $this->Admin->findAdminById($id);

		if(is_object($account) && is_object($personal)) return true;

		return false;
	}

	private function getAllActivities($id) {
		$result = $this->Activity->findAllActivitiesByActor($id);

		if(is_array($result)) return $result;

		return [];
	}

	private function getAllAdmin() {
		$admins = $this->Admin->getAllAdmin();

		if(is_array($admins)) return $admins;

		return [];
	}

	private function createUserSession($user) {
		$admin = $this->Admin->findAdminById($user->id);
		
		$_SESSION['id'] = $user->id;
		$_SESSION['email'] = $user->email;
		$_SESSION['fname'] = $admin->fname;		
		$_SESSION['lname'] = $admin->lname;
		$_SESSION['type'] = $user->type;
		$_SESSION['pic'] = $user->pic;
	}

	private function getConsultationFrequency($id) {
		$freq = $this->Consultation->getConsultationFrequencyOfAdviser($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getUpcomingConsultation($id) {
		$freq = $this->Consultation->findUpcomingConsultationOfAdviser($id);

		if(is_array($freq)) return $freq;

		return [];
	}

	private function getAdminRecords($id) {
		$records = $this->Admin->getAdminRecords($id);

		if(is_object($records)) return $records;

		return [];
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}

	private function isLoginDetailsValid($data) {
		if(empty($data['id'])) return false;
		if(empty($data['pass'])) return false;
		return true;
	}
}

?>