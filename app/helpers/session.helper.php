<?php

function redirect($PAGE) {
	if(isUserSessionExists() && $PAGE != 'PAGE_THAT_NEED_USER_SESSION') {
		header('location:'.URLROOT.'/user/dashboard');
	} 

	if(!isUserSessionExists() && $PAGE == 'PAGE_THAT_NEED_USER_SESSION'){
		header('location:'.URLROOT.'/home/index');
	}
}

function isUserSessionExists() {
	if(isset($_SESSION['id'])) return true;
	return false;
}

	

?>