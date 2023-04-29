<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Welcome, Alumni!</p>
		<!-- <p class="text-sm text-slate-500">Records summary</p> -->
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

												if($row->is_tor_included) $doc = 'Transcript of Records';
												if($row->is_diploma_included) $doc = 'Diploma';
												if($row->is_honorable_dismissal_included) $doc = 'Honorable Dismissal';
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
					</ul>
					<?php else:?>
						<div class="w-full bg-slate-200 text-slate-500 text-center p-2 mt-5">
							<p>No ongoing request found</p>
						</div>
					<?php endif; ?>
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
					<div class="before:content-[''] before:absolute before:top-0 before:left-0 before:w-0.5 before:h-full before:bg-slate-200 flex flex-col gap-1 pl-6 py-3">
						<div class="absolute w-2 h-2 rounded-full bg-slate-200 -left-[3px] top-8"></div>
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
		require APPROOT.'/views/user/dashboard/alumni/alumni.js';
	?>
</script>
