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

		<div class="flex justify-center w-full h-full px-2 md:px-0 overflow-y-scroll bg-white">
			<div class="min-h-full w-full h-max sm:w-10/12 z-2 pb-24 mt-5">
				<a href="<?php echo URLROOT; ?>/consultation/request" title="back">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		  				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
					</svg>
				</a>

				<div class="flex flex-col w-full text-start md:w-max mt-5">
					<p class="text-2xl font-bold">New Consultation</p>
					<p class="text-sm text-slate-500">Create new online consultation</p>
				</div>

				<div class="w-full sm:w-10/12">
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>
					<form method="POST" action="<?php echo URLROOT;?>/consultation/add" enctype="multipart/form-data">
						<input name="student-id" type="hidden" value="<?php echo $_SESSION['id'] ?>">
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">Purpose<span class="text-sm font-normal"> (required)</span></span>
							<select name="purpose" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" required>
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
								<textarea name="problem" class="border rounded-sm border-slate-300 py-2 px-2 outline-1 outline-blue-400 mt-5"></textarea>
							</div>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">College / Department<span class="text-sm font-normal"> (required)</span></span>
							<!-- <select name="department" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Option</option>
								<option value="College of Computer Science and Information Technology">College of Computer Science and Information Technology</option>
								<option value="College of Engineering">College of Engineering</option>
								<option value="College of Bussiness and Accountancy">College of Bussiness and Accountancy</option>
								<option value="College of Education">College of Education</option>
								<option value="Guidance">Guidance</option>
								<option value="Clinic">Clinic</option>
							</select> -->

							<input name="department" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" readonly/>
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
						
						<input name="schedule" type="hidden"/>
						<input name="start-time" type="hidden">
						
						<div id="appointment-panel" class="mt-5 hidden">
							<p>Please choose a suitable date and time for your appointment by selecting an available slot from the calendar below. The calendar shows the dates and corresponding time slots that are currently available for scheduling an appointment.</p>
							<div id="calendar" class="flex flex-col md:flex-row gap-2 mt-5 w-full p-4 bg-slate-100"></div>
						</div>

						<div id="timeslots" class="mt-5 hidden">
							<p class="mt-2">All times are in Asia/Manila (UTC+08)</p>
							<div class="grid mt-2 grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-2 w-full h-full bg-slate-100 p-4 rounded-md">
								<button class="timeslot-btn" data-enabled="false" data-time="8:00" disabled><div data-time="8:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">8:00 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="8:30" disabled><div data-time="8:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">8:30 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="9:00" disabled><div data-time="9:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">9:00 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="9:30" disabled><div data-time="9:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">9:30 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="10:00" disabled><div data-time="10:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">10:00 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="10:30" disabled><div data-time="10:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">10:30 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="11:00" disabled><div data-time="11:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">11:00 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="11:30" disabled><div data-time="11:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">11:30 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="12:00" disabled><div data-time="12:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">12:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="12:30" disabled><div data-time="12:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">12:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="13:00" disabled><div data-time="13:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">1:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="13:30" disabled><div data-time="13:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">1:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="14:00" disabled><div data-time="14:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">2:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="14:30" disabled><div data-time="14:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">2:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="15:00" disabled><div data-time="15:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">3:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="15:30" disabled><div data-time="15:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">3:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="16:00" disabled><div data-time="16:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">4:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="16:30" disabled><div data-time="16:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">4:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="17:00" disabled><div data-time="17:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">5:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="17:30" disabled><div data-time="17:30" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">5:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="18:00" disabled><div data-time="18:00" class="px-6 opacity-50 cursor-not-allowed rounded-md py-1 w-full h-max bg-slate-200">6:00 PM</div></button>
							</div>
						</div>

						<div id="appointment-err" class="hidden mt-5 w-full h-full bg-slate-100 p-4 text-red-500 text-center">
							<p></p>
						</div>
						
						<!-- <div class="flex flex-col w-full mt-5 gap-2">
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
						</div> -->
						
						<div class="flex flex-col mt-5 gap-2">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-semibold">Upload Document/s</span>
								<input name="document[]" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="file" multiple="multiple"/>
							</div>
							<p class="text-sm">Document/s to upload must be relevant to the intended consultation</p>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">Preferred Mode of Consultation<span class="text-sm font-normal"> (required)</span></span>
							<select name="mode" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" required>
								<option value="online">Online</option>
								<option value="face-to-face">Face-to-face</option>
							</select>
						</div>

						<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Submit"/>
						<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
					</form>
				</div>

			</div>
		</div>
	</div>
</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/consultation/add/add.js'; ?>
</script>

