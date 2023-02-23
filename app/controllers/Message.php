<?php

class Message extends Controller {
	public function __construct() {
		$this->Message = $this->model('Messages');
	}

	public function send() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$msg = [
				'consultation-id' => trim($post['id']),
				'sender' => trim($post['sender']),
				'receiver' => trim($post['receiver']),
				'message' => trim($post['message'])
			];

			$result = $this->Message->save($msg);

			if($result) {
				echo json_encode('');
				return;
			}

			echo json_encode('Something went wrong, please try again.');
			return;
		}
	}

	public function seen_unseen() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$id = trim($post['id']);

			$result = $this->Message->seen_unseen($id);

			if($result) {
				echo json_encode('');
				return;
			};
		}

		echo json_encode('Fail to update unseen messages to seen. Please report if error occurs frequently.');
	}

	public function count_unseen() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$id = trim($post['id']);

			$result = $this->Message->count_unseen($id);

			if($result) {
				echo json_encode($result->count);
				return;
			}
		}
		
		echo json_encode('Fail to count unseen messages. Please report if error occurs frequently.');
	}
}



?>