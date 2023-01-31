

<!-------------------------------- admin ---------------------------------->

<?php

if($_SESSION['type'] == 'guidance'):

?>
		
	<a href="<?php echo URLROOT; ?>/good_moral">
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['moral-nav-active'] ?>">
			<p>Good Moral</p>
		</li>
	</a>

<?php

endif;

?>

<!-------------------------------- student ------------------------------->

<?php 

if($_SESSION['type'] == 'student'):
	
?>

	<a href="<?php echo URLROOT; ?>/good_moral">
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['moral-nav-active'] ?>">
			<p>Good Moral</p>
		</li>
	</a>

<?php

endif;

?>