
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

<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/alumni/alumni.js';
	?>
</script>