

<a href="<?php echo URLROOT; ?>/consultation/records">
	<li class="flex py-1 px-2 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['consultation-records-nav-active'] ?>">
		<p>Online Consultation</p>
	</li>
</a>

<!-- <a href="<?php echo URLROOT; ?>/consultation/request">
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['consultation-request-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Pending</p>
		</div>

		<div id="consultation-req-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
			<span class="text-center text-[10px]"></span>
		</div>
	</li>
</a>	 -->

<a href="<?php echo URLROOT; ?>/consultation/active">
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['consultation-active-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Active</p>
		</div>
		<div id="consultation-active-alert" class="flex items-center text-white justify-center rounded-full bg-blue-600 h-4 w-4 hidden">
			<span class="text-center text-[10px]">!</span>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/consultation/resolved">
	<li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-resolved-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Resolved</p>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/consultation/declined">
	<li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-declined-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Declined</p>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/consultation/cancelled">
	<li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-cancelled-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Cancelled</p>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/consultation/schedule">
	<li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-schedule-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Schedule</p>
		</div>
	</li>
</a>


<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/professor/professor.js';
	?>
</script>