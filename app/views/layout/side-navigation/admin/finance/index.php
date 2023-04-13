<p class="flex py-1 px-2 text-slate-400 text-normal rounded-sm">Student Account Documents</p>

<a href="<?php echo URLROOT; ?>/student_account/pending" >
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-pending-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Pending</p>
		</div>
		<div id="pending-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
			<span class="text-center text-[10px]"></span>
		</div>
	</li>
</a>

<!-- <a href="<?php echo URLROOT; ?>/student_account/accepted" >
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-accepted-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Accepted</p>
		</div>
		<div id="accepted-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
			<span class="text-center text-[10px]"></span>
		</div>
	</li>
</a> -->

<a href="<?php echo URLROOT; ?>/student_account/forprocess" >
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-inprocess-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>For Process</p>
		</div>
		<div id="inprocess-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
			<span class="text-center text-[10px]"></span>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/student_account/forclaiming" >
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-forclaiming-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>For Claiming</p>
		</div>
		<div id="forclaiming-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
			<span class="text-center text-[10px]"></span>
		</div>
	</li>
</a>

<!-- <a href="<?php echo URLROOT; ?>/student_account/completed" >
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-completed-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Completed</p>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/student_account/declined" >
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-declined-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Declined</p>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/student_account/cancelled" >
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-cancelled-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>Cancelled</p>
		</div>
	</li>
</a> -->

<a href="<?php echo URLROOT; ?>/student_account/records" >
	<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-records-nav-active'] ?>">
		<div class="flex gap-1">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
			  <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
			</svg>

			<p>History</p>
		</div>
	</li>
</a>


<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/admin/finance/finance.js';
	?>
</script>