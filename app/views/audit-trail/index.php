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
						<p class="text-2xl font-bold">Audit Trail</p>
						<p class="text-sm text-slate-500">All system activity records</p>
					</div>
				</div>

				<div class="flex flex-col mt-5 gap-2 pb-24">
					
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>

					<div class="grid w-full justify-items-end mt-5">
						<div class="flex w-full gap-2 border p-4 bg-white rounded-md items-end">
							<div class="flex flex-col gap-1 w-full">
								<p class="font-semibold">Search Records</p>
								<input id="search" class="border rounded-sm border-slate-300 bg-slate-100 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
							</div>
						</div>	
					</div>

					<div class="flex flex-col gap-2 px-4 py-2 bg-white border rounded-md mt-5">
						<div class="flex items-center justify-between py-2">
							<p class="p-2 font-semibold">Trail</p>
							<div class="flex gap-2 items">
								<button id="export-table-btn" class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1 h-max">
									<!--<div class="flex items-center text-blue-700 gap-1">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
					 						 <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
										</svg>
									</div>-->
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
									 	<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
									</svg>

									Export Table
								</button>
							</div>
						</div>

						<table id="request-table" class="bg-slate-50 text-sm">
							<thead class="bg-slate-100 text-slate-900 font-medium">
								<tr>
									<th class="flex gap-2 items-center"><input id="select-all-row-checkbox" type="checkbox">Action ID</th>
									<th>Actor</th>
									<th>Action</th>
									<th>Description</th>
									<th>DateTime</th>
								</tr>
							</thead>

							<tbody>
								
								<?php foreach ($data['audit-trail'] as $key => $row): ?>
									<tr class="border-b border-slate-200">
										<td><?php echo $row->id; ?></td>
										<td><?php echo $row->actor; ?></td>
										<td><?php echo ucwords($row->action); ?></td>
										<td><?php echo ucwords($row->description); ?></td>
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

</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/audit-trail/index.js';
	?>
</script>
