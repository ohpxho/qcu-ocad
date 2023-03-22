<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Academic Documents</p>
		<p class="text-sm text-slate-500">Review and manage your academic document requests</p>
	</div>
	<a href="<?php echo URLROOT;?>/academic_document/add" class="bg-blue-700 w-max h-max rounded-md text-white px-5 py-1 hide">New request</a>
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

			<div class="flex flex-col gap-1 w-1/4">
				<p class="font-semibold">Status</p>
				<select id="status-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
					<option value="">All</option>
					<option value="pending">Pending</option>
					<option value="accepted">Accepted</option>
					<option value="declined">Declined</option>
					<option value="for payment">For Payment</option>
					<option value="in process">In Process</option>
					<option value="for claiming">For Claiming</option>
					<option value="completed">Completed</option>
					<option value="cancelled">Cancelled</option>
				</select>
			</div>

			<div class="flex flex-col gap-1 w-1/4">
				<p class="font-semibold">Documents</p>
				<select id="document-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
					<option value="">All</option>
					<option value="tor">TOR</option>
					<option value="diploma">Diploma</option>
					<option value="honorable dismissal">Honorable Dismissal</option>
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
			<p class="p-2 font-semibold">Request Summary</p>
			<div class="flex gap-2 items">
				<a href="<?php echo URLROOT;?>/academic_document/add">
					<li class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1"> 
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
						</svg>
						<span>New Request</span> 
					</li>
				</a>
			</div>
		</div>

		<table id="request-table" class="bg-white text-sm">
			<thead class="bg-slate-100 text-slate-900 font-medium">
				<tr>
					<th class="hidden">Request ID</th>
					<th>Date Requested</th>
					<th>Date Completed</th>
					<th>Document</th>
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
							<td><?php echo $date_created; ?></td>
							<td><?php echo $date_completed; ?></td>
							<td class="flex gap-1">
								
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
							
							<?php if($row->status == 'pending'): ?>
								<td>
									<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1">pending</span>
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

							<?php if($row->status == 'for payment'): ?>
								<td>
									<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1">for payment</span>
								</td>
							<?php endif; ?>

							<?php if($row->status == 'in process'): ?>
								<td>
									<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1">in process</span>
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
								<!--<?php //echo URLROOT.'/academic_document/show/'.$row->id ;?>-->
								<a class="hover:text-blue-700 view-btn" class="text-blue-700" href="#">view</a>
								<?php if($row->status == 'pending'): ?>
									<a class="hover:text-blue-700" href="<?php echo URLROOT.'/academic_document/edit/'.$row->id ;?>">edit</a>
									<a class="text-red-700 drop-btn" href="<?php echo URLROOT.'/academic_document/cancel/'.$row->id ;?>" >cancel</a>
								<?php endif; ?>
							</td>
							
						</tr>
				<?php
					endforeach;
				?>
			
			</tbody>
		</table>
	</div>

	<div class="flex flex-col items-start gap-2 mt-5">
		<div class="flex gap-2">
			<div class="flex flex-col shadow-sm gap-2 w-2/6 p-4 border rounded-md">
				<div>
					<p class="font-medium">Frequency of Request by Document</p>
					<p class="text-sm text-slate-500">Your request frequency by document for academic documents</p>
				</div>
				
				<table class="w-full table-fixed mt-3">
					<?php
						$freq = $data['request-frequency'];
						$tor = isset($freq->TOR)? $freq->TOR : '0';
						$diploma = isset($freq->DIPLOMA)? $freq->DIPLOMA : '0';
						$dismissal = isset($freq->HONORABLE_DISMISSAL)? $freq->HONORABLE_DISMISSAL : '0';
					?>
					<tr>
						<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Document</td>
						<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
					</tr>
					<tr>
						<td width="80" class="py-2 pl-2 border border text-sm">Transcript of records</td>
						<td width="20" class="py-2 text-center border bg-slate-50"><span id="gradeslip-count"><?php echo $tor ?></span></td>
					</tr>

					<tr>
						<td width="80" class="py-2 pl-2 border border text-sm">Diploma</td>
						<td width="20" class="py-2 text-center border bg-slate-50"><span id="ctc-count"><?php echo $diploma ?></span></td>
					</tr>

					<tr>
						<td width="80" class="py-2 pl-2 border border text-sm">Honorable Dismissal</td>
						<td width="20" class="py-2 text-center border bg-slate-50"><span id="others-count"><?php echo $dismissal ?></span></td>
					</tr>
				</table>
			</div>	

			<div class="flex flex-col shadow-sm gap-2 w-2/6 h-max p-4 border rounded-md">
				<div>
					<p class="font-medium">Frequency of Request by Status</p>
					<p class="text-sm text-slate-500">Your request frequency by status for document request</p>
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
						$cancelled = isset($statfreq->completed)? $statfreq->cancelled : '0';
					?>
					<tr>
						<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Status</td>
						<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Pending</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $pending ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Accepted</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $accepted ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Declined</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $rejected ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">For Payment</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $forpayment ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">In Process</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $inprocess ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">For Claiming</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $forclaiming ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Completed</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $completed ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Cancelled</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $cancelled ?></span></td>
					</tr>
				</table>
			</div>	
		</div>

		<div class="w-full border p-4 rounded-md bg-slate-50 mt-5">
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

		<!--<div id="activity-panel" class="flex flex-col w-2/6 h-72 overflow-y-scroll px-4 mt-5">
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
		</div>-->
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
			<div class="flex flex-col gap-2 w-full">
				<p class="text-2xl font-bold">REQUEST ID <span class="font-normal" id="request-id"></span></p>
				<p class="text-sm text-slate-500">If the below information is not accurate, please contact an admin to address the problem.</p>
			</div>

			<div class="flex flex-col gap2 w-full mt-6">
				<table class="w-full table-fixed">
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Status</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="status"></span></td>
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

			<div class="flex flex-col gap2 w-full mt-2">
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
						<td width="70" class="py-2 pl-2"><span id="tor-price">P 300</span></td>
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
						<td width="70" class="p-1 pl-2"><a href="#" id="ctc-document" class="text-blue-700 hover:underline"></a></td>
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


<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/academic-document/index/alumni/alumni.js';
	?>
</script>


