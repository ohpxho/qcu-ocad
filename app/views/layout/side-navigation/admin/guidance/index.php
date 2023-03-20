<li class="flex flex-col py-1 rounded-sm">
	<a id="document-request-dropdown-btn" class=" flex items-center gap-2 justify-between hover:bg-slate-600 py-1 px-2">
		<p>Good Moral Requests</p>
		<span id="document-request-dropdown-icon">
		      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
		</span>
	</a>

	<ul id="document-request-menu" class="h-max overflow-hidden pl-1">
		<a href="<?php echo URLROOT; ?>/good_moral/pending" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-pending-nav-active'] ?>">
				<p>Pending</p>
				<div id="pending-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/good_moral/accepted" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-accepted-nav-active'] ?>">
				<p>Accepted</p>
				<div id="accepted-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/good_moral/inprocess" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-inprocess-nav-active'] ?>">
				<p>In Process</p>
				<div id="inprocess-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/good_moral/forclaiming" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-forclaiming-nav-active'] ?>">
				<p>For Claiming</p>
				<div id="forclaiming-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/good_moral/records" >
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['document-records-nav-active'] ?>">
				<p>Request Records</p>
				<div id="forclaiming-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>
	</ul>
</li>

<li class="flex flex-col py-1 rounded-sm">
	<a id="consultation-dropdown-btn" class=" flex items-center gap-2 justify-between hover:bg-slate-600 py-1 px-2">
		<p>Consultation</p>
		<span id="consultation-dropdown-icon">
		      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
		</span>
	</a>

	<ul id="consultation-menu" class="h-max overflow-hidden pl-1">
		<a href="<?php echo URLROOT; ?>/consultation/request">
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['consultation-request-nav-active'] ?>">
				<p>Consultation Requests</p>
				<div id="consultation-req-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>	

		<a href="<?php echo URLROOT; ?>/consultation/active">
			<li class="flex py-1 px-4 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['consultation-active-nav-active'] ?>">
				<p>Active Consultations</p>
				<div id="consultation-active-alert" class="flex items-center text-white justify-center rounded-full bg-blue-600 h-4 w-4 hidden">
					<span class="text-center text-[10px]">!</span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/consultation/records">
			<li class="flex py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['consultation-records-nav-active'] ?>">
				<p>Consultation Records</p>
			</li>
		</a>
	</ul>
</li>

<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/admin/guidance/guidance.js';
	?>
</script>