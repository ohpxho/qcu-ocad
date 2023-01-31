

<!-------------------------------- admin ---------------------------------->

<?php

if($_SESSION['type'] == 'registrar' || $_SESSION['type'] == 'guidance' || $_SESSION['type'] == 'finance'):

?>
		
	<a href="<?php echo URLROOT; ?>/academic_document" >
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['student-records-nav-active'] ?>">
			<p>Student Records</p>
		</li>
	</a>

<?php

endif;

?>
