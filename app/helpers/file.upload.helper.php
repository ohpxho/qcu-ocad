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

	function uploadMultipleDocument($files) {
		$path = [];
		$count = count($files['name']);

		for($i = 0; $i < $count; $i++) {
			$targetDir = str_replace('\\', '/', WEBROOT).'/public/assets/document/';
			$targetFile = $targetDir.basename($files['name'][$i]);
			if (move_uploaded_file($files["tmp_name"][$i], $targetFile)) {
	    		array_push($path, '/public/assets/document/'.basename($files['name'][$i]));
	    	}
    	}

    	if(count($path) > 0) return implode(',', $path);

    	return '';		
	}


?>
