<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Welcome, Registrar Admin!</p>
	</div>
</div>

<div class="flex flex-col mt-5 gap-2 pb-24">
	<div class="flex flex-col">
		
		<div class="flex gap-2 mt-5">
			<div class="flex w-full lg:w-max pr-12 bg-blue-200 rounded-md shadow-md overflow-hidden">
				<div class="w-20 h-20 flex items-center justify-center bg-blue-300">
					<span class="font-medium text-xl"><?php echo count($data['inprogress-academic']) ?></span>
				</div>
				<div class="w-full pl-5 flex flex-col justify-center">
					<p class="text-medium text-lg font-medium">Ongoing</p>
					<p>no. of ongoing request for document</p>
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
