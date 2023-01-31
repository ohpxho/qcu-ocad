<?php
	
if(isset($_SESSION['id'])) {
	require APPROOT.'/views/layout/horizontal-navigation/with.session.php';
} else {
	require APPROOT.'/views/layout/horizontal-navigation/no.session.php';
}

?>