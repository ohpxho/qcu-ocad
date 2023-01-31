<div class="flex flex-col w-60 h-full grow-0 shrink-0 bg-slate-100 text-sm nav-box-shadow">
	<div class="flex flex-col h-full">
		
		<!------------------------------------------ profile --------------------------------------------------------->
		
		<div class="flex flex-col gap-1 py-5 pb-6 px-4 text-slate-700 ">
			
			<div class="flex gap-2">
				<div class="flex items-center grow-0 shrink-0 justify-center h-7 w-7 text-lg font-semibold">
					<?php
						require APPROOT.'/views/includes/profile.picture.php';
					?>
				</div>
				<span class="text-lg font-semibold truncate ..."><?php echo $_SESSION['fname'] ?></span>	
			</div>

			<span class="text-xs truncate ..."><?php echo $_SESSION['email']?></span>
		
		</div>
		
		<!------------------------------------ search & notification menu ------------------------------------------>
		
		<ul class="flex flex-col px-2 border-b pb-4">
			
			<a href="#" ><li class="flex gap-2 py-1 px-2 items-center hover:bg-slate-200 text-slate-700 rounded-sm">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" /></svg>
				<p>Profile</p>
			</li></a>

			<a href="#" ><li class="flex gap-2 py-1 px-2 items-center hover:bg-slate-200 text-slate-700 rounded-sm">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
				<p>Search</p>
			</li></a>
			
			<a href="#"><li class="flex gap-2 py-1 px-2 items-center hover:bg-slate-200 text-slate-700 rounded-sm">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10 2a6 6 0 00-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 00.515 1.076 32.91 32.91 0 003.256.508 3.5 3.5 0 006.972 0 32.903 32.903 0 003.256-.508.75.75 0 00.515-1.076A11.448 11.448 0 0116 8a6 6 0 00-6-6zM8.05 14.943a33.54 33.54 0 003.9 0 2 2 0 01-3.9 0z" clip-rule="evenodd" /></svg>
				<p>Notification</p>
			</li></a>	

		</ul>

		<!------------------------------------- services menu -------------------------------------------------------->

		<ul class="flex flex-col mt-5 px-2">

			<a href="<?php echo URLROOT; ?>/home/index"><li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['dashboard-nav-active'] ?>">
				<p>Dashboard</p>
			</li></a>

			<?php
				require APPROOT.'/views/layout/side-navigation/document.request.php';
			?>
			
			<?php
				require APPROOT.'/views/layout/side-navigation/good.moral.php';
			?>	

			<?php
				require APPROOT.'/views/layout/side-navigation/statement.account.php';
			?>

			<?php
				require APPROOT.'/views/layout/side-navigation/consultation.php';
			?>

			<?php
				require APPROOT.'/views/layout/side-navigation/student.records.php';
			?>

			<a href="<?php echo URLROOT; ?>/record"><li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['record-nav-active'] ?>">
				<p>Reports</p>
			</li></a>
			
		</ul>

	</div>

	<!---------------------------------------- footer ------------------------------------------------------------->

	<div class="flex items-center px-2 py-4 border-t w-full h-max text-xs text-slate-500">
		<p>The services provided by the application should be understood and read the <a href="#" class="underline">instructions</a> carefully.</p>
	</div>
</div> 

<!------------------------------------------- script ------------------------------------------------->

<script>
	
	$(document).ready(function() {
		
		/**
		 * execute onclick event when user click consultation dropdown button 
		**/

		$('#consultation-dropdown-btn').click(function() {
			$('#consultation-menu').toggleClass('h-0');
			$('#consultation-dropdown-icon').toggleClass('-rotate-90');
		});

	});

</script>