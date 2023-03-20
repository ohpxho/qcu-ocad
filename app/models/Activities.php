<?php

class Activities {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($details) {
		$this->db->query("INSERT INTO activities (actor, action, description) VALUES (:actor, :action, :description)");
		$this->db->bind(':actor', $details['actor']);
		$this->db->bind(':action', $details['action']);
		$this->db->bind(':description', $details['description']);
		
		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function findRecentActivitiesByActor($actor) {
		$this->db->query("SELECT * FROM activities WHERE actor=:actor ORDER BY(date_acted) DESC LIMIT 3");
		$this->db->bind(':actor', $actor);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllActivitiesByActorAndAction($details) {
		$this->db->query("SELECT * FROM activities WHERE actor=:actor AND action=:action ORDER BY(date_acted) DESC");
		$this->db->bind(':actor', $details['actor']);
		$this->db->bind(':action', $details['action']);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllActivitiesByActorAndYear($details) {
		$this->db->query("SELECT * FROM activities WHERE actor=:actor AND YEAR(date_acted)=:year");
		$this->db->bind(':actor', $details['actor']);
		$this->db->bind(':year', $details['year']);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllActivitiesByActorAndActionAndYear($details) {
		$this->db->query("SELECT * FROM activities WHERE actor=:actor AND YEAR(date_acted)=:year AND action=:action");
		$this->db->bind(':actor', $details['actor']);
		$this->db->bind(':year', $details['year']);
		$this->db->bind(':action', $details['action']);
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;	
	}

	public function findAllDocumentActivitiesByActorAndActionAndYear($details) {
		$this->db->query("SELECT * FROM activities WHERE actor=:actor AND YEAR(date_acted)=:year AND (action='ACADEMIC_DOCUMENT_REQUEST' OR action='GOOD_MORAL_DOCUMENT_REQUEST' OR action='SOA_DOCUMENT_REQUEST')");
		$this->db->bind(':actor', $details['actor']);
		$this->db->bind(':year', $details['year']);
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;	
	} 
}


?>