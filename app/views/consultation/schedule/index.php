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

			$details = $data['request-data'];
		?>

		<div class="flex justify-center w-full h-full overflow-y-scroll">
			<div class="h-max w-10/12 py-14 pb-24">
				<div class="flex flex-col gap-2">
					<p class="text-2xl font-bold">Schedule</p>
					<p class="text-sm text-slate-500">Manage your schedule for online consultations</p>
				</div>

				<div class="w-10/12">
					<?php
						require APPROOT.'/views/includes/loader.main.php';
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>

					<form class="" method="POST">
						<!-- <div>
							<label id="monday-label" for="monday" >Mon</label>
							<input id="monday" type="checkbox" value="monday" class="days hidden"/>
						</div>

						<div>
							<label id="tuesday-label" for="tuesday" >Tue</label>
							<input id="tuesday" type="checkbox" value="tuesday" class="days hidden"/>
						</div>

						<div>
							<label id="wednesday-label" for="wednesday" >Wed</label>
							<input id="wednesday" type="checkbox" value="wednesday" class="days hidden"/>
						</div>

						<div>
							<label id="thursday-label" for="thursday" >Thu</label>
							<input id="thursday" type="checkbox" value="thursday" class="days hidden"/>
						</div>

						<div>
							<label id="friday-label" for="friday" >Fri</label>
							<input id="friday" type="checkbox" value="friday" class="days hidden"/>
						</div>

						<div>
							<label id="saturday-label" for="saturday" >Sat</label>
							<input id="saturday" type="checkbox" value="saturday" class="days hidden"/>
						</div>

						<div>
							<label id="sunday-label" for="sunday" >Sun</label>
							<input id="sunday" type="checkbox" value="sunday" class="days hidden"/>
						</div>	 -->

						<table class="w-full mt-5 border-collapse border">
							<thead class="border">
								<tr class="text-center border">
									<td class="text-slate-500 border py-2 px-4">Monday</td>
									<td class="text-slate-500 border py-2 px-4">Tuesday</td>
									<td class="text-slate-500 border py-2 px-4">Wednesday</td>
									<td class="text-slate-500 border py-2 px-4">Thursday</td>
									<td class="text-slate-500 border py-2 px-4">Friday</td>
									<td class="text-slate-500 border py-2 px-4">Saturday</td>
									<td class="text-slate-500 border py-2 px-4">Sunday</td>
								</tr>			
							</thead>

							<tbody class="border">
								<tr>
									<td id="mon-controls" class="border">
										<div  class="flex gap-1 text-slate-400 items-center justify-center w-full py-2 px-4 bg-slate-100">
											<a id="mon-insert" data-day="monday" title="insert" class="hover:text-blue-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
												</svg>

											</a>

											<a id="mon-reset" title="clear all" class="hover:text-red-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
												</svg>
											</a>

											<a id="mon-delete-selected" title="delete selected" class="cursor-not-allowed">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path d="M2 3a1 1 0 00-1 1v1a1 1 0 001 1h16a1 1 0 001-1V4a1 1 0 00-1-1H2z" />
  													<path fill-rule="evenodd" d="M2 7.5h16l-.811 7.71a2 2 0 01-1.99 1.79H4.802a2 2 0 01-1.99-1.79L2 7.5zm5.22 1.72a.75.75 0 011.06 0L10 10.94l1.72-1.72a.75.75 0 111.06 1.06L11.06 12l1.72 1.72a.75.75 0 11-1.06 1.06L10 13.06l-1.72 1.72a.75.75 0 01-1.06-1.06L8.94 12l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
												</svg>
											</a>	
										</div>
									</td>

									<td id="tue-controls" class="border">
										<div  class="flex gap-1 text-slate-400 items-center justify-center w-full py-2 px-4 bg-slate-100">
											<a id="tue-insert" data-day="tuesday" title="insert" class="hover:text-blue-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
												</svg>

											</a>

											<a id="tue-reset" title="clear all" class="hover:text-red-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
												</svg>
											</a>

											<a id="tue-delete-selected" title="delete selected" class="cursor-not-allowed">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path d="M2 3a1 1 0 00-1 1v1a1 1 0 001 1h16a1 1 0 001-1V4a1 1 0 00-1-1H2z" />
  													<path fill-rule="evenodd" d="M2 7.5h16l-.811 7.71a2 2 0 01-1.99 1.79H4.802a2 2 0 01-1.99-1.79L2 7.5zm5.22 1.72a.75.75 0 011.06 0L10 10.94l1.72-1.72a.75.75 0 111.06 1.06L11.06 12l1.72 1.72a.75.75 0 11-1.06 1.06L10 13.06l-1.72 1.72a.75.75 0 01-1.06-1.06L8.94 12l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
												</svg>
											</a>	
										</div>
									</td>

									<td id="wed-controls" class="border">
										<div  class="flex gap-1 text-slate-400 items-center justify-center w-full py-2 px-4 bg-slate-100">
											<a id="wed-insert" data-day="wednesday" title="insert" class="hover:text-blue-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
												</svg>

											</a>

											<a id="wed-reset" title="clear all" class="hover:text-red-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
												</svg>
											</a>

											<a id="wed-delete-selected" title="delete selected" class="cursor-not-allowed">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path d="M2 3a1 1 0 00-1 1v1a1 1 0 001 1h16a1 1 0 001-1V4a1 1 0 00-1-1H2z" />
  													<path fill-rule="evenodd" d="M2 7.5h16l-.811 7.71a2 2 0 01-1.99 1.79H4.802a2 2 0 01-1.99-1.79L2 7.5zm5.22 1.72a.75.75 0 011.06 0L10 10.94l1.72-1.72a.75.75 0 111.06 1.06L11.06 12l1.72 1.72a.75.75 0 11-1.06 1.06L10 13.06l-1.72 1.72a.75.75 0 01-1.06-1.06L8.94 12l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
												</svg>
											</a>	
										</div>
									</td>

									<td id="thu-controls" class="border">
										<div  class="flex gap-1 text-slate-400 items-center justify-center w-full py-2 px-4 bg-slate-100">
											<a id="thu-insert" data-day="thursday" title="insert" class="hover:text-blue-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
												</svg>

											</a>

											<a id="thu-reset" title="clear all" class="hover:text-red-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
												</svg>
											</a>

											<a id="thu-delete-selected" title="delete selected" class="cursor-not-allowed">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path d="M2 3a1 1 0 00-1 1v1a1 1 0 001 1h16a1 1 0 001-1V4a1 1 0 00-1-1H2z" />
  													<path fill-rule="evenodd" d="M2 7.5h16l-.811 7.71a2 2 0 01-1.99 1.79H4.802a2 2 0 01-1.99-1.79L2 7.5zm5.22 1.72a.75.75 0 011.06 0L10 10.94l1.72-1.72a.75.75 0 111.06 1.06L11.06 12l1.72 1.72a.75.75 0 11-1.06 1.06L10 13.06l-1.72 1.72a.75.75 0 01-1.06-1.06L8.94 12l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
												</svg>
											</a>	
										</div>
									</td>

									<td id="fri-controls" class="border">
										<div  class="flex gap-1 text-slate-400 items-center justify-center w-full py-2 px-4 bg-slate-100">
											<a id="fri-insert" data-day="friday" title="insert" class="hover:text-blue-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
												</svg>

											</a>

											<a id="fri-reset" title="clear all" class="hover:text-red-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
												</svg>
											</a>

											<a id="fri-delete-selected" title="delete selected" class="cursor-not-allowed">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path d="M2 3a1 1 0 00-1 1v1a1 1 0 001 1h16a1 1 0 001-1V4a1 1 0 00-1-1H2z" />
  													<path fill-rule="evenodd" d="M2 7.5h16l-.811 7.71a2 2 0 01-1.99 1.79H4.802a2 2 0 01-1.99-1.79L2 7.5zm5.22 1.72a.75.75 0 011.06 0L10 10.94l1.72-1.72a.75.75 0 111.06 1.06L11.06 12l1.72 1.72a.75.75 0 11-1.06 1.06L10 13.06l-1.72 1.72a.75.75 0 01-1.06-1.06L8.94 12l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
												</svg>
											</a>	
										</div>
									</td>

									<td id="sat-controls" class="border">
										<div  class="flex gap-1 text-slate-400 items-center justify-center w-full py-2 px-4 bg-slate-100">
											<a id="sat-insert" data-day="saturday" title="insert" class="hover:text-blue-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
												</svg>

											</a>

											<a id="sat-reset" title="clear all" class="hover:text-red-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
												</svg>
											</a>

											<a id="sat-delete-selected" title="delete selected" class="cursor-not-allowed">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path d="M2 3a1 1 0 00-1 1v1a1 1 0 001 1h16a1 1 0 001-1V4a1 1 0 00-1-1H2z" />
  													<path fill-rule="evenodd" d="M2 7.5h16l-.811 7.71a2 2 0 01-1.99 1.79H4.802a2 2 0 01-1.99-1.79L2 7.5zm5.22 1.72a.75.75 0 011.06 0L10 10.94l1.72-1.72a.75.75 0 111.06 1.06L11.06 12l1.72 1.72a.75.75 0 11-1.06 1.06L10 13.06l-1.72 1.72a.75.75 0 01-1.06-1.06L8.94 12l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
												</svg>
											</a>	
										</div>
									</td>

									<td id="sun-controls" class="border">
										<div  class="flex gap-1 text-slate-400 items-center justify-center w-full py-2 px-4 bg-slate-100">
											<a id="sun-insert" data-day="sunday" title="insert" class="hover:text-blue-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
												</svg>

											</a>

											<a id="sun-reset" title="clear all" class="hover:text-red-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
													<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
												</svg>
											</a>

											<a id="sun-delete-selected" title="delete selected" class="cursor-not-allowed">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
  													<path d="M2 3a1 1 0 00-1 1v1a1 1 0 001 1h16a1 1 0 001-1V4a1 1 0 00-1-1H2z" />
  													<path fill-rule="evenodd" d="M2 7.5h16l-.811 7.71a2 2 0 01-1.99 1.79H4.802a2 2 0 01-1.99-1.79L2 7.5zm5.22 1.72a.75.75 0 011.06 0L10 10.94l1.72-1.72a.75.75 0 111.06 1.06L11.06 12l1.72 1.72a.75.75 0 11-1.06 1.06L10 13.06l-1.72 1.72a.75.75 0 01-1.06-1.06L8.94 12l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
												</svg>
											</a>	
										</div>
									</td>
								</tr>

								<tr>
									<td class="border text-center text-sm py-4">
										<ul id="mon-timeslot-list">
										</ul>
									</td>

									<td class="border text-center text-sm py-4">
										<ul id="tue-timeslot-list">								
										</ul>
									</td>

									<td class="border text-center text-sm py-4">
										<ul id="wed-timeslot-list">	
										</ul>
									</td>
									
									<td class="border text-center text-sm py-4">
										<ul id="thu-timeslot-list">										
										</ul>
									</td>
									
									<td class="border text-center text-sm py-4">
										<ul id="fri-timeslot-list">						
										</ul>
									</td>
									
									<td class="border text-center text-sm py-4">
										<ul id="sat-timeslot-list">										
										</ul>
									</td>
									
									<td class="border text-center text-sm py-4">
										<ul id="sun-timeslot-list">						
										</ul>
									</td>
									
								</tr>
							</tbody>
						</table>
					</form>

					<div id="insert-panel" style="background-color: rgba(255, 255, 255, 0.5)" class="fixed flex flex-col justify-center items-center top-0 left-0 h-full w-full hidden z-50">
						<div class="w-1/2 h-max p-2 bg-slate-50">
							<div class="flex">
								<input name="day" type="hidden"/>
								<input name="from" type="time"/>
								<input name="to" type="time"/>
								<p class="text-red-700" id="insert-error"></p>
								<a id="insert-btn">Add timeslot</a>
							</div>
						</div>
						
						<div class="w-1/2 h-max bg-slate-50 p-2">
							<ul id="insert-timeslot-list">
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/consultation/schedule/schedule.js'?>;
</script>	