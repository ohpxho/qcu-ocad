<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Welcome, Student!</p>
		<!-- <p class="text-sm text-slate-500">Records summary</p> -->
	</div>
	<a href="<?php echo URLROOT;?>/academic_document/add" class="bg-blue-700 w-max h-max rounded-md text-white px-5 py-1 hide">New request</a>
	<div >
		
	</div>
</div>

<div class="flex flex-col mt-5 gap-2 pb-24">
	<div class="flex flex-col">
		<!-- <p class="text-lg font-medium">Document Request</p>
		<p class="text-sm text-slate-500">Request records summary</p> -->


		<div class="flex gap-2">
			<div class="w-full">
				<div class="flex flex-col w-full rounded-md">
					<div class="flex w-full text-center font-medium">
						<p>These are your on-going document request :</p>	
					</div>
					
					<?php if(count($data['inprogress-academic'])>0 || count($data['inprogress-account'])>0 || count($data['inprogress-moral'])>0): ?>
						<ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-1 mt-3">
							<?php foreach($data['inprogress-academic'] as $key => $row): ?>
								<div class="cursor-pointer w-full p-2 rounded-md border bg-white shadow-md text-sm">
									<li class="flex items-center justify-between">
										<div class="flex flex-col w-full justify-between">
											<?php
												$doc = '';

												if($row->is_gradeslip_included) $doc = 'Gradeslip';
												if($row->is_ctc_included) $doc = 'Certified True Copy';
												if($row->other_requested_document != '' && $row->other_requested_document != null) $doc = 'Others'
											?>

											<div class="flex gap-1 items-center">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
													  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
													</svg>

												<span><?php echo $doc ?></span>
											</div>

											<div class="flex gap-1 mt-5">
												<?php echo html_entity_decode(getDocumentRequestStatusDesign($row->status)) ?>
												<?php if($row->price > 0): ?>
													<span class="bg-orange-500 text-white rounded-md px-1 py-0.5 status-btn cursor-pointer">with payment</span>
												<?php else:?>
													<span class="bg-green-500 text-white rounded-md px-1 py-0.5 status-btn cursor-pointer">no payment</span>
												<?php endif; ?>
											</div>	
										</div>
										
										<a href="<?php echo URLROOT?>/academic_document">
											<div class="rounded-full bg-slate-200 px-2 py-1 text-slate-500 mr-3">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
													<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
												</svg>
											</div>
										</a>			
									</li>
								</div>
							<?php endforeach; ?>

							<?php foreach($data['inprogress-moral'] as $key => $row): ?>
								<div class="cursor-pointer p-2 w-full rounded-md border bg-white shadow-md text-sm">
									<li class="flex items-center justify-between">
										<div class="flex flex-col w-full justify-between">
											<div class="flex gap-1 items-center">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
													  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
													</svg>

												<span>Good Moral Certificate</span>
											</div>
											<div class="flex gap-1 mt-5">
												<?php echo html_entity_decode(getDocumentRequestStatusDesign($row->status)) ?>
												<?php if($row->price > 0): ?>
													<span class="bg-orange-500 text-white rounded-md px-1 py-0.5 status-btn cursor-pointer">with payment</span>
												<?php else:?>
													<span class="bg-green-500 text-white rounded-md px-1 py-0.5 status-btn cursor-pointer">no payment</span>
												<?php endif; ?>
											</div>
										</div>

										<a href="<?php echo URLROOT?>/good_moral">
											<div class="rounded-full bg-slate-200 px-2 py-1 text-slate-500 mr-3">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
													<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
												</svg>
											</div>
										</a>
									</li>

								</div>
							<?php endforeach; ?>

							<?php foreach($data['inprogress-account'] as $key => $row): ?>
								<div class="cursor-pointer p-2 w-full rounded-md border bg-white shadow-md text-sm">
									<li class="flex items-center justify-between">
										<div class="flex flex-col w-full justify-between">
											<?php
												$doc = '';

												if($row->requested_document == 'soa') $doc = 'Statement of Account';
												else $doc = 'Order of Payment';
											?>
											<div class="flex gap-1 items-center">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
													  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
													</svg>

												<span><?php echo $doc ?></span>
											</div>
											<div class="flex gap-1 mt-5">
												<?php echo html_entity_decode(getDocumentRequestStatusDesign($row->status)) ?>
												<?php if($row->price > 0): ?>
													<span class="bg-orange-500 text-white rounded-md px-1 py-0.5 status-btn cursor-pointer">with payment</span>
												<?php else:?>
													<span class="bg-green-500 text-white rounded-md px-1 py-0.5 status-btn cursor-pointer">no payment</span>
												<?php endif; ?>
											</div>
										</div>

										<a href="<?php echo URLROOT?>/student_account">
											<div class="rounded-full bg-slate-200 px-2 py-1 text-slate-500 mr-3">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
													<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
												</svg>
											</div>
										</a>
									</li>
								</div>
						<?php endforeach; ?>
					</ul>
					<?php else:?>
						<div class="w-full bg-slate-200 text-slate-500 text-center p-2 mt-5">
							<p>No ongoing request found</p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="flex flex-col mt-5">
		<div class="flex w-full text-center font-medium">
			<p>Please take a look at your upcoming consultation :</p>	
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 w-full mt-5">
			<?php
				$upcoming = $data['upcoming-consultation'];
				$consultation_today_count = count($upcoming);

				$consultation_freq = $data['consultation-frequency'];
				$active = isset($consultation_freq->ACTIVE)? $consultation_freq->ACTIVE : 0;
			?>
			
			<div class="flex w-full pr-12 bg-orange-200 rounded-md shadow-md overflow-hidden">
				<div class="w-20 h-20 flex items-center justify-center bg-orange-300">
					<span class="font-medium text-xl"><?php echo $consultation_today_count ?></span>
				</div>
				<div class="w-full pl-5 flex flex-col justify-center">
					<p class="text-medium text-lg font-medium">No. of consultations today</p>
					<a href="<?php echo URLROOT?>/consultation/active" class="text-sm text-blue-700"> - view consultations</a>
				</div>
			</div>

			<div class="flex w-full pr-12 bg-green-200 rounded-md shadow-md overflow-hidden">
				<div class="w-20 h-20 flex items-center justify-center bg-green-300">
					<span class="font-medium text-xl"><?php echo $active ?></span>
				</div>
				<div class="w-full pl-5 flex flex-col justify-center">
					<p class="text-medium text-lg font-medium">No. of active consultations</p>
					<a href="<?php echo URLROOT?>/consultation/active" class="text-sm text-blue-700"> - view consultations</a>
				</div>
			</div>

			<!-- <div class="flex flex-col p-4 w-full aspect-video rounded-md bg-green-200">
				<div class="w-14 flex items-center justify-center bg-green-400 text-white aspect-square rounded-full">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
					</svg>

				</div>
				<p class="text-4xl mt-5 font-bold"><?php echo $active ?></p>
				<p class="mt-3">No. of active consultations</p>
				<a href="<?php echo URLROOT?>/consultation/active" class="text-sm text-blue-700"> - view consultations</a>
			</div> -->
		</div>

	</div>

	<div class="flex flex-col mt-5">
		<p class="text-lg font-medium">Recent Activities</p>
		<p class="text-sm text-slate-500">
			<?php
				$current = date('d F Y');
				echo $current;
			?>	
		</p>

		<div class="flex flex-col w-full sm:w-1/2 mt-5">
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
		require APPROOT.'/views/user/dashboard/student/student.js';
	?>
</script>
