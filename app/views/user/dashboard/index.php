<?php
	require APPROOT.'/views/layout/header.php';
?>

<main class="flex flex-con h-full w-full overflow-hidden">

	<!-------------------------------------- side navigation ----------------------------------------------------------------->
	
	<?php
		require APPROOT.'/views/layout/side-navigation/index.php';
	?>

	<!-------------------------------------- main content -------------------------------------------------------------------->
	
	<div class="w-full h-full">
		<?php
			require APPROOT.'/views/layout/horizontal-navigation/index.php';
		?>

		<div class="flex justify-center w-full h-full overflow-y-scroll">
			<div class="min-h-full w-10/12 py-14">
				<?php
					switch($_SESSION['type']) {
						case 'student':
							require APPROOT.'/views/user/dashboard/student/student.php';
							break;
						case 'professor':
							require APPROOT.'/views/user/dashboard/professor/professor.php';
							break;
						default:
							require APPROOT.'/views/user/dashboard/admin/admin.php';
					}
				?>
			</div>
		</div>
	</div>

</main>

