<div class="flex justify-between text-neutral-700 top-0 items-center w-full h-max py-2 px-4 bg-white border-b z-40">
	<div class="flex gap-3 text-sm items-center">
		<?php
			require APPROOT.'/views/includes/breadcrumb.php';
		?>
	</div>

	<div class="flex gap-2">
		<a class="cursor-pointer" id="setting-dropdown-btn"><img class="h-5 w-5" src="<?php echo URLROOT?>/public/assets/img/ellipsis.png"></a>
	</div>

	<!------------------------------------- setting modal ---------------------------------------->

	<div id="setting-menu-container" class="hide flex-col absolute w-max right-4 bg-white rounded-md top-8 card-box-shadow ">
		<div class="flex flex-col px-1 w-max py-1 text-sm">
			<a class="rounded-md px-2 hover:bg-red-100 text-red-500" href="<?php echo URLROOT;?>/home/logout">Logout</a>	
		</div>
	</div>

</div>

<!----------------------------------------- script ----------------------------------------------->

<script>
	$(document).ready(function() {
		
		/**
		 * execute onclick event when user click the setting dropdown button 
		**/

		$('#setting-dropdown-btn').click(function() {

			$('#setting-menu-container').toggleClass('show');
		});

	});
</script>