<?php

class Home extends Controller{
	public function __construct() {
		$this->User = $this->model('Users');
		$this->Student = $this->model('Students');
		$this->Admin = $this->model('Admins');
		$this->Professor = $this->model('Professors');
		$this->Alumni = $this->model('Alumnis');

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
			'setting-nav-active' => ''
		];
	}
	
	public function index() {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');
		$this->login();
	}	

	public function terms() {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');
		$this->view('home/terms', $this->data);
	}

	public function privacy_policy() {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');
		$this->view('home/privacy-policy', $this->data);
	}

	public function login() {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');

		$max_attempts = 5;
		$wait_time = 300;

		$this->data['credentials'] = [];

		if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= $max_attempts && time() - $_SESSION['login_time'] < $wait_time) {

		 	$time_left = $wait_time - (time() - $_SESSION['login_time']);
		 	$this->data['flash-error-message'] = "You have exceeded the maximum login attempts. Please try again in " . $time_left . " seconds.";
		
		} else {

			if(isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= $max_attempts) {
				 unset($_SESSION['login_attempts']);
				 unset($_SESSION['login_time']);
			}

			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				$credentials = [
					'id' => trim($post['id']),
					'pass' => trim($post['password'])
				];

				$this->data['credentials'] = $credentials;

				if($this->isLoginDetailsValid($credentials)) {
					$user = $this->User->login($credentials);

					if(is_object($user)) {
						if($user->status == 'blocked') {
							$this->data['flash-error-message'] = 'Your account is blocked';
						} else if($user->status == 'closed') {
							$this->data['flash-error-message'] = 'Your account is closed';
						} else {
							$_SESSION['login_attempts'] = 0;
   							$_SESSION['login_time'] = 0;
							$this->createUserSession($user);	
							header('location:'.URLROOT.'/user/dashboard');
						} 
					} else {
						if (!isset($_SESSION['login_attempts'])) {
					      $_SESSION['login_attempts'] = 1;
					    } else {
					      $_SESSION['login_attempts']++;
					    }

					    if (!isset($_SESSION['login_time'])) {
					      $_SESSION['login_time'] = time();
					    }

						$this->data['flash-error-message'] = 'Incorrect ID/Email or Password';
					}
				} else {
					$this->data['flash-error-message'] = 'Invalid input, please try again';
				}
			}
		}

		$this->view('home/index', $this->data);
	}

	public function logout() {
		return $this->destroyUserSession();
	}

	private function createUserSession($user) {

		$personal = $this->getUserDetails($user->id, $user->type);
		
		$_SESSION['id'] = $user->id;
		$_SESSION['email'] = $user->email;
		$_SESSION['fname'] = $personal->fname;		
		$_SESSION['lname'] = $personal->lname;
		$_SESSION['type'] = $user->type;
		$_SESSION['pic'] = $user->pic;
	}

	private function destroyUserSession() {
		unset($_SESSION['id']);
		unset($_SESSION['email']);
		unset($_SESSION['lname']);
		unset($_SESSION['fname']);
		unset($_SESSION['type']);
		unset($_SESSION['pic']);

		header('location:'.URLROOT.'/home/index');
	}

	private function getUserDetails($id, $type) {
		switch($type) {
			case 'student': 
				$user = $this->Student->findStudentById($id);
				break;
			case 'alumni':
				$user = $this->Alumni->findAlumniById($id);
				break;
			case 'professor': 
				$user = $this->Professor->findProfessorById($id);
				break;
			default:
				$user = $this->Admin->findAdminById($id);
		}

		if(is_object($user)) return $user;

		return [];
	}

	private function isLoginDetailsValid($data) {
		if(empty($data['id'])) return false;

		if(empty($data['pass'])) return false;
		return true;
	}
}

?>


