<?php


class Consultations {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($request) {
		
		$validate = $this->validateAddRequest($request);

		if(empty($validate)) {

			$this->db->query("INSERT INTO consultations (creator, creator_name, purpose, problem, department, subject, adviser_id, adviser_name, preferred_date_for_gmeet, preferred_time_for_gmeet, shared_file_from_student) VALUES (:creator, :creator_name, :purpose, :problem, :department, :subject, :adviser_id, :adviser_name, :preferred_date, :preferred_time, :shared_file)");
			
			$this->db->bind(':creator', $request['creator']);
			$this->db->bind(':creator_name', ucwords($request['creator-name']));
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':problem', $request['problem']);
			$this->db->bind(':department', $request['department']);
			$this->db->bind(':subject', $request['subject']);
			$this->db->bind(':adviser_id', $request['adviser-id']);
			$this->db->bind(':adviser_name', ucwords($request['adviser-name']));
			$this->db->bind(':preferred_date', $request['preferred-date']);
			$this->db->bind(':preferred_time', $request['preferred-time']);
			$this->db->bind(':shared_file', $request['document']);

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
			$this->db->query("UPDATE consultations SET purpose=:purpose, problem=:problem, department=:department, subject=:subject, adviser_id=:adviser_id, adviser_name=:adviser_name, preferred_date_for_gmeet=:preferred_date, preferred_time_for_gmeet=:preferred_time, shared_file_from_student=:shared_file WHERE id=:id");
			$this->db->bind(':id', $request['id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':problem', $request['problem']);
			$this->db->bind(':department', $request['department']);
			$this->db->bind(':subject', $request['subject']);
			$this->db->bind(':adviser_id', $request['adviser-id']);
			$this->db->bind(':adviser_name', $request['adviser-name']);
			$this->db->bind(':shared_file', $request['document']);
			$this->db->bind(':preferred_date', $request['preferred-date']);
			$this->db->bind(':preferred_time', $request['preferred-time']);
			

			$result = $this->db->execute();

			if($result) {
				return '';
			}

			return 'Something went wrong, please try again.';

		} else {
			return $validate;
		}
	}

	public function update($request) {
		if(!empty($request['status'])) {
			if(isset($request['adviser-id'])) {
				if($request['status'] == 'rejected') {
					$this->db->query("UPDATE consultations SET adviser_id=:adviser_id, adviser_name=:adviser_name, status=:status, remarks=:remarks, date_completed=NOW() WHERE id=:id");
				} else {
					$this->db->query("UPDATE consultations SET adviser_id=:adviser_id, adviser_name=:adviser_name, status=:status, remarks=:remarks WHERE id=:id");
				}

				$this->db->bind(':adviser_id', $request['adviser-id']);
				$this->db->bind(':adviser_name', $request['adviser-name']);
			} else {
				$this->db->query("UPDATE consultations SET status=:status, remarks=:remarks, date_completed=NOW() WHERE id=:id");
			}
			

			$this->db->bind(':status', $request['status']);
			$this->db->bind(':remarks', $request['remarks']);
			$this->db->bind(':id', $request['request-id']);

			$result = $this->db->execute();

			if($result) return '';
			else return 'Something went wrong, please try again.';

		} else {
			return 'You need to accept/reject the request of the student.';
		}
	}

