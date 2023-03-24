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

		<div class="flex justify-center w-full h-full overflow-y-scroll">
			<div class="min-h-full w-10/12 py-14">
				<div class="flex justify-between items-center">
					<div class="flex flex-col">
						<p class="text-2xl font-bold">Subject Management</p>
						<p class="text-sm text-slate-500">Review and manage subjects</p>
					</div>
				</div>

				<div class="flex flex-col mt-5 gap-2 pb-24">
					
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>

					<div class="grid w-full justify-items-end mt-5">
						<div class="flex w-full gap-2 border p-4 bg-slate-100 rounded-md items-end">
							<div class="flex flex-col gap-1 w-1/2">
								<p class="font-semibold">Search Records</p>
								<input id="search" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
							</div>

							<div class="flex flex-col gap-1 w-1/2">
								<p class="font-semibold">Department</p>
								<select id="purpose-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
									<option value="">All</option>
								</select>
							</div>

							<a id="search-btn" class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 h-max">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
								  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
								</svg>

								<span>Search</span>
							</a>

						</div>	
					</div>

					<div class="flex flex-col gap-2 px-4 py-2 border rounded-md mt-5">
						<div class="flex items-center justify-between py-2">
							<p class="p-2 font-semibold">Subject Summary</p>
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

								<a id="new-subject-btn" href="#">
									<li class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1"> 
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
											<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
										</svg>
										<span>New Subject</span> 
									</li>
								</a>

								<form action="<?php echo URLROOT;?>/subject/multiple_delete" method="POST" id="multiple-drop-form" class="hidden">
									<input name="subject-ids-to-drop" type="hidden">
								</form>

								<button id="drop-multiple-row-selection-btn" class="flex gap-1 items-center bg-red-500 text-white rounded-md px-4 py-1 h-max opacity-50 cursor-not-allowed" disabled>
									<!--<div class="flex items-center text-red-700 gap-1">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
				  							<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
										</svg>
									</div>-->
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
										<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
									</svg>

									Delete Selected
								</button>
							</div>
						</div>

						<table id="request-table" class="bg-white text-sm">
							<thead class="bg-slate-100 text-slate-900 font-medium">
								<tr>
									<th class="flex gap-2 items-center"><input id="select-all-row-checkbox" type="checkbox">Subject ID</th>
									<th>Code</th>
									<th>Title</th>
									<th>Department</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								
								<?php foreach ($data['subjects'] as $key => $row): ?>
									<tr class="border-b border-slate-200">
										<td class="flex gap-2 items-center"><input class="row-checkbox" type="checkbox"><?php echo $row->id; ?></td>
										<td><?php echo $row->code; ?></td>
										<td><?php echo ucwords($row->title); ?></td>
										<td><?php echo ucwords($row->department); ?></td>
										
										<td class="text-center">
											<a class="hover:text-blue-700 update-btn" class="text-blue-700" href="#">update</a>
											<a class="text-red-500 drop-btn" href="<?php echo URLROOT.'/subject/delete/'.$row->id; ?>">delete</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>

				<!-------------------------------------- add panel ---------------------------------->

				<div id="add-panel" class="fixed z-35 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
					<div class="flex gap-2">
						<a id="add-exit-btn" class="m-2 p-1 hover:bg-slate-100">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
								<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
							</svg>
						</a>
					</div>
					<div class="flex justify-center w-full h-max">
						<div class="flex flex-col w-10/12 pt-10 pb-20">
							<div class="flex flex-col gap2 w-full">
								<a class="text-2xl cursor-pointer font-bold">New Subject</a>
								<p class="text-sm text-slate-500">Subjects to be registered will be used for consultations</p>
							</div>

							<div class="w-full">
								<form action="<?php echo URLROOT; ?>/subject/add" method="POST" class="w-full">

									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Code<span class="text-sm font-normal"> (required)</span></p>
										</div>
										<input type="text" name="code" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700">
									</div>

									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Title<span class="text-sm font-normal"> (required)</span></p>
										</div>
										<input type="text" name="title" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700">
									</div>

									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Department<span class="text-sm font-normal"> (required)</span></p>
										</div>
										<select name="department" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
											<option value="">Choose Option</option>
											<option value="College Of Computer Science And Information Technology">College Of Computer Science And Information Technology</option>
											<option value="College Of Engineering">College Of Engineering</option>
											<option value="College Of Bussiness And Accountancy">College Of Bussiness And Accountancy</option>
											<option value="College Of Education">College Of Education</option>
										</select>
									</div>

									<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Add subject"/>
								</form>

							</div>
						</div>
					</div>
				</div>

				<!-------------------------------------- update panel ---------------------------------->

				<div id="update-panel" class="fixed z-35 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
					<div class="flex gap-2">
						<a id="update-exit-btn" class="m-2 p-1 hover:bg-slate-100">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
								<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
							</svg>
						</a>
					</div>
					<div class="flex justify-center w-full h-max">
						<div class="flex flex-col w-10/12 pt-10 pb-20">
							<div class="flex flex-col gap2 w-full">
								<a class="text-2xl cursor-pointer font-bold">Update Subject</a>
								<p class="text-sm text-slate-500">Subjects registered will be used for consultations</p>
							</div>

							<div class="w-full">
								<form action="<?php echo URLROOT; ?>/subject/update" method="POST" class="w-full">
									<input type="hidden" name="id" value="">

									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Code<span class="text-sm font-normal"> (required)</span></p>
										</div>
										<input type="text" name="code" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700">
									</div>

									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Title<span class="text-sm font-normal"> (required)</span></p>
										</div>
										<input type="text" name="title" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700">
									</div>

									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Department<span class="text-sm font-normal"> (required)</span></p>
										</div>
										<select name="department" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
											<option value="">Choose Option</option>
											<option value="College Of Computer Science And Information Technology">College Of Computer Science And Information Technology</option>
											<option value="College Of Engineering">College Of Engineering</option>
											<option value="College Of Bussiness And Accountancy">College Of Bussiness And Accountancy</option>
											<option value="College Of Education">College Of Education</option>
										</select>
									</div>

									<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Update subject"/>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/subject/subject.js';
	?>
</script>
