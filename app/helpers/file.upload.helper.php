<?php

	function uploadImage($file) {
		$targetDir = str_replace('\\', '/', WEBROOT).'/public/assets/img/uploads/';
		$targetFile = $targetDir.basename($file['name']);
		if (move_uploaded_file($file["tmp_name"], $targetFile)) {
    		return '/public/assets/img/uploads/'.basename($file['name']);
    	} else {
    		return '';
    	}		
	}

	function uploadDocument($file) {
		$targetDir = str_replace('\\', '/', WEBROOT).'/public/assets/document/';
		$targetFile = $targetDir.basename($file['name']);
		if (move_uploaded_file($file["tmp_name"], $targetFile)) {
    		return '/public/assets/document/'.basename($file['name']);
    	} else {
    		return '';
    	}		
	}

?>
