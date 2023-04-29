<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col w-full text-start md:w-max">
		<p class="text-2xl font-bold">Online Consultation</p>
		<p class="text-sm text-slate-500">Review and manage your active online consultation</p>
	</div>
</div>

<div class="flex flex-col mt-1 sm:mt-5 gap-2 pb-24">
	<div class="grid w-full md:justify-items-end mt-5">
		<div class="flex flex-col md:flex-row w-full gap-2 border p-4 bg-white rounded-md md:items-end">
			<div class="flex flex-col gap-1 w-full md:w-1/2">
				<p class="font-semibold">Search Records</p>
				<input id="search" class="border rounded-sm bg-slate-100 border-slate-300 py-2 sm:py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
			</div>

			<!-- <div class="flex flex-col gap-1 w-full md:w-1/4">
				<p class="font-semibold">Purpose</p>
				<select id="purpose-filter" class="border rouded-sm border-slate-300 bg-slate-100 py-2 sm:py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
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
			</div> -->

			<div class="flex flex-col gap-1 w-full md:w-1/2">
				<p class="font-semibold">Date</p>
				<select id="date-filter" class="border rouded-sm border-slate-300 bg-slate-100 py-2 sm:py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
					<option value="">All</option>
				</select>
			</div>

			<a id="search-btn" class="flex gap-1 items-center justify-center md:justify-start bg-blue-700 text-white rounded-md px-4 h-max mt-3 py-2 sm:py-1 md:py-0 md:mt-0">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-8 md:h-8">
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

	<div class="flex flex-col gap-2 px-4 py-2 border bg-white rounded-md mt-5">
		<div class="flex flex-col md:flex-row md:justify-between py-2">
			<p class="p-2 pl-0 sm:pl-2 font-semibold">Consultation Summary</p>		
			<div class="flex flex-col sm:gap-2 items-start md:items-end mt-3 md:mt-0">
				<p class="font-medium">
					<?php
						date_default_timezone_set('Asia/Manila');
						$date = date('Y-m-d'); 
						echo formatDate($date);
					?>
				</p>
				<p class="text-sm">today</p>
			
			</div>
		</div>

		<div class="overflow-x-scroll pb-4">
			<table id="request-table" class="bg-slate-50 text-sm">
				<thead class="bg-slate-100 text-slate-900 font-medium">
					<tr>
						<th class="hidden">Consultation ID</th>
						<th>Date Requested</th>
						<th>Adviser</th>
						<th>Department</th>
						<th>Subject Code</th>
						<th>Purpose</th>
						<th>Schedule</th>
						<th>Start</th>
						<th>Mode</th>
						<th>Status</th>
						<th></th>
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
								case 9:
									$purpose = 'Health Concern';
									break;
							}

							$currentDateTime = new DateTime();
							$datetimeToCompare = DateTime::createFromFormat('Y-m-d H:i', $row->schedule.' '.$row->start_time);
							
							$isSchedBehindCurrentDateTime = false;
							
							if($datetimeToCompare < $currentDateTime) {
								$isSchedBehindCurrentDateTime = true;
							}

					?>
						<?php if(!$isSchedBehindCurrentDateTime): ?>
							<tr class="border-b border-slate-200">
								<td class="font-semibold hidden"><?php echo $row->id; ?></td>
								<td><?php echo $date_created; ?></td>
								<td><?php echo $row->adviser_name; ?></td>
								<td><?php echo $row->department; ?></td>
								<td><?php echo (empty($row->subject))? 'N/A': $row->subject; ?></td>

								<td><?php echo $purpose; ?></td>
								<td><?php echo formatDate($row->schedule); ?></td>
								<td><?php echo formatTime($row->start_time); ?></td>
								<td><?php echo $row->mode; ?></td>
								<td><span class="bg-green-500 text-white rounded-md px-1 py-1">active</span></td></td>
								
								<td class="text-center">
									<a class="hover:text-blue-700" class="text-blue-700" href="<?php echo URLROOT.'/consultation/show/active/'.$row->id; ?>">view</a>
								</td>

								<td class="border-b border-white"> </td>
							</tr>
						<?php else: ?>
							<tr class="border-b border-slate-200 bg-red-100 text-red-700">
								<td class="font-semibold hidden"><?php echo $row->id; ?></td>
								<td><?php echo $date_created; ?></td>
								<td><?php echo $row->adviser_name; ?></td>
								<td><?php echo $row->department; ?></td>
								<td><?php echo (empty($row->subject))? 'N/A': $row->subject; ?></td>

								<td><?php echo $purpose; ?></td>
								<td><?php echo formatDate($row->schedule); ?></td>
								<td><?php echo formatTime($row->start_time); ?></td>
								<td><?php echo $row->mode; ?></td>
								<td><span class="bg-green-500 text-white rounded-md px-1 py-1">active</span></td>
								
								<td class="text-center">
									<a class="hover:text-blue-700" class="text-blue-700" href="<?php echo URLROOT.'/consultation/show/active/'.$row->id; ?>">view</a>
								</td>

								<td class="border-b border-white"></td>
							</tr>
						<?php endif; ?>
					<?php
						endforeach;
					?>
				
				</tbody>
			</table>
		</div>
	</div>
</div>


<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/consultation/active/student/student.js';
	?>
</script>



