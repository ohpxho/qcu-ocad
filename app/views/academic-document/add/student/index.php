<div class="flex justify-center w-full h-full px-2 md:px-0 overflow-y-scroll bg-white">
	<div class="min-h-full w-full h-max md:w-10/12 z-2 pb-24 mt-5">
		<a href="<?php echo URLROOT; ?>/academic_document" title="back">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
			</svg>
		</a>
		
		<div class="flex flex-col w-full text-start md:w-max mt-5">
			<p class="text-2xl font-bold">New Request</p>
			<p class="text-sm text-slate-500">Create new request for academic documents</p>
		</div>

		<div class="w-full sm:w-10/12">
			<?php
				require APPROOT.'/views/flash/fail.php';
				require APPROOT.'/views/flash/success.php';
			?>
			<form id="add-request-form" method="POST" action="<?php echo URLROOT;?>/academic_document/add" enctype="multipart/form-data">
				<div class="flex flex-col mt-4">
					<input name="student-id" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-400 mt-2" type="hidden" value=""/>
				</div>

				<div class="flex flex-col mt-4">
					<span class="text-neutral-700 font-semibold">Academic Document To Request<span class="text-sm font-normal"> (required)</span></span>
					
					<!------------------------------------ TOR ------------------------------------->
					

					<!------------------------------------ Diploma ------------------------------------->
					
					<!--<div class="flex mt-4 gap-2 pt-2 border-t ">
						<input type="checkbox" name="is-diploma-included" value="1" <?php echo $isDiplomaChecked['for-input']?>>
						<div id="diploma-text" class="flex flex-col">
							<p class="text-neutral-700">TOR / Diploma</p>
							<p class="text-sm text-slate-500">testifying that the recipient has graduated by successfully completing their courses of studies in QCU</p>
						</div>
					</div>
					
					<div id="diploma-hidden-input" class="flex flex-col mt-4 pb-4 <?php echo $isDiplomaChecked['for-hidden-input']?>">
						<span class="text-neutral-700 font-semibold">Year Graduated</span>
						<select name="diploma-year-graduated" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Academic Year</option>
								<option value="2001">2001</option>
								<option value="2002">2002</option>
								<option value="2003">2003</option>
								<option value="2004">2004</option>
								<option value="2005">2005</option>
								<option value="2006">2006</option>
								<option value="2007">2007</option>
								<option value="2008">2008</option>
								<option value="2009">2009</option>
								<option value="2010">2010</option>
								<option value="2011">2011</option>
								<option value="2012">2012</option>
								<option value="2013">2013</option>
								<option value="2014">2014</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
								<option value="2021">2021</option>
								<option value="2022">2022</option>
								<option value="2023">2023</option>
							</select>
					</div>-->

					<!------------------------------------ Grade slip ------------------------------------->

					<div class="flex mt-4 gap-2 pt-2 border-t ">
						<input type="checkbox" name="is-gradeslip-included" value="gradeslip" >
						<div id="gradeslip-text" class="flex flex-col">
							<p class="text-neutral-700"><span>Gradeslip</span></p>
							<p class="text-sm text-slate-500">a document with the grades a student has earned for a specific semester or academic term</p>
						</div>
					</div>

					<div id="gradeslip-hidden-input" class="flex mt-4 gap-1 pb-4 hidden">
						<div class="flex flex-col w-full">
							<span class="text-neutral-700 font-semibold">Academic Year<span class="text-sm font-normal"> (required)</span></span>
							<select name="gradeslip-academic-year" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Option</option>
							</select>
						</div>

						<div class="flex flex-col w-full">
							<span class="text-neutral-700 font-semibold">Semester<span class="text-sm font-normal"> (required)</span></span>
							<select name="gradeslip-semester" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
								<option value="">Choose Semester</option>
								<option value="1">1st</option>
								<option value="2">2nd</option>
							</select>
						</div>
					</div>

					<!------------------------------------ CTC ------------------------------------->

					<div class="flex mt-4 gap-2 pt-2 border-t ">
						<input type="checkbox" name="is-ctc-included" value="ctc">
						<div id="ctc-text" class="flex flex-col">
							<p class="text-neutral-700"><span>Authentication / Certified True Copy</span></p>
							<p class="text-sm text-slate-500">a document that has been verified as an exact copy of the original document by an authorized person</p>
						</div>
					</div>

					<div id="ctc-hidden-input" class="flex flex-col mt-4 pb-4 hidden">
						<span class="text-neutral-700 font-semibold">Clear Copy of Document<span class="text-sm font-normal"> (required)</span></span>
						<input name="ctc-document" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="file" accept="application/pdf"/>
					</div>

					<!------------------------------------ Other Certification ------------------------------------->
					
					<div class="flex mt-4 gap-2 pt-2 border-t ">
						<input type="checkbox" name="is-other-document-included" value="other">
						<span class="text-neutral-700">Other Document</span>
					</div>

					<div id="other-requested-document-hidden-input" class="flex flex-col pb-4 mt-4 hidden">
						<span class="text-neutral-700 font-semibold">Specify Document<span class="text-sm font-normal"> (required)</span></span>
						<input name="other-requested-document" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="text" value=""/>
					</div>
				</div>

				<!------------------------------------ Quantity ------------------------------------->

				<div class="flex flex-col mt-5">
					<div class="flex flex-col">
						<p class="text-neutral-700 font-semibold">Quantity<span class="text-sm font-normal"> (required)</span></p>
					</div>
					<input name="quantity" type="number" min="1" max="5" value="1" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" required />
				</div>

				<!------------------------------------ Purpose of Request ------------------------------------->

				<div class="flex flex-col mt-5">
					<div class="flex flex-col">
						<p class="text-neutral-700 font-semibold">Purpose of Request<span class="text-sm font-normal"> (required)</span></p>
						<p class="text-sm text-slate-500">dont write a lot of unnecessary sentences - make it clear and short</p>
					</div>
					<div class="flex flex-col gap-1">
					<textarea name="purpose-of-request" class="border rounded-sm border-slate-300 py-2 px-2 outline-1 outline-blue-400 mt-4" required></textarea>
					<p class="text-sm text-slate-500">e.g., for employment, for scholarhip, for board exam</p>
					</div>
				</div>
				
				<input id="add-submit-btn" class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Submit"/>
				<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
			</form>
		</div>

	</div>
</div>

<script>
	<?php require APPROOT.'/views/academic-document/add/student/student.js'; ?>
</script>

