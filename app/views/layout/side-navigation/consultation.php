

<!-------------------------------- admin ---------------------------------->

<?php

if($_SESSION['type'] != 'student' && $_SESSION['type'] != 'finance' && $_SESSION['type'] != 'registrar'):

?>
		
	<li class="flex flex-col py-1 text-slate-700 rounded-sm">
		<a id="consultation-dropdown-btn" class=" flex items-center gap-2 justify-between hover:bg-slate-200 py-1 px-2">
			<p>Consultation</p>
			<span id="consultation-dropdown-icon">
			      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
			</span>
		</a>

		<ul id="consultation-menu" class="h-max overflow-hidden">
			<a href="<?php echo URLROOT; ?>/consultation/requests"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['request-nav-active'] ?>">
				<p>Consultation Requests</p>
			</li></a>	

			<a href="<?php echo URLROOT; ?>/consultation/ongoing"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['ongoing-nav-active'] ?>">
				<p>Ongoing Consultations</p>
			</li></a>
		</ul>
	</li>

<?php

endif;

?>

<!-------------------------------- student ------------------------------->

<?php 

if($_SESSION['type'] == 'student'):
	
?>

	<li class="flex flex-col py-1 text-slate-700 rounded-sm">
		<a id="consultation-dropdown-btn" class=" flex items-center gap-2 justify-between hover:bg-slate-200 py-1 px-2">
			<p>Consultation</p>
			<span id="consultation-dropdown-icon">
			      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
			</span>
		</a>

		<ul id="consultation-menu" class="h-max overflow-hidden">
			<a href="<?php echo URLROOT; ?>/consultation/request"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['request-nav-active'] ?>">
				<p>Request Consultation</p>
			</li></a>	

			<a href="<?php echo URLROOT; ?>/consultation/ongoing"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['ongoing-nav-active'] ?>">
				<p>Ongoing Consultations</p>
			</li></a>
		</ul>
	</li>

<?php

endif;

?>