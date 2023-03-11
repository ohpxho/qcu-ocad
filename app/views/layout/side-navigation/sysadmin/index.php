<li class="flex flex-col py-1 text-slate-700 rounded-sm">
	<a id="document-request-dropdown-btn" class=" flex items-center gap-2 justify-between hover:bg-slate-200 py-1 px-2">
		<p>Document Request Records</p>
		<span id="document-request-dropdown-icon">
		      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
		</span>
	</a>

	<ul id="document-request-menu" class="h-max overflow-hidden pl-1">
		<a href="<?php echo URLROOT; ?>/academic_document/records">
			<li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['document-nav-active'] ?>">
				<p>Academic Document</p>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/good_moral/records">
			<li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['moral-nav-active'] ?>">
				<p>Good Moral</p>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/consultation/records">
			<li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['soa-nav-active'] ?>">
				<p>Statement Of Account</p>
			</li>
		</a>
	</ul>
</li>

<a href="<?php echo URLROOT; ?>/academic_document/records" >
	<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['consultation-records-nav-active'] ?>">
		<p>Consultation Records</p>
	</li>
</a>

<li class="flex flex-col py-1 text-slate-700 rounded-sm">
	<a id="document-request-dropdown-btn" class=" flex items-center gap-2 justify-between hover:bg-slate-200 py-1 px-2">
		<p>User Management</p>
		<span id="document-request-dropdown-icon">
		      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
		</span>
	</a>

	<ul id="document-request-menu" class="h-max overflow-hidden pl-1">
		<a href="<?php echo URLROOT; ?>/consultation/records">
			<li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['student-nav-active'] ?>">
				<p>Student</p>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/consultation/records">
			<li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['alumni-nav-active'] ?>">
				<p>Alumni</p>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/consultation/records">
			<li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['admin-nav-active'] ?>">
				<p>Admin</p>
			</li>
		</a>

		<a href="<?php echo URLROOT; ?>/consultation/records">
			<li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['professor-nav-active'] ?>">
				<p>Professor</p>
			</li>
		</a>
	</ul>
</li>

<a href="<?php echo URLROOT; ?>/academic_document/records" >
	<li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['setting-nav-active'] ?>">
		<p>Settings</p>
	</li>
</a>

<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/sysadmin/sysadmin.js';
	?>
</script>