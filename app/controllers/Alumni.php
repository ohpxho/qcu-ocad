<?php

class Alumni extends Controller {
	public function __construct() {
		$this->Alumni = $this->model('Alumnis');
		
		$this->data = [];
	}

	public function index() {
		$this->view('alumni/index/index', $this->data);
	}

	public function profile() {

	}

	public function request() {
		
	}

	public function records() {

	}

}

?>