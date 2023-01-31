

<!-------------------------------- admin ---------------------------------->

<?php

if($_SESSION['type'] == 'registrar'):

?>
		
	<a href="<?php echo URLROOT; ?>/academic_document" >
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['document-nav-active'] ?>">
			<p>Academic Document</p>
		</li>
	</a>

<?php

endif;

?>

<!-------------------------------- student ------------------------------->

<?php 

if($_SESSION['type'] == 'student'):
	
?>

	<a href="<?php echo URLROOT; ?>/academic_document" >
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['document-nav-active'] ?>">
			<p>Academic Documents</p>
		</li>
	</a>

<?php

endif;

?>