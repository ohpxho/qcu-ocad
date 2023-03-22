
<p class="flex py-1 px-2 text-slate-400 text-normal rounded-sm">Document Request</p>

<a href="<?php echo URLROOT; ?>/academic_document"><li class="flex py-1 px-6 hover:bg-slate-600 rounded-sm <?php echo $data['document-nav-active'] ?>">
	<p>Academic Documents</p>
</li></a>	

<a href="<?php echo URLROOT; ?>/good_moral"><li class="flex py-1 px-6 hover:bg-slate-600 rounded-sm <?php echo $data['moral-nav-active'] ?>">
	<p>Good Moral Certificate</p>
</li></a>

<a href="<?php echo URLROOT; ?>/student_account"><li class="flex py-1 px-6 hover:bg-slate-600 rounded-sm <?php echo $data['soa-nav-active'] ?>">
	<p>Student Account Documents</p>
</li></a>

<p class="flex py-1 px-2 text-slate-400 text-normal rounded-sm">Online Consultation</p>

<a href="<?php echo URLROOT; ?>/consultation/request"><li class="flex py-1 px-6 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-request-nav-active'] ?>">
	<p>Request Consultation</p>
</li></a>	

<a href="<?php echo URLROOT; ?>/consultation/active">
	<li class="flex py-1 justify-between items-center px-6 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-active-nav-active'] ?>">
		<p>Active Consultations</p>
		<div id="consultation-active-alert" class="flex items-center text-white justify-center rounded-full bg-blue-600 h-4 w-4 hidden">
			<span class="text-center text-[10px]">!</span>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/consultation/records"><li class="flex py-1 px-6 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-records-nav-active'] ?>">
	<p>Consultation Records</p>
</li></a>


<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/student/student.js';
	?>
</script>