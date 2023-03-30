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
					<p class="text-2xl font-bold">New Student</p>
					<p class="text-sm text-slate-500">Create new account for student</p>
				</div>

				<div class="w-10/12">
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>
					<form method="POST" action="<?php echo URLROOT;?>/student/add">
						<input type="hidden" name="type" value="student"/>

						<div class="flex flex-col mt-4">
							<span class="text-neutral-700 font-medium">Student ID<span class="text-sm font-normal"> (required)</span></span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" name="id"/>
						</div>		
						
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-medium">Email<span class="text-sm font-normal"> (required)</span></span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="email" name="email"/>
							<p class="text-sm text-slate-500">You have to set an active email address. Email registered here will be used for notification and other stuff within the application</p>
						</div>

						<div class="flex mt-4 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Password<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="password" name="pass"/>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Confirm password<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="password" name="confirm-pass"/>
							</div>
						</div>
						<p class="text-sm text-slate-500">Password should be atleast 8 characters long. Alphanumeric</p>

						<div class="flex mt-4 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Lastname<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="lname"/>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Firstname<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="fname"/>
							</div>
						</div>
						
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-medium">Middlename</span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="mname"/>
						</div>

						<div class="flex mt-4 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Gender<span class="text-sm font-normal"> (required)</span></span>
								<select class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" name="gender">
									<option value="">Choose option</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Contact<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" name="contact"/>
							</div>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700">Location of residence<span class="text-sm font-normal"> (required)</span></span>
							<select name="location" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Location</option>
								<option value="QC">QC</option>
								<option value="NON-QC">NON-QC</option>
							</select>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700">Complete present address<span class="text-sm font-normal"> (required)</span></span>
							<input name="address" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text"/>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700">Type<span class="text-sm font-normal"> (required)</span></span>
							<select name="type-of-student" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Type</option>
								<option value="REGULAR">REGULAR</option>
								<option value="IRREGULAR">IRREGULAR</option>
							</select>
						</div>

						<div class="flex mt-5 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700">Course<span class="text-sm font-normal"> (required)</span></span>
								<select name="course" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
									<option value="">Choose Course</option>
									<option value="BSIT">BSIT</option>
									<option value="BSENTREP">BSEntrep</option>
									<option value="BSACCOUNTANCY">BSAccountancy</option>
									<option value="BSECE">BSECE</option>
									<option value="BSIE">BSIE</option>
								</select>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700">Year<span class="text-sm font-normal"> (required)</span></span>
								<select name="year" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
									<option value="">Choose Year</option>
									<option value="1">1st</option>
									<option value="2">2nd</option>
									<option value="3">3rd</option>
									<option value="4">4th</option>
								</select>
							</div>
						</div>

						<div class="flex flex-col mt-5 w-full">
							<span class="text-neutral-700">Section<span class="text-sm font-normal"> (required)</span></span>
							<input name="section" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2"/>
						</div>

						<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Add new student"/>
						<p class="text-sm text-slate-500 mt-2">Upon submission, SMS and an Email will be sent to notify the admin. </p>
					</form>
				</div>

			</div>
		</div>
	</div>
</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/student/add/add.js'; ?>
</script>

