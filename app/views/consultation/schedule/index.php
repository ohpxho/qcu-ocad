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

				<div class="w-full">
					<?php
						require APPROOT.'/views/includes/loader.main.php';
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>

					<form id="day-form" action="<?php echo URLROOT; ?>/schedule/update" class="mt-5 w-full" method="POST">
						<input type="hidden" name="advisor" value="<?php echo $_SESSION['id'] ?>" readonly/>
						<input type="hidden" name="day" readonly />
						<input type="hidden" name="timeslots" readonly />
						
						<div class="flex gap-2 w-full h-max">
							<ul class="flex flex-col w-1/4">
								<li id="monday-li" class="text-center hover:bg-blue-700 hover:text-white rounded-md p-2">
									<input class="hidden" type="radio" name="day-radio" id="monday" checked/>
									<label class="cursor-pointer" for="monday">Monday</label>
								</li>
								<li id="tuesday-li" class="text-center hover:bg-blue-700 hover:text-white rounded-md p-2">
									<input class="hidden" type="radio" name="day-radio" id="tuesday" value="tuesday"/>
									<label class="cursor-pointer" for="tuesday">Tuesday</label>
								</li>
								<li id="wednesday-li" class="text-center hover:bg-blue-700 hover:text-white rounded-md p-2">
									<input class="hidden" type="radio" name="day-radio" id="wednesday"/>
									<label class="cursor-pointer" for="wednesday">Wednesday</label>
								</li>
								<li id="thursday-li" class="text-center hover:bg-blue-700 hover:text-white rounded-md p-2">
									<input class="hidden" type="radio" name="day-radio" id="thursday"/>
									<label class="cursor-pointer" for="thursday">Thursday</a></label>
								</li>
								<li id="friday-li" class="text-center hover:bg-blue-700 hover:text-white rounded-md p-2">
									<input class="hidden" type="radio" name="day-radio" id="friday"/>
									<label class="cursor-pointer" for="friday">Friday</label>
								</li>
								<li id="saturday-li" class="text-center hover:bg-blue-700 hover:text-white rounded-md p-2">
									<input class="hidden" type="radio" name="day-radio" id="saturday"/>
									<label class="cursor-pointer" for="saturday">Saturday</label>
								</li>
								<li id="sunday-li" class="text-center hover:bg-blue-700 hover:text-white rounded-md p-2">
									<input class="hidden" type="radio" name="day-radio" id="sunday"/>
									<label class="cursor-pointer" for="sunday">Sunday</label>
								</li>
							</ul>
							<div id="day-timeslots" class="flex flex-col gap-2 items-end w-full h-full">
								<div class="grid grid-cols-5 gap-2 w-full h-full bg-slate-100 p-4">
									<button class="timeslot-btn" data-enabled="false" data-time="8:00"><div data-time="8:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">8:00 AM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="8:30"><div data-time="8:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">8:30 AM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="9:00"><div data-time="9:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">9:00 AM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="9:30"><div data-time="9:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">9:30 AM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="10:00"><div data-time="10:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">10:00 AM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="10:30"><div data-time="10:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">10:30 AM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="11:00"><div data-time="11:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">11:00 AM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="11:30"><div data-time="11:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">11:30 AM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="12:00"><div data-time="12:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">12:00 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="12:30"><div data-time="12:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">12:30 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="13:00"><div data-time="13:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">1:00 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="13:30"><div data-time="13:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">1:30 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="14:00"><div data-time="14:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">2:00 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="14:30"><div data-time="14:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">2:30 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="15:00"><div data-time="15:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">3:00 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="15:30"><div data-time="15:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">3:30 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="16:00"><div data-time="16:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">4:00 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="16:30"><div data-time="16:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">4:30 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="17:00"><div data-time="17:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">5:00 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="17:30"><div data-time="17:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">5:30 PM</div></button>
									<button class="timeslot-btn" data-enabled="false" data-time="18:00"><div data-time="18:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">6:00 PM</div></button>
								</div>
								<input type="submit" value="Update schedule" class="flex bg-blue-700 gap-1 items-center text-white rounded-md px-4 py-1 h-max w-max opacity-50 cursor-not-allowed" disabled />
							</div>
						</div>	
					</form>

					<form id="calendar-form" action="" >
						<div id="calendar"></div>
						<div id="calendar-timeslots" class="flex flex-col gap-2 items-end w-full h-full">
							<div class="grid grid-cols-5 gap-2 w-full h-full bg-slate-100 p-4">
								<button class="timeslot-btn" data-enabled="false" data-time="8:00"><div data-time="8:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">8:00 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="8:30"><div data-time="8:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">8:30 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="9:00"><div data-time="9:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">9:00 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="9:30"><div data-time="9:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">9:30 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="10:00"><div data-time="10:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">10:00 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="10:30"><div data-time="10:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">10:30 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="11:00"><div data-time="11:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">11:00 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="11:30"><div data-time="11:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">11:30 AM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="12:00"><div data-time="12:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">12:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="12:30"><div data-time="12:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">12:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="13:00"><div data-time="13:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">1:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="13:30"><div data-time="13:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">1:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="14:00"><div data-time="14:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">2:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="14:30"><div data-time="14:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">2:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="15:00"><div data-time="15:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">3:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="15:30"><div data-time="15:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">3:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="16:00"><div data-time="16:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">4:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="16:30"><div data-time="16:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">4:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="17:00"><div data-time="17:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">5:00 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="17:30"><div data-time="17:30" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">5:30 PM</div></button>
								<button class="timeslot-btn" data-enabled="false" data-time="18:00"><div data-time="18:00" class="px-6 rounded-md py-1 w-full h-max bg-slate-200">6:00 PM</div></button>
							</div>
							<input type="submit" value="Update schedule" class="flex bg-blue-700 gap-1 items-center text-white rounded-md px-4 py-1 h-max w-max opacity-50 cursor-not-allowed" disabled />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/consultation/schedule/schedule.js'?>;
</script>	