<a href="<?php echo URLROOT; ?>/consultation/request">
	<li class="flex py-1 px-2 justify-between items-center hover:bg-slate-700 rounded-sm <?php echo $data['consultation-request-nav-active'] ?>">
		<p>Consultation Requests</p>
		<div id="consultation-req-count" class="flex items-center text-white justify-center rounded-full bg-red-500 h-4 w-4 hidden">
			<span class="text-center text-[10px]"></span>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/consultation/active">
	<li class="flex py-1 px-2 justify-between items-center hover:bg-slate-600 rounded-sm <?php echo $data['consultation-active-nav-active'] ?>">
		<p>Acitve Consultations</p>
		<div id="consultation-active-alert" class="flex items-center text-white justify-center rounded-full bg-blue-600 h-4 w-4 hidden">
			<span class="text-center text-[10px]">!</span>
		</div>
	</li>
</a>

<a href="<?php echo URLROOT; ?>/consultation/records">
	<li class="flex py-1 px-2 hover:bg-slate-700 rounded-sm <?php echo $data['consultation-records-nav-active'] ?>">
		<p>Consultation Records</p>
	</li>
</a>

<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/professor/professor.js';
	?>
</script>