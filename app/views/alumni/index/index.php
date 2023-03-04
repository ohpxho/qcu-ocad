<?php 

require APPROOT.'/views/layout/header.php';
require APPROOT.'/views/layout/horizontal-navigation/index.php';

?>

<div class="w-full h-full">
	<div class="flex items-center justify-center w-full h-full">
		<div class="flex flex-col gap-2 p-2 border">
			<span>Student ID</span>
			<input class="" type="number" name="id"/>
			<button class="border">Submit</button>
		</div>
	</div>

	<div class="">
		<form id="profile-form">
			
		</form>
	</div>
</div>

<script>
	<?php require APPROOT.'/views/alumni/redirect.js'; ?>
	<?php require APPROOT.'/views/alumni/index/index.js'; ?>
</script>