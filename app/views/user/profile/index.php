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

		<div class="flex justify-center w-full h-full px-2 md:px-0 overflow-y-scroll">
			<div class="min-h-full md:w-10/12 w-full py-14">
				<?php
					switch($_SESSION['type']) {
						case 'student':
							require APPROOT.'/views/user/profile/student/index.php';
							break;
						case 'alumni':
							require APPROOT.'/views/user/profile/alumni/index.php';
							break;
						case 'professor':
							require APPROOT.'/views/user/profile/professor/index.php';
							break;
						default:
							require APPROOT.'/views/user/profile/admin/index.php';
					}
				?>
			</div>
		</div>
	</div>

</main>

