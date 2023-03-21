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
			'moral-nav-active' => '',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'record-nav-active' => '',
			'student-nav-active' => '',
			'alumni-nav-active' => '',
			'professor-nav-active' => '',
			'admin-nav-active' => '',
			'setting-nav-active' => ''
		];
	}
	
	public function index() {
		redirect('PAGE_THAT_DONT_NEED_USER_SESSION');
		$this->view('home/index', $this->data);
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
}

?>


