<?php
	
if(isset($_SESSION['id'])) {
	require APPROOT.'/views/layout/adminhorizontal-navigation/with.session.php';
} else {
	require APPROOT.'/views/layout/adminhorizontal-navigation/no.session.php';
}

?>