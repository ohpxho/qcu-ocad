<div class="flex flex-col w-60 h-full grow-0 shrink-0 bg-slate-100 text-sm nav-box-shadow">
	<div class="flex flex-col h-full">
		
		<!------------------------------------------ profile --------------------------------------------------------->
		
		<div class="flex flex-col gap-1 py-5 pb-6 px-4 text-slate-700 ">
			
			<div class="flex gap-2 items-center">
				<div class="flex items-center grow-0 shrink-0 justify-center h-10 w-10 text-lg font-semibold">
					<?php
						require APPROOT.'/views/includes/profile.picture.php';
					?>
				</div>
				<div class="flex flex-col justify-center">
					<span class="text-lg font-semibold truncate ..."><?php echo $_SESSION['fname'].' '.$_SESSION['lname'] ?></span>	
					<span class="text-xs truncate ...">
						<?php
							if($_SESSION['type'] == 'sysadmin') {
								echo 'System Admin';
							} else {
								echo ucwords($_SESSION['type']);
							}	
						?>
					</span>
				</div>
			</div>
		</div>
		
		<!------------------------------------ search & notification menu ------------------------------------------>
		
		<ul class="flex flex-col px-2 border-b pb-4">
			
			<a href="<?php echo URLROOT ?>/user/profile" ><li class="flex gap-2 py-1 px-2 items-center hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['profile-nav-active'] ?>">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" /></svg>
				<p>Profile</p>
			</li></a>
	
			<a href="#"><li class="flex gap-2 py-1 px-2 items-center hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['notification-nav-active'] ?>">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10 2a6 6 0 00-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 00.515 1.076 32.91 32.91 0 003.256.508 3.5 3.5 0 006.972 0 32.903 32.903 0 003.256-.508.75.75 0 00.515-1.076A11.448 11.448 0 0116 8a6 6 0 00-6-6zM8.05 14.943a33.54 33.54 0 003.9 0 2 2 0 01-3.9 0z" clip-rule="evenodd" /></svg>
				<p>Notification</p>
			</li></a>	

		</ul>

		<!------------------------------------- services menu -------------------------------------------------------->

		<ul class="flex flex-col mt-5 px-2">

			<a href="<?php echo URLROOT; ?>/user/dashboard"><li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['dashboard-nav-active'] ?>">
				<p>Dashboard</p>
			</li></a>

			<?php

			if($_SESSION['type'] == 'student') {
				require APPROOT.'/views/layout/side-navigation/student/index.php';
			} 

			elseif($_SESSION['type'] == 'professor') {
				require APPROOT.'/views/layout/side-navigation/professor/index.php';
			}

			elseif($_SESSION['type'] == 'sysadmin') {
				require APPROOT.'/views/layout/side-navigation/sysadmin/index.php';
			}

			else {
				require APPROOT.'/views/layout/side-navigation/admin/index.php';
			}

			?>
			
		</ul>

	</div>

	<!---------------------------------------- footer ------------------------------------------------------------->

	<div class="flex items-center px-2 py-4 border-t w-full h-max text-xs text-slate-500">
		<p>The services provided by the application should be understood and read the <a href="#" class="underline">instructions</a> carefully.</p>
	</div>
</div> 
