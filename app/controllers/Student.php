<?php


class Student extends Controller {
	public function __construct() {
		$this->Student = $this->model('Students');
	}

	public function index() {
		return;
	}

	public function documentrequest() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$data = [
			'dashboard-nav-active' => '',
			'document-nav-active' => 'bg-slate-200',
			'moral-nav-active' => '',
			'soa-nav-active' => '',
			'request-nav-active' => '',
			'ongoing-nav-active' => '',
			'transaction-nav-active' => '',
			'record-nav-active' => ''
		];

		$this->view('document-request/index', $data);
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
}


?>