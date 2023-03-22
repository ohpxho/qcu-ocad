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
						<p class="text-2xl font-bold">Alumni Management</p>
						<p class="text-sm text-slate-500">Review and manage alumni accounts</p>
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

							<div class="flex flex-col gap-1 w-1/4">
								<p class="font-semibold">Course</p>
								<select id="course-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
									<option value="">All</option>
									<option value="BSIT">BSIT</option>
								<option value="BSENTREP">BSENTREP</option>
								<option value="BSACCOUNTANCY">BSACCOUNTANCY</option>
								<option value="BSECE">BSECE</option>
								<option value="BSIE">BSIE</option>
									
								</select>
							</div>

							<div class="flex flex-col gap-1 w-1/4">
								<p class="font-semibold">Status</p>
								<select id="status-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
									<option value="">All</option>
									<option value="for review">for review</option>
									<option value="active">active</option>
									<option value="closed">closed</option>
									<option value="declined">declined</option>
									<option value="blocked">blocked</option>
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
							<p class="p-2 font-semibold">Alumni Summary</p>
							<div class="flex gap-2 items">
								<button id="export-table-btn" class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1 h-max">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
									 	<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
									</svg>

									Export Table
								</button>

								<button id="drop-multiple-row-selection-btn" class="flex gap-1 items-center bg-red-500 text-white rounded-md px-4 py-1 h-max opacity-50 cursor-not-allowed" disabled>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
										<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
									</svg>

									Delete Selected
								</button>

								<form action="<?php echo URLROOT;?>/user/multiple_delete/alumni" method="POST" id="multiple-drop-form" class="hidden">
									<input name="type" type="hidden" value="alumni">
									<input name="ids-to-drop" type="hidden">
								</form>
							</div>
						</div>
						
						<table id="request-table" class="bg-white text-sm">
							<thead class="bg-slate-100 text-slate-900 font-medium">
								<tr>
									<th class="flex gap-2 items-center"><input id="select-all-row-checkbox" type="checkbox">Student ID</th>
									<th>Email</th>
									<th>Lastname</th>
									<th>Firstname</th>
									<th>Course</th>
									<th>Year Graduated</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								
								<?php
									foreach ($data['alumnis'] as $key => $row):
								?>
									<tr class="border-b border-slate-200">
										<td  class="flex gap-2 items-center"><?php if($row->status=='closed' || $row->status=='blocked' || $row->status=='declined'): ?><input class="row-checkbox" type="checkbox"><?php endif;?><?php echo formatUnivId($row->id) ?></td>
										
										<td><?php echo $row->email; ?></td>
										<td><?php echo $row->lname; ?></td>
										<td><?php echo $row->fname; ?></td>
										<td><?php echo $row->course; ?></td>
										<td><?php echo $row->year_graduated ?></td>
										
										<?php if($row->status == 'declined'): ?>
											<td>
												<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1">declined</span>
											</td>
										<?php endif; ?>

										<?php if($row->status == 'closed'): ?>
											<td>
												<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1">closed</span>
											</td>
										<?php endif; ?>

										<?php if($row->status == 'blocked'): ?>
											<td>
												<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1">blocked</span>
											</td>
										<?php endif; ?>

										<?php if($row->status == 'active'): ?>
											<td>
												<span class="bg-green-100 text-green-700 rounded-full px-5 text-sm py-1">active</span>
											</td>
										<?php endif; ?>

										<?php if($row->status == 'for review'): ?>
											<td>
												<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1">for review</span>
											</td>
										<?php endif; ?>
										
										<td class="text-center">
											<!--<?php //echo URLROOT.'/academic_document/show/'.$row->id ;?>-->
											
											<?php if($row->status == 'for review' || $row->status == 'declined'): ?>
												<a class="hover:text-blue-700 view-btn" href="#">view</a>
											<?php endif; ?>

											<?php if($row->status == 'active' || $row->status == 'closed' || $row->status == 'blocked'): ?>
												<a class="hover:text-blue-700" href="<?php echo URLROOT.'/alumni/records/'.$row->id ; ?>">view</a>
											<?php endif; ?>

											<?php if($row->status == 'closed'): ?>
												<a id="open-account-btn" class="hover:text-blue-700" title="open account" href="<?php echo URLROOT.'/user/open/alumni/'.$row->id;?>">activate</a>
											<?php endif; ?>

											<?php if($row->status == 'blocked'): ?>
												<a id="unblock-account-btn" class="hover:text-blue-700" href="<?php echo URLROOT.'/user/unblock/alumni/'.$row->id;?>" title="unblock account">unblock</a>
											<?php endif; ?>

											<?php if($row->status == 'closed' || $row->status == 'blocked' || $row->status == 'declined'): ?>
												<a id="delete-btn" class="text-red-500" href="<?php echo URLROOT.'/user/delete/alumni/'.$row->id ; ?>">delete</a>
											<?php endif; ?>
											
											<?php if($row->status == 'for review'): ?>
												<a class="hover:text-blue-700 update-approval-btn" href="#">update</a>
											<?php endif; ?>

											<?php if($row->status == 'active'): ?>
												<a id="close-account-btn" class="text-red-500" title="close account" href="<?php echo URLROOT.'/user/close/alumni/'.$row->id;?>">close</a>
												<a class="text-red-500 block-btn" href="#" title="block account">block</a>
											<?php endif; ?>
										</td>
										
									</tr>
								<?php
									endforeach;
								?>
							
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-------------------------------------- view panel ---------------------------------->

	<div id="view-panel" class="fixed z-30 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
		<div class="flex gap-2">
			<a id="view-exit-btn" class="m-2 p-1 hover:bg-slate-100">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
					<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
				</svg>
			</a>
		</div>

		<div class="flex justify-center w-full h-max">
			<div class="flex flex-col w-10/12 pt-10 pb-20">
				<div class="flex flex-col gap2 w-full">
					<p class="text-2xl font-bold">Alumni Details<span class="text-sm font-normal" id="request-id"></span></p>
					<p class="text-sm text-slate-500">Check details included here throughly before accepting/declining account</p>
				</div>

				<div class="flex flex-col gap2 w-full mt-6">
					<table class="w-full table-fixed">
						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Student ID</td>
							<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="student-id"></span></td>
						</tr>

						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Status</td>
							<td id="status" width="70" class="hover:bg-slate-100 p-1 pl-2"></td>
						</tr>

						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Name</td>
							<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="name" ></span></td>
						</tr>
						
						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Email</td>
							<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="email" class=""></span></td>
						</tr>
						
						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Contact no.</td>
							<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="contact" class=""></span></td>
						</tr>

						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Gender</td>
							<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="gender" class=""></span></td>
						</tr>

						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Location</td>
							<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="location" class=""></span></td>
						</tr>

						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Complete address</td>
							<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="address" class=""></span></td>
						</tr>

						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Course</td>
							<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="course" class=""></span></td>
						</tr>

						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Year Graduated</td>
							<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="year" class=""></span></td>
						</tr>	

						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Section</td>
							<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="section" class=""></span></td>
						</tr>					

						<tr>
							<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Identification</td>
							<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="identification" class=""></span></td>
						</tr>
					</table>	
				</div>

				<div class="flex flex-col gap2 w-full mt-2">
					<p class="pl-2 pt-2 pb-4 font-semibold">Remarks</p>
					<div class="w-full pl-2">
						<p id="remarks">...</p>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-------------------------------------- update approval panel ---------------------------------->

	<div id="update-approval-panel" class="fixed z-35 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
		<div class="flex gap-2">
			<a id="update-approval-exit-btn" class="m-2 p-1 hover:bg-slate-100">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
					<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
				</svg>
			</a>
		</div>
		<div class="flex justify-center w-full h-max">
			<div class="flex flex-col w-10/12 pt-10 pb-20">
				<div class="flex flex-col gap2 w-full">
					<a id="request-id-btn" class="text-2xl cursor-pointer font-bold">Update Account<span class="text-sm font-normal" id="update-request-id"></span></a>
					<p class="text-sm text-slate-500">Update status and send a remarks for the request</p>
				</div>

				<div class="w-full">
					<form action="<?php echo URLROOT; ?>/user/approval" method="POST" class="w-full">
						<input name="id" type="hidden" value="" />
						<input name="type" type="hidden" value="alumni" />

						<div class="flex flex-col mt-5">
							<div class="flex flex-col gap2 w-full">
								<p class="font-semibold">Is account approved?</p>
							</div>
							<select name="status" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700">
								<option value="">Choose Option</option>
								<option value="active">approved</option>
								<option value="declined">declined</option>
							</select>
						</div>

						<div class="flex flex-col mt-5">
							<div class="flex flex-col gap2 w-full">
								<p class="font-semibold">Remarks</p>
								<p class="text-sm text-slate-500"></p>
							</div>
							<textarea name="remarks" class="border rounded-sm border-slate-300 py-2 px-2 outline-1 outline-blue-400 mt-4 h-36" placeholder="Write a remarks..."></textarea>
						</div>

						<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Update request"/>
							<p class="text-sm text-slate-500 mt-2">Upon submission, SMS and an Email will be sent to notify the student. </p>
					</form>

				</div>
			</div>
		</div>
	</div>


	<!-------------------------------------- block panel ---------------------------------->

	<div id="block-panel" class="fixed z-35 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
		<div class="flex gap-2">
			<a id="block-exit-btn" class="m-2 p-1 hover:bg-slate-100">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
					<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
				</svg>
			</a>
		</div>
		<div class="flex justify-center w-full h-max">
			<div class="flex flex-col w-10/12 pt-10 pb-20">
				<div class="flex flex-col gap2 w-full">
					<a id="request-id-btn" class="text-2xl cursor-pointer font-bold">Block Account<span class="text-sm font-normal" id="update-request-id"></span></a>
					<p class="text-sm text-slate-500">Block student account and write the reason in remarks</p>
				</div>

				<div class="w-full">
					<form action="<?php echo URLROOT; ?>/user/block" method="POST" class="w-full">
						<input name="id" type="hidden" value="" />
						<input name="type" type="hidden" value="alumni" />

						<div class="flex flex-col mt-5">
							<div class="flex flex-col gap2 w-full">
								<p class="font-semibold">Remarks</p>
								<p class="text-sm text-slate-500"></p>
							</div>
							<textarea name="remarks" class="border rounded-sm border-slate-300 py-2 px-2 outline-1 outline-blue-400 mt-4 h-36" placeholder="Write a remarks..."></textarea>
						</div>

						<input class=" mt-10 rounded-sm bg-red-500 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Block account"/>
							<p class="text-sm text-slate-500 mt-2">Upon submission, SMS and an Email will be sent to notify the student. </p>
					</form>

				</div>
			</div>
		</div>
	</div>
</main>

<script>
	<?php
		require APPROOT.'/views/user/alumni/alumni.js';
	?>
</script>