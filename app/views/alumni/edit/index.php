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

				<a href="<?php echo URLROOT; ?>/user/alumni" title="back">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		  				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
					</svg>
				</a>

				<div class="flex flex-col mt-5">
					<p class="text-2xl font-bold">New Alumni</p>
					<p class="text-sm text-slate-500">Create new account for alumni</p>
				</div>

				<div class="w-10/12">
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>
					<form method="POST" action="<?php echo URLROOT;?>/alumni/update/<?php echo $data['records']->id ?>">
						<input type="hidden" name="type" value="alumni"/>

						<div class="flex flex-col mt-4">
							<span class="text-neutral-700 font-medium">Student ID<span class="text-sm font-normal"> (required)</span></span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="id" readonly/>
						</div>		
						
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-medium">Email<span class="text-sm font-normal"> (required)</span></span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="email" name="email" required/>
							<p class="text-sm text-slate-500">You have to set an active email address. Email registered here will be used for notification and other stuff within the application</p>
						</div>

						<div class="flex mt-4 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Lastname<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="lname" required/>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Firstname<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="fname" required/>
							</div>
						</div>
						
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-medium">Middlename</span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="mname"/>
						</div>

						<div class="flex mt-4 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Gender<span class="text-sm font-normal"> (required)</span></span>
								<select class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" name="gender" required>
									<option value="">Choose option</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Contact<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" name="contact" required/>
							</div>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700">Location of residence<span class="text-sm font-normal"> (required)</span></span>
							<select name="location" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" required>
								<option value="">Choose Location</option>
								<option value="QC">QC</option>
								<option value="NON-QC">NON-QC</option>
							</select>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700">Complete present address<span class="text-sm font-normal"> (required)</span></span>
							<input name="address" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" required/>
						</div>

						<div class="flex mt-5 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700">Course<span class="text-sm font-normal"> (required)</span></span>
								<select name="course" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" required>
									<option value="">Choose Course</option>
									<option value="BSIT">BSIT</option>
									<option value="BSENTREP">BSEntrep</option>
									<option value="BSACCOUNTANCY">BSAccountancy</option>
									<option value="BSECE">BSECE</option>
									<option value="BSIE">BSIE</option>
								</select>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700">Section<span class="text-sm font-normal"> (required)</span></span>
								<input name="section" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" required/>
							</div>
						</div>

						<div class="flex flex-col mt-5 w-full">
							<span class="text-neutral-700">Year Graduated<span class="text-sm font-normal"> (required)</span></span>
							<input type="number" name="year-graduated" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" min="1980" max="<?php echo date('Y') ?>" required/>
						</div>

						<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Update"/>
					</form>
				</div>

			</div>
		</div>
	</div>
</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/alumni/edit/edit.js'; ?>
</script>
