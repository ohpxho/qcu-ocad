<li class="flex flex-col py-1 rounded-sm">
	<a id="document-request-dropdown-btn" class=" flex items-center gap-2 justify-between hover:bg-slate-600 py-1 px-2">
		<p>Document Requests</p>
		<span id="document-request-dropdown-icon">
		      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
		</span>
	</a>

	<ul id="document-request-menu" class="h-max overflow-hidden pl-1">
		<a href="<?php echo URLROOT; ?>/academic_document/pending" >
			<li class="flex items-center justify-between py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['document-pending-nav-active'] ?>">
				<p>Pending Requests</p>
				<div id="pending-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/academic_document/accepted" >
			<li class="flex items-center justify-between py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['document-accepted-nav-active'] ?>">
				<p>Accepted Requests</p>
				<div id="accepted-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/academic_document/inprocess" >
			<li class="flex items-center justify-between py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['document-inprocess-nav-active'] ?>">
				<p>Requests In Process</p>
				<div id="inprocess-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/academic_document/forclaiming" >
			<li class="flex items-center justify-between py-1 px-4 hover:bg-slate-600 rounded-sm <?php echo $data['document-forclaiming-nav-active'] ?>">
				<p>Requests For Claiming</p>
				<div id="forclaiming-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
					<span class="text-center text-[10px]"></span>
				</div>
			</li>
		</a>
	</ul>
</li>

<a href="<?php echo URLROOT; ?>/academic_document/records" >
	<li class="flex py-1 px-2 hover:bg-slate-600 rounded-sm <?php echo $data['document-records-nav-active'] ?>">
		<p>Document Request Records</p>
	</li>
</a>


<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/admin/registrar/registrar.js';
	?>
</script>