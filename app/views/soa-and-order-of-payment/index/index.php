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
				

				<!-- header -->
				<div class="flex justify-between items-center">
					<div class="flex flex-col w-full">
						<p class="text-3xl font-bold">Statement Of Account Requests</p>
						<p class="text-sm text-slate-500">Review and manage your statement of account document requests</p>
					</div>
					<div class="flex items-center">
						<a class="flex gap-2 bg-blue-700 text-white items-center rounded-md px-4 py-1 cursor-pointer w-max hover:bg-slate-900" href="#">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer">
								<title>download order of payment slip</title>
								<path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
							</svg>
							<span>Order Of Payment Slip</span> 
						</a>		
					</div>
				</div>

				<div class="flex flex-col mt-5 gap-2 pb-24">
					
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>

					<div class="grid w-full justify-items-end mt-5">
						<div class="flex w-full gap-2 items-end">
							<div class="flex flex-col gap-1 w-1/2">
								<p class="font-semibold">What are you looking for?</p>
								<input id="search" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
							</div>

							<div class="flex flex-col gap-1 w-1/2">
								<p class="font-semibold">Status</p>
								<select id="status-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
									<option value="">All</option>
									<option value="pending">Pending</option>
									<option value="accepted">Accepted</option>
									<option value="rejected">Rejected</option>
									<option value="in process">In Process</option>
									<option value="for claiming">For Claiming</option>
									<option value="completed">Completed</option>
								</select>
							</div>

							<a id="search-btn" class="flex bg-blue-700 text-white rounded-md px-4 py-1 h-max cursor-pointer hover:bg-slate-900">Search</a>
						</div>	
					</div>
					
					<div class="flex flex-col gap-2 px-4 py-2 border rounded-md mt-5">
						<div class="flex items-center justify-between py-2">
							<p class="p-2 text-lg font-semibold">Request Summary</p>
							<div class="flex gap-2 items">
								<a id="add-request-btn"><li class="flex bg-blue-700 text-white rounded-md px-4 py-1 cursor-pointer hover:bg-slate-900"> New Document Request </li></a>
							</div>
						</div>

						<table id="request-table" class="bg-white text-sm mt-5">
							<thead class="bg-slate-100 text-slate-900 font-medium">
								<tr>
									<th class="hidden">Request ID</th>
									<th>Date Requested</th>
									<th>Date Completed</th>
									<th>Purpose</th>
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
											$date_created = $date_created->format('Y/m/d');
										}

										$date_completed = new DateTime($row->date_completed);
										if(empty($row->date_completed)) {
											$date_completed = '---- -- --';
										} else {
											$date_completed = $date_completed->format('Y/m/d');
										}

								?>
										<tr class="border-b border-slate-200">
											<td class="font-semibold hidden"><?php echo $row->id; ?></td>
											<td><?php echo $date_created; ?></td>
											<td><?php echo $date_completed; ?></td>

											<td><?php echo $row->purpose; ?></td>
											
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
													<span class="bg-red-100 text-red-700 rounded-full px-5 py-1">rejected</span>
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
											
											<td class="text-center">
												<!--<?php //echo URLROOT.'/academic_document/show/'.$row->id ;?>-->
												<a class="hover:text-blue-700 view-btn" class="text-blue-700" href="#">view</a>
												<?php if($row->status == 'pending'): ?>
													<a class="hover:text-blue-700 edit-btn" href="#">edit</a>
													<a class="text-red-700 drop-btn" href="<?php echo URLROOT.'/soa_and_order_of_payment/cancel/'.$row->id ;?>" >cancel</a>
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
							<div class="flex flex-col gap2 w-full">
								<p class="text-2xl font-bold">Document Request <span class="text-sm font-normal" id="request-id"></span></p>
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

				<!-------------------------------------- edit panel ---------------------------------->


				<div id="edit-panel" class="fixed z-35 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
					<div class="flex gap-2">
						<a id="edit-exit-btn" class="m-2 p-1 hover:bg-slate-100">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
								<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
							</svg>
						</a>
					</div>
					<div class="flex justify-center w-full h-max">
						<div class="flex flex-col w-10/12 pt-10 pb-20">
							<div class="flex flex-col gap2 w-full">
								<a class="text-2xl cursor-pointer font-bold">Edit Document Request <span class="text-sm font-normal" id="request-id"></span></a>
								<p class="text-sm text-slate-500">Update your statement of account request</p>
							</div>

							<div class="w-full">
								<form id="add-request-form" action="<?php echo URLROOT; ?>/soa_and_order_of_payment/edit" enctype="multipart/form-data" method="POST" class="w-full">
									<input name="request-id" type="hidden" value="" />
									
									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Purpose<span class="text-sm font-normal"> (required)</span></p>
										</div>
										<select name="purpose" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700">
											<option value="">Choose Option</option>
											<option value="Scholarship / Financial Assistance">Scholarship / Financial Assistance</option>
											<option value="Enrollment / Transfer To Other School">Enrollment / Transfer To Other School</option>
											<option value="Work / Employment">Work / Employment</option>
											<option value="Masteral / Graduate Studies">Masteral / Graduate Studies</option>
											<option value="PNP Application">PNP Application</option>
											<option value="On The Job Application / Intership">On The Job Application / Intership</option>
											<option value="Application For Second Course (for graduate only)">Application For Second Course (for graduate only)</option>
											<option value="Others">Others</option>
										</select>
									</div>

									<div id="others-hidden-input" class="flex flex-col mt-5 hidden">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Please Specify<span class="text-sm font-normal"> (required)</span></p>
											<p class="text-sm text-slate-500"></p>
										</div>
										<input name="other-purpose" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-4" type="text">
									</div>

									<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Submit Request"/>
									<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
								</form>

							</div>
						</div>
					</div>
				</div>

				<!-------------------------------------- add panel ---------------------------------->

				<div id="add-panel" class="fixed z-35 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
					<div class="flex gap-2">
						<a id="add-exit-btn" class="m-2 p-1 hover:bg-slate-100">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
								<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
							</svg>
						</a>
					</div>
					<div class="flex justify-center w-full h-max">
						<div class="flex flex-col w-10/12 pt-10 pb-20">
							<div class="flex flex-col gap2 w-full">
								<a class="text-2xl cursor-pointer font-bold">New Document Request</a>
								<p class="text-sm text-slate-500">Create new request for statement of account</p>
							</div>

							<div class="w-full">
								<form action="<?php echo URLROOT; ?>/soa_and_order_of_payment/add" enctype="multipart/form-data" method="POST" class="w-full">
									<input name="student-id" type="hidden" value="<?php echo $_SESSION['id']?>"/>

									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Purpose<span class="text-sm font-normal"> (required)</span></p>
										</div>
										<select name="purpose" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700">
											<option value="">Choose Option</option>
											<option value="Scholarship / Financial Assistance">Scholarship / Financial Assistance</option>
											<option value="Enrollment / Transfer To Other School">Enrollment / Transfer To Other School</option>
											<option value="Work / Employment">Work / Employment</option>
											<option value="Masteral / Graduate Studies">Masteral / Graduate Studies</option>
											<option value="PNP Application">PNP Application</option>
											<option value="On The Job Application / Intership">On The Job Application / Intership</option>
											<option value="Application For Second Course (for graduate only)">Application For Second Course (for graduate only)</option>
											<option value="Others">Others</option>
										</select>
									</div>

									<div id="others-hidden-input" class="flex flex-col mt-5 hidden">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Please Specify<span class="text-sm font-normal"> (required)</span></p>
											<p class="text-sm text-slate-500"></p>
										</div>
										<input name="other-purpose" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-4" type="text">
									</div>

									<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer " type="submit" value="Submit Request"/>
									<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/soa-and-order-of-payment/index/index.js';
	?>
</script>



