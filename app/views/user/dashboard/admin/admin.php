<?php


switch($_SESSION['type']) {
	case 'guidance':
		require APPROOT.'/views/user/dashboard/admin/guidance/index.php';
		break;
	case 'finance':
		require APPROOT.'/views/user/dashboard/admin/finance/index.php';
		break;
	case 'registrar':
		require APPROOT.'/views/user/dashboard/admin/registrar/index.php';
		break;
	case 'clinic':
		require APPROOT.'/views/user/dashboard/admin/clinic/index.php';
		break;
}


?>