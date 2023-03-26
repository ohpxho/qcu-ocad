<?php
	require APPROOT.'/views/layout/header.php';
?>

<main class="w-full flex flex-con h-full overflow-hidden">

	<!-------------------------------------- side navigation ----------------------------------------------------------------->
	
	<?php
		require APPROOT.'/views/layout/side-navigation/index.php';
	?>

	<!-------------------------------------- main content -------------------------------------------------------------------->
	
	<div class="w-full h-full">
		<?php
			require APPROOT.'/views/layout/horizontal-navigation/index.php';
		?>

		<div class="flex justify-center w-full h-full overflow-y-scroll bg-neutral-100">
				<div class="fixed z-10 w-full h-full top-0 left-0 flex items-center	justify-center">
					<img class="opacity-10 w-1/3 " src="<?php echo URLROOT;?>/public/assets/img/logo.png">
				</div>

			<div class="min-h-full z-20 w-10/12 py-14">
				<?php
					switch($_SESSION['type']) {
						case 'student':
							require APPROOT.'/views/user/dashboard/student/student.php';
							break;
						case 'alumni':
							require APPROOT.'/views/user/dashboard/alumni/alumni.php';
							break;
						case 'professor':
							require APPROOT.'/views/user/dashboard/professor/professor.php';
							break;
						case 'sysadmin':
							require APPROOT.'/views/user/dashboard/sysadmin/sysadmin.php';
						default:
							require APPROOT.'/views/user/dashboard/admin/admin.php';
					}
				?>
			</div>
		</div>
	</div>

</main>

