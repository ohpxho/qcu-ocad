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
		<p class="text-sm text-slate-500">The good moral certificate requests and progress frequency of students</p>
		<div class="flex gap-2">
			
		</div>
	</div>

	<div class="flex flex-col mt-5">
		<p class="text-lg font-medium">Consultation</p>
		<p class="text-sm text-slate-500">Consultation records summary</p>

		<div class="flex gap-2 mt-5">
			<?php
				$upcoming = $data['upcoming-consultation'];
				$consultation_today_count = count($upcoming);
			?>
			<div class="grid grid-cols-4 gap-4 w-full">
				<div class="flex flex-col p-4 w-full aspect-video bg-slate-100 rounded-md bg-orange-200">
					<div class="w-14 flex items-center justify-center bg-orange-400 text-white aspect-square rounded-full">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
						 	<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
						</svg>
					</div>
					<p class="text-4xl mt-5 font-bold"><?php echo $consultation_today_count ?></p>
					<p class="mt-3">No. of consultations today</p>
					<a href="<?php echo URLROOT?>/consultation/active" class="text-sm text-blue-700"> - view consultations</a>
				</div>
			</div>
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
		require APPROOT.'/views/user/dashboard/student/student.js';
	?>
</script>
