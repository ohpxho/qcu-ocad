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

		<div class="flex justify-center w-full h-full px-2 md:px-0 overflow-y-scroll bg-neutral-100">
			<div class="fixed z-10 w-full h-full top-0 left-0 flex items-center	justify-center">
				<img class="opacity-10 w-1/3" src="<?php echo URLROOT;?>/public/assets/img/logo.png">
			</div>

			<div class="min-h-full w-full md:w-10/12 py-14 z-20">
				<?php
					if($_SESSION['type'] == 'student') {
						require APPROOT.'/views/consultation/records/student/index.php';
					} else {
						require APPROOT.'/views/consultation/records/adviser/index.php';
					}
				?>
			</div>
		</div>
	</div>

</main>

