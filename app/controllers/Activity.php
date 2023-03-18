<?php

class Activity extends Controller {
	public function __construct() {
		$this->Activity = $this->model('Activities');
	}

	public function get_all_activities_by_actor_year_action() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'actor' => trim($post['actor']),
				'action' => trim($post['action']),
				'year' => trim($post['year'])
			];

			$result = $this->Activity->findAllActivitiesByActorAndActionAndYear($details);
			
			if(is_array($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);
	}

	public function get_all_document_activities_by_actor_year_action() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'actor' => trim($post['actor']),
				'year' => trim($post['year'])
			];

			$result = $this->Activity->findAllDocumentActivitiesByActorAndActionAndYear($details);
			
			if(is_array($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);	
	}

	public function get_all_activities_by_actor_year() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'actor' => trim($post['actor']),
				'year' => trim($post['year'])
			];

			$result = $this->Activity->findAllActivitiesByActorAndYear($details);
			
			if(is_array($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);	
	}
}



?>