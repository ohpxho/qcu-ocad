<?php

class Schedule extends Controller {
	public function __construct() {
		$this->Schedule = $this->model('Schedules');
		$this->Availability = $this->model('Availabilities');
		$this->Activity = $this->model('Activities');

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
			'consultation-resolved-nav-active' => '',
			'consultation-declined-nav-active' => '',
			'consultation-cancelled-nav-active' => '',
			'consultation-records-nav-active' => '',
			'consultation-schedule-nav-active' => '',
			'record-nav-active' => '',
			'student-nav-active' => '',
			'alumni-nav-active' => '',
			'professor-nav-active' => '',
			'admin-nav-active' => '',
			'setting-nav-active' => '',
			'request-data' => [],
			'data-changes-flag' => false
		];
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

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);
	}

	public function get_availability_by_advisor_and_date() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$advisor = trim($post['advisor']);
			$date = trim($post['date']);

			$result = $this->Availability->findAvailabilityByDateAndAdvisor($advisor, $date);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo json_encode([]);	
	}

	public function get_all_availability_by_advisor() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$advisor = trim($post['advisor']);

			$result = $this->Availability->findAllAvailabilityByAdvisor($advisor);

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
				'start' => trim($post['start'])
			];

			$result = $this->Schedule->add($details);

			if($result) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'SCHEDULE',
					'description' => 'added timeslots in schedule'
				];

				$this->addActionToActivities($action);

				echo json_encode('Schedule has been updated');
				return;
			}

			echo json_encode('Some error occured while updating schedule, please try again');
 		}	
	}

	public function update() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-schedule-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'advisor' => trim($post['advisor']),
				'day' => trim($post['day']),
				'timeslots' => trim($post['timeslots'])				
			];

			switch($details['day']) {
				case 'monday':
					$result = $this->Schedule->updateMondaySchedOfAdvisor($details);
					break;
				case 'tuesday':
					$result = $this->Schedule->updateTuesdaySchedOfAdvisor($details);
					break;
				case 'wednesday':
					$result = $this->Schedule->updateWednesdaySchedOfAdvisor($details);
					break;
				case 'thursday':
					$result = $this->Schedule->updateThursdaySchedOfAdvisor($details);
					break;
				case 'friday':
					$result = $this->Schedule->updateFridaySchedOfAdvisor($details);
					break;
				case 'saturday':
					$result = $this->Schedule->updateSaturdaySchedOfAdvisor($details);
					break;
				default:
					$result = $this->Schedule->updateSundaySchedofAdvisor($details);
					break;
			}

			if($result) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'SCHEDULE',
					'description' => 'updated a schedule'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Schedule has been updated';
			} else {
				$this->data['flash-error-message'] = 'Some error occured while updating schedule, please try again';
			}
		}

		if($_SESSION['type'] == 'professor') $advisor = $_SESSION['id'];
		if($_SESSION['type'] == 'guidance') $advisor = 'guidance';
		if($_SESSION['type'] == 'clinic') $advisor = 'clinic';

		$this->data['schedule'] = $this->getScheduleByAdvisor($advisor);

		$this->view('consultation/schedule/index', $this->data);
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}

	public function set_availability() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['consultation-schedule-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$details = [
				'date' => trim($post['date']),
				'timeslots' => trim($post['timeslots']),
				'advisor' => trim($post['advisor'])
			];

			if($this->isAvailabilityAlreadyExist($details['advisor'], $details['date'])) {
				$result = $this->Availability->update($details);
			} else {
				$result = $this->Availability->add($details);
			}

			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'action' => 'SCHEDULE',
					'description' => 'set availability of specific date'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Availability has been set';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}
		
		if($_SESSION['type'] == 'professor') $advisor = $_SESSION['id'];
		if($_SESSION['type'] == 'guidance') $advisor = 'guidance';
		if($_SESSION['type'] == 'clinic') $advisor = 'clinic';

		$this->data['schedule'] = $this->getScheduleByAdvisor($advisor);

		$this->view('consultation/schedule/index', $this->data);
	}

	private function isAvailabilityAlreadyExist($advisor, $date) {
		$availability = $this->Availability->findAvailabilityByDateAndAdvisor($advisor, $date);

		if(is_object($availability)) return true;

		return false;
	}

	private function getScheduleByAdvisor($id) {
		$sched = $this->Schedule->findScheduleByAdvisor($id);
		
		if(is_object($sched)) return $sched;

		return [];
	}

}


?>