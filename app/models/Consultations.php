<?php


class Consultations {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($request) {
		
		$validate = $this->validateAddRequest($request);

		if(empty($validate)) {

			$this->db->query("INSERT INTO consultations (creator, creator_name, purpose, problem, department, subject, adviser_id, adviser_name, schedule, start_time, mode, shared_file_from_student) VALUES (:creator, :creator_name, :purpose, :problem, :department, :subject, :adviser_id, :adviser_name, :schedule, :start_time, :mode, :shared_file)");
			
			$this->db->bind(':creator', $request['creator']);
			$this->db->bind(':creator_name', ucwords($request['creator-name']));
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':problem', $request['problem']);
			$this->db->bind(':department', $request['department']);
			$this->db->bind(':subject', $request['subject']);
			$this->db->bind(':adviser_id', $request['adviser-id']);
			$this->db->bind(':adviser_name', ucwords($request['adviser-name']));
			$this->db->bind(':schedule', $request['schedule']);
			$this->db->bind(':start_time', $request['start-time']);
			$this->db->bind(':mode', $request['mode']);
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
			$this->db->query("UPDATE consultations SET purpose=:purpose, problem=:problem, department=:department, subject=:subject, adviser_id=:adviser_id, adviser_name=:adviser_name, schedule=:schedule, start_time=:start_time, mode=:mode, shared_file_from_student=:shared_file WHERE id=:id");
			$this->db->bind(':id', $request['id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':problem', $request['problem']);
			$this->db->bind(':department', $request['department']);
			$this->db->bind(':subject', $request['subject']);
			$this->db->bind(':adviser_id', $request['adviser-id']);
			$this->db->bind(':adviser_name', $request['adviser-name']);
			$this->db->bind(':shared_file', $request['document']);
			$this->db->bind(':schedule', $request['schedule']);
			$this->db->bind(':mode', $request['mode']);
			$this->db->bind(':start_time', $request['start-time']);
			

			$result = $this->db->execute();

			if($result) {
				return '';
			}

			return 'Some eror occured while updating consultation, please try again';

		} else {
			return $validate;
		}
	}

