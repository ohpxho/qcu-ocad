<?php

class GoodMoralRequests {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($request) {
		$validate = $this->validateAddRequest($request);
		
		if(empty($validate)) {
			$this->db->query("INSERT INTO good_moral_requests (student_id, purpose, other_purpose, type, quantity) VALUES (:student_id, :purpose, :other_purpose, :type, :quantity)");
			
			$this->db->bind(':student_id', $request['student-id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':other_purpose', $request['other-purpose']);
			$this->db->bind(':type', $request['type']);
			$this->db->bind(':quantity', $request['quantity']);

			$result = $this->db->execute();

			if($result) {
				return '';
			}

			return 'Something went wrong, please try again.';

		} else {
			return $validate;
		}
	}

	public function edit($request) {
		$validate = $this->validateEditRequest($request);

		if(empty($validate)) {
			$this->db->query("UPDATE good_moral_requests SET purpose=:purpose, other_purpose=:other_purpose, quantity=:quantity WHERE id=:id");
			$this->db->bind(':id', $request['request-id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':other_purpose', $request['other-purpose']);
			$this->db->bind(':quantity', $request['quantity']);

			$result = $this->db->execute();

			if($result) {
				return '';
			}

			return 'Something went wrong, please try again.';

		} else {
			return $validate;
		}
	}

	public function confirmPayment($id) {
		$this->db->query("UPDATE good_moral_requests SET status='for process' WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function findAllRequestByStudentId($id) {
		$this->db->query("SELECT * FROM good_moral_requests WHERE student_id=:id ORDER BY CASE WHEN status='awaiting payment confirmation' THEN 0 else 4 END, CASE WHEN status='for claiming' THEN 3 else 4 END, CASE WHEN status='for process' THEN 3 else 4 END, CASE WHEN status='pending' THEN 3 else 4 END, date_created DESC");

		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();
		
		if(is_array($result)) {
			return $result;
		}

		return false;
	}

	public function findRequestById($id) {
		$this->db->query("SELECT * FROM good_moral_requests WHERE id=:id ORDER BY FIELD(status, 'pending') DESC");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();
		
		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function findAllRequest() {
		$this->db->query("SELECT * FROM good_moral_requests ORDER BY FIELD(status, 'pending') DESC");
		
		$result = $this->db->getAllResult();
		
		if(is_array($result)) {
			return $result;
		}

		return false;
	}

	public function updateStatusAndRemarks($request) {
		if(!empty($request['status'])) {
			if($request['status'] == 'completed' || $request['status'] == 'rejected' || $request['status'] == 'cancelled') {
				$this->db->query("UPDATE good_moral_requests SET status=:status, remarks=:remarks, date_completed=NOW() WHERE id=:id");
			} else {
				if($request['status'] == 'awaiting payment confirmation') {
					if($request['price'] <= 0) return 'Payment amount is invalid, please try again';
					$this->db->query("UPDATE good_moral_requests SET status=:status, price=:price, remarks=:remarks WHERE id=:id");
					$this->db->bind(':price', $request['price']);
				} else {
					$this->db->query("UPDATE good_moral_requests SET status=:status, remarks=:remarks WHERE id=:id");
				}
			}
			
			$this->db->bind(':id', $request['request-id']);
			$this->db->bind(':status', $request['status']);
			$this->db->bind(':remarks', $request['remarks']);

			$result = $this->db->execute();
			
			if($result) return '';

			return 'Some error occured while updating request, please try again';
		}

		return 'Status is required';
	}

	public function drop($id) {
		$this->db->query("DELETE FROM good_moral_requests WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function cancel($id) {
		$this->db->query("UPDATE good_moral_requests SET status='cancelled', date_completed=NOW() WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function getAnnualRequestStatusFrequencyOfStudent($id) {
		$this->db->query("SELECT YEAR(date_created) as year, MONTH(date_created) as month, COUNT(CASE WHEN status='completed' THEN 1 ELSE NULL END) as completed, COUNT(CASE WHEN status='rejected' THEN 1 ELSE NULL END) as declined, COUNT(CASE WHEN status='cancelled' THEN 1 ELSE NULL END) as cancelled FROM good_moral_requests WHERE creator=:id GROUP BY YEAR(date_created), MONTH(date_created) ORDER BY YEAR(date_created), MONTH(date_created)");
		
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getAnnualRequestStatusFrequencyOfAdviser($id) {
		$this->db->query("SELECT YEAR(date_created) as year, MONTH(date_created) as month, COUNT(CASE WHEN status='completed' THEN 1 ELSE NULL END) as completed, COUNT(CASE WHEN status='rejected' THEN 1 ELSE NULL END) as declined, COUNT(CASE WHEN status='cancelled' THEN 1 ELSE NULL END) as cancelled FROM good_moral_requests GROUP BY YEAR(date_created), MONTH(date_created) ORDER BY YEAR(date_created), MONTH(date_created)");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getAnnualRequestStatusFrequencyOfSysAdmin() {
		$this->db->query("SELECT YEAR(date_created) as year, MONTH(date_created) as month, COUNT(CASE WHEN status='completed' THEN 1 ELSE NULL END) as completed, COUNT(CASE WHEN status='rejected' THEN 1 ELSE NULL END) as declined, COUNT(CASE WHEN status='cancelled' THEN 1 ELSE NULL END) as cancelled FROM good_moral_requests GROUP BY YEAR(date_created), MONTH(date_created) ORDER BY YEAR(date_created), MONTH(date_created)");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getHistoryOfStudent($id) {
		$this->db->query("SELECT YEAR(date_created) as year, * FROM good_moral_requests WHERE creator=:id AND (status='completed' OR status='rejected' OR status='cancelled') ORDER BY YEAR(date_created), MONTH(date_created)");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getHistoryOfAdviser($id) {
		$this->db->query("SELECT *, YEAR(date_created) as year FROM good_moral_requests WHERE (status='completed' OR status='rejected' OR status='cancelled') ORDER BY YEAR(date_created), MONTH(date_created)");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getHistoryOfSysAdmin() {
		$this->db->query("SELECT YEAR(date_created) as year, * FROM good_moral_requests WHERE status='completed' OR status='rejected' OR status='cancelled' ORDER BY YEAR(date_created), MONTH(date_created)");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllPendingRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='pending' || status='awaiting payment confirmation' ORDER BY status ASC");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllAcceptedRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='accepted' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllInProcessRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='for process' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllForClaimingRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='for claiming' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllCompletedRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='completed' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRejectedRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='rejected' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllCancelledRequest() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='cancelled' ");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsByStudentId($id) {
		$this->db->query("SELECT * FROM good_moral_requests WHERE student_id=:id AND (status='completed' || status='rejected')");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsOfStudentsForAdmin() {
		$this->db->query("SELECT * FROM good_moral_requests WHERE status='completed' OR status='rejected' OR status='cancelled' ORDER BY date_completed DESC");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsOfStudentsForSystemAdmin() {
		$this->db->query("SELECT * FROM good_moral_requests");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getRequestsCount() {
		$this->db->query("SELECT SUM(case when status='pending' OR status='awaiting payment confirmation' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='for process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming FROM good_moral_requests");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getRequestFrequency($id) {
		$this->db->query("SELECT COUNT(id) as GOOD_MORAL FROM good_moral_requests WHERE student_id=:id");
		
		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getStatusFrequency($id) {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as pending, SUM(case when status='accepted' then 1 else 0 end) as accepted, SUM(case when status='rejected' then 1 else 0 end) as rejected, SUM(case when status='for process' then 1 else 0 end) as inprocess, SUM(case when status='for claiming' then 1 else 0 end) as forclaiming, SUM(case when status='completed' then 1 else 0 end) as completed, SUM(case when status='cancelled' then 1 else 0 end) as cancelled FROM good_moral_requests WHERE student_id=:id");

		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	public function getRequestAvailability($id) {
		$this->db->query("SELECT COUNT(id) as GOOD_MORAL FROM good_moral_requests WHERE student_id=:id AND (status!='completed' AND status!='rejected' AND status!='cancelled')");
		
		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) {
			return $result;
		}

		return false;
	}

	private function validateAddRequest($request) {
		if(empty($request['student-id'])) {
			return 'A problem occured, please try again';
		}

		$availability = $this->getRequestAvailability($request['student-id']);

		if(is_object($availability)) {	
			if($availability->GOOD_MORAL > 0) {
				return 'You still have ongoing request for this document';
			}	
		}

		if(empty($request['purpose'])) {
			return 'Purpose is required';
		}

		if($request['purpose'] == 'Others' && empty($request['other-purpose'])) {
			return 'You need to specify the reason for request.';
		}

		if(empty($request['quantity'])) {
			return 'Specify the quantity of requested document';
		}

		return '';
	}

	private function validateEditRequest($request) {
		if(empty($request['purpose'])) {
			return 'Purpose is required';
		}

		if($request['purpose'] == 'Others' && empty($request['other-purpose'])) {
			return 'You need to specify the reason for request';
		}

		if(empty($request['quantity'])) {
			return 'Specify the quantity of requested document';
		}

		return '';
	}
}

?>