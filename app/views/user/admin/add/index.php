<?php
	require APPROOT.'/views/layout/header.php';
?>
<main class="flex flex-con h-full w-full overflow-hidden">

	<!-------------------------------------- side navigation ----------------------------------------------------------------->
	
	<?php
		require APPROOT.'/views/layout/side-navigation/index.php';
	?>

	<!-------------------------------------- main content -------------------------------------------------------------------->
	
	<div class="w-full h-full">
		<?php
			require APPROOT.'/views/layout/horizontal-navigation/index.php';
		?>

		<div class="flex justify-center w-full h-full overflow-y-scroll">
			<div class="h-max w-10/12 py-14 pb-24">
				<div class="flex flex-col">
					<p class="text-3xl font-bold">Add new Admin</p>
					<p class="text-sm text-slate-500">Creat new Admin account </p>
				</div>

				<div class="w-10/12">
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>
				<form method="POST" action="<?php echo URLROOT;?>/admin/add" enctype="multipart/form-data">
						<input name="student-id" type="hidden" value="<?php echo $_SESSION['id'] ?>">
		

						<div class="flex flex-col w-full mt-5 gap-2">
							<div class="flex w-full gap-1">
								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Admin ID<span class="text-sm font-normal"> (required)</span></span>
									<input name="id" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="number" required>
								</div>

								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Email Address<span class="text-sm font-normal"> (required)</span></span>
									<input name="email" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" type="email" required>
								</div>

							<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Gender<span class="text-sm font-normal"> (required)</span></span>
									<select name="gender" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" type="text" required>
										<option value="">Choose Option</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>

								</div>

							</div>
						</div>
						
						<div class="flex flex-col w-full mt-5 gap-2">
							<div class="flex w-full gap-1">
								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Last Name<span class="text-sm font-normal"> (required)</span></span>
									<input name="lname" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="text" required>
								</div>

								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">First Name<span class="text-sm font-normal"> (required)</span></span>
									<input name="fname" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" type="text" required>
								</div>
								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Middle Name<span class="text-sm font-normal"> (required)</span></span>
									<input name="mname" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" type="text" required>
								</div>
							</div>
						</div>
						<div class="flex flex-col w-full mt-5 gap-2">
							<div class="flex w-full gap-1">
								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold"> Contact Number<span class="text-sm font-normal"> (required)</span></span>
									<input name="cnumber" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="number" required>
								</div>
								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Department<span class="text-sm font-normal"> (required)</span></span>
								<select name="department" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" required>
										<option value="">Choose Option</option>
									<option value="Computer Science And Information Technology">Computer Science And Information Technology</option>
									<option value="Engineering">Engineering</option>
									<option value="Bussiness And Accountancy">Business And Accountancy</option>
									<option value="Education">Education</option>
									<option value="Guidance">Guidance</option>
									<option value="Clinic">Clinic</option>
								</select>

								</div>
							</div>
						</div>
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">Address<span class="text-sm font-normal"> (required)
							</span></span>
							<input name="address" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" type="text">
						</div>
						<div class="flex flex-col w-full mt-5 gap-2">
							<div class="flex w-full gap-1">
								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Password<span class="text-sm font-normal"> (required)</span></span>
									<input name="pword" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="password" required>
									<p class="text-sm">Password Must be hard</p>
								</div>

								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Confirm Password<span class="text-sm font-normal"> (required)</span></span>
									<input name="pword" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" type="password" required>
								</div>
							</div>
						</div>


						<div class="flex flex-col mt-5 pb-4 gap-2">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-semibold">Upload Picture/s</span>
								<input name="document[]" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="file" multiple="multiple"/>
								<p class="text-sm text-slate-500">The Photo will be used as Profile Picture of the Admin</p>
							</div>
						</div>
						<input class=" mt-5 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Create Admin"/>
						<p class="text-sm text-slate-500 ">----------------</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/user/admin/add/add.js'; ?>
</script>

