<?php

class Schedules {
	public function __construct() {
		$this->db = new Database();
	}

	public function findScheduleByAdvisor($advisor) {
		$this->db->query("SELECT * FROM schedules WHERE advisor=:advisor");
		$this->db->bind(':advisor', $advisor);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function add($advisor) {
		$this->db->query("INSERT INTO schedules (advisor) VALUES (:advisor)");
		$this->db->bind(':advisor', $advisor);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function updateMondaySchedOfAdvisor($details) {
		$this->db->query("UPDATE schedules SET monday=:monday WHERE advisor=:advisor");
		$this->db->bind(':advisor', $details['advisor']);
		$this->db->bind(':monday', $details['timeslots']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function updateTuesdaySchedOfAdvisor($details) {
		$this->db->query("UPDATE schedules SET tuesday=:tuesday WHERE advisor=:advisor");
		$this->db->bind(':advisor', $details['advisor']);
		$this->db->bind(':tuesday', $details['timeslots']);
		
		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function updateWednesdaySchedOfAdvisor($details) {
		$this->db->query("UPDATE schedules SET wednesday=:wednesday WHERE advisor=:advisor");
		$this->db->bind(':advisor', $details['advisor']);
		$this->db->bind(':wednesday', $details['timeslots']);
		
		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function updateThursdaySchedOfAdvisor($details) {
		$this->db->query("UPDATE schedules SET thursday=:thursday WHERE advisor=:advisor");
		$this->db->bind(':advisor', $details['advisor']);
		$this->db->bind(':thursday', $details['timeslots']);
		
		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function updateFridaySchedOfAdvisor($details) {
		$this->db->query("UPDATE schedules SET friday=:friday WHERE advisor=:advisor");
		$this->db->bind(':advisor', $details['advisor']);
		$this->db->bind(':friday', $details['timeslots']);
		
		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function updateSaturdaySchedOfAdvisor($details) {
		$this->db->query("UPDATE schedules SET saturday=:saturday WHERE advisor=:advisor");
		$this->db->bind(':advisor', $details['advisor']);
		$this->db->bind(':saturday', $details['timeslots']);
		
		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function updateSundaySchedOfAdvisor($details) {
		$this->db->query("UPDATE schedules SET sunday=:sunday WHERE advisor=:advisor");
		$this->db->bind(':advisor', $details['advisor']);
		$this->db->bind(':sunday', $details['timeslots']);
		
		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function delete($advisor) {
		$this->db->query("DELETE FROM schedules WHERE advisor=:advisor");
		$this->db->bind(':id', $advisor);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}
}


?>