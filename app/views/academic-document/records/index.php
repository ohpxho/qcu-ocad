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
		?>

		<div class="flex justify-center w-full h-full overflow-y-scroll bg-neutral-100">
			<div class="fixed z-10 w-full h-full top-0 left-0 flex items-center justify-center">
				<img class="opacity-10 w-1/3" src="<?php echo URLROOT;?>/public/assets/img/logo.png">
			</div>

			<div class="min-h-full w-10/12 py-14 z-20">
				
				<div class="flex justify-between items-center">
					<div class="flex flex-col">
						<p class="text-2xl font-bold">Academic Documents</p>
						<p class="text-sm text-slate-500">Review and manage student's request records</p>
					</div>
				</div>

				<div class="flex flex-col mt-5 gap-2 pb-24">
					
					<div class="grid w-full justify-items-end mt-5">
						<div class="flex w-full gap-2 border p-4 bg-white rounded-md items-end">
							<div class="flex flex-col gap-1 w-1/2">
								<p class="font-semibold">Search Records</p>
								<input id="search" class="border rounded-sm border-slate-300 bg-slate-100 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
							</div>

							<div class="flex flex-col gap-1 w-1/4">
								<p class="font-semibold">Type</p>
								<select id="type-filter" class="border rouded-sm border-slate-300 bg-slate-100 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
									<option value="">All</option>
									<option value="student">Student</option>
									<option value="alumni">Alumni</option>
								</select>
							</div>

							<div class="flex flex-col gap-1 w-1/4">
								<p class="font-semibold">Documents</p>
								<select id="document-filter" class="border rouded-sm border-slate-300 bg-slate-100 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
									<option value="">All</option>
									<option value="tor">TOR(undergraduate)</option>
									<option value="diploma">TOR/Diploma</option>
									<option value="honorable dismissal">Honorable Dismissal</option>
									<option value="ctc">CTC</option>
									<option value="gradeslip">Gradeslip</option>
									<option value="others">Others</option>
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
					
					<div class="flex flex-col gap-2 px-4 py-2 border rounded-md mt-5 bg-white">
						<div class="flex items-center justify-between py-2">
							<p class="p-2 font-semibold">Request Summary</p>
							<div class="flex gap-2 items">
								<button id="export-table-btn" class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1 h-max">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
									 	<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
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

								<button id="drop-multiple-row-selection-btn" class="flex gap-1 items-center bg-red-500 text-white rounded-md px-4 py-1 h-max opacity-50 cursor-not-allowed" disabled>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
										<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
									</svg>

									Delete Selected
								</button>

								<form action="<?php echo URLROOT;?>/academic_document/multiple_delete" method="POST" id="multiple-drop-form" class="hidden">
									<input name="request-ids-to-drop" type="hidden">
								</form>
							</div>
						</div>
						<table id="request-table" class="bg-slate-50 text-sm">
							<thead class="bg-slate-100 text-slate-900 font-medium">
								<tr>
									<th class="hidden">Request ID</th>
									<th class="flex gap-2 items-center"><input id="select-all-row-checkbox" type="checkbox">Student ID</th>
									<th>Date Requested</th>
									<th>Date Completed</th>
									<th>Requested Document</th>
									<th>Type</th>
									<th>Quantity</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								
								<?php
									foreach ($data['requests-data'] as $key => $row):
										$date_created = new DateTime($row->date_created);
										if(empty($row->date_created)) {
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

								?>
										<tr class="border-b border-slate-200">
											<td class="font-semibold hidden"><?php echo $row->id; ?></td>
											<td class="flex gap-2 items-center">
												<?php if($row->status == 'completed' || $row->status == 'rejected' || $row->status == 'cancelled'): ?>
													<input class="row-checkbox" type="checkbox">
												<?php endif; ?>
												<?php echo $row->student_id; ?>
											</td>
											<td><?php echo $date_created; ?></td>
											<td><?php echo $date_completed; ?></td>
											<td class="flex gap-1 text-sm">
												
												<?php

													$documents = [];
													if($row->is_tor_included) array_push($documents, 'TOR');
													if($row->is_gradeslip_included) array_push($documents, 'Gradeslip');
													if($row->is_ctc_included) array_push($documents, 'CTC');
													if($row->is_diploma_included) array_push($documents, 'Diploma');
													if($row->is_honorable_dismissal_included) array_push($documents, 'Honorable Dismissal');
													if(!empty($row->other_requested_document) && $row->other_requested_document != null) array_push($documents, ucwords($row->other_requested_document));

													$documents = implode(' + ', $documents);
												?>

												<p><?php echo $documents; ?></p>	
											</td>

											<td><?php echo $row->type ?></td>
											<td><?php echo $row->quantity ?></td>
											
											<?php if($row->status == 'pending'): ?>
												<td>
													<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1">pending</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'awaiting payment confirmation'): ?>
												<td>
													<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1">awaiting payment confirmation</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'accepted'): ?>
												<td>
													<span class="bg-cyan-100 text-cyan-700 rounded-full px-5 py-1">accepted</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'rejected'): ?>
												<td>
													<span class="bg-red-100 text-red-700 rounded-full px-5 py-1">declined</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'for process'): ?>
												<td>
													<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1">for process</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'for claiming'): ?>
												<td>
													<span class="bg-sky-100 text-sky-700 rounded-full px-5 py-1">for claiming</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'completed'): ?>
												<td>
													<span class="bg-green-100 text-green-700 rounded-full px-5 py-1">completed</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'cancelled'): ?>
												<td>
													<span class="bg-red-100 text-red-700 rounded-full px-5 py-1">cancelled</span>
												</td>
											<?php endif; ?>
											
											<td class="text-center">
												<a class="view-btn" class="hover:text-blue-700 text-blue-700" href="#">view</a>
													
												<?php if($row->status=='completed' || $row->status=='rejected' || $row->status=='cancelled'): ?>
													<a class="text-red-500 drop-btn" href="<?php echo URLROOT.'/academic_document/delete/'.$row->id?>">delete</a>
												<?php endif; ?>
											</td>
											
										</tr>
								<?php
									endforeach;
								?>
							
							</tbody>
						</table>
					</div>
					<!-- gerate report year option -->
					<div id="generate-report" style="background-color: rgba(255, 255, 255, 0.5)" class="fixed h-full w-full flex top-0 left-0 items-center justify-center z-30 hidden">
						<div class="flex flex-col gap-1 h-max w-1/4 bg-white rounded-md border p-6">
							<p>Choose type of report to generate</p>
							<div class="flex gap-2 mt-3">
								<div class="w-1/3">
									<label class="report-option flex justify-center items-center px-4 p-2 bg-blue-700 text-white cursor-pointer rounded-md w-full" for="year-report-option">Year</label>
									<input type="radio" name="report" data-type="year" id="year-report-option" class="hidden" checked/>
								</div>

								<div class="w-1/3">
									<label class="report-option flex justify-center items-center px-4 p-2 bg-blue-700 text-white cursor-pointer rounded-md w-full opacity-50" for="month-report-option">Month</label>
									<input type="radio" name="report" data-type="month" id="month-report-option" class="hidden"/>
								</div>

								<div class="w-1/3">
									<label for="day-report-option" class="report-option flex justify-center items-center px-4 p-2 bg-blue-700 text-white cursor-pointer rounded-md w-full opacity-50">Day</label>
									<input type="radio" name="report" data-type="day" id="day-report-option" class="hidden"/>
								</div>
							</div>

							<div id="year-report-input" class="w-full">
								<input name="year" type="number" value="<?php echo date('Y') ?>" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700 w-full">
							</div>

							<div id="month-report-input" class="flex gap-1 w-full hidden">
								<select name="month" class="w-1/2 border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
									<option value="1">Jan</option>
									<option value="2">Feb</option>
									<option value="3">Mar</option>
									<option value="4">Apr</option>
									<option value="5">May</option>
									<option value="6">Jun</option>
									<option value="7">Jul</option>
									<option value="8">Aug</option>
									<option value="9">Sep</option>
									<option value="10">Oct</option>
									<option value="11">Nov</option>
									<option value="12">Dec</option>
								</select>

								<input type="number" name="year" value="<?php echo date('Y') ?>" class="w-1/2 border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700"/>
							</div>

							<div id="day-report-input" class="w-full hidden">
								<input name="day" type="date" value="<?php echo date('Y-m-d') ?>" class="border rouded-sm w-full border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
							</div>

							<div class="flex items-center gap-2">
								<input id="generate-report-btn" type="submit" value="Generate" class="mt-3 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer">
								<a id="generate-report-cancel-btn" class="mt-3 rounded-sm bg-red-500 text-white border w-max px-5 py-1 rounded-md cursor-pointer">Cancel</a>
							</div>
						</div>
					</div>

					<div id="crystal-report-modal" class="flex flex-col gap-2 justify-center items-center h-max w-full top-0 left-0 z-20 hidden">

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
									<p class="text-lg font-medium ">Document Request Frequency of Status (completed, declined, and cancelled)</p>
									<p class="">A chart displaying the frequency of every status per month of the stated year.</p>
								  	<div class="flex justify-center w-full">
								  		<canvas class="mt-5 flex flex-col items-center justify-center" width="700" height="500" id="canvas"></canvas>
								  	</div>
								</div>

								<div id="freq-table-panel" class="flex gap-2 flex-col justify-center w-full mt-5">
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
								  				<td class="p-2 border border-slate-300 text-center">Completed</td>
								  				<td class="p-2 border border-slate-300 text-center" id="jan-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="feb-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="mar-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="apr-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="may-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="jun-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="jul-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="aug-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="sep-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="oct-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="nov-completed">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="dec-completed">-</td>
								  			</tr>

								  			<tr class="border border-slate-300 bg-orange-100 text-orange-700">
								  				<td class="p-2 border border-slate-300 text-center">Declined</td>
								  				<td class="p-2 border border-slate-300 text-center" id="jan-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="feb-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="mar-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="apr-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="may-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="jun-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="jul-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="aug-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="sep-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="oct-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="nov-declined">-</td>
								  				<td class="p-2 border border-slate-300 text-center" id="dec-declined">-</td>
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
									  			<th class="border border-slate-300 p-2 bg-slate-100 text-slate-500">Document</th>
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
								<p class="text-2xl font-bold">REQUEST ID <span class="font-normal" id="request-id"></span></p>
								<p class="text-sm text-slate-500">If the below information is not accurate, please contact an admin to address the problem.</p>
							</div>

							<div class="flex flex-col gap2 w-full mt-6">
								<table class="w-full table-fixed">
									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Student ID</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="student-id"></span></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Status</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="status"></a></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Document Requested</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="documents" ></span></td>
									</tr>
									
									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Date Created</td>
										<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="date-created" class=""></span></td>
									</tr>
									
									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Date Completed</td>
										<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="date-completed" class=""></span></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Purpose</td>
										<td width="80" class="hover:bg-slate-100 p-1 pl-2">
											<p id="purpose"></p>
										</td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Quantity</td>
										<td width="80" class="hover:bg-slate-100 p-1 pl-2">
											<p id="quantity"></p>
										</td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">RA11261 Beneficiary</td>
										<td id="beneficiary" width="80" class="width-full hover:bg-slate-100 p-1 pl-2"></td>
									</tr>
								</table>	
							</div>

							<div id="student-info" class="flex flex-col gap-2 w-full mt-2 hidden">
								<p class="pl-2 pt-2 font-semibold">Student Information</p>
								<table class="w-full table-fixed">
									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Name</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="stud-name"></a></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Course</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="stud-course"></a></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Year</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="stud-year"></a></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Section</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="stud-section"></a></td>
									</tr>

								</table>
							</div>

							<div id="alumni-info" class="flex flex-col gap-2 w-full mt-2 hidden">
								<p class="pl-2 pt-2 font-semibold">Alumni Information</p>
								<table class="w-full table-fixed">
									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Name</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="alum-name"></a></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Course</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="alum-course"></a></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Section</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="alum-section"></a></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Year Graduated</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="alum-year"></a></td>
									</tr>

								</table>
							</div>

							<div id="payment-info" class="flex flex-col gap-2 w-full mt-2 hidden">
								<p class="pl-2 pt-2 font-semibold">Payment Information</p>
								<table class="w-full table-fixed">
									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Price</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="price"></a></td>
									</tr>
								</table>
								<a href="" id="generate-oop-btn" class="mt-3 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer">Generate Order of Payment</a>
							</div>

							<div class="flex flex-col gap-2 w-full mt-2">
								<p class="pl-2 pt-2 pb-4 font-semibold">Additional Information</p>
								<table class="w-full table-fixed">
									
									<tr id="tor" class="border-t border-slate-200 hidden"> 
										<td class="text-slate-500 p-1 pl-2" width="30">
											<p class="text-sm text-slate-700">Transcipt Of Records</p>
											<p>Academic Year</p>
										</td>
										<td width="70" class="py-2 pl-2"><span id="academic-year"></span></td>
									</tr>

									<!-- <tr id="tor-price" class="border-t border-slate-200 hidden"> 
										<td class="text-slate-500 p-1 pl-2" width="30">
											<p class="text-sm text-slate-700">Transcipt Of Records</p>
											<p>Price</p>
										</td>
										<td width="70" class="py-2 pl-2">P 300</td>
									</tr> -->
								
									<tr id="diploma" class="border-t border-slate-200 hidden">
										<td class="text-slate-500 py-2 pl-2" width="30">
											<p class="text-sm text-slate-700">Diploma</p>
											<p>Year Graduated</p>
										</td>
										<td width="70" class="py-2 pl-2"><span id="year-graduated" ></span></td>
									</tr>
									
									<tr id="gradeslip" class="border-t border-slate-200 hidden">
										<td class="text-slate-500 py-2 pl-2" width="30">
											<p class="text-sm text-slate-700">Gradeslip</p>
											<p>Year & Sem</p>
										</td>
										<td width="70" class="py-2 pl-2"><span id="year-sem" class=""></span></td>
									</tr>
									
									<tr id="ctc" class="border-t border-slate-200 hidden">
										<td class="text-slate-500 py-2 pl-2" width="30">
											<p class="text-sm text-slate-700">Certified True Copy</p>
											<p>Document</p>
										</td>
										<td width="70" class="p-1 pl-2"><a href="#" id="ctc-document" class="hover:underline text-blue-700"></a></td>
									</tr>

									<tr id="other" class="border-t border-slate-200 hidden">
										<td class="text-slate-500 p-1 pl-2" width="30">
											<p class="text-sm text-slate-700">Other Requested Doc</p>
											<p>Document</p>
										</td>
										<td width="70" class="p-1 pl-2"><span id="other-document" class=""></span></td>
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

			</div>
		</div>
	</div>

	<div id="oop-modal" style="background-color: rgba(255, 255, 255, 0.5);" class="fixed flex flex-col gap-2 justify-center items-center w-full h-full z-50 top-0 left-0 hidden">
		<div class="w-1/4 flex items-end justify-end p-4 rounded-md">
			<a id="upload-oop" class="p-2 h-max w-max bg-blue-700 text-white rounded-full flex justify-center items-center">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
				</svg>
			</a>
		</div>

		<div id="oop-body" class="bg-white w-1/4 border rounded-md p-6">
			<a class="absolute right-2 top-2 cursor-pointer" id="oop-exit-btn">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
				</svg>
			</a>

			<div class="flex flex-col items-center gap-1 w-full">
				<img class="w-32 aspect-square" src="<?php echo URLROOT; ?>/public/assets/img/logo.png"/>
				<p class="text-xl font-bold">QUEZON CITY UNIVERSITY</p>
				<p>Online Consultation and Document Request</p>
				<p class="mt-5 font-medium text-xl">ORDER OF PAYMENT</span></p>
			</div>

			<div class="mt-5">
				<table class="border border-collapse w-full text-sm">
					<tr class="border">
						<td width="40%" class="border p-2">Transaction No.<td>
						<td width="60%" class="p-2"><p id="oop-no"></p><td>
					</tr>
					
					<tr class="border">
						<td width="40%" class="border p-2">Student ID<td>
						<td width="60%" class="p-2"><p id="oop-id"></p><td>
					</tr>

					<tr class="border">
						<td width="40%" class="border p-2">Name<td>
						<td width="60%" class="p-2"><p id="oop-name"></p><td>
					</tr>

					<tr class="border">
						<td class="border p-2">Amount Due in PHP<td>
						<td class="p-2"><p id="oop-price"></p><td>
					</tr>

					<tr class="border">
						<td class="border p-2">Document<td>
						<td class="p-2"><p id="oop-doc"></p><td>
					</tr>				
				</table>
			</div>

			<div class="mt-5">
				<p>When you come to make your payment, please bring a copy of this document and a valid university ID. This will help us verify the amount due and ensure that your payment is processed correctly.</p>
			</div>
		</div>
	</div>
</main>

<script>
	<?php
		require APPROOT.'/views/academic-document/records/records.js';
	?>
</script>
