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

		<div class="flex justify-center w-full h-full overflow-y-scroll">
			<div class="min-h-full w-10/12 py-14">
				
				<div class="flex justify-between items-center">
					<div class="flex flex-col">
						<p class="text-2xl font-bold">Academic Documents</p>
						<p class="text-sm text-slate-500">Review and manage student's request records</p>
					</div>
				</div>

				<div class="flex flex-col mt-5 gap-2 pb-24">
					
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>
					
					<div class="grid w-full justify-items-end mt-5">
						<div class="flex w-full gap-2 border p-4 bg-slate-100 rounded-md items-end">
							<div class="flex flex-col gap-1 w-1/2">
								<p class="font-semibold">Search Records</p>
								<input id="search" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
							</div>

							<div class="flex flex-col gap-1 w-1/4">
								<p class="font-semibold">Type</p>
								<select id="type-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
									<option value="">All</option>
									<option value="student">Student</option>
									<option value="alumni">Alumni</option>
								</select>
							</div>

							<div class="flex flex-col gap-1 w-1/4">
								<p class="font-semibold">Documents</p>
								<select id="document-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
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

					<div class="flex flex-col gap-2 px-4 py-2 border rounded-md mt-5">
						<div class="flex items-center justify-between py-2">
							<p class="p-2 font-semibold">Request Summary</p>
							<div class="flex gap-2 items">
								<button id="export-table-btn" class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1 h-max">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
									 	<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
									</svg>

									Export Table
								</button>
							</div>
						</div>
						<table id="request-table" class="bg-white text-sm">
							<thead class="bg-slate-100 text-slate-900 font-medium">
								<tr>
									<th class="hidden">Request ID</th>
									<th class="flex gap-2 items-center"><input id="select-all-row-checkbox" type="checkbox">Student ID</th>
									<th>Date Requested</th>
									<th>Date Completed</th>
									<th>Requested Document</th>
									<th>Type</th>
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
											<td class="flex gap-2 items-center"><input class="row-checkbox" type="checkbox"><?php echo formatUnivId($row->student_id); ?></td>
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
													if(!empty($row->other_requested_document)) array_push($documents, 'Others');

													$documents = implode(' + ', $documents);
												?>

												<p><?php echo $documents; ?></p>
												
											</td>

											<td><?php echo $row->type ?></td>
											
											<?php if($row->status == 'pending'): ?>
												<td>
													<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">pending</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'accepted'): ?>
												<td>
													<span class="bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">accepted</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'rejected'): ?>
												<td>
													<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">declined</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'cancelled'): ?>
												<td>
													<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">cancelled</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'in process'): ?>
												<td>
													<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">in process</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'for payment'): ?>
												<td>
													<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1">for payment</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'for claiming'): ?>
												<td>
													<span class="bg-sky-100 text-sky-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">for claiming</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'completed'): ?>
												<td>
													<span class="bg-green-100 text-green-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">completed</span>
												</td>
											<?php endif; ?>
											
											<td class="text-center">
												<!--<?php //echo URLROOT.'/academic_document/show/'.$row->id ;?>-->
												<a class="view-btn" class="hover:text-blue-700 text-blue-700" href="#">view</a>
											</td>
											
										</tr>
								<?php
									endforeach;
								?>
							
							</tbody>
						</table>
					</div>

					<div class="flex gap-2">
						<div class="flex flex-col w-2/6 gap-1 mt-5 p-4 border rounded-md">
							<div>
								<p class="font-medium">Frequency of Request by Document</p>
								<p class="text-sm text-slate-500">The request frequency by document of students in good moral request</p>
							</div>

							<table class="w-full table-fixed mt-3">
								<?php
									$reqfreq = $data['request-frequency'];
									$tor = isset($reqfreq->TOR)? $reqfreq->TOR : '0';
									$diploma = isset($reqfreq->DIPLOMA)? $reqfreq->DIPLOMA : '0';
									$dismissal = isset($reqfreq->HONORABLE_DISMISSAL)? $reqfreq->HONORABLE_DISMISSAL : '0';
									$gslip = isset($reqfreq->GRADESLIP)? $reqfreq->GRADESLIP : '0';
									$ctc = isset($reqfreq->CTC)? $reqfreq->CTC : '0';
									$others = isset($reqfreq->OTHERS)? $reqfreq->OTHERS : '0';	
								?>
								<tr>
									<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Status</th>
									<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</th>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Transcript of Records</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $tor ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Diploma</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $diploma ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Honorable Dismissal</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $dismissal ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Gradeslip</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $gslip ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Certified True Copy</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $ctc ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Others</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $others ?></span></td>
								</tr>
							</table>
						</div>
						
						<div class="flex flex-col w-2/6 gap-1 mt-5 p-4 border rounded-md">
							<div>
								<p class="font-medium">Frequency of Request by Status</p>
								<p class="text-sm text-slate-500">The request frequency by status of students in good moral request</p>
							</div>

							<table class="w-full table-fixed mt-3">
								<?php
									$statfreq = $data['status-frequency'];
									$pending = isset($statfreq->pending)? $statfreq->pending : '0';
									$accepted = isset($statfreq->accepted)? $statfreq->accepted : '0';
									$rejected = isset($statfreq->rejected)? $statfreq->rejected : '0';
									$inprocess = isset($statfreq->inprocess)? $statfreq->inprocess : '0';
									$forclaiming = isset($statfreq->forclaiming)? $statfreq->forclaiming : '0';
									$forpayment = isset($statfreq->forpayment)? $statfreq->forpayment : '0';
									$completed = isset($statfreq->completed)? $statfreq->completed : '0';
									$cancelled = isset($statfreq->cancelled)? $statfreq->cancelled : '0';
								?>
								<tr>
									<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Status</th>
									<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</th>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Pending</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $pending ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Accepted</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $accepted ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Declined</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $rejected ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">For Payment</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $forpayment ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">In Process</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $inprocess ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">For Claiming</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $forclaiming ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Completed</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $completed ?></span></td>
								</tr>

								<tr>
									<td width="90" class="p-1 pl-2 border text-sm ">Cancelled</td>
									<td width="10" class="p-1 text-center border bg-slate-50"><span ><?php echo $cancelled ?></span></td>
								</tr>
							</table>
						</div>
					</div>

					<div class="w-full border p-4 rounded-md bg-slate-50 mt-5">
						<div class="flex flex-col">
							<p class="font-medium"><?php echo date('Y')?> Activity Graph</p>
							<p class="text-sm text-slate-500">Your activity graph of the current year of document request</p>
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

									<tr id="tor-price" class="border-t border-slate-200 hidden"> 
										<td class="text-slate-500 p-1 pl-2" width="30">
											<p class="text-sm text-slate-700">Transcipt Of Records</p>
											<p>Price</p>
										</td>
										<td width="70" class="py-2 pl-2">P 300</td>
									</tr>
								
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

</main>

<script>
	<?php
		require APPROOT.'/views/academic-document/records/records.js';
	?>
</script>
