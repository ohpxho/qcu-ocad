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

			<div class="min-h-full w-10/12 py-14 z-20 h-max pb-24">	
				<a href="<?php echo URLROOT; ?>/user/alumni" title="back">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		  				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
					</svg>
				</a>

				<div class="flex justify-between items-center mt-5">
					<div class="flex flex-col">
						<p class="text-2xl font-bold">Alumni Profile</p>
						<p class="text-sm text-slate-500">Review alumni profile</p>
					</div>
				</div>

				<div>
					<div class="flex flex-col items-center mt-5 h-max w-full gap-3">	
						<div class="flex flex-col items-center text-center w-full h-full bg-slate-700 text-white rounded-md border p-4">
							<div id="profile-pic-con" class="h-32 w-32 rounded-md overflow-hidden border"></div>
							<div class="flex flex-col mt-3 w-full text-sm">
								<p class="text-lg font-medium"><?php echo $data['records']->fname.' '.$data['records']->lname ?></p>
								<p class="">
									@ <?php echo formatUnivId($data['records']->id) ?>
								</p>
								<p class="truncate ...">
									@ <?php echo $data['records']->email ?>
								</p>
								<p>@ <?php echo $data['records']->contact ?></p>
								<p class="mt-2"><?php echo $data['records']->year_graduated.' graduate' ?></p>
								<p><?php echo $data['records']->course.' / '.$data['records']->section ?></p>
								<p><?php echo $data['records']->gender ?></p>
								<p class="truncate ..." title="<?php echo $data['records']->address; ?>"><?php echo $data['records']->address ?></p>
								<p><?php echo $data['records']->location ?> resident</p>
								<p><?php echo $data['records']->type ?></p>
							</div>
						</div>

						<div class="flex flex-col w-full h-full">
							<div class="flex flex-col">
								<p class="text-lg font-medium">Document Request</p>
								<p class="text-sm text-slate-500">Student's academic, good moral, and statement of account document requests and progress frequency</p>
								<div class="flex gap-2">
									<div class="flex flex-col w-1/2 bg-white gap-1 mt-5 p-4 border rounded-md">
										<div>
											<p class="font-medium">Frequency of Request by Document</p>
											<p class="text-sm text-slate-500">Request frequency by document for document request</p>
										</div>

										<table class="w-full table-fixed mt-3">
											<?php
												$reqfreq = $data['request-frequency'];
												$tor = isset($reqfreq->TOR)? $reqfreq->TOR : '0';
												$diploma = isset($reqfreq->DIPLOMA)? $reqfreq->DIPLOMA : '0';
												$dismissal = isset($reqfreq->HONORABLE_DISMISSAL)? $reqfreq->HONORABLE_DISMISSAL : '0';
												$moral = isset($reqfreq->GOOD_MORAL)? $reqfreq->GOOD_MORAL : '0';
											?>
											<tr>
												<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Document</td>
												<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
											</tr>

											<tr>
												<td width="80" class="p-1 pl-2 border text-sm ">Transcript of Records</td>
												<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $tor ?></span></td>
											</tr>

											<tr>
												<td width="80" class="p-1 pl-2 border text-sm ">Diploma</td>
												<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $diploma ?></span></td>
											</tr>

											<tr>
												<td width="80" class="p-1 pl-2 border text-sm ">Honorable Dismissal</td>
												<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $dismissal ?></span></td>
											</tr>

											<tr>
												<td width="80" class="p-1 pl-2 border text-sm ">Good Moral Certificate</td>
												<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $moral ?></span></td>
											</tr>
										</table>
									</div>

									<div class="flex flex-col gap-1 w-1/2 bg-white mt-5 p-4 border rounded-md">
										<div>
											<p class="font-medium">Frequency of Request by Status</p>
											<p class="text-sm text-slate-500">Request frequency by status for document request</p>
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
												<td width="80" class="p-1 pl-2 border text-sm ">Declined</td>
												<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $rejected ?></span></td>
											</tr>
											
											<tr>
												<td width="80" class="p-1 pl-2 border text-sm ">For Process</td>
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
							</div>
						</div>
					</div>

					<div class="w-full flex flex-col mt-5 bg-white p-4 rounded-md">
						<p class="text-lg font-medium">Activities</p>
						<div class="flex gap-2">
							<table id="request-table" class="bg-slate-50 text-sm mt-3">
								<thead class="bg-slate-100 text-slate-900 font-medium">
									<tr>
										<th>Action</th>
										<th>Description</th>
										<th>Date</th>
									</tr>
								</thead>
									
								<tbody>
									<?php foreach($data['activities'] as $row): ?>
										<tr>
											<td><?php echo $row->action ?></td>
											<td><?php echo $row->description ?></td>
											<td><?php echo $row->date_acted ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>

<script>
	<?php
		require APPROOT.'/views/alumni/records/records.js';
	?>
</script>