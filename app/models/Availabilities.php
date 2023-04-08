<?php

class Availabilities {
	public function __construct() {
		$this->db = new Database();
	}

	public function findAvailabilityByDateAndAdvisor($advisor, $date) {
		$this->db->query("SELECT * FROM availabilities WHERE advisor=:advisor AND date=:date");
		$this->db->bind(':advisor', $advisor);
		$this->db->bind(':date', $date);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function add($details) {
		$validate = $this->validate($details);

		if(empty($validate)) {
			$this->db->query("INSERT INTO availabilities (advisor, date, timeslots) VALUES (:advisor, :date, :timeslots)");
			$this->db->bind(':advisor', $details['advisor']);
			$this->db->bind(':date', $details['date']);
			$this->db->bind(':timeslots', $details['timeslots']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while setting availability, please try again';
		}

		return $validate;
	}

	public function update($details) {
		$validate = $this->validate($details);

		if(empty($validate)) {
			$this->db->query("UPDATE availabilities SET timeslots=:timeslots WHERE advisor=:advisor AND date=:date");
			$this->db->bind(':advisor', $details['advisor']);
			$this->db->bind(':date', $details['date']);
			$this->db->bind(':timeslots', $details['timeslots']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while setting availability, please try again';
		}

		return $validate;
	}

	private function validate($details) {
		if(empty($details['date'])) return 'Date not found';

		if(empty($details['advisor'])) return 'Advisor not found';

		return '';
	}
}

?>