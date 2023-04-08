<?php


function formatDateTimeOfChat($dt) {
	date_default_timezone_set('Asia/Manila');
	$from = new DateTime($dt);
	$to = new DateTime(date('Y-m-d'));

	$interval = calculateDateDiffInDays($from, $to);
	
	if(intval($interval->d) == 0) {
	
		return $from->format('h:i A');
	
	} elseif(intval($interval->d) < 7) {

		return $from->format('D \A\T h:i A');

	} 

	return $from->format('M d \A\T h:i A');
}

function getDayDiff($dt) {
	date_default_timezone_set('Asia/Manila');
	$from = new DateTime($dt);
	$to = new DateTime(date('Y-m-d'));

	$interval = calculateDateDiffInDays($from, $to);

	return intval($interval->d);
}

function formatDate($dt) {
	date_default_timezone_set('Asia/Manila');
	$dt = new DateTime($dt);
	
	return $dt->format('d F Y');
}

function formatTime($time) {
	date_default_timezone_set('Asia/Manila');
	$dt = new DateTime($time);

	return $dt->format('h:i A');
}

function calculateDateDiffInDays($from, $to) {
	return $from->diff($to);
}

?>