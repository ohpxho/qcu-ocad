<?php

class Home extends Controller{
	public function __construct() {
		$this->User = $this->model('Users');
		$this->Student = $this->model('Students');
		$this->Admin = $this->model('Admins');
		$this->Professor = $this->model('Professors');

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
				$user = $this->User->login($credentials);

				if(is_object($user)) {
					if($user->block) {
						$this->data['flash-error-message'] = 'Your account is blocked.';
					} else {
						$this->createUserSession($user);	
						header('location:'.URLROOT.'/home/dashboard');
					} 
				} else {
					$this->data['flash-error-message'] = 'Incorrect ID/email or password';
				}
			} else {
				$this->data['flash-error-message'] = 'Invalid input. Please try again.';
			}
		}

		$this->view('home/index', $this->data);
	}	

	public function register() {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			if(isset($post['partial'])) {
				switch($post['partial']) {
					case 'account':
						$account = [
							'id' => trim($post['id']),
							'email' => trim($post['email']),
							'pass' => trim($post['pass']),
							'cpass' => trim($post['cpass'])
						];  
						echo json_encode($this->validateAccountDetails($account));
						return;
					case 'personal':
						$personal = [
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
						echo json_encode($this->validatePersonalDetails($personal));
						return;
				}
			} else {
				$student = [
					'id' => trim($post['id']),
					'email' => trim($post['email']),
					'pass' => password_hash(trim($post['password']), PASSWORD_DEFAULT),
					'lname' => ucwords(strtolower(trim($post['lastname']))),
					'fname' => ucwords(strtolower(trim($post['firstname']))),
					'mname' => ucwords(strtolower(trim($post['middlename']))),
					'gender' => trim($post['gender']),
					'contact' => trim($post['contact']),
					'location' => trim($post['location']),
					'address' => ucwords(strtolower(trim($post['address']))),
					'course' => strtoupper(trim($post['course'])),
					'year' => trim($post['year']),
					'section' => strtoupper(trim($post['section'])),
					'type' => trim($post['type'])
				];

				$result = $this->User->register($student);

				if($result) {
					$this->data['flash-success-message'] = 'Registered successfully.';
				} else {
					$this->data['flash-error-message'] = 'Something went wrong. Please try again.';
				}
			}
		}

		$this->view('home/register/index', $this->data);		
	}	

	public function dashboard() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		$this->data['dashboard-nav-active'] = 'bg-slate-200';
		$this->view('home/dashboard/index', $this->data);
	}

	public function logout() {
		return $this->destroyUserSession();
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

	private function createUserSession($user) {
		$_SESSION['id'] = $user->id;
		$_SESSION['email'] = $user->email;
		
		if($user->type == 'student') {
			$student = $this->Student->findStudentById($user->id);
			$_SESSION['fname'] = $student->fname;		
			$_SESSION['lname'] = $student->lname;
		} else if($user->type == 'professor') {
			$professor = $this->Professor->findProfessorById($user->id);
			$_SESSION['fname'] = $professor->fname;		
			$_SESSION['lname'] = $professor->lname;
		}else {
			$admin = $this->Admin->findAdminById($user->id);
			$_SESSION['fname'] = $admin->fname;		
			$_SESSION['lname'] = $admin->lname;
		}

		$_SESSION['type'] = $user->type;
		$_SESSION['pic'] = $user->pic;
	}

	private function isLoginDetailsValid($data) {
		if(empty($data['id'])) return false;
		if(empty($data['pass'])) return false;
		return true;
	}

	private function validateAccountDetails($data) {
		if(empty($data['id'])) {
				return 'ID cannot be empty.';
			}

			if(!is_numeric($data['id'])) {
				return 'ID has wrong format.';
			}

			if(empty($data['email'])) {
				return 'Email cannot be empty.';
			}

			if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
 			   return 'Email is invalid. Please try again.';
			}

			$domain = explode('@', $data['email'])[1];
			if($domain !== 'gmail.com') {
				return 'Gmail is required for email.';
			}

			if(empty($data['pass'])) {
				return 'Password cannot be empty.';
			}

			if(empty($data['cpass'])) {
				return 'Confirm Password cannot be empty.';
			}

			if(strlen($data['pass']) < 8) {
				return 'Password should be atlest 8 characters long. Alphanumeric.';
			}

			if($data['cpass'] != $data['pass']) {
				return 'Password and Confirm Password don\'t match.';
			}

			if($this->User->findUSerById($data['id'])) {
				return 'User already exist.';
			}

			if($this->User->findUSerByEmail($data['email'])) {
				return 'Email is already in use.';
			}

			return '';
	}

	private function validatePersonalDetails($data) {
		if(empty($data['lname'])) {
			return 'Lastname cannot be empty.';
		}

		if(empty($data['fname'])) {
			return 'Firstname cannot be empty.';
		}

		if(empty($data['location'])) {
			return 'Location cannot be empty.';
		}

		if(empty($data['address'])) {
			return 'Address cannot be empty.';
		}

		if(empty($data['gender'])) {
			return 'Gender cannot be empty.';
		}

		if(empty($data['course'])) {
			return 'Course cannot be empty.';
		}

		if(empty($data['year'])) {
			return 'Year cannot be empty.';
		}

		if(empty($data['section'])) {
			return 'Section cannot be empty.';
		}

		if(empty($data['contact'])) {
			return 'Contact cannot be empty.';
		}

		if(!is_numeric($data['contact']) || !preg_match('/^[0-9]{11}+$/', $data['contact'])) {
			return 'Contact has wrong format.';
		}

		if(empty($data['type'])) {
			return 'Type cannot be empty.';
		}

		return '';	
	}
}

?>


