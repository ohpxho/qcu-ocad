<?php

if(empty($_SESSION['pic'])):

?>

	<div class='flex items-center justify-center w-full rounded-sm h-full bg-slate-300 text-slate-500'>
		<?php
			echo strtoupper($_SESSION['fname'][0]);
		?>
	</div>

<?php

else:

?>

	<img src="<?php echo $_SESSION['pic']; ?>" class="h-full w-full object-cover"/>

<?php

endif;

?>