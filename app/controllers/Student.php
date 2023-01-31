<?php


class Student extends Controller {
	public function __construct() {

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
}


?>