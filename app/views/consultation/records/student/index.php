<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Online Consultation Records</p>
		<p class="text-sm text-slate-500">Review and manage your online consultation records</p>
	</div>
</div>

<div class="flex flex-col mt-10 gap-2 pb-24">
	
	<?php
		require APPROOT.'/views/flash/fail.php';
		require APPROOT.'/views/flash/success.php';
	?>

	<div class="grid w-full justify-items-end">
		<div class="flex w-full gap-2 border p-4 bg-slate-100 rounded-md items-end">
			<div class="flex flex-col gap-1 w-1/2">
				<p class="font-semibold">Search Records</p>
				<input id="search" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
			</div>

			<div class="flex flex-col gap-1 w-1/4">
				<p class="font-semibold">Status</p>
				<select id="status-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
					<option value="">All</option>
					<option value="resolved">Resolved</option>
					<option value="cancelled">Cancelled</option>
					<option value="declined">Declined</option>
				</select>
			</div>

			<div class="flex flex-col gap-1 w-1/4">
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
					<option value="Health Concern">Health Concern</option>
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
	
	<div class="flex flex-col gap-2 px-4 py-2 border rounded-md mt-5">
		<div class="flex items-center justify-between py-2">
			<p class="p-2 font-medium">Consultation Summary</p>
			<div class="flex gap-2 items">
				<!--<button id="export-table-btn" class="flex bg-blue-700 text-white rounded-md px-4 py-1 h-max">
					Export Table
				</button>-->
			</div>
		</div>

		<table id="request-table" class="bg-white text-sm">
			<thead class="bg-slate-100 text-slate-900 font-medium">
				<tr>
					<th class="hidden">Consultation ID</th>
					<th>Date Requested</th>
					<th>Date Completed</th>
					<th>Adviser</th>
					<th>Purpose</th>
					<th>Status</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				
				<?php
					foreach ($data['requests-data'] as $key => $row):
						$date_created = new DateTime($row->date_requested);
						if(empty($row->date_requested)) {
							$date_created = '---- -- --';
						} else {
							$date_created = $date_created->format('m/d/Y');
						}

						$date_completed = new DateTime($row->date_completed);
						if(empty($row->date_completed)) {
							$date_completed = '---- -- --';
						} else {
							$date_completed = $date_completed->format('m/d/Y');
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
							<td><?php echo $date_completed; ?></td>
							<td><?php echo $row->adviser_name; ?></td>

							<td><?php echo $purpose; ?></td>
							<td>
								<?php if($row->status == 'resolved'): ?>
									<span class="bg-green-100 text-green-700 rounded-full px-5 py-1"><?php echo $row->status ?></span>
								<?php else: ?>
									<span class="bg-red-100 text-red-700 rounded-full px-5 py-1"><?php echo $row->status ?></span>
								<?php endif; ?>
							</td>
							
							<td class="text-center">
								<a class="hover:text-blue-700" class="text-blue-700" href="<?php echo URLROOT.'/consultation/show/records/'.$row->id; ?>">view</a>
							</td>

							<td class="border-b border-white"> </td>
						</tr>
				<?php
					endforeach;
				?>
			
			</tbody>
		</table>
	</div>

	<div class="flex flex-col items-start gap-2 mt-5">
		<div class="flex gap-2">
			<div class="w-1/2 border p-4 rounded-md bg-slate-50">
				<div class="flex flex-col">
					<p class="font-medium"><?php echo date('Y')?> Activity Graph</p>
					<p class="text-sm text-slate-500">You activity graph of the current year for academic document request</p>
				</div>

				<div class="flex flex-col gap-2 w-full h-max rounded-md border p-4 py-6 bg-white overflow-hidden hover:overflow-x-scroll mt-3">
					<div class="w-max" id="calendar-activity-graph"></div>
				</div>

				<div class="flex items-center justify-end mt-3">
					<div class="flex gap-2 items-center text-sm ">
						<span>Less</span>
						<svg width="10" height="10">
	                		<rect width="10" height="10" fill="#CBD5E1" data-level="0" rx="2" ry="2"></rect>
	              		</svg>
	              		<svg width="10" height="10">
	                		<rect width="10" height="10" fill="#86EFAC" data-level="0" rx="2" ry="2"></rect>
	              		</svg>
	              		<svg width="10" height="10">
	                		<rect width="10" height="10" fill="#4ADE80" data-level="0" rx="2" ry="2"></rect>
	              		</svg>
	              		<svg width="10" height="10">
	                		<rect width="10" height="10" fill="#16A34A" data-level="0" rx="2" ry="2"></rect>
	              		</svg>
	              		<svg width="10" height="10">
	                		<rect width="10" height="10" fill="#166534" data-level="0" rx="2" ry="2"></rect>
	              		</svg>
						<span>More</span>
					</div>
				</div>
			</div>

			<div class="flex flex-col gap-2 w-2/6 h-max p-4 shadow-sm border rounded-md">
				<p class="font-medium">Frequency of Request by Status</p>
				
				<table class="w-full table-fixed">
					<?php
						$freq = $data['consultation-frequency'];
						$pendingCount = isset($freq->PENDING)? $freq->PENDING : '0';
						$activeCount = isset($freq->ACTIVE)? $freq->ACTIVE : '0';
						$resolvedCount = isset($freq->RESOLVED)? $freq->RESOLVED : '0';
						$unresolvedCount = isset($freq->UNRESOLVED)? $freq->UNRESOLVED : '0';
						$rejectedCount = isset($freq->REJECTED)? $freq->REJECTED : '0';
					?>
					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Pending</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="tor-count"><?php echo $pendingCount ?></span></td>
					</tr>
					
					<tr class="bg-slate-100">
						<td width="80" class="p-1 pl-2 border text-sm ">Active</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="tor-count"><?php echo $activeCount ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Resolved</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="tor-count"><?php echo $resolvedCount ?></span></td>
					</tr>

					<tr class="bg-slate-100">
						<td width="80" class="p-1 pl-2 border border text-sm ">Cancelled</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="gradeslip-count"><?php echo $unresolvedCount ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border border text-sm ">Declined</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="ctc-count"><?php echo $rejectedCount ?></span></td>
					</tr>

				</table>
			</div>
		</div>

		<div id="activity-panel" class="flex flex-col w-1/2 h-64 overflow-y-scroll mt-5">
			<p class="font-medium">Activities</p>
			<p class="text-sm text-slate-500">
				<?php
					echo date('d F Y');
				?>	
			</p>

			<div class="flex flex-col w-full mt-5 ml-4">
				<?php if(count($data['activity']) > 0): ?>
					<?php foreach($data['activity'] as $row): ?>
						<div class="before:content-[''] before:absolute before:top-0 before:left-0 before:w-0.5 before:h-full before:bg-orange-700 flex flex-col gap-1 pl-6 py-3">
							<div class="absolute w-2 h-2 rounded-full bg-orange-700 -left-[3px] top-8"></div>
							<p class=""><?php echo ucwords($row->description) ?></p>
							<?php
								$dtacted = new DateTime($row->date_acted);
								$dtacted = $dtacted->format('d F Y');
							?>
							<p class="text-sm text-orange-700"><?php echo $dtacted ?></p>
						</div>
					<?php endforeach;?>
				<?php else: ?>
						<div class="before:content-[''] before:absolute before:top-0 before:left-0 before:w-0.5 before:h-full before:bg-slate-200 flex flex-col gap-1 pl-6 py-3">
							<div class="absolute w-2 h-2 rounded-full bg-slate-300 -left-[3px] top-5"></div>
							<p class="text-slate-500">no activity found</p>
						</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>


<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/consultation/records/student/student.js';
	?>
</script>



