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
					<option value="declined">Declined</option>
					<option value="for process">For Process</option>
					<option value="for claiming">For Claiming</option>
					<option value="completed">Completed</option>
					<option value="cancelled">Cancelled</option>
				</select>
			</div>

			<div class="flex flex-col gap-1 w-1/4">
				<p class="font-semibold">Documents</p>
				<select id="document-filter" class="border rouded-sm border-slate-300 bg-slate-100 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
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
	
	<div class="flex flex-col gap-2 px-4 py-2 border rounded-md mt-5 bg-white">
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

		<table id="request-table" class="bg-slate-50 text-sm">
			<thead class="bg-slate-100 text-slate-900 font-medium">
				<tr>
					<th class="hidden">Request ID</th>
					<th>Date Requested</th>
					<th>Date Completed</th>
					<th>Document</th>
					<th>Purpose</th>
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

							<td><?php echo $row->purpose_of_request ?></td>
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

							<?php if($row->status == 'for payment'): ?>
								<td>
									<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 py-1">for payment</span>
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
								<!--<?php //echo URLROOT.'/academic_document/show/'.$row->id ;?>-->
								<a class="hover:text-blue-700 view-btn" class="text-blue-700" href="#">view</a>
								<?php if($row->status == 'pending'): ?>
									<a class="hover:text-blue-700" href="<?php echo URLROOT.'/academic_document/edit/'.$row->id ;?>">edit</a>
								<?php endif; ?>

								<?php if($row->status == 'awaiting payment confirmation'): ?>
									<a class="hover:text-blue-700 confirm-payment-btn" href="<?php echo URLROOT.'/academic_document/confirm_payment/'.$row->id ;?>" >confirm</a>
								<?php endif; ?>

								<?php if($row->status == 'pending' || $row->status == 'awaiting payment confirmation'): ?>
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
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Quantity</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="quantity" class=""></span></td>
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

			<div id="payment-info" class="flex flex-col gap-2 w-full mt-2 hidden">
				<p class="pl-2 pt-2 font-semibold">Payment Information</p>
				<table class="w-full table-fixed">
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Price</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="price"></a></td>
					</tr>
				</table>
				<a href="" id="generate-oop-btn" data-request="" class="mt-3 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer">Generate Order of Payment</a>
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

				<!-- 	<tr id="tor-price" class="border-t border-slate-200 hidden"> 
						<td class="text-slate-500 p-1 pl-2" width="30">
							<p class="text-sm text-slate-700">Transcipt Of Records</p>
							<p>Price</p>
						</td>
						<td width="70" class="py-2 pl-2"><span id="tor-price">P 300</span></td>
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

			<div id="payment-info" class="flex flex-col gap-2 w-full mt-2 hidden">
				<p class="pl-2 pt-2 font-semibold">Payment Information</p>
				<table class="w-full table-fixed">
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Price</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="price"></a></td>
					</tr>
				</table>
				<a href="" id="generate-oop-btn" data-request="" class="mt-3 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer">Generate Order of Payment</a>
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
<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/academic-document/index/alumni/alumni.js';
	?>
</script>



