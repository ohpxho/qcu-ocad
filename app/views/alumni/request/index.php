<?php 

require APPROOT.'/views/layout/header.php';
require APPROOT.'/views/layout/horizontal-navigation/index.php';

?>

<main class="flex w-full min-h-full pt-20">
	
	<div class="w-max min-h-full pt-12">
		<ul class="">
			<a href="<?php echo URLROOT; ?>/alumni/profile"><li class="hover:bg-slate-200 text-center p-2 px-9">Profile</li></a>
			<a href="<?php echo URLROOT; ?>/alumni/new_request"><li class="bg-slate-200 text-center p-2 px-12">Request</li></a>
			<a id="records-link" href="#"><li class="hover:bg-slate-200 text-center p-2 px-12">Records</li></a>
			<a href="#" id="logout">
				<li class="flex items-center text-red-700 text-center p-2 px-9 justify-center ">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
 						<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
					</svg>
				</li>
			</a>
		</ul>
	</div>
	
	<!-------------------------------- document to request choices ------------------------------------->

	<div class="h-max w-full p-8 px-20 pt-12">
		<div class="flex flex-col">
			<p class="text-2xl font-bold">Request Document</p>
			<p class="text-sm text-slate-500">Pick one document to request</p>
		</div>

		<?php
			require APPROOT.'/views/flash/fail.php';
			require APPROOT.'/views/flash/success.php';
		?>

		<div class="grid grid-cols-2 gap-2 w-full h-max mt-5">
			<a id="tor" href="#" data-doc="TOR" class="doc-option-btn border hover:bg-slate-100 flex flex-col w-full p-4 justify-center">
				<div class="flex items-center gap-2"><p class="text-neutral-700 font-medium">Trancript Of Records</p><span class="err text-sm text-red-500 "></span></div>
				<p class="text-sm text-slate-500">courses taken and grades earned of a student throughout his stay in QCU</p>
			</a>

			<a id="diploma" href="#" data-doc="Diploma" class="doc-option-btn border hover:bg-slate-100 flex flex-col w-full p-4 justify-center">
				<div class="flex items-center gap-2"><p class="text-neutral-700 font-medium">Diploma</p><span class="err text-sm text-red-500"></span></div>
				<p class="text-sm text-slate-500">testifying that the recipient has graduated by successfully completing their courses of studies in QCU</p>
			</a>
			
			<a id="dismissal" href="#" data-doc="Honorable Dismissal" class="doc-option-btn border hover:bg-slate-100 flex flex-col w-full p-4 justify-center">
				<div class="flex items-center gap-2"><p class="text-neutral-700 font-medium">Honorable Dismissal</p><span class="err text-sm text-red-500"></span></div>
				<p class="text-sm text-slate-500">a document voluntary withdrawal of a student from the university with the consent of the University Registrar.</p>
			</a>
		</div>
	</div>

	<!------------------------------------- add new document to request --------------------------------------->

	<div id="add-panel" class="fixed z-50 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll">
		<div class="flex gap-2">
			<a id="add-exit-btn" class="m-2 p-1 hover:bg-slate-100">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
					<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
				</svg>
			</a>
		</div>

		<div class="flex justify-center w-full h-max">
			<div class="flex flex-col w-10/12 pt-5 pb-20">
				<div class="flex flex-col gap2 w-full">
					<a class="text-2xl cursor-pointer font-bold">New Document Request</a>
					<p class="text-sm text-slate-500">Create new academic document request</p>
				</div>

				<div class="w-full">
					<form action="<?php echo URLROOT; ?>/alumni/new_request" method="POST" enctype="multipart/form-data" class="w-full">
						<input name="id" type="hidden" value=""/>

						<div class="flex flex-col mt-5 gap-1">
							<div class="flex flex-col gap-1 w-full">
								<p class="font-semibold">Document<span class="text-sm font-normal"> (required)</span></p>
							</div>
							<input type="text" name="requested-document" value="" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 cursor-not-allowed outline-blue-500 text-neutral-700" readonly>
						</div>

						<div id="tor-last-academic-year-attended-con" class="flex flex-col mt-5 gap-1 hidden">
							<div class="flex flex-col gap-1 w-full">
								<p class="font-semibold">Last Academic Year Attended<span class="text-sm font-normal"> (required)</span></p>
							</div>
							<input type="text" name="tor-last-academic-year-attended" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 cursor-not-allowed outline-blue-500 text-neutral-700" readonly>
						</div>

						<div id="diploma-year-graduated-con" class="flex flex-col mt-5 gap-1 hidden">
							<div class="flex flex-col gap-1 w-full">
								<p class="font-semibold">Year Graduated<span class="text-sm font-normal"> (required)</span></p>
							</div>
							<input type="text" name="diploma-year-graduated" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 cursor-not-allowed outline-blue-500 text-neutral-700" readonly>
						</div>

						<div class="flex flex-col mt-5 gap-1">
							<div class="flex flex-col gap-1 w-full">
								<p class="font-semibold">Purpose<span class="text-sm font-normal"> (required)</span></p>
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

						<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Submit Request"/>
						<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
					</form>

				</div>
			</div>
		</div>
	</div>
</main>

<!------------------------------------ script ------------------------------------>
<script>
	<?php require APPROOT.'/views/alumni/redirect.js'; ?>
	<?php require APPROOT.'/views/alumni/request/request.js'; ?>
</script>