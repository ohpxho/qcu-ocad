<?php 
	require APPROOT.'/views/layout/header.php';
	//require APPROOT.'/views/layout/horizontal-navigation/index.php';
?>

<main class="flex items-center justify-center w-full min-h-full py-4" role="main">
	<div class="w-1/2 bg-slate-50 h-max flex flex-col shadow-sm pt-5">

		<div class="flex flex-col w-full items-center gap-2 pb-5">
			<a href="<?php echo URLROOT;?>/home"><img class="aspect-square h-20 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>
			
			<a href="<?php echo URLROOT;?>/home" >
				<div class="flex flex-col text-center">
					<span class="font-bold text-lg">QCU - STUDENT MODULE</span>
					<span class="text-sm" >Online Consultation And Document Request</span>
				</div>
			</a>

			<p class="font-medium text-lg mt-2">Resubmit Application</p>
		</div>

		<div id="registration-form" class="w-full h-96 mb-2 px-10 pb-20 overflow-hidden hover:overflow-y-scroll">
			<?php
				require APPROOT.'/views/includes/loader.registration.php';
				require APPROOT.'/views/flash/success.php';
				require APPROOT.'/views/flash/fail.php';
			?>

			<form id="reg-form" class="flex w-full flex-col flex-1 mt-7" action="<?php echo URLROOT.'/student/declined/'.$data['details']->id; ?>" enctype="multipart/form-data" method="POST">
				<!------------------------------------------------ account details -------------------------------------------------------->

					<div class="flex flex-col mt-4">
						<span class="text-neutral-700 font-medium">Account Details</span>
					</div>
					
					<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="hidden" name="old-id"/>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Student ID <span class="text-sm font-normal"> (required)</span></span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" name="id"/>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Email<span class="text-sm font-normal"> (required)</span></span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="email" name="email"/>
						<p class="text-sm text-slate-500">You have to set an active email address. Email registered here will be used for notification and other stuff within the application</p>
					</div>

				<!------------------------------------------------ personal details -------------------------------------------------------->
				
					<div class="flex flex-col mt-5">
						<span class="text-neutral-700 font-medium">Personal Details</span>
					</div>

					<div class="flex mt-3 gap-1">
						<div class="flex flex-col w-full">
							<span class="text-neutral-700">Lastname<span class="text-sm font-normal"> (required)</span></span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="lname"/>
						</div>

						<div class="flex flex-col w-full">
							<span class="text-neutral-700">Firstname<span class="text-sm font-normal"> (required)</span></span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="fname"/>
						</div>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Middlename</span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="mname"/>
						<span class="text-sm mt-2 text-neutral-500">leave this blank if none</span>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Gender at birth<span class="text-sm font-normal"> (required)</span></span>
						<select class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" name="gender">
							<option value="">Choose Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Contact no.<span class="text-sm font-normal"> (required)</span></span>
						<input name="contact" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" />
						<span class="text-sm mt-2 text-neutral-500">should be an active number</span>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Location of residence<span class="text-sm font-normal"> (required)</span></span>
						<select name="location" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
							<option value="">Choose Location</option>
							<option value="1">QC</option>
							<option value="-1">NON-QC</option>
						</select>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Complete present address<span class="text-sm font-normal"> (required)</span></span>
						<input name="address" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text"/>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Type<span class="text-sm font-normal"> (required)</span></span>
						<select name="type" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
							<option value="">Choose Type</option>
							<option value="REGULAR">REGULAR</option>
							<option value="IRREGULAR">IRREGULAR</option>
						</select>
					</div>

					<div class="flex mt-3 gap-1">
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

					<div class="flex flex-col mt-3 w-full">
						<span class="text-neutral-700">Section<span class="text-sm font-normal"> (required)</span></span>
						<input name="section" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2"/>
					</div>

					<div class="flex flex-col gap-1 mt-3">
						<div class="flex flex-col gap-1 w-full">
							<p>University Id / Latest registration form<span class="text-sm font-normal"> (required)</span></p>
							<div id="identification-input-con" class="flex flex-col gap-1 w-full">
								<input class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700" type="file" name="identification" accept="image/*" />
							</div>
						</div>
						<p class="text-sm text-slate-500">clear photo of your registered Id or latest registration form</p>

						<a id="uploaded-identification" href="#" class="text-blue-700 mt-3 hover:underline py-1 w-full">-------</a>
					</div>

					<div class="flex flex-col mt-5 w-full">
						<span class="text-neutral-700">Remarks<span class="text-sm font-normal"> (required)</span></span>
						<p class="remarks">...</p>
					</div>

					<input class="text-white bg-blue-700 py-0.5 px-5 rounded-md w-max cursor-pointer mt-5" type="submit" value="Resubmit" />
					
			</form>
		</div>
	</div>
</main>


<?php 
	require APPROOT.'/views/layout/footer.php';
?>

<script>
	<?php require APPROOT.'/views/student/declined/declined.js'; ?>
</script>