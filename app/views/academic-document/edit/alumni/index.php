<div class="flex justify-center w-full h-full overflow-y-scroll">
	<div class="h-max w-10/12 py-14 pb-24">
		<div class="flex flex-col">
			<p class="text-2xl font-bold">Edit Request</p>
			<p class="text-sm text-slate-500">Update request for academic documents</p>
		</div>

		<div class="w-10/12">
			<?php
				require APPROOT.'/views/flash/fail.php';
				require APPROOT.'/views/flash/success.php';
			?>
			<form method="POST" action="<?php echo URLROOT;?>/academic_document/edit/<?php echo $data['input-details']->id ?>" enctype="multipart/form-data">
				<div class="flex flex-col mt-4">
					<input name="request-id" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-400 mt-2" type="hidden" value=""/>
					<input name="student-id" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-400 mt-2" type="hidden" value=""/>
				</div>

				<div class="flex flex-col mt-4">
					<span class="text-neutral-700 font-semibold">Academic document to request<span class="text-sm font-normal"> (required)</span></span>
					
					<!------------------------------------ TOR ------------------------------------->

					<div class="flex mt-4 gap-2 items-center justify-between pt-2 border-t ">
						<div class="flex gap-2">
							<input type="checkbox" name="is-tor-included" value="tor" >
							<div id="tor-text" class="flex flex-col">
								<p class="text-neutral-700"><span>Transcript of Records</span></p>
								<p class="text-sm text-slate-500">an official document that provides a summary of a student's academic performance in university</p>
							</div>
						</div>
						<div title="you don't need to pay if RA11261 beneficiary" class="px-4 cursor-pointer py-2 rounded-full bg-slate-100 text-slate-500">P 300</div>
					</div>

					<div id="tor-hidden-input" class="flex flex-col mt-4 pb-4 hidden">
						<span class="text-neutral-700 font-semibold">Last academic year attended <span class="text-sm font-normal">(required)</span></span>
						<input type="text" name="tor-last-academic-year-attended" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 cursor-not-allowed outline-blue-500 mt-2 text-neutral-700" readonly>
					</div>

					<!------------------------------------ Diploma ------------------------------------->

					<div class="flex mt-4 gap-2 pt-2 border-t ">
						<input type="checkbox" name="is-diploma-included" value="diploma">
						<div id="diploma-text" class="flex flex-col">
							<p class="text-neutral-700"><span>Diploma</span></p>
							<p class="text-sm text-slate-500">a certificate that proves that you have completed a certain course of education</p>
						</div>
					</div>

					<div id="diploma-hidden-input" class="flex flex-col mt-4 pb-4 hidden">
						<span class="text-neutral-700 font-semibold">Year graduated <span class="text-sm font-normal">(required)</span></span>
						<input type="text" name="diploma-year-graduated" class="cursor-not-allowed border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" readonly>
					</div>

					<!------------------------------------ Honorable Dismissal ------------------------------------->
					
					<div class="flex mt-4 gap-2 pt-2 border-t ">
						<input type="checkbox" name="is-honorable-dismissal-included" value="honorable dismissal">
						<div id="dismissal-text" class="flex flex-col">
							<p class="text-neutral-700"><span>Honorable Dismissal</span></p>
							<p class="text-sm text-slate-500">a document that confirms that a student has voluntarily withdrawn from a program or course of study in good standing</p>
						</div>
					</div>
				</div>

				<!------------------------------------ Purpose of Request ------------------------------------->

				<div class="flex flex-col mt-5">
					<div class="flex flex-col">
						<p class="text-neutral-700 font-semibold">Purpose of Request<span class="text-sm font-normal"> (required)</span></p>
						<p class="text-sm text-slate-500">dont write a lot of unnecessary sentences - make it clear and short</p>
					</div>
					<div class="flex flex-col gap-1">
					<textarea name="purpose-of-request" class="border rounded-sm border-slate-300 py-2 px-2 outline-1 outline-blue-400 mt-4"></textarea>
					<p class="text-sm text-slate-500">e.g., for employment, for scholarhip, for board exam</p>
					</div>
				</div>
				
				<!------------------------------------ RA11261 beneficiary ------------------------------------->

				<div class="flex flex-col mt-5">
					<span class="text-neutral-700 font-semibold">Are you an RA11261 "FIRST TIME JOBSEEKERS ASSISTANCE ACT" Beneficiary ?<span class="text-sm font-normal"> (required)</span></span>
					<select name="is-RA11261-beneficiary" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700">
						<option value="">Choose Option</option>
						<option value="yes">YES</option>
						<option value="no">NO</option>
					</select>
				</div>

				<div id="RA11261-beneficiary-hidden-input" class="flex flex-col mt-4 gap-2 hidden">
					<div class="flex flex-col gap-2">
						<span class="text-neutral-700 font-semibold">Barangay Certification(First Time Jobseekers Act-RA 11261)<span class="text-sm font-normal"> (required)</span></span>
						<input name="barangay-certificate" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400" type="file" accept="application/pdf"/>
					</div>

					<div class="flex flex-col gap-2">
						<span class="text-neutral-700 font-semibold">Oath Of Undertaking<span class="text-sm font-normal"> (required)</span></span>
						<input name="oath-of-undertaking" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400" type="file" accept="application/pdf"/>
					</div>
				</div>

				<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Submit request"/>
				<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
			</form>
		</div>

	</div>
</div>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/academic-document/edit/alumni/alumni.js'; ?>
</script>
