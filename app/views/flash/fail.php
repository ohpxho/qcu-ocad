<?php
	$hide = 'hidden';
	if(!empty($data['flash-error-message'])) $hide = '';
?>

<div id="flash-error" class="flex justify-between items-center w-full py-2 bg-red-100 mt-5 text-red-700 px-3 <?php echo $hide; ?>">
	<div class="flex gap-2 items-center">
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  			<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
		</svg>

		<p id="flash-message"><?php echo $data['flash-error-message']?></p>
	</div>
	<span class="flash-close-btn text-red-700 cursor-pointer">
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