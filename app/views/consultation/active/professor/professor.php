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
				<th>Student</th>
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
						<td><?php echo $row->creator_name; ?></td>
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

<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/consultation/active/professor/professor.js';
	?>
</script>



