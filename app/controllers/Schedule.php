<?php

class Schedule extends Controller {
	public function __construct() {
		$this->Schedule = $this->model('Schedules');
	}

	public function get_schedule_by_id() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$id = trim($post['id']);

			$result = $this->Schedule->findScheduleById($id);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			};
		}

		echo json_encode([]);
	}

	public function get_schedule_by_advisor() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$advisor = trim($post['advisor']);

			$result = $this->Schedule->findScheduleByAdvisor($advisor);

			if(is_array($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);
	}

	public function add_timeslot() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'advisor' => trim($post['advisor']),
				'day' => trim($post['day']),
				'start' => trim($post['start']),
				'end' => trim($post['end'])
			];

			$result = $this->Schedule->add($details);

			if($result) {
				echo json_encode('Schedule has been updated');
				return;
			}

			echo json_encode('Some error occured while updating schedule, please try again');
 		}	
	}
}


?>