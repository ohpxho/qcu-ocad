<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Welcome, Clinic Admin!</p>
	</div>
</div>

<div class="flex flex-col mt-5 gap-2 pb-24">
	<div class="flex flex-col">
		<div class="flex w-full text-center font-medium">
			<p>Please take a look at your upcoming consultation :</p>	
		</div>

		<div class="flex gap-2 mt-5">
			<?php
				$upcoming = $data['upcoming-consultation'];
				$consultation_today_count = count($upcoming);

				$consultation_freq = $data['consultation-frequency'];
				$active = isset($consultation_freq->ACTIVE)? $consultation_freq->ACTIVE : 0;
			?>
			
			<div class="flex w-full lg:w-max pr-12 bg-orange-200 rounded-md shadow-md overflow-hidden">
				<div class="w-20 h-20 flex items-center justify-center bg-orange-300">
					<span class="font-medium text-xl"><?php echo $consultation_today_count ?></span>
				</div>
				<div class="w-full pl-5 flex flex-col justify-center">
					<p class="text-medium text-lg font-medium">No. of consultations today</p>
					<a href="<?php echo URLROOT?>/consultation/active" class="text-sm text-blue-700"> - view consultations</a>
				</div>
			</div>

			<div class="flex w-full lg:w-max pr-12 bg-green-200 rounded-md shadow-md overflow-hidden">
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
		require APPROOT.'/views/user/dashboard/admin/clinic/clinic.js';
	?>
</script>
