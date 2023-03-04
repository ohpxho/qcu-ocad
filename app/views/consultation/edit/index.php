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

			$details = $data['request-data'];
		?>

		<div class="flex justify-center w-full h-full overflow-y-scroll">
			<div class="h-max w-10/12 py-14 pb-24">
				<div class="flex flex-col gap-2">
					<p class="text-3xl font-bold">Edit Consultation</p>
					<p class="text-sm text-slate-500"></p>
				</div>

				<div class="w-10/12">
					<?php
						require APPROOT.'/views/includes/loader.main.php';
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>
					<form method="POST" action="<?php echo URLROOT.'/consultation/edit/'.$data['request-data']->id;?>" enctype="multipart/form-data">
						<input name="request-id" type="hidden" value="<?php echo $data['request-data']->id ?>">
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">Purpose<span class="text-sm font-normal"> (required)</span></span>
							<select name="purpose" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Option</option>
								<option value="1">Thesis/Capstone Advising</option>
								<option value="4">Lecture Inquiries</option>
								<option value="2">Project Concern/Advising</option>
								<option value="3">Grades Consulting</option>
								<option value="6">Performance Consulting</option>
								<option value="5">Exams/Quizzes/Assignment Concern</option>
								<option value="7">Counseling</option>
								<option value="8">Report</option>
								<option value="9">Health Concerns</option>
							</select>
						</div>

						<div class="flex flex-col mt-5">
							<div class="flex flex-col pb-2">
								<p class="text-neutral-700 font-semibold">Problem<span class="text-sm font-normal"> (required)</span></p>
							</div>
							<div class="flex flex-col gap-1">
								<textarea id="problem" name="problem" class="border rounded-sm border-slate-300 py-2 px-2 outline-1 outline-blue-400 mt-5"></textarea>
							</div>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">College / Department<span class="text-sm font-normal"> (required)</span></span>
							<select name="department" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Option</option>
								<option value="Computer Science And Information Technology">Computer Science And Information Technology</option>
								<option value="Engineering">Engineering</option>
								<option value="Bussiness And Accountancy">Bussiness And Accountancy</option>
								<option value="Education">Education</option>
								<option value="Guidance">Guidance</option>
								<option value="Clinic">Clinic</option>
							</select>
						</div>

						<div id="subject-adviser-input-holder" class="hidden">
							<div class="flex flex-col mt-5">
								<span class="text-neutral-700 font-semibold">Subject Code<span class="text-sm font-normal"> (required)</span></span>
								<select name="subject" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
									<option value="">Choose Option</option>
								</select>
							</div>

							<div class="flex flex-col mt-5">
								<span class="text-neutral-700 font-semibold">Adviser<span class="text-sm font-normal"> (required)</span></span>
								<select name="adviser-id" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
									<option value="">Choose Option</option>
								</select>
							</div>
						</div>
						
						<div class="flex flex-col w-full mt-5 gap-2">
							<div class="flex w-full gap-1">
								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Preferred Date<span class="text-sm font-normal"> (required)</span></span>
									<input name="preferred-date" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="date" value=""/>
								</div>

								<div class="flex flex-col w-full">
									<span class="text-neutral-700 font-semibold">Preferred Time<span class="text-sm font-normal"> (required)</span></span>
									<select name="preferred-time" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
										<option value="">Choose Option</option>
										<option value="Anytime">Anytime</option>
										<option value="8:00 AM">8:00 AM</option>
										<option value="8:30 AM">8:30 AM</option>
										<option value="9:00 AM">9:00 AM</option>
										<option value="9:30 AM">9:30 AM</option>
										<option value="10:00 AM">10:00 AM</option>
										<option value="10:30 AM">10:30 AM</option>
										<option value="11:00 AM">11:00 AM</option>
										<option value="11:30 AM">11:30 AM</option>
										<option value="12:00 PM">12:00 PM</option>
										<option value="12:30 PM">12:30 PM</option>
										<option value="1:00 PM">1:00 PM</option>
										<option value="1:30 PM">1:30 PM</option>
										<option value="2:00 PM">2:00 PM</option>
										<option value="2:30 PM">2:30 PM</option>
										<option value="3:00 PM">3:00 PM</option>
									</select>
								</div>
							</div>
							<p class="text-sm">Specifiy date and time to let the adviser know what is your preferred date and time for online meeting</p>
						</div>
						
						<div class="flex flex-col mt-5 gap-2">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-semibold">Upload Document/s</span>
								<input name="document[]" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="file" multiple="multiple"/>
								<input name="existing-documents" type="hidden">
							</div>
							<p class="text-sm">Document/s to upload must be relevant to the intended consultation</p>
							<span id="shared-doc" class="text-slate-500"></span>
							<ul id="shared-doc-list"></ul>
						</div>

						<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Update Consultation"/>
						<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
					</form>
				</div>

			</div>
		</div>
	</div>
</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/consultation/edit/edit.js'?>;
</script>

