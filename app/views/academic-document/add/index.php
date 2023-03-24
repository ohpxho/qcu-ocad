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

		<?php
			if($_SESSION['type'] == 'student') {
				require APPROOT.'/views/academic-document/add/student/index.php';
			} else {
				require APPROOT.'/views/academic-document/add/alumni/index.php';
			}

		?>
	</div>
</main>
