
<p class="flex py-1 px-2 text-slate-400 text-normal rounded-sm">Document Request</p>

<a href="<?php echo URLROOT; ?>/academic_document"><li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['document-nav-active'] ?>">
	<div class="flex gap-1">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
		  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
		</svg>

		<p>Academic Documents</p>
	</div>
</li></a>	

<a href="<?php echo URLROOT; ?>/good_moral"><li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['moral-nav-active'] ?>">
	<div class="flex gap-1">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
		  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
		</svg>

		<p>Good Moral Certificate</p>
	</div>
</li></a>

<a href="<?php echo URLROOT; ?>/student_account"><li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['soa-nav-active'] ?>">
	<div class="flex gap-1">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
		  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
		</svg>

		<p>Student Account Documents</p>
	</div>
</li></a>

<p class="flex py-1 px-2 text-slate-400 text-normal rounded-sm">Online Consultation</p>

<a href="<?php echo URLROOT; ?>/consultation/request"><li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-request-nav-active'] ?>">
	<div class="flex gap-1">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
		  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
		</svg>

		<p>Request Consultation</p>
	</div>
</li></a>	

<a href="<?php echo URLROOT; ?>/consultation/active">
	<li class="flex py-1 justify-between items-center px-4 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-active-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Active Consultation</p>
		</div>
		<div id="consultation-active-alert" class="flex items-center text-white justify-center rounded-full bg-blue-600 h-4 w-4 hidden">
			<span class="text-center text-[10px]">!</span>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/consultation/records"><li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-records-nav-active'] ?>">
	<div class="flex gap-1">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
		  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
		</svg>

		<p>Consultation Records</p>
	</div>
</li></a>


<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/student/student.js';
	?>
</script>