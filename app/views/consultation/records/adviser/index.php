<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Online Consultation</p>
		<p class="text-sm text-slate-500">Review and manage online consultation records</p>
	</div>
</div>

<div class="flex flex-col mt-5 gap-2 pb-24">
	
	<?php
		require APPROOT.'/views/flash/fail.php';
		require APPROOT.'/views/flash/success.php';
	?>

	<div class="grid w-full justify-items-end mt-5">
		<div class="flex w-full gap-2 border p-4 bg-white rounded-md items-end">
			<div class="flex flex-col gap-1 w-1/2">
				<p class="font-semibold">Search Records</p>
				<input id="search" class="border rounded-sm border-slate-300 bg-slate-100 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
			</div>

			<div class="flex flex-col gap-1 w-1/4">
				<p class="font-semibold">Status</p>
				<select id="status-filter" class="border rouded-sm border-slate-300 bg-slate-100 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
					<option value="">All</option>
					<option value="pending">Pending</option>
					<option value="active">Active</option>
					<option value="resolved">Resolved</option>
					<option value="declined">Declined</option>
					<option value="cancelled">Cancelled</option>
				</select>
			</div>

			<div class="flex flex-col gap-1 w-1/4">
				<p class="font-semibold">Purpose</p>
				<select id="purpose-filter" class="border rouded-sm border-slate-300 bg-slate-100 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
					<option value="">All</option>
					<?php if($_SESSION['type'] == 'professor' || $_SESSION['type'] == 'sysadmin'): ?>
						<option value="Thesis/Capstone Advising">Thesis/Capstone Advising</option>
						<option value="Lecture Inquiries">Lecture Inquiries</option>
						<option value="Project Concern/Advising">Project Concern/Advising</option>
						<option value="Grades Consulting">Grades Consulting</option>
						<option value="Performance Consulting">Performance Consulting</option>
						<option value="Exams/Quizzes/Assignment Concern">Exams/Quizzes/Assignment Concern</option>
					<?php endif; ?>

					<?php if($_SESSION['type'] == 'clinic' || $_SESSION['type'] == 'sysadmin'): ?>
						<option value="Health Concern">Health Concern</option>
					<?php endif; ?>

					<?php if($_SESSION['type'] == 'guidance' || $_SESSION['type'] == 'sysadmin'): ?>
						<option value="Counseling">Counseling</option>
						<option value="Report">Report</option>
					<?php endif; ?>
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

	<div class="flex flex-col gap-2 px-4 py-2 border rounded-md bg-white mt-5">
		<div class="flex items-center justify-between py-2">
			<p class="p-2 font-semibold">Consultation Summary</p>
			<div class="flex gap-2 items">
				<button id="export-table-btn" class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1 h-max">
					<!--<div class="flex items-center text-blue-700 gap-1">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
	 						 <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
						</svg>
					</div>-->
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
					</svg>

					Export Table
				</button>

				<button id="generate-report-modal-btn" class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1 h-max">
					<!--<div class="flex items-center text-blue-700 gap-1">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
	 						 <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
						</svg>
					</div>-->
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
					 	<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
					</svg>

					Generate Report
				</button>
			</div>
		</div>

		<table id="request-table" class="bg-slate-50 text-sm">
			<thead class="bg-slate-100 text-slate-900 font-medium">
				<tr>
					<th class="hidden">Consultation ID</th>
					<th class="flex gap-2 items-center">Student</th>
					<th>Date Requested</th>
					<th>Date Completed</th>
					<th>Purpose</th>
					<th>Mode</th>
					<th>Status</th>
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
							<td class="flex gap-2 items-center"><?php echo $row->creator_name; ?></td>
							<td><?php echo $date_created; ?></td>
							<td><?php echo $date_completed; ?></td>

							<td><?php echo $purpose; ?></td>
							<td><?php echo $row->mode; ?></td>
							<td>
								<?php if($row->status == 'resolved' || $row->status == 'active'): ?>
									<span id="status-btn" class="bg-green-100 text-green-700 rounded-full px-5 py-1"><?php echo $row->status ?></span>
								<?php elseif($row->status == 'pending'):?> 
									<span id="status-btn" class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1"><?php echo $row->status ?></span>
								<?php elseif($row->status == 'unresolved'): ?>
									<span id="status-btn" class="bg-red-100 text-red-700 rounded-full px-5 py-1">cancelled</span>
								<?php elseif($row->status == 'rejected'): ?>
									<span id="status-btn" class="bg-red-100 text-red-700 rounded-full px-5 py-1">declined</span>
								<?php endif; ?>
							</td>
							
							<td class="text-center">
								<a class="hover:text-blue-700" class="text-blue-700" href="<?php echo URLROOT.'/consultation/show/records/'.$row->id; ?>">view</a>
							</td>
						</tr>
				<?php
					endforeach;
				?>
			
			</tbody>
		</table>
	</div>

	<!-- gerate report year option -->
	<div id="generate-report" style="background-color: rgba(255, 255, 255, 0.5)" class="fixed h-full w-full flex top-0 left-0 items-center justify-center z-50 hidden">
		<div class="flex flex-col gap-1 h-max w-1/4 bg-white rounded-md border p-6">
			<p class="font-medium">Type year to generate report:</p>
			<input name="year" type="number" value="<?php echo date('Y') ?>" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
			<div class="flex items-center gap-2">
				<input id="generate-report-btn" type="submit" value="Generate" class="mt-3 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer">
				<a id="generate-report-cancel-btn" class="mt-3 rounded-sm bg-red-500 text-white border w-max px-5 py-1 rounded-md cursor-pointer">Cancel</a>
			</div>
		</div>
	</div>

	<div id="crystal-report-modal" class="flex flex-col gap-2 justify-center items-center h-full w-full top-0 left-0 hidden">

		<div class="w-10/12 flex items-end justify-end p-4 rounded-md">
			<a id="upload-crystal-report" class="p-2 h-max w-max bg-blue-700 text-white rounded-full flex justify-center items-center">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  					<path stroke-linecap="round" stroke-linejoin="round" d="M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
				</svg>
			</a>
		</div>

		<div id="crystal-report" class="w-10/12 p-6 h-max bg-white border rounded-md">	
			<!--header-->
			<div class="flex flex-col items-center gap-1 w-full">
				<img class="w-32 aspect-square" src="<?php echo URLROOT; ?>/public/assets/img/logo.png"/>
				<p class="text-xl font-bold">QUEZON CITY UNIVERSITY</p>
				<p>Online Consultation and Document Request</p>
				<p class="mt-5 font-medium text-xl">Crystal Report <span class="report-year"></span></p>
			</div>
			
			<!--content-->
			<div class="w-full mt-5">
				<div id="grouped-bar-chart flex gap-2 flex-col justify-center w-full">
					<p class="text-lg font-medium ">Consultation Frequency of Status (resolved and cancelled)</p>
					<p class="">A chart displaying the frequency of every status per month of the stated year.</p>
				  	<canvas class="mt-5" id="canvas"></canvas>
				</div>

				<div id="flex gap-2 flex-col justify-center w-full mt-5">
					<p class="mt-5">A table displaying the frequency of every status per month of the stated year.</p>
				  	<table class="w-full mt-5 border border-collapse" id="freq-table">
				  		<thead>
				  			<tr>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Status</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Jan</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Feb</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Mar</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Apr</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">May</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Jun</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Jul</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Aug</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Sep</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Oct</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Nov</th>
				  				<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Dec</th>
				  			</tr>
				  		</thead>
				  		<tbody>
				  			<tr class="border border-slate-300 bg-green-100 text-green-700">
				  				<td class="p-2 border border-slate-300 text-center">Resolved</td>
				  				<td class="p-2 border border-slate-300 text-center" id="jan-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="feb-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="mar-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="apr-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="may-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="jun-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="jul-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="aug-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="sep-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="oct-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="nov-resolved">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="dec-resolved">-</td>
				  			</tr>

				  			<tr class="border border-slate-300 bg-red-100 text-red-700">
				  				<td class="p-2 border border-slate-300 text-center">Cancelled</td>
				  				<td class="p-2 border border-slate-300 text-center" id="jan-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="feb-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="mar-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="apr-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="may-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="jun-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="jul-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="aug-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="sep-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="oct-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="nov-cancelled">-</td>
				  				<td class="p-2 border border-slate-300 text-center" id="dec-cancelled">-</td>
				  			</tr>
				  		</tbody>
				  	</table>
				</div>

				<div id="grouped-bar-chart flex gap-2 flex-col justify-center w-full mt-5">
					<p class="text-lg font-medium mt-5">Consultation History</p>
					<p class="">Display all resolved/cancelled consultations</p>
				  	<table class="w-full mt-5 border border-collapse" id="history-table">
				  		<thead>
				  			<tr>
					  			<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Student</th>
					  			<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Date Completed</th>
					  			<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Schedule</th>
					  			<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Start Time</th>
					  			<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Purpose</th>
					  			<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Status</th>
					  			<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Remark/Comments</th>
				  			</tr>
				  		</thead>

				  		<tbody id="history-table-body"></tbody>
				  	</table>
				</div>	
			</div>
		</div>
	</div>
</div>


<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/consultation/records/adviser/adviser.js';
	?>
</script>



