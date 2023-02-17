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
					if($_SESSION['type'] == 'student') {
						require APPROOT.'/views/consultation/active/student/student.php';
					} 

					if($_SESSION['type'] == 'professor') {
						require APPROOT.'/views/consultation/active/professor/professor.php';
					}
				?>
			</div>
		</div>
	</div>

</main>

