<?php


function formatYearLevel($year) {
	switch($year) {
		case 1: 
			return '1st';
		case 2:
			return '2nd';
		case 3: 
			return '3rd';
		case 4:
			return '4th';
	}

	return '';
}

function formatUnivId($id) {
	return substr_replace($id, '-', 2, 0);	
}

function formatRequestId($id) {
	if($id < 10) return '0'.$id;
	return $id;
}

function generateRandomPassword() {
	$length = 8;
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$password = '';
	for ($i = 0; $i < $length; $i++) {
		$password .= $chars[rand(0, strlen($chars) - 1)];
	}
	return $password;
}

?>