	public function updateSchedule($request) {
		$this->db->query("UPDATE consultations SET schedule_for_gmeet=:sched, gmeet_link=:link WHERE id=:id");
		$this->db->bind(':id', $request['id']);
		$this->db->bind(':sched', $request['sched']);
		$this->db->bind(':link', $request['link']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function drop($id) {
		$this->db->query("DELETE FROM consultations WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function cancel($id) {
		$this->db->query("UPDATE consultations SET status='unresolved' WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function getConsultationFrequencyOfStudent($id) {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as PENDING, SUM(case when status='active' then 1 else 0 end) as ACTIVE, SUM(case when status='resolved' then 1 else 0 end) as RESOLVED, SUM(case when status='unresolved' then 1 else 0 end) as UNRESOLVED, SUM(case when status='rejected' then 1 else 0 end) as REJECTED FROM consultations WHERE creator=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getConsultationFrequencyOfAdviser($id) {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as PENDING, SUM(case when status='active' then 1 else 0 end) as ACTIVE, SUM(case when status='resolved' then 1 else 0 end) as RESOLVED, SUM(case when status='unresolved' then 1 else 0 end) as UNRESOLVED, SUM(case when status='rejected' then 1 else 0 end) as REJECTED FROM consultations WHERE adviser_id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getConsultationFrequencyForSystemAdmin() {
		$this->db->query("SELECT SUM(case when status='pending' then 1 else 0 end) as PENDING, SUM(case when status='active' then 1 else 0 end) as ACTIVE, SUM(case when status='resolved' then 1 else 0 end) as RESOLVED, SUM(case when status='unresolved' then 1 else 0 end) as UNRESOLVED, SUM(case when status='rejected' then 1 else 0 end) as REJECTED FROM consultations");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function findUpcomingConsultationOfStudent($id) {
		$this->db->query("SELECT * FROM consultations WHERE schedule_for_gmeet!='0000-00-00 00:00:00' AND creator=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findUpcomingConsultationOfAdviser($id) {
		$this->db->query("SELECT * FROM consultations WHERE schedule_for_gmeet!='0000-00-00 00:00:00' AND adviser_id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findUpcomingConsultationForSystemAdmin() {
		$this->db->query("SELECT * FROM consultations WHERE schedule_for_gmeet!='0000-00-00 00:00:00'");
		
		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllPendingRequestByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND status='pending'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllPendingRequestByProfessorId($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='pending'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;		
	}

	public function findAllPendingRequestOfGuidance() {
		$this->db->query("SELECT * FROM consultations WHERE department='guidance' AND status='pending'");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;		
	}

	public function findAllPendingRequestOfClinic() {
		$this->db->query("SELECT * FROM consultations WHERE department='clinic' AND status='pending'");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;		
	}

	public function findAllActiveRequestByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND status='active'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllActiveRequestByAdviserId($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='active'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllRecordsByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND (status!='pending' AND status!='active') ORDER BY (date_completed) DESC");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsByAdviserId($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND (status!='pending' AND status!='active') ORDER BY (date_completed) DESC");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllRecordsOfStudents() {
		$this->db->query("SELECT * FROM consultations ORDER BY FIELD(status, 'pending', 'active', 'resolved', 'rejected', 'unresolved') ASC");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findRequestById($id) {
		$this->db->query("SELECT * FROM consultations WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;
		return false;
	}

	public function uploadDocumentsFromAdviser($request) {
		$this->db->query("UPDATE consultations SET shared_file_from_advisor=:documents WHERE id=:id");
		$this->db->bind(':id', $request['id']);
		$this->db->bind(':documents', $request['documents']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function uploadDocumentsFromStudent($request) {
		$this->db->query("UPDATE consultations SET shared_file_from_student=:documents WHERE id=:id");
		$this->db->bind(':id', $request['id']);
		$this->db->bind(':documents', $request['documents']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function deleteDocumentFromStudent($request) {
		$leftover = $this->removeFileFromExisting($request['file-to-delete'], $request['existing-documents']);

		$this->db->query("UPDATE consultations SET shared_file_from_student=:documents WHERE id=:id");
		$this->db->bind(':documents', $leftover);
		$this->db->bind(':id', $request['id']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function deleteDocumentFromAdviser($request) {
		$leftover = $this->removeFileFromExisting($request['file-to-delete'], $request['existing-documents']);
		
		$this->db->query("UPDATE consultations SET shared_file_from_advisor=:documents WHERE id=:id");
		$this->db->bind(':documents', $leftover);
		$this->db->bind(':id', $request['id']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function getGuidanceRequestsCount() {
		$this->db->query("SELECT COUNT(id) as count FROM consultations WHERE status='pending' AND department='Guidance'");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getClinicRequestsCount() {
		$this->db->query("SELECT COUNT(id) as count FROM consultations WHERE status='pending' AND department='Clinic'");

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function getProfessorRequestsCount($id) {
		$this->db->query("SELECT COUNT(id) as count FROM consultations WHERE status='pending' AND adviser_id=:id");
		$this->db->bind(':id', $id);
		
		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	private function removeFileFromExisting($fileToDelete, $existing) {
		$existing = explode(',', $existing);

		foreach($existing as $key => &$filepath) {
			$file = explode('/', $filepath);
			$filename = end($file);

			if($filename === $fileToDelete) {	
				unset($existing[$key]);
			}
		} 
		return implode(',', $existing);
	}

	private function validateAddRequest($request) {
		if(empty($request['creator'])) {
			return 'We cannot find your Student ID';
		}

		if(empty($request['purpose'])) {
			return 'Purpose is required';
		}

		if(empty($request['problem'])) {
			return 'Problem is required';
		}

		if(empty($request['department'])) {
			return 'Department is required';
		}

		if(($request['department'] != 'Guidance' && $request['department'] != 'Clinic') && empty($request['subject'])) {
			return 'Subject Code is required';
		}

		if(($request['department'] != 'Guidance' && $request['department'] != 'Clinic') && empty($request['adviser-id'])) {
			return 'Adviser is required';
		}

		if(empty($request['preferred-date'])) {
			return 'Preferred Date is required';
		} 

		if(empty($request['preferred-time'])) {
			return 'Preferred Time is required';
		}
	}

	private function validateEditRequest($request) {

		if(empty($request['purpose'])) {
			return 'Purpose is required';
		}

		if(empty($request['problem'])) {
			return 'Problem is required';
		}

		if(empty($request['department'])) {
			return 'Department is required';
		}

		if(($request['department'] != 'Guidance' && $request['department'] != 'Clinic') && empty($request['subject'])) {
			return 'Subject Code is required';
		}

		if(($request['department'] != 'Guidance' && $request['department'] != 'Clinic') && empty($request['adviser-id'])) {
			return 'Adviser is required';
		}

		if(empty($request['preferred-date'])) {
			return 'Preferred Date is required';
		} 

		if(empty($request['preferred-time'])) {
			return 'Preferred Time is required';
		}
	}
}

?>