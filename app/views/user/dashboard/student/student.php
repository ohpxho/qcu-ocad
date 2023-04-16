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
		<p class="text-sm text-slate-500">Request records summary</p>
		<div class="flex gap-2 mt-5">
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full">
				<div class="flex flex-col p-4 sm:aspect-video w-full h-max rounded-md bg-green-200">
					<?php
						$completed_frequency = $data['completed-frequency'];
						$gradeslip = isset($completed_frequency->GRADESLIP)? $completed_frequency->GRADESLIP : '0';
						$ctc = isset($completed_frequency->CTC)? $completed_frequency->CTC : '0';
						$others = isset($completed_frequency->OTHERS)? $completed_frequency->OTHERS : '0';
						$goodmoral = isset($completed_frequency->GOOD_MORAL)? $completed_frequency->GOOD_MORAL : '0';
						$soa = isset($completed_frequency->SOA)? $completed_frequency->SOA : '0';
						$oop = isset($completed_frequency->ORDER_OF_PAYMENT)? $completed_frequency->ORDER_OF_PAYMENT : '0';
						
						$completed_count = $gradeslip + $ctc + $others + $goodmoral + $soa + $oop;
					?>

					<div class="w-14 flex items-center justify-center bg-green-400 text-white aspect-square rounded-full">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
						</svg>


					</div>
					<p class="text-4xl mt-5 font-bold"><?php echo $completed_count ?></p>
					<p class="mt-3">No. of completed request</p>
					<a id="completed-req-summary-btn" class="cursor-pointer text-sm text-blue-700"> - view summary</a>
					
					<div style="background-color: rgba(255, 255, 255, 0.5)"  id="completed-req-summary-modal" class="fixed w-full h-full top-0 left-0 z-50 flex justify-center items-center hidden">
						<div class="flex flex-col w-2/6 gap-1 mt-5 p-4 border rounded-md bg-white">
							<div class="flex justify-between">
								<div class="flex flex-col">
									<p class="font-medium">Frequency of Request by Document</p>
									<p class="text-sm text-slate-500">Displays the frequency of completed document request</p>
								</div>

								<a class="cursor-pointer" id="completed-req-summary-exit-btn">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
									  <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
									</svg>
								</a>
							</div>
							
							<table class="w-full table-fixed mt-3">
								<tr>
									<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Document</td>
									<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Gradeslip</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $gradeslip ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Certified True Copy</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $ctc ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Good Moral Certificate</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $goodmoral ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Statement Of Account</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $soa ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Order of Payment</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $oop ?></span></td>
								</tr>

								<tr >
									<td width="80" class="p-1 pl-2 border text-sm ">Others</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $others ?></span></td>
								</tr>
							</table>
						</div>
					</div>
				
				</div>


				<div class="flex flex-col p-4 w-full aspect-video rounded-md bg-red-200">
					<?php
						$rejected_frequency = $data['rejected-frequency'];
						$gradeslip = isset($rejected_frequency->GRADESLIP)? $rejected_frequency->GRADESLIP : '0';
						$ctc = isset($rejected_frequency->CTC)? $rejected_frequency->CTC : '0';
						$others = isset($rejected_frequency->OTHERS)? $rejected_frequency->OTHERS : '0';
						$goodmoral = isset($rejected_frequency->GOOD_MORAL)? $rejected_frequency->GOOD_MORAL : '0';
						$soa = isset($rejected_frequency->SOA)? $rejected_frequency->SOA : '0';
						$oop = isset($rejected_frequency->ORDER_OF_PAYMENT)? $rejected_frequency->ORDER_OF_PAYMENT : '0';
						
						$rejected_count = $gradeslip + $ctc + $others + $goodmoral + $soa + $oop;
					?>

					<div class="w-14 flex items-center justify-center bg-red-400 text-white aspect-square rounded-full">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
						</svg>
					</div>
					<p class="text-4xl mt-5 font-bold"><?php echo $rejected_count ?></p>
					<p class="mt-3">No. of declined request</p>
					<a id="rejected-req-summary-btn" class="cursor-pointer text-sm text-blue-700"> - view summary</a>
					
					<div style="background-color: rgba(255, 255, 255, 0.5)"  id="rejected-req-summary-modal" class="fixed w-full h-full top-0 left-0 z-50 flex justify-center items-center hidden">
						<div class="flex flex-col w-2/6 gap-1 mt-5 p-4 border rounded-md bg-white">
							<div class="flex justify-between">
								<div class="flex flex-col">
									<p class="font-medium">Frequency of Request by Document</p>
									<p class="text-sm text-slate-500">Displays the frequency of rejected document request</p>
								</div>

								<a class="cursor-pointer" id="rejected-req-summary-exit-btn">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
									  <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
									</svg>
								</a>
							</div>
							
							<table class="w-full table-fixed mt-3">
								<tr>
									<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Document</td>
									<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Gradeslip</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $gradeslip ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Certified True Copy</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $ctc ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Good Moral Certificate</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $goodmoral ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Statement Of Account</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $soa ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Order of Payment</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $oop ?></span></td>
								</tr>

								<tr >
									<td width="80" class="p-1 pl-2 border text-sm ">Others</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $others ?></span></td>
								</tr>
							</table>
						</div>
					</div>
				
				</div>

				<div class="flex flex-col p-4 w-full aspect-video rounded-md bg-red-300">
					<?php
						$cancelled_frequency = $data['cancelled-frequency'];
						$gradeslip = isset($cancelled_frequency->GRADESLIP)? $cancelled_frequency->GRADESLIP : 0;
						$ctc = isset($cancelled_frequency->CTC)? $cancelled_frequency->CTC : 0;
						$others = isset($cancelled_frequency->OTHERS)? $cancelled_frequency->OTHERS : 0;
						$goodmoral = isset($cancelled_frequency->GOOD_MORAL)? $cancelled_frequency->GOOD_MORAL : 0;
						$soa = isset($cancelled_frequency->SOA)? $cancelled_frequency->SOA : 0;
						$oop = isset($cancelled_frequency->ORDER_OF_PAYMENT)? $cancelled_frequency->ORDER_OF_PAYMENT : 0;
						
						$cancelled_count = $gradeslip + $ctc + $others + $goodmoral + $soa + $oop;
					?>

					<div class="w-14 flex items-center justify-center bg-red-500 text-white aspect-square rounded-full">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
						</svg>
					</div>
					<p class="text-4xl mt-5 font-bold"><?php echo $cancelled_count ?></p>
					<p class="mt-3">No. of cancelled request</p>
					<a id="cancelled-req-summary-btn" class="cursor-pointer text-sm text-blue-700"> - view summary</a>
					
					<div style="background-color: rgba(255, 255, 255, 0.5)"  id="cancelled-req-summary-modal" class="fixed w-full h-full top-0 left-0 z-50 flex justify-center items-center hidden">
						<div class="flex flex-col w-2/6 gap-1 mt-5 p-4 border rounded-md bg-white">
							<div class="flex justify-between">
								<div class="flex flex-col">
									<p class="font-medium">Frequency of Request by Document</p>
									<p class="text-sm text-slate-500">Displays the frequency of cancelled document request</p>
								</div>

								<a class="cursor-pointer" id="cancelled-req-summary-exit-btn">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
									  <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
									</svg>
								</a>
							</div>
							
							<table class="w-full table-fixed mt-3">
								<tr>
									<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Document</td>
									<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Gradeslip</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $gradeslip ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Certified True Copy</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $ctc ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Good Moral Certificate</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $goodmoral ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Statement Of Account</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $soa ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Order of Payment</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $oop ?></span></td>
								</tr>

								<tr >
									<td width="80" class="p-1 pl-2 border text-sm ">Others</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $others ?></span></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="flex flex-col mt-5">
		<p class="text-lg font-medium">Consultation</p>
		<p class="text-sm text-slate-500">Consultation records summary</p>

		<div class="flex gap-2 mt-5">
			<?php
				$upcoming = $data['upcoming-consultation'];
				$consultation_today_count = count($upcoming);

				$consultation_freq = $data['consultation-frequency'];
				$active = isset($consultation_freq->ACTIVE)? $consultation_freq->ACTIVE : 0;
			?>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full">
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

				<div class="flex flex-col p-4 w-full aspect-video rounded-md bg-green-200">
					<div class="w-14 flex items-center justify-center bg-green-400 text-white aspect-square rounded-full">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
						</svg>

					</div>
					<p class="text-4xl mt-5 font-bold"><?php echo $active ?></p>
					<p class="mt-3">No. of active consultations</p>
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

		<div class="flex flex-col w-full sm:w-1/2 mt-5">
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
