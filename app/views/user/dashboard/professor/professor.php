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
		<p class="text-lg font-medium">Consultation</p>
		<p class="text-sm text-slate-500">Consultation records summary</p>

		<div class="flex gap-2 mt-5">
			<div class="flex flex-col w-2/6 bg-white gap-1 p-4 border rounded-md">
				<div>
					<p class="font-medium">Frequency of Request by Status</p>
					<p class="text-sm text-slate-500">The request frequency by status of students in online consultation</p>
				</div>

				<table class="w-full table-fixed mt-3">
					<?php
						$consultfreq = $data['consultation-frequency'];
						$_pending = isset($consultfreq->PENDING)? $consultfreq->PENDING : '0';
						$active = isset($consultfreq->ACTIVE)? $consultfreq->ACTIVE : '0';
						$resolved = isset($consultfreq->RESOLVED)? $consultfreq->RESOLVED : '0';
						$unresolved = isset($consultfreq->UNRESOLVED)? $consultfreq->UNRESOLVED : '0';
						$_rejected = isset($consultfreq->REJECTED)? $consultfreq->REJECTED : '0';
					?>
					<tr>
						<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Status</th>
						<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</th>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Pending</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="tor-count"><?php echo $_pending ?></span></td>
					</tr>
					
					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Active</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="tor-count"><?php echo $active ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Resolved</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="tor-count"><?php echo $resolved ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border border text-sm ">Cancelled</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="gradeslip-count"><?php echo $unresolved ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border border text-sm ">Declined</td>
						<td width="20" class="p-1 text-center border bg-slate-100"><span id="ctc-count"><?php echo $_rejected ?></span></td>
					</tr>

				</table>
			</div>
			
			<div class="w-full border rounded-md p-4 bg-white">
				<p class="font-medium">Upcoming Consultation</p>
				<p class="text-sm text-slate-500">Scheduled online consultation</p>
				
				<ul class="w-full mt-3 border h-56 bg-slate-50 overflow-y-scroll">
					<?php
						$purpose = [
							'Thesis/Capstone Advising',
	    					'Project Concern/Advising',
					        'Grades Consulting',
					        'Lecture Inquiries',
					        'Exams/Quizzes/Assignment Concern',
					        'Performance Consulting',
					        'Counseling',
					        'Report',
					        'Health Concern'
					    ];

					?>

					<?php if(count($data['upcoming-consultation']) > 0):?> 
						<?php foreach($data['upcoming-consultation'] as $row):?>
							<?php
								$current = new DateTime();
								$dt = new DateTime($row->schedule_for_gmeet);
							?>

							<?php if($current < $dt && $row->status == 'active'): ?>
								<a href="<?php echo URLROOT.'/consultation/show/active/'.$row->id ?>">
									<li class="group/active text-sm flex justify-between gap-2 p-4 hover:bg-blue-700 border-b hover:text-white ">
										<div >
											<span><?php echo $row->creator_name ?></span>
											<span class="text-sm"> - </span>
											<span class="group-hover/active:text-white text-orange-700"><?php echo $purpose[$row->purpose] ?><span/>
										</div>

										<?php
											$sched = new DateTime($row->schedule_for_gmeet);
											$sched = $sched->format('d M Y h:i A');
										?>
										<span><?php echo $sched ?><span/>	
									</li>
								</a>
							<?php endif; ?>
						<?php endforeach;?>
					<?php else: ?>
						<div class="flex items-center justify-center w-full h-full text-slate-500 bg-slate-50">
							<p>No upcoming consultation</p>
						</div>
					<?php endif;?>	
				</ul>
			</div>
		</div>

		<div class="w-full border p-4 rounded-md bg-white mt-5">
			<div class="flex flex-col">
				<p class="font-medium"><?php echo date('Y')?> Activity Graph</p>
				<p class="text-sm text-slate-500">You activity graph of the current year of online consultation</p>
			</div>

			<div class="flex flex-col gap-2 w-full h-max rounded-md border p-4 py-6 bg-slate-50 overflow-hidden hover:overflow-x-scroll mt-3">
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
		require APPROOT.'/views/user/dashboard/professor/professor.js';
	?>
</script>
