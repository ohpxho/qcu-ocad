<div class="sticky flex flex-col gap-5 top-0 right-0 h-full w-2/6 px-5 py-5 border-l">
	<?php
		switch($_SESSION['type']) {
			case 'student':
				require APPROOT.'/views/user/dashboard/side/student/student.php';
				break;
			case 'professor':
				require APPROOT.'/views/user/dashboard/side/professor/professor.php';
				break;
			default:
				require APPROOT.'/views/user/dashboard/side/admin/admin.php';
		}
	?>
</div>
