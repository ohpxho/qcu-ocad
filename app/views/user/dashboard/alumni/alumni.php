<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Dashboard</p>
		<p class="text-sm text-slate-500">Records summary</p>
	</div>
	<a href="<?php echo URLROOT;?>/academic_document/add" class="bg-blue-700 w-max h-max rounded-md text-white px-5 py-1 hide">New request</a>
	<div >
		
	</div>
</div>

<div class="flex flex-col mt-5 gap-2 pb-24">
	<div class="flex flex-col">
		<p class="text-lg font-medium">Document Request</p>
		<p class="text-sm text-slate-500">Your academic, good moral, and statement account document request records summary</p>
		<div class="flex gap-2">
			<div class="flex flex-col w-2/6 gap-1 mt-5 p-4 border rounded-md">
				<div>
					<p class="font-medium">Frequency of Request by Document</p>
					<p class="text-sm text-slate-500">Your request frequency by document for document request</p>
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

			<div class="flex flex-col gap-1 w-2/6 mt-5 p-4 border rounded-md">
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
				<p class="text-sm text-slate-500">You activity graph of the current year for document request</p>
			</div>

			<div class="flex flex-col gap-2 w-full h-max rounded-md border p-4 py-6 bg-white overflow-hidden hover:overflow-x-scroll mt-3">
				<div class="w-max" id="calendar-activity-graph-document"></div>
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

	<div class="flex flex-col mt-5">
		<p class="text-lg font-medium">Recent Activities</p>
		<p class="text-sm text-slate-500">
			<?php
				echo date('d F Y');
			?>	
		</p>

		<div class="flex flex-col w-1/2 mt-5">
			<?php if(count($data['recent-activity']) > 0): ?>
				<?php foreach($data['recent-activity'] as $row): ?>
					<div class="before:content-[''] before:absolute before:top-0 before:left-0 before:w-0.5 before:h-full before:bg-orange-700 flex flex-col gap-1 pl-6 py-3">
						<div class="absolute w-2 h-2 rounded-full bg-orange-700 -left-[3px] top-8"></div>
						<p><?php echo ucwords($row->description) ?></p>
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

<script>
	<?php
		require APPROOT.'/views/user/dashboard/student/student.js';
	?>
</script>
