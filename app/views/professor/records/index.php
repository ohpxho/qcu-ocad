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
				<a href="<?php echo URLROOT; ?>/user/professor" title="back">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		  				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
					</svg>
				</a>

				<div class="flex justify-between items-center mt-5">
					<div class="flex flex-col">
						<p class="text-2xl font-bold">Professor Profile</p>
						<p class="text-sm text-slate-500">Review professor profile</p>
					</div>
				</div>

				<div>
					<div class="flex flex-col items-center mt-5 h-max w-full gap-3">	
						<div class="flex flex-col items-center text-center w-full h-full bg-slate-700 text-white rounded-md border p-4">
							<div class="absolute right-10 flex gap-2 items-center">
								<a href="<?php echo URLROOT?>/professor/update/<?php echo $data['records']->id ?>">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
									</svg>
								</a>
							</div>

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
								
								<p class="mt-2"><?php echo ucwords($data['records']->department) ?></p>
								<p><?php echo $data['records']->gender ?></p>
							</div>
						</div>

						<div class="flex flex-col w-full h-full">

							<div class="flex flex-col">
								<p class="text-lg font-medium">Consultation</p>
								<p class="text-sm text-slate-500">Review teacher profile</p>

								<div class="flex gap-2 mt-5">
									<div class="flex flex-col w-1/2 bg-white gap-1 p-4 border rounded-md">
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
		require APPROOT.'/views/professor/records/records.js';
	?>
</script>