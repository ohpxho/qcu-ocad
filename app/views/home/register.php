<?php 
require APPROOT.'/views/layout/header.php';
require APPROOT.'/views/layout/horizontal-navigation/index.php';

?>
<main class="flex w-full h-max justify-center items-center mt-32 pb-20" role="main">
	<div class="w-1/2 max-w-lg h-1/2 flex flex-col justify-center items-center">

		<p class="text-5xl font-bold text-neutral-700">Register</p>
		<p class="mt-3 text-neutral-700">Online Consultation and Document Request</p>
		<div class="w-full h-full">
			<?php
				require APPROOT.'/views/includes/loader.registration.php';
				require APPROOT.'/views/flash/success.php';
				require APPROOT.'/views/flash/fail.php';
			?>
			
			<!---------------------------------------------------- progress ------------------------------------------------------------->

			<div class="flex w-full justify-between mt-5">
				<div class="flex flex-col items-center justify-center w-full py-3 ">
					<p id="step1-head" class="text-blue-700 font-semibold">STEP 1</p>
					<p id="step1-text" class="text-blue-700">Account Details</p>
				</div>

				<div class="flex flex-col items-center justify-center w-full py-3 ">
					<p id="step2-head" class="text-neutral-700 font-semibold">STEP 2</p>
					<p id="step2-text" class="text-neutral-700">Personal Details</p>
				</div>

				<div class="flex flex-col items-center justify-center w-full py-3">
					<p id="step3-head" class="text-neutral-700 font-semibold">STEP 3</p>
					<p id="step3-text" class="text-neutral-700">Data Privacy Consent</p>
				</div>

			</div>

			<div class="w-full bg-gray-200 h-1 rounded-full">
	  			<div id="progress-bar" class="bg-blue-700 h-1 rounded-full progress-young"></div>
			</div>

			<form class="flex w-full flex-col flex-1 mt-3" action="<?php echo URLROOT; ?>/home/register" method="POST">

				<!------------------------------------------------ account details -------------------------------------------------------->

				<div id="account-details-container" class="flex w-full flex-col flex-1">
					<div class="flex flex-col mt-4">
						<span class="text-neutral-700">Student ID</span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="id"/>
					</div>

					<div class="flex flex-col mt-5">
						<span class="text-neutral-700">Email</span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="email" name="email"/>
						<span class="text-sm mt-2 text-neutral-500"> use your google account email</span>
					</div>

					<div class="flex flex-col mt-5">
						<span class="text-neutral-700">Password</span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="password" name="password"/>
						<span class="text-sm mt-2 text-neutral-500">at least 8 alphanumeric characters</span>
					</div>

					<div class="flex flex-col mt-5">
						<span class="text-neutral-700">Confirm Password</span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="password" name="confirm-password"/>
					</div>
						
					<a id="account-details-nxt-btn" class="border mt-7 border-blue-300 rounded-sm bg-blue-100 text-blue-700 border w-full p-1 cursor-pointer text-center">Next</a>
				</div>

				<!------------------------------------------------ personal details -------------------------------------------------------->
				
				<div id="personal-details-container" class="flex w-full flex-col flex-1 hidden">
					<div class="flex mt-4 gap-1">
						<div class="flex flex-col w-full">
							<span class="text-neutral-700">Lastname</span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="lastname"/>
						</div>

						<div class="flex flex-col w-full">
							<span class="text-neutral-700">Firstname</span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="firstname"/>
						</div>
					</div>

					<div class="flex flex-col mt-5">
						<span class="text-neutral-700">Middlename</span>
						<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="middlename"/>
						<span class="text-sm mt-2 text-neutral-500">leave this blank if none</span>
					</div>

					<div class="flex flex-col mt-5">
						<span class="text-neutral-700">Gender at Birth</span>
						<select class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" name="gender">
							<option value="">Choose Gender</option>
							<option value="M">Male</option>
							<option value="F">Female</option>
						</select>
					</div>

					<div class="flex flex-col mt-5">
						<span class="text-neutral-700">Contact No.</span>
						<input name="contact" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" />
						<span class="text-sm mt-2 text-neutral-500">should be an active number</span>
					</div>

					<div class="flex flex-col mt-5">
						<span class="text-neutral-700">Location of Residence</span>
						<select name="location" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
							<option value="">Choose Location</option>
							<option value="1">QC</option>
							<option value="-1">NON-QC</option>
						</select>
					</div>

					<div class="flex flex-col mt-5">
						<span class="text-neutral-700">Complete Present Address</span>
						<input name="address" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text"/>
					</div>

					<div class="flex flex-col mt-5">
						<span class="text-neutral-700">Type</span>
						<select name="type" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
							<option value="">Choose Type</option>
							<option value="1">REGULAR</option>
							<option value="-1">IRREGULAR</option>
						</select>
					</div>

					<div class="flex mt-5 gap-1">
						<div class="flex flex-col w-full">
							<span class="text-neutral-700">Course</span>
							<select name="course" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Course</option>
								<option value="bsit">BSIT</option>
								<option value="bsentrep">BSEntrep</option>
								<option value="bsaccountancy">BSAccountancy</option>
								<option value="bsece">BSECE</option>
								<option value="bsie">BSIE</option>
							</select>
						</div>

						<div class="flex flex-col w-full">
							<span class="text-neutral-700">Year</span>
							<select name="year" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Year</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
						</div>
					</div>

					<div class="flex flex-col mt-5 w-full">
						<span class="text-neutral-700">Section</span>
						<input name="section" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2"/>
					</div>

					<a id="personal-details-prev-btn" class="border mt-7 border-red-300 rounded-sm bg-red-100 text-red-700 border w-full p-1 cursor-pointer text-center">Back</a>

					<a id="personal-details-nxt-btn" class="border mt-2 border-blue-300 rounded-sm bg-blue-100 text-blue-700 border w-full p-1 cursor-pointer text-center">Next</a>
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
						<span class="text-neutral-700 italic">I am giving my consent to QCU from what is stated above.</span>
					</div>

					<a id="privacy-consent-prev-btn" class="border mt-7 border-red-300 rounded-sm bg-red-100 text-red-700 border w-full p-1 cursor-pointer text-center">Back</a>

					<input class="border mt-2 rounded-sm border-blue-300 bg-blue-100 text-blue-700 border w-full p-1 cursor-pointer disabled:border-slate-100 disabled:bg-slate-100 disabled:text-slate-400" type="submit" value="Submit" disabled />
				</div>
			</form>
		</div>
	</div>
</main>
<?php 
require APPROOT.'/views/layout/footer.php';
?>

<script src="<?php echo URLROOT;?>/public/script/registration.multistep.form.js"></script>