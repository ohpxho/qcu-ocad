<div class="flex justify-between text-neutral-700 top-0 items-center w-full h-max py-2 px-4 bg-white border-b z-30">
	<div class="flex gap-3 text-sm items-center ">
		<?php
			//require APPROOT.'/views/includes/breadcrumb.php';
		?>
		<div id="side-nav-btn" class="hidden lg:block bg-slate-100 p-4 rounded-md mr-6 cursor-pointer">
			<div class="space-y-1">
				<div class="w-6 h-0.5 bg-slate-600"></div>
			  	<div class="w-6 h-0.5 bg-slate-600"></div>
			  	<div class="w-6 h-0.5 bg-slate-600"></div>
			</div>
		</div>	

		<a href="<?php echo URLROOT;?>/dashboard"><img class="aspect-square h-12 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>
		
		<a href="<?php echo URLROOT;?>/dashboard" >
			<div class="sm:flex hidden flex-col">
				<span class="text-neutral-700 font-bold text-xl">QUEZON CITY UNIVERSITY</span>
				<span class="text-sm text-neutral-500">Online Consultation And Document Request</span>
			</div>

			<div class="sm:hidden flex flex-col">
				<span class="text-neutral-700 font-bold text-xl">QCU-OCAD</span>
			</div>
		</a>
	</div>

	<div class="flex gap-2">
		<!--<a class="cursor-pointer" id="setting-dropdown-btn"><img class="h-5 w-5" src="<?php echo URLROOT?>/public/assets/img/ellipsis.png"></a>-->
		<a class="hidden lg:block rounded-md px-2 py-1 hover:bg-red-100 text-red-500 text-sm logout" title="logout" href="<?php echo URLROOT;?>/home/logout">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
 				<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
			</svg>
		</a>

		<div class="lg:hidden">
			<div id="nav-hamburger-btn" class="space-y-2">
				<div class="w-8 h-0.5 bg-slate-600"></div>
			  	<div class="w-8 h-0.5 bg-slate-600"></div>
			  	<div class="w-8 h-0.5 bg-slate-600"></div>
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

		$('#nav-hamburger-btn').click(function() {
			$('#side-nav').removeClass('-left-full').addClass('left-0');
		});

		$('#side-nav-btn').click(function() {
			if($('#side-nav').css('position') == 'fixed') {
				$('#side-nav').removeClass('fixed').addClass('lg:relative');
				$('#side-nav').removeClass('-left-full').addClass('lg:left-0');
			} else {
				$('#side-nav').removeClass('lg:relative').addClass('fixed');
				$('#side-nav').removeClass('lg:left-0').addClass('-left-full');
			}
		});

		$('.logout').click(function() {
			localStorage.removeItem('welcome-flag');
		});
	});
</script>