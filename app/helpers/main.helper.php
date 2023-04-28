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


function getDocumentRequestStatusDesign($status) {

	switch($status) {
		case 'pending':
			return '<span class="bg-yellow-500 text-white text-sm rounded-md px-1 status-btn cursor-pointer">pending</span>';
		case 'awaiting payment confirmation':
			return '<span class="bg-yellow-500 text-white text-sm rounded-md px-1 status-btn cursor-pointer">awaiting payment confirmation</span>';
		case 'for process':
			return '<span class="bg-orange-500 text-white text-sm rounded-md px-1 status-btn cursor-pointer">for process</span>';
		case 'for claiming':
			return '<span class="bg-sky-500 text-white text-sm rounded-md px-1 status-btn cursor-pointer">for claiming</span>';
		case 'rejected':
			return '<span class="bg-red-500 text-white text-sm rounded-md px-1 status-btn cursor-pointer">declined</span>';
		case 'cancelled':
			return '<span class="bg-red-500 text-white text-sm rounded-md px-1 status-btn cursor-pointer">cancelled</span>';
		case 'completed':
			return '<span class="bg-green-500 text-white text-sm rounded-md px-1 status-btn cursor-pointer">completed</span>';
	}
}

?>