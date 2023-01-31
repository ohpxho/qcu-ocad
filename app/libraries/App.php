<?php

class App {
	protected $controller = 'Home';
	protected $method = 'index';
	protected $params = [];

	public function __construct() {
		$url = $this->parseURL();
		$this->setController($url);
		$this->setMethod($url);
		$this->setParams($url);

		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	private function parseUrl() {
		if(isset($_GET['url'])) {
			return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}

	private function setController(&$url) {
		if(isset($url[0])) {
			$urlController = str_replace(' ', '', (ucwords(str_replace('_', ' ', $url[0]))));
			if(file_exists('../app/controllers/'.$urlController.'.php')) {
				$this->controller = $urlController;
				unset($url[0]);
			}
		}

		require_once '../app/controllers/'.$this->controller.'.php';
		$this->controller = new $this->controller;
	}

	private function setMethod(&$url) {
		if(isset($url[1])) {
			$urlMethod = $url[1];
			$this->method = $urlMethod;
			unset($url[1]); 
		}
	}

	private function setParams(&$url) {
		$this->params = $url ? array_values($url) : [];
	}

}

?>