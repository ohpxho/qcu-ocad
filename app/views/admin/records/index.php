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
						<p class="text-2xl font-bold">Admin Profile</p>
						<p class="text-sm text-slate-500">Review admin profile</p>
					</div>
				</div>

				<div class="flex mt-5 h-max w-full gap-3 pb-24">
					
					<div class="flex flex-col w-1/4 h-full bg-white border p-4">
						<div id="profile-pic-con" class="h-32 w-32 rounded-md overflow-hidden border"></div>
						<div class="flex flex-col mt-3 w-full text-sm">
							<p class="text-lg font-medium"><?php echo $data['records']->fname.' '.$data['records']->lname ?></p>
							<p class="flex gap-1 items-center">
								@ <?php echo formatUnivId($data['records']->id) ?>
							</p>
							<p class="truncate ...">
								@ <?php echo $data['records']->email ?>
							</p>
							<p>@ <?php echo $data['records']->contact ?></p>
							
							<p class="mt-2"><?php echo ucwords($data['records']->department) ?></p>
							<p><?php echo $data['records']->gender ?></p>
						</div>
					</div>

					<div class="flex flex-col w-full h-full">
						<?php if($data['records']->type == 'guidance' || $data['records']->type == 'clinic'): ?>
							<div class="flex flex-col">
								<p class="text-lg font-medium">Consultation</p>
								<p class="text-sm text-slate-500">Consultation records summary</p>

								<div class="flex gap-2 mt-5">
									<div class="flex flex-col w-2/6 bg-white gap-1 p-4 border rounded-md">
										<div>
											<p class="font-medium">Frequency of Request by Status</p>
											<p class="text-sm text-slate-500">The request frequency by status of students in online consultation</p>
										</div>

										<table class="w-full table-fixed mt-3 bg-slate-50">
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

													<?php if($current < $dt): ?>
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
							</div>
						<?php endif; ?>

						<div class="w-full border p-4 rounded-md bg-white mt-5 <?php if($data['records']->type == 'guidance' || $data['records']->type == 'clinic'): ?> mt-5 <?php endif; ?>">
								<div class="flex flex-col">
									<p class="font-medium"><?php echo date('Y')?> Activity Graph</p>
									<p class="text-sm text-slate-500">You activity graph of the current year for document request</p>
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
				</div>
			</div>
		</div>
	</div>

</main>

<script>
	<?php
		require APPROOT.'/views/admin/records/records.js';
	?>
</script>