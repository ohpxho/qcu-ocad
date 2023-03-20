<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Online Consultation Requests</p>
		<p class="text-sm text-slate-500">Review and manage your online consultation requests</p>
	</div>
	<div >
		
	</div>
</div>

<div class="flex flex-col mt-5 gap-2 pb-24">
	<div class="grid w-full justify-items-end mt-5">
		<div class="flex w-full gap-2 border p-4 bg-slate-100 rounded-md items-end">
			<div class="flex flex-col gap-1 w-1/2">
				<p class="font-semibold">Search Records</p>
				<input id="search" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
			</div>

			<div class="flex flex-col gap-1 w-1/2">
				<p class="font-semibold">Purpose</p>
				<select id="purpose-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
					<option value="">All</option>
					<option value="Thesis/Capstone Advising">Thesis/Capstone Advising</option>
					<option value="Lecture Inquiries">Lecture Inquiries</option>
					<option value="Project Concern/Advising">Project Concern/Advising</option>
					<option value="Grades Consulting">Grades Consulting</option>
					<option value="Performance Consulting">Performance Consulting</option>
					<option value="Exams/Quizzes/Assignment Concern">Exams/Quizzes/Assignment Concern</option>
					<option value="Counseling">Counseling</option>
					<option value="Report">Report</option>
				</select>
			</div>

			<div class="flex flex-col gap-1 w-1/2">
				<p class="font-semibold">Department</p>
				<select id="department-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
					<option value="">All</option>
					<option value="College of Computer Science and Information Technology">College of Computer Science and Information Technology</option>
					<option value="College of Engineering">College of Engineering</option>
					<option value="College of Bussiness and Accountancy">College of Bussiness and Accountancy</option>
					<option value="College of Education">College of Education</option>
					<option value="Guidance">Guidance</option>
					<option value="Clinic">Clinic</option>
				</select>
			</div>

			<a id="search-btn" class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 h-max">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
				</svg>

				<span>Search</span>
			</a>

		</div>	
	</div>
	
	<?php
		require APPROOT.'/views/flash/fail.php';
		require APPROOT.'/views/flash/success.php';
	?>

	<div class="flex flex-col gap-2 px-4 py-2 border rounded-md mt-5">
		<div class="flex items-center justify-between py-2">
			<p class="p-2 font-medium">Consultation Summary</p>
			<div class="flex gap-2 items">
				<a href="<?php echo URLROOT;?>/consultation/add">
					<li class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1"> 
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
						</svg>
						<span>New Consultation</span> 
					</li>
				</a>
			</div>
		</div>

		<table id="request-table" class="bg-white text-sm">
			<thead class="bg-slate-100 text-slate-900 font-medium">
				<tr>
					<th class="hidden">Consultation ID</th>
					<th>Date Requested</th>
					<th>Adviser</th>
					<th>Department</th>
					<th>Subject Code</th>
					<th>Purpose</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				
				<?php
					foreach ($data['pending-requests-data'] as $key => $row):
						$date_created = new DateTime($row->date_requested);
						if(empty($row->date_requested)) {
							$date_created = '---- -- --';
						} else {
							$date_created = $date_created->format('m/d/Y');
						}

						$purpose = '';

						switch($row->purpose) {
							case 1:
								$purpose = 'Thesis/Capstone Advising';
								break; 
							case 2:
								$purpose = 'Project Concern/Advising';
								break;
							case 3:
								$purpose = 'Grades Consulting';
								break;
							case 4:
								$purpose = 'Lecture Inquiries';
								break;
							case 5:
								$purpose = 'Exams/Quizzes/Assignment Concern';
								break;
							case 6: 
								$purpose = 'Performance Consulting';
								break;
							case 7:
								$purpose = 'Counseling';
								break;
							case 8:
								$purpose = 'Report';
								break;
							case 9:
								$purpose = 'Health Concern';
								break;

						}

				?>
						<tr class="border-b border-slate-200">
							<td class="font-semibold hidden"><?php echo $row->id; ?></td>
							<td><?php echo $date_created; ?></td>
							<td><?php echo (empty($row->adviser_name))? 'N/A' : $row->adviser_name; ?></td>
							<td class="truncate ..."><?php echo $row->department; ?></td>
							<td><?php echo (empty($row->subject))? 'N/A' : $row->subject; ?></td>

							<td><?php echo $purpose; ?></td>
							<td><span class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1">pending</span></td>
							
							<td class="text-center">
								<a class="hover:text-blue-700 view-btn" class="text-blue-700" href="#">view</a>
								<a class="hover:text-blue-700 edit-btn" href="<?php echo URLROOT.'/consultation/edit/'.$row->id; ?>">edit</a>
								<a class="text-red-700 drop-btn" href="<?php echo URLROOT.'/consultation/cancel/'.$row->id ;?>" >cancel</a>
							</td>
							
						</tr>
				<?php
					endforeach;
				?>
			
			</tbody>
		</table>
	</div>
</div>

<!-------------------------------------- view panel ---------------------------------->

<div id="view-panel" class="fixed z-30 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
	<div class="flex gap-2">
		<a id="view-exit-btn" class="m-2 p-1 hover:bg-slate-100">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
				<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
			</svg>
		</a>
	</div>

	<div class="flex justify-center w-full h-max">
		<div class="flex flex-col w-10/12 pt-10 pb-20">
			<div class="flex flex-col gap2 w-full">
				<p class="text-2xl font-bold">CONSULTATION <span class="font-normal" id="request-id"></span></p>
				<p class="text-sm text-slate-500">If the below information is not accurate, please contact an admin to address the problem.</p>
			</div>

			<div class="flex flex-col gap2 w-full mt-6">
				<table class="w-full table-fixed">
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Status</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="status"></span></td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Purpose</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="purpose" ></span></td>
					</tr>
					
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Date Created</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="date-created" class=""></span></td>
					</tr>
					
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Adviser</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2">
							<p id="adviser"></p>
						</td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Department</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="department"></span></td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Subject Code</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="subject"></span></td>
					</tr>
				</table>	
			</div>

			<div class="flex flex-col gap2 w-full mt-2">
				<div class="pl-2 pt-2 pb-4 flex flex-col gap-1">
					<p class="font-semibold">Problem</p>
					<p class="text-slate-500 text-sm">Focus subject of consultation</p>
				</div>
				<div class="pl-2 pt-2 pb-4" id="problem"></div>
			</div>

			<div class="flex flex-col gap2 w-full mt-2">
				<p class="pl-2 pt-2 pb-4 font-semibold">Additional Information</p>
				<table class="w-full table-fixed">
					
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Preferred Date</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="preferred-date" class=""></span></td>
					</tr>
				
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Preferred Time</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="preferred-time" class=""></span></td>
					</tr>
					
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Shared File</td>
						<td id="shared-file" height="70" class="h-max flex flex-col gap-2 hover:bg-slate-100 p-1 pl-2"></td>
					</tr>
				</table>
			</div>

			<div class="flex flex-col gap2 w-full mt-2">
				<p class="pl-2 pt-2 pb-4 font-semibold">Remarks</p>
				<div class="w-full pl-2">
					<p id="remarks">...</p>
				</div>
			</div>

		</div>
	</div>
</div>


<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/consultation/request/student/student.js';
	?>
</script>



