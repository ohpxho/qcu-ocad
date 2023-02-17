<?php if($_SESSION['type'] == 'guidance'):?>
	<a href="<?php echo URLROOT; ?>/good_moral">
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['moral-nav-active'] ?>">
			<p>Good Moral Requests</p>
		</li>
	</a>

	<li class="flex flex-col py-1 text-slate-700 rounded-sm">
		<a id="consultation-dropdown-btn" class=" flex items-center gap-2 justify-between hover:bg-slate-200 py-1 px-2">
			<p>Consultation</p>
			<span id="consultation-dropdown-icon">
			      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
			</span>
		</a>

		<ul id="consultation-menu" class="h-max overflow-hidden pl-2">
			<a href="<?php echo URLROOT; ?>/consultation/request"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['consultation-request-nav-active'] ?>">
			<p>Consultation Requests</p>
			</li></a>	

			<a href="<?php echo URLROOT; ?>/consultation/active"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['consultation-active-nav-active'] ?>">
				<p>Active Consultations</p>
			</li></a>

			<a href="<?php echo URLROOT; ?>/consultation/records"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['consultation-records-nav-active'] ?>">
				<p>Consultation Records</p>
			</li></a>
		</ul>
	</li>
<?php endif;?>

<?php if($_SESSION['type'] == 'registrar'): ?>
		
	<a href="<?php echo URLROOT; ?>/academic_document" >
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['document-nav-active'] ?>">
			<p>Academic Document</p>
		</li>
	</a>
<?php endif;?>

<?php if($_SESSION['type'] == 'finance'): ?>
	<a href="<?php echo URLROOT; ?>/statement_of_account">
		<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['soa-nav-active'] ?>">
			<p>Statement of Account</p>
		</li>
	</a>
<?php endif; ?>

<a href="<?php echo URLROOT; ?>/student_record" >
	<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['student-records-nav-active'] ?>">
		<p>Student Requests Records</p>
	</li>
</a>