<?php 
	require APPROOT.'/views/layout/header.php';
	//require APPROOT.'/views/layout/horizontal-navigation/index.php';
?>

<main class="relative flex w-full h-full justify-center items-center sm:pb-20" role="main">
	<div class="relative sm:mt-20 w-full h-full sm:h-max border-0 sm:w-96 flex flex-col sm:justify-center sm:items-center p-4 sm:rounded-md sm:border bg-slate-50 sm:shadow-md">
		<!--<p class="text-4xl font-bold text-neutral-700">Log in</p>-->
		<div class="relative flex flex-col w-full items-center gap-2 pb-5">
			<a href="<?php echo URLROOT;?>/home"><img class="aspect-square h-20 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>
			
			<a href="<?php echo URLROOT;?>/home" >
				<div class="flex flex-col text-center">
					<span class="font-bold text-lg">QCU - STUDENT MODULE</span>
					<span class="text-sm" >Online Consultation And Document Request</span>
				</div>
			</a>
		</div>


		<!---------------------------------------------------- progress ------------------------------------------------------------->

		<div class="flex w-full h-max justify-center items-center pt-10 pb-2">
			<div class="flex w-4/6 justify-between items-center h-4/6">
				<div id="step1-head" class="flex h-max items-center justify-center z-10 py-1 px-3 rounded-full bg-blue-700">
					<p id="step1-text" class="text-white ">1</p>
				</div>

				<div id="step2-head" class="flex flex-col h-max items-center justify-center py-1 px-3 rounded-full z-10 bg-gray-200 ">
					<p id="step2-text" class="text-neutral-700 ">2</p>
				</div>

				<div id="step3-head" class="flex flex-col h-max items-center justify-center py-1 px-3 rounded-full z-10 bg-gray-200 ">
					<p id="step3-text" class="text-neutral-700 ">3</p>
				</div>
			</div>

			<div class="absolute w-4/6 bg-gray-200 h-1 rounded-full">
	  			<div id="progress-bar" class="bg-blue-700 h-1 rounded-full progress-young"></div>
			</div>	
		</div>

		<div id="registration-form" class="w-full h-96 mb-2 px-10 pb-10 overflow-hidden hover:overflow-y-scroll">
			<?php
				require APPROOT.'/views/includes/loader.registration.php';
				require APPROOT.'/views/flash/success.php';
				require APPROOT.'/views/flash/fail.php';
			?>

			<form id="reg-form" class="flex w-full flex-col flex-1 mt-7" action="<?php echo URLROOT; ?>/student/register" enctype="multipart/form-data" method="POST">

				<!------------------------------------------------ account details -------------------------------------------------------->

				<div id="account-details-container" class="flex w-full flex-col flex-1 ">
					<div class="flex flex-col mt-4 border-b pb-5">
						<span class="text-neutral-700 text-lg font-semibold">Account Details</span>
					</div>

					<div class="flex flex-col mt-4">
						<span class="text-neutral-700">Student ID <span class="text-sm font-normal"> (required)</span></span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" name="id"/>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Email<span class="text-sm font-normal"> (required)</span></span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="email" name="email"/>
						<p class="text-sm text-slate-500">You have to set an active email address. Email registered here will be used for notification and other stuff within the application</p>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Password<span class="text-sm font-normal"> (required)</span></span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="password" name="pass"/>
						<p class="text-sm text-slate-500">Password should be atleast 8 characters long. Alphanumeric</p>
					</div>

					<div class="flex flex-col mt-3">
						<span class="text-neutral-700">Confirm password<span class="text-sm font-normal"> (required)</span></span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="password" name="cpass"/>
					</div>

					<a id="account-details-nxt-btn" class="text-white bg-blue-700 py-0.5 px-5 mt-5 cursor-pointer rounded-md w-max">Next</a>
				</div>

				<!------------------------------------------------ personal details -------------------------------------------------------->
				
				<div id="personal-details-container" class="flex w-full flex-col flex-1 hidden">
					<div class="flex flex-col mt-4 border-b pb-5">
						<span class="text-neutral-700 text-lg font-semibold">Personal Details</span>
					</div>

					<div class="flex mt-4 gap-1">
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
					</div>

					<div class="flex gap-2 mt-5">
						<a id="personal-details-prev-btn" class="text-white bg-red-500 cursor-pointer py-0.5 px-5 rounded-md w-max">Back</a>
						<a id="personal-details-nxt-btn" class="text-white bg-blue-700 cursor-pointer py-0.5 px-5 rounded-md w-max">Next</a>
					</div>
				</div>

				<!------------------------------------------------ data privacy consent -------------------------------------------------------->
				
				<div id="privacy-consent-container" class="flex w-full flex-col flex-1 hidden">
					<div class="text-neutral-700">
						<p class="text-lg mt-2 font-semibold">Data Privacy Consent</p><br>
						<p>To the best of my own knowledge, I certify that the information I have written is true and correct.</p><br>
						<p>I hereby allow to the collection, use, recording, storing, organizing, consolidating, updating, processing, access to transfer, disclosure, or data sharing of my personal and sensitive information that I provided to QCU for the purposes for which it was collected and such other lawful purposes as I consent to or as required or permitted by law.</p><br>
						<p>I understand that the consent or authorization I am giving QCU will take effect immediately after submitting this form and will continue until I cancel it in writing.</p>
					</div>

					<div class="flex mt-4 w-full gap-2 items-center">
						<input type="checkbox" name="consent"/>
						<span class="text-neutral-700 font-medium">I am giving my consent to QCU from what is stated above.</span>
					</div>

					<div class="flex gap-2 items-center mt-5">
						<a id="privacy-consent-prev-btn" class="text-white bg-red-500 cursor-pointer py-0.5 px-5 rounded-md w-max">Back</a>
						<input id="submit-form-btn" class="text-white bg-blue-700 py-0.5 px-5 rounded-md w-max cursor-pointer disabled:border-slate-100 disabled:bg-slate-100 disabled:text-slate-400" type="submit" value="Submit" disabled />
					</div>
				</div>
			</form>
		</div>

		<div id="email-verification" style="background-color: rgba(255, 255, 255, 0.4)" class="fixed flex justify-center items-center h-full w-full top-0 left-0 z-40 hidden">
			<div class="flex flex-col gap-2 pb-8 bg-slate-50 border w-1/3 h-max rounded-md shadow-md overflow-y-scroll p-4 px-6">
				<?php
					require APPROOT.'/views/includes/loader.email.php';
				?>
				<a href="#" id="email-verification-exit-btn" class="flex gap-2 items-center">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
							<path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
					</svg>
				</a>

				<div>
					<p class="font-medium">Email Verification</p>
					<p class="text-sm text-slate-500">Please verify your email address by entering the code we have sent to you</p>
				</div>

				<div class="flex gap-1 flex-col mt-3">
					<input name="code" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700" type="number" placeholder="Enter code..." />
					<p id="email-verification-error" class="text-sm text-red-500"></p>	
				</div>

				<div class="flex gap-2 items-center">
					<input id="submit-code-btn" class=" mt-3 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Continue"/>
					<input id="resend-code-btn" class=" mt-3 rounded-sm bg-orange-500 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Resend code"/>
				</div>	
			</div>
		</div>

	</div>
</main>

<?php 
	require APPROOT.'/views/layout/footer.php';
?>

<script>
	<?php require APPROOT.'/views/student/register/register.js'; ?>
</script>