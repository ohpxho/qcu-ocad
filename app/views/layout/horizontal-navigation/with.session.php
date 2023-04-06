<link rel="stylesheet" href="C:\xampp\htdocs\qcu-ocad\public\css\style.css">
<div class="topnav">
	<div class="relative w-full h-20 text-neutral-700 top-0 sm:h-20 border-0 md:w-full lg:w-full flex justify-between sm:items-center p-4 bg-white border-b z-40">
		<div class="relative flex gap-3 text-sm items-center ">
			<?php
				//require APPROOT.'/views/includes/breadcrumb.php';
			?>
			<a href="<?php echo URLROOT;?>/dashboard"><img class="aspect-square h-12 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>
				
			<a href="<?php echo URLROOT;?>/dashboard" >
				<div class="flex flex-col">
					<span class="text-neutral-900 font-medium">QUEZON CITY UNIVERSITY</span>
					<span class="text-[12px] md:text-sm text-neutral-500">Online Consultation And Document Request</span>
				</div>
			</a>
		</div>

		<div class="flex md:hidden">
			<button id="mobile-menu-button" class="p-4">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
			</button>
		</div>

		<div class="hidden md:flex gap-2">
			<!--<a class="cursor-pointer" id="setting-dropdown-btn"><img class="h-5 w-5" src="<?php echo URLROOT?>/public/assets/img/ellipsis.png"></a>-->
			<a class="rounded-md px-2 py-1 hover:bg-red-100 text-red-500 text-sm" href="<?php echo URLROOT;?>/home/logout">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
					<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
				</svg>
			</a>	
		</div>

		<!------------------------------------- setting modal ---------------------------------------->

		<div id="setting-menu-container" class="relative hidden flex-col absolute w-max right-4 bg-white rounded-md top-8 card-box-shadow ">
			<div class="flex flex-col px-1 w-max py-1 text-sm">
				<a class="rounded-md px-2 hover:bg-red-100 text-red-500" href="<?php echo URLROOT;?>/home/logout">Logout</a>	
			</div>
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