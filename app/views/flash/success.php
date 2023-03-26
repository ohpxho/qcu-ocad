<?php
	$hide = 'hidden';
	if(!empty($data['flash-success-message'])) $hide = '';
?>

<div id="flash-success" class="flex justify-between items-center pl-5 w-full px-3 py-2 text-green-700 bg-green-200 mt-5 <?php echo $hide;?>">
	<div class="flex gap-2 items-center">
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
 		 	<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
		</svg>

		<p id="flash-message" class="text-green-700"><?php echo $data['flash-success-message']?></p>
	</div>
	<span class="flash-close-btn text-green-700 cursor-pointer">
    	<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  			<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
		</svg>
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