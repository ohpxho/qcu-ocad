<?php

class Schedules {
	public function __construct() {
		$this->db = new Database();
	}

	public function findScheduleById($id) {
		$this->db->query("SELECT * FROM schedules WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function findScheduleByAdvisor($advisor) {
		$this->db->query("SELECT * FROM schedules WHERE advisor=:advisor ORDER BY day, start ASC");
		$this->db->bind(':advisor', $advisor);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findScheduleByIdAndDay($id, $day) {
		$this->db->query("SELECT * FROM schedules WHERE id=:id AND day=:day");
		$this->db->bind(':id', $id);
		$this->db->bind(':day', $day);

		$resuls = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function add($details) {
		$this->db->query("INSERT INTO schedules (advisor, day, start, end) VALUES (:advisor, :day, :start, :end)");
		$this->db->bind(':advisor', $details['advisor']);
		$this->db->bind(':day', $details['day']);
		$this->db->bind(':start', $details['start']);
		$this->db->bind(':end', $details['end']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function delete($id) {
		$this->db->query("DELETE FROM schedules WHERE id=:id");
		$thi->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}
}


?>