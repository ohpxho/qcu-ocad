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

?>