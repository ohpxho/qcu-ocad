<?php
	$hide = 'hidden';
	if(!empty($data['flash-error-message'])) $hide = '';
?>

<div id="flash-error" class="flex justify-between items-center w-full p-1 py-2 bg-red-200 mt-5 pl-5 <?php echo $hide; ?>">
	<p id="flash-message" class="text-red-700"><?php echo $data['flash-error-message']?></p>
	<span class="flash-close-btn">
    	<svg class="fill-current h-5 w-5 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  	</span>
</div>

<!-------------------------------------- script ---------------------------------->

<script>
	
	$(document).ready(function() {
		
		/**
	 	* hide flash message when user clicks the exit button 
		**/

		$('.flash-close-btn').click(function() {
			$(this).closest('div').addClass('hidden');
		});
	});

</script>