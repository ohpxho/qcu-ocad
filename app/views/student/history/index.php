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

		<div class="flex justify-center w-full h-full overflow-y-scroll bg-slate-200">
			<div class="min-h-full z-20 w-10/12 py-14">
				<a href="<?php echo URLROOT?>/document_request/records">Document Request</a>
				<a href="<?php echo URLROOT?>/consultation/records">Online Consultation</a>
			</div>
		</div>
	</div>

</main>

<script>
	
</script>
