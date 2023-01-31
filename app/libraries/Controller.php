<?php

class Controller {

	protected function view($view, $data) {
		if(file_exists('../app/views/'.$view.'.php')) {
			require_once '../app/views/'.$view.'.php';
		} else {
			require_once '../app/views/error/404.php';
		}
	}

	protected function model($model) {
		if(file_exists('../app/models/'.$model.'.php')) {
			require_once '../app/models/'.$model.'.php';
			return new $model;	
		} else {
			require_once '../app/views/error/500.php';
		}
	}
}

?>