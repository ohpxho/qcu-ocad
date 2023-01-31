

<!-------------------------------- admin ---------------------------------->

<?php

if($_SESSION['type'] == 'finance'):

?>
		
	<a href="<?php echo URLROOT; ?>/statement_of_account">
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['soa-nav-active'] ?>">
			<p>Statement of Account</p>
		</li>
	</a>

<?php

endif;

?>

<!-------------------------------- student ------------------------------->

<?php 

if($_SESSION['type'] == 'student'):
	
?>

	<a href="<?php echo URLROOT; ?>/statement_of_account">
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['soa-nav-active'] ?>">
			<p>Statement of Account</p>
		</li>
	</a>

<?php

endif;

?>