	public function update($request) {
		if(!empty($request['status'])) {
			if(!empty($request['adviser-id'])) {
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

	public function updateByProfessor($request) {
		if(!empty($request['status'])) {
			
			if($request['status'] !== 'active') {
				$this->db->query("UPDATE consultations SET status=:status, remarks=:remarks, date_completed=NOW() WHERE id=:id");
			} else {
				$this->db->query("UPDATE consultations SET status=:status, remarks=:remarks WHERE id=:id");
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

	public function updateByAdmin($request) {
		if(!empty($request['status'])) {
			
			if($request['status'] !== 'active') {
				$this->db->query("UPDATE consultations SET adviser_id=:adviser_id, adviser_name=:adviser_name, status=:status, remarks=:remarks, date_completed=NOW() WHERE id=:id");
			} else {
				$this->db->query("UPDATE consultations SET adviser_id=:adviser_id, adviser_name=:adviser_name, status=:status, remarks=:remarks WHERE id=:id");
			}

			$this->db->bind(':adviser_id', $request['adviser-id']);
			$this->db->bind(':adviser_name', $request['adviser-name']);
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

	public function updateLink($details) {
		$validate = $this->validateUpdateLinkInputs($details);

		if(empty($validate)) {
			$this->db->query("UPDATE consultations SET gmeet_link=:link WHERE id=:id");
			$this->db->bind(':link', $details['link']);
			$this->db->bind(':id', $details['id']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while updating gmeet link, please try again';
		}

		return $validate;
	}

	private function validateUpdateLinkInputs($details) {
		if(empty($details['id'])) return 'A problem occured, please try again';
		//if(empty($details['link'])) return 'Gmeet link is required';

		return '';
	}

	public function reschedule($details) {
		$validate = $this->validateRecheduleInputs($details);
		if(empty($validate)) {
			$this->db->query('UPDATE consultations SET schedule=:schedule, start_time=:start_time WHERE id=:id');
			$this->db->bind(':schedule', $details['schedule']);
			$this->db->bind(':start_time', $details['start-time']);
			$this->db->bind(':id', $details['request-id']);

			$result = $this->db->execute();

			if($result) return '';

			return 'Some error occured while rescheduling consultation, please try again';
		} 

		return $validate;
	}

	private function validateRecheduleInputs($details) {
		if(empty($details['request-id']) || empty($details['schedule']) || empty($details['start-time'])) return 'Some error occured while rescheduling consultation, please try again';
		return '';
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
		$this->db->query("UPDATE consultations SET status='unresolved', date_completed=NOW() WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function getAnnualConsultationStatusFrequencyOfStudent($id) {
		$this->db->query("SELECT YEAR(date_requested) as year, MONTH(date_requested) as month, COUNT(CASE WHEN status='resolved' THEN 1 ELSE NULL END) as resolved, COUNT(CASE WHEN status='unresolved' THEN 1 ELSE NULL END) as cancelled FROM consultations WHERE creator=:id GROUP BY YEAR(date_requested), MONTH(date_requested) ORDER BY YEAR(date_requested), MONTH(date_requested)");
		
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getDayRequestStatusFrequencyOfStudent($id) {

	}

	public function getAnnualConsultationStatusFrequencyOfAdviser($id) {
		$this->db->query("SELECT YEAR(date_requested) as year, MONTH(date_requested) as month, COUNT(CASE WHEN status='resolved' THEN 1 ELSE NULL END) as resolved, COUNT(CASE WHEN status='unresolved' THEN 1 ELSE NULL END) as cancelled, COUNT(CASE WHEN status='rejected' THEN 1 ELSE NULL END) as rejected FROM consultations WHERE adviser_id=:id GROUP BY YEAR(date_requested), MONTH(date_requested) ORDER BY YEAR(date_requested), MONTH(date_requested)");
		
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getDayRequestStatusFrequencyOfAdviser($id) {
		$this->db->query("SELECT YEAR(date_requested) as year, MONTH(date_requested) as month, DAY(date_requested) as day, COUNT(CASE WHEN status='resolved' THEN 1 ELSE NULL END) as resolved, COUNT(CASE WHEN status='unresolved' THEN 1 ELSE NULL END) as cancelled, COUNT(CASE WHEN status='rejected' THEN 1 ELSE NULL END) as rejected FROM consultations WHERE adviser_id=:id GROUP BY DAY(date_requested) ORDER BY YEAR(date_requested), MONTH(date_requested)");

		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}


	public function getAnnualConsultationStatusFrequencyOfSysAdmin() {
		$this->db->query("SELECT YEAR(date_requested) as year, MONTH(date_requested) as month, COUNT(CASE WHEN status='resolved' THEN 1 ELSE NULL END) as resolved, COUNT(CASE WHEN status='unresolved' THEN 1 ELSE NULL END) as cancelled, COUNT(CASE WHEN status='rejected' THEN 1 ELSE NULL END) as rejected FROM consultations GROUP BY YEAR(date_requested), MONTH(date_requested) ORDER BY YEAR(date_requested), MONTH(date_requested)");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getDayRequestStatusFrequencyOfSysAdmin() {
		$this->db->query("SELECT YEAR(date_requested) as year, MONTH(date_requested) as month, DAY(date_requested) as day, COUNT(CASE WHEN status='resolved' THEN 1 ELSE NULL END) as resolved, COUNT(CASE WHEN status='rejected' THEN 1 ELSE NULL END) as rejected, COUNT(CASE WHEN status='unresolved' THEN 1 ELSE NULL END) as cancelled FROM consultations GROUP BY DAY(date_requested) ORDER BY YEAR(date_requested), MONTH(date_requested)");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

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
	
	public function getHistoryOfStudent($id) {
		$this->db->query("SELECT *, YEAR(date_requested) as year, MONTH(date_requested) as month, DAY(date_requested) as day FROM consultations WHERE creator=:id AND (status='resolved' OR status='unresolved') ORDER BY YEAR(date_requested), MONTH(date_requested)");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getHistoryOfAdviser($id) {
		$this->db->query("SELECT *, YEAR(date_requested) as year, MONTH(date_requested) as month, DAY(date_requested) as day FROM consultations WHERE adviser_id=:id AND (status='resolved' OR status='unresolved') ORDER BY YEAR(date_requested), MONTH(date_requested)");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function getHistoryOfSysAdmin() {
		$this->db->query("SELECT *, YEAR(date_requested) as year, MONTH(date_requested) as month, DAY(date_requested) as day FROM consultations WHERE status='resolved' OR status='unresolved' ORDER BY YEAR(date_requested), MONTH(date_requested)");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findUpcomingConsultationOfStudent($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND schedule=NOW() AND status='active'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findUpcomingConsultationOfAdviser($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND schedule=NOW() AND status='active'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findUpcomingConsultationForSystemAdmin() {
		$this->db->query("SELECT * FROM consultations WHERE schedule=NOW() AND status='active'");
		
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
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='pending' ORDER BY schedule ASC, start_time ASC");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;		
	}

	public function findAllPendingRequestOfGuidance() {
		$this->db->query("SELECT * FROM consultations WHERE department='guidance' AND status='pending' ORDER BY schedule ASC, start_time ASC");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;		
	}

	public function findAllPendingRequestOfClinic() {
		$this->db->query("SELECT * FROM consultations WHERE department='clinic' AND status='pending' ORDER BY schedule ASC, start_time ASC");

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
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='active' ORDER BY schedule ASC,start_time ASC");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllResolvedRequestByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND status='resolved'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllResolvedRequestByAdviserId($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='resolved'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllDeclinedRequestByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND status='rejected'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllDeclinedRequestByAdviserId($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='rejected'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllCancelledRequestByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND status='unresolved'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllCancelledRequestByAdviserId($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='unresolved'");
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
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND (status='resolved' OR status='rejected' OR status='unresolved') ORDER BY (date_completed) DESC");
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

	public function findAllActiveConsultationOfAdvisor($advisor) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:adviser_id AND (status='active' OR status='pending')");
		$this->db->bind(':adviser_id', $advisor);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;

		return false;
	}

	public function findAllActiveConsultationOfDepartment($department) {
		$this->db->query("SELECT * FROM consultations WHERE department=:department AND (status='active' OR status='pending')");
		$this->db->bind(':department', $department);

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

	public function findConsultationAcceptanceByAdvisor($advisor) {
		$this->db->query("SELECT * FROM consultation_acceptance WHERE advisor=:advisor");
		$this->db->bind(':advisor', $advisor);

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

	public function findConsultationAcceptanceStatus($advisor) {
		$this->db->query("SELECT * from consultation_acceptance WHERE advisor=:advisor");
		$this->db->bind(':advisor',$advisor);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;

		return false;
	}

	public function start($advisor) {
		$this->db->query("UPDATE consultation_acceptance SET status='open' WHERE advisor=:advisor");
		$this->db->bind(':advisor', $advisor);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function stop($advisor) {
		$this->db->query("UPDATE consultation_acceptance SET status='closed' WHERE advisor=:advisor");
		$this->db->bind(':advisor', $advisor);

		$result = $this->db->execute();

		if($result) return true;

		return false;
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

		if(empty($request['schedule'])) {
			return 'You need to appoint a date of consultation';
		} 

		if(empty($request['mode'])) {
			return 'Preferred mode of consultation is required';
		} 

		if(empty($request['start-time'])) {
			return 'You need to appoint a time of consultation';
		}

		if($this->checkIfScheduleHasBeenPicked($request['schedule'], $request['start-time'])) return 'Schedule has been appointed already';
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

		if(empty($request['schedule'])) {
			return 'You need to appoint a date of consultation';
		} 

		if(empty($request['mode'])) {
			return 'Preferred mode of consultation is required';
		} 

		if(empty($request['start-time'])) {
			return 'You need to appoint a time of consultation';
		}

		if($this->checkIfScheduleHasBeenPicked($request['schedule'], $request['start-time'])) return 'Schedule has been appointed already';
	}

	private function checkIfScheduleHasBeenPicked($dt, $tm) {
		$this->db->query("SELECT * FROM consultations WHERE schedule=:schedule AND start_time=:start_time");
		$this->db->bind(':schedule', $dt);
		$this->db->bind(':start_time', $tm);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return true;

		return false;
	}
}

?>