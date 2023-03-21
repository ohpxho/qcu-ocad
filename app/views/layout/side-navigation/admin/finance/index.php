<li class="flex flex-col py-1 rounded-sm">
	<p class="flex items-center gap-2 justify-between rounded-sm hover:bg-slate-600 py-1 px-2 <?php echo $data['document-records-nav-active'] ?>">
		<a href="<?php echo URLROOT; ?>/student_account/records">Student Account Documents</a>
		<span id="document-request-dropdown-btn" class="document-request-dropdown-icon">
		      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
		</span>
	</p>

	<ul id="document-request-menu" class="h-max overflow-hidden pl-1">
		<a href="<?php echo URLROOT; ?>/student_account/pending" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-pending-nav-active'] ?>">
				<p>Pending</p>
				<div id="pending-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/student_account/accepted" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-accepted-nav-active'] ?>">
				<p>Accepted</p>
				<div id="accepted-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/student_account/inprocess" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-inprocess-nav-active'] ?>">
				<p>In Process</p>
				<div id="inprocess-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/student_account/forclaiming" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-forclaiming-nav-active'] ?>">
				<p>For Claiming</p>
				<div id="forclaiming-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/student_account/completed" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-completed-nav-active'] ?>">
				<p>Completed</p>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/student_account/declined" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-declined-nav-active'] ?>">
				<p>Declined</p>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/student_account/cancelled" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-cancelled-nav-active'] ?>">
				<p>Cancelled</p>
			</li>
		</a>
	</ul>
</li>

<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/admin/finance/finance.js';
	?>
</script>