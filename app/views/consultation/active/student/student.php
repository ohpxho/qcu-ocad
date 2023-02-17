<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-3xl font-bold">Active Online Consultations</p>
		<p class="text-sm text-slate-500">Review and manage your active online consultation</p>
	</div>
</div>

<div class="flex flex-col mt-10 gap-2 pb-24">
	
	<?php
		require APPROOT.'/views/flash/fail.php';
		require APPROOT.'/views/flash/success.php';
	?>

	<div class="grid w-full justify-items-end">
		<div class="flex w-full gap-2 items-end">
			<div class="flex flex-col gap-1 w-1/2">
				<p class="font-semibold">What are you looking for?</p>
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

			<a id="search-btn" class="flex bg-blue-700 text-white rounded-md px-4 py-1 h-max">Search</a>

		</div>	
	</div>
	
	<table id="request-table" class="bg-white text-sm mt-5">
		<thead class="font-semibold">
			<tr>
				<th class="hidden">Consultation ID</th>
				<th>Date Requested</th>
				<th>Adviser</th>
				<th>Subject Code</th>
				<th>Purpose</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			
			<?php
				foreach ($data['active-requests-data'] as $key => $row):
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
					}

			?>
					<tr class="border-b border-slate-200">
						<td class="font-semibold hidden"><?php echo $row->id; ?></td>
						<td><?php echo $date_created; ?></td>
						<td><?php echo $row->adviser_name; ?></td>
						<td><?php echo $row->subject; ?></td>

						<td><?php echo $purpose; ?></td>
						<td><span class="bg-green-100 text-green-700 rounded-full px-5 py-1">active</span></td>
						
						<td class="text-center">
							<a class="hover:text-blue-700" class="text-blue-700" href="<?php echo URLROOT.'/consultation/show/'.$row->id; ?>">view</a>
						</td>
						
					</tr>
			<?php
				endforeach;
			?>
		
		</tbody>
	</table>
</div>

<!-------------------------------------- view panel ---------------------------------->

<div id="view-panel" class="fixed z-30 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-9">
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
				<p class="text-2xl font-bold">Request #<span id="request-id"></span></p>
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
				<span class="pl-2 pt-2 pb-4" id="problem"></span>
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
						<td id="shared-file" width="70" class="hover:bg-slate-100 p-1 pl-2"></td>
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



