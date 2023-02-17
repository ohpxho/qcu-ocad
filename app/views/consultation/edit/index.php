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
					<p class="text-3xl font-bold">Edit Request</p>
					<p class="text-sm text-slate-500"></p>
				</div>

				<div class="w-10/12">
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>
					<form method="POST" action="<?php echo URLROOT.'/consultation/edit/'.$details->id; ?>" enctype="multipart/form-data">
						<input name="request-id" type="hidden" value="">
						
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">Purpose</span>
							<select name="purpose" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Purpose</option>
								<option value="1">Thesis/Capstone Advising</option>
								<option value="4">Lecture Inquiries</option>
								<option value="2">Project Concern/Advising</option>
								<option value="3">Grades Consulting</option>
								<option value="6">Performance Consulting</option>
								<option value="5">Exams/Quizzes/Assignment Concern</option>
								<option value="7">Counseling</option>
								<option value="8">Report</option>
							</select>
						</div>

						<div class="flex flex-col mt-5">
							<div class="flex flex-col pb-2">
								<p class="text-neutral-700 font-semibold">Problem</p>
							</div>
							<div class="flex flex-col gap-1">
								<textarea name="problem" class="border rounded-sm border-slate-300 py-2 px-2 outline-1 outline-blue-400 mt-5"></textarea>
							</div>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">College / Department</span>
							<select name="department" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Option</option>
								<option value="information technology">Computer Science And Information Technology</option>
								<option value="engineering">Engineering</option>
								<option value="entrepreneurship">Bussiness And Accountancy</option>
								<option value="accountancy">Education</option>
								<option value="guidance">Guidance</option>
							</select>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">Subject Code</span>
							<select name="subject" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Purpose</option>
								<option value="SAM101">SAM101</option>
								<option value="ALGO101">ALGO101</option>
								<option value="NETOWRKING1">NETWORKING1</option>
								<option value="NETWORKING2">NETWORKING2</option>
							</select>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-semibold">Adviser</span>
							<select name="adviser-id" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Purpose</option>
								<option value="1900001">Lalaine Carrao</option>
								<option value="120003">Isagani Tano</option>
							</select>
						</div>

						<div class="flex w-full mt-5 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-semibold">Preferred Date</span>
								<input name="preferred-date" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="date" value=""/>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-semibold">Preferred Time</span>
								<select name="preferred-time" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
									<option value="">Choose Option</option>
									<option value="Anytime">Anytime</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="8:00 AM">8:00 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="6:00 PM">6:00 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="8:00 PM">8:00 PM</option>
								</select>
							</div>
						</div>

						<div class="flex flex-col w-full mt-5 pb-4">
							<span class="text-neutral-700 font-semibold">Share File/s</span>
							<input name="document[]" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="file" multiple="multiple"/>

							<div class="flex flex-col gap-2 mt-5">
								<p>Shared file/s</p>
								<div id="shared-file" class="flex flex-col gap-1"></div>	
							</div>
						</div>

						<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Update Request"/>
						<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. SMS or Email will be sent afterwards. </p>
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

