
<p class="flex py-1 px-2 text-slate-400 text-normal rounded-sm">Document Request</p>

<a href="<?php echo URLROOT; ?>/academic_document"><li class="flex py-1 px-6 hover:bg-slate-600 rounded-sm <?php echo $data['document-nav-active'] ?>">
	<p>Academic Documents</p>
</li></a>

<a href="<?php echo URLROOT; ?>/good_moral"><li class="flex py-1 px-6 hover:bg-slate-600 rounded-sm <?php echo $data['moral-nav-active'] ?>">
	<p>Good Moral Certificate</p>
</li></a>

<script>
	<?php
		require APPROOT.'/views/layout/side-navigation/alumni/alumni.js';
	?>
</script>