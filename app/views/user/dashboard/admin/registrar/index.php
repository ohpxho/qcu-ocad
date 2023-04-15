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
			<div class="grid grid-cols-4 gap-4 w-full">
				<div class="flex flex-col p-4 w-full aspect-video rounded-md bg-green-200">
					<?php
						$completed_frequency = $data['completed-frequency'];
						$gradeslip = isset($completed_frequency->GRADESLIP)? $completed_frequency->GRADESLIP : 0;
						$tor = isset($completed_frequency->TOR)? $completed_frequency->TOR : 0;
						$diploma = isset($completed_frequency->DIPLOMA)? $completed_frequency->DIPLOMA : 0;
						$dismissal = isset($completed_frequency->HONORABLE_DISMISSAL)? $completed_frequency->HONORABLE_DISMISSAL : 0;
						$ctc = isset($completed_frequency->CTC)? $completed_frequency->CTC : 0;
						$others = isset($completed_frequency->OTHERS)? $completed_frequency->OTHERS : 0;
						$goodmoral = isset($completed_frequency->GOOD_MORAL)? $completed_frequency->GOOD_MORAL : 0;
						$soa = isset($completed_frequency->SOA)? $completed_frequency->SOA : 0;
						$oop = isset($completed_frequency->ORDER_OF_PAYMENT)? $completed_frequency->ORDER_OF_PAYMENT : 0;
						
						$completed_count = $gradeslip + $ctc + $others + $goodmoral + $soa + $oop + $tor + $diploma + $dismissal;
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
									<td width="80" class="p-1 pl-2 border text-sm ">Transcript of Record</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $tor ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Diploma</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $diploma ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Honorable Dismissal</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $dismissal ?></span></td>
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
						$gradeslip = isset($rejected_frequency->GRADESLIP)? $rejected_frequency->GRADESLIP : 0;
						$tor = isset($rejected_frequency->TOR)? $rejected_frequency->TOR : 0;
						$diploma = isset($rejected_frequency->DIPLOMA)? $rejected_frequency->DIPLOMA : 0;
						$dismissal = isset($rejected_frequency->HONORABLE_DISMISSAL)? $rejected_frequency->HONORABLE_DISMISSAL : 0;
						$ctc = isset($rejected_frequency->CTC)? $rejected_frequency->CTC : 0;
						$others = isset($rejected_frequency->OTHERS)? $rejected_frequency->OTHERS : 0;
						$goodmoral = isset($rejected_frequency->GOOD_MORAL)? $rejected_frequency->GOOD_MORAL : 0;
						$soa = isset($rejected_frequency->SOA)? $rejected_frequency->SOA : 0;
						$oop = isset($rejected_frequency->ORDER_OF_PAYMENT)? $rejected_frequency->ORDER_OF_PAYMENT : 0;
						
						$rejected_count = $gradeslip + $ctc + $others + $goodmoral + $soa + $oop + $tor + $diploma + $dismissal;
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
									<td width="80" class="p-1 pl-2 border text-sm ">Transcript of Record</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $tor ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Diploma</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $diploma ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Honorable Dismissal</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $dismissal ?></span></td>
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
						$tor = isset($cancelled_frequency->TOR)? $cancelled_frequency->TOR : 0;
						$diploma = isset($cancelled_frequency->DIPLOMA)? $cancelled_frequency->DIPLOMA : 0;
						$dismissal = isset($cancelled_frequency->HONORABLE_DISMISSAL)? $cancelled_frequency->HONORABLE_DISMISSAL : 0;
						$ctc = isset($cancelled_frequency->CTC)? $cancelled_frequency->CTC : 0;
						$others = isset($cancelled_frequency->OTHERS)? $cancelled_frequency->OTHERS : 0;
						$goodmoral = isset($cancelled_frequency->GOOD_MORAL)? $cancelled_frequency->GOOD_MORAL : 0;
						$soa = isset($cancelled_frequency->SOA)? $cancelled_frequency->SOA : 0;
						$oop = isset($cancelled_frequency->ORDER_OF_PAYMENT)? $cancelled_frequency->ORDER_OF_PAYMENT : 0;
						
						$cancelled_count = $gradeslip + $ctc + $others + $goodmoral + $soa + $oop + $tor + $diploma + $dismissal;
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
									<td width="80" class="p-1 pl-2 border text-sm ">Transcript of Record</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $tor ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Diploma</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $diploma ?></span></td>
								</tr>

								<tr>
									<td width="80" class="p-1 pl-2 border text-sm ">Honorable Dismissal</td>
									<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $dismissal ?></span></td>
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
