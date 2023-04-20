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

		<div class="flex justify-center w-full h-full px-2 md:px-0 overflow-y-scroll bg-white">
			<div class="min-h-full w-full md:w-10/12 z-20 pt-5">
				<?php
					if($_SESSION['type'] == 'student') {
						require APPROOT.'/views/consultation/view/student/student.php';
					} elseif($_SESSION['type'] == 'professor') {

						require APPROOT.'/views/consultation/view/professor/professor.php';
					} else {
						require APPROOT.'/views/consultation/view/admin/admin.php';
					}
				?>

			</div>
		</div>
	</div>

</main>

