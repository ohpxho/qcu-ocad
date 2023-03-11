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
		<p class="text-sm text-slate-500">Your academic, good moral, and statement of account document requests and progress frequency</p>
		<div class="flex gap-2">
			<table class="w-1/2 table-fixed mt-5 h-max">
				<?php
					$reqfreq = $data['request-frequency'];
					$tor = isset($reqfreq->TOR)? $reqfreq->TOR : '-';
					$gradeslip = isset($reqfreq->GRADESLIP)? $reqfreq->GRADESLIP : '-';
					$ctc = isset($reqfreq->CTC)? $reqfreq->CTC : '-';
					$diploma= isset($reqfreq->DIPLOMA)? $reqfreq->DIPLOMA : '-';
					$dismissal = isset($reqfreq->HONORABLE_DISMISSAL)? $reqfreq->HONORABLE_DISMISSAL : '-';
					$others = isset($reqfreq->OTHERS)? $reqfreq->OTHERS : '-';
				?>
				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Transcript Of Records</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $tor ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Gradeslip</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $gradeslip ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Certified True Copy</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $ctc ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Diploma</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $diploma ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Honorable Dismissal</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $dismissal ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Others</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $others ?></span></td>
				</tr>

			</table>

			<table class="w-1/2 table-fixed mt-5">
				<?php
					$statfreq = $data['status-frequency'];
					$pending = isset($statfreq->pending)? $statfreq->pending : '-';
					$accepted = isset($statfreq->accepted)? $statfreq->accepted : '-';
					$rejected = isset($statfreq->rejected)? $statfreq->rejected : '-';
					$inprocess = isset($statfreq->inprocess)? $statfreq->inprocess : '-';
					$forclaiming = isset($statfreq->forclaiming)? $statfreq->forclaiming : '-';
					$completed = isset($statfreq->completed)? $statfreq->completed : '-';
				?>
				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Pending</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $pending ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Accepted</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $accepted ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Rejected</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $rejected ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">In Process</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $inprocess ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">For Claiming</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $forclaiming ?></span></td>
				</tr>

				<tr>
					<td width="90" class="p-1 pl-2 border text-sm ">Completed</td>
					<td width="10" class="p-1 text-center border bg-slate-100"><span ><?php echo $completed ?></span></td>
				</tr>
			</table>
		</div>

		<div class="flex flex-col gap-2 w-full h-max rounded-md border p-4 mt-5">

			<div class="w-max " id="calendar-activity-graph-document"></div>
			
			<div class="flex items-center justify-between mt-3">
				<p class="text-sm">Activity of the year</p>

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
				$current = new DateTime();
				$current = $current->format('d F Y');
				echo $current;
			?>	
		</p>

		<div class="flex flex-col w-1/2 mt-5">
			<?php if(count($data['recent-activity']) > 0): ?>
				<?php foreach($data['recent-activity'] as $row): ?>
					<div class="before:content-[''] before:absolute before:top-0 before:left-0 before:w-0.5 before:h-full before:bg-slate-200 flex flex-col gap-1 pl-6 py-3">
						<div class="absolute w-2 h-2 rounded-full bg-slate-300 -left-[3px] top-8"></div>
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
		require APPROOT.'/views/user/dashboard/admin/registrar/registrar.js';
	?>
</script>
