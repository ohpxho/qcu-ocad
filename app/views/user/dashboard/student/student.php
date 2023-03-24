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
		<p class="text-sm text-slate-500">Your academic, good moral, and statement account document request records summary</p>
		<div class="flex gap-2">
			<div class="flex flex-col w-2/6 gap-1 mt-5 p-4 border rounded-md">
				<div>
					<p class="font-medium">Frequency of Request by Document</p>
					<p class="text-sm text-slate-500">Your request frequency by document for document request</p>
				</div>

				<table class="w-full table-fixed mt-3">
					<?php
						$reqfreq = $data['request-frequency'];
						$gradeslip = isset($reqfreq->GRADESLIP)? $reqfreq->GRADESLIP : '0';
						$ctc = isset($reqfreq->CTC)? $reqfreq->CTC : '0';
						$others = isset($reqfreq->OTHERS)? $reqfreq->OTHERS : '0';
						$goodmoral = isset($reqfreq->GOOD_MORAL)? $reqfreq->GOOD_MORAL : '0';
						$soa = isset($reqfreq->SOA)? $reqfreq->SOA : '0';
						$oop = isset($reqfreq->ORDER_OF_PAYMENT)? $reqfreq->ORDER_OF_PAYMENT : '0';
							
					?>
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

			<div class="flex flex-col gap-1 w-2/6 mt-5 p-4 border rounded-md">
				<div>
					<p class="font-medium">Frequency of Request by Status</p>
					<p class="text-sm text-slate-500">Your request frequency by status for document request</p>
				</div>

				<table class="w-full table-fixed mt-3">
					<?php
						$statfreq = $data['status-frequency'];
						$pending = isset($statfreq->pending)? $statfreq->pending : '0';
						$accepted = isset($statfreq->accepted)? $statfreq->accepted : '0';
						$rejected = isset($statfreq->rejected)? $statfreq->rejected : '0';
						$inprocess = isset($statfreq->inprocess)? $statfreq->inprocess : '0';
						$forclaiming = isset($statfreq->forclaiming)? $statfreq->forclaiming : '0';
						$completed = isset($statfreq->completed)? $statfreq->completed : '0';
					?>
					<tr>
						<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Status</td>
						<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Pending</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $pending ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Accepted</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $accepted ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Declined</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $rejected ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">In Process</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $inprocess ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">For Claiming</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $forclaiming ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Completed</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $completed ?></span></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="w-full border p-4 rounded-md bg-slate-50 mt-5">
			<div class="flex flex-col">
				<p class="font-medium"><?php echo date('Y')?> Activity Graph</p>
				<p class="text-sm text-slate-500">You activity graph of the current year for document request</p>
			</div>

			<div class="flex flex-col gap-2 w-full h-max rounded-md border p-4 py-6 bg-white overflow-hidden hover:overflow-x-scroll mt-3">
				<div class="w-max" id="calendar-activity-graph-document"></div>
			</div>

			<div class="flex items-center justify-end mt-3">
				<div class="flex gap-2 items-center text-sm ">
					<span>Less</span>
					<svg width="10" height="10">
                		<rect width="10" height="10" fill="#CBD5E1" data-level="0" rx="2" ry="2"></rect>
              		</svg>
              		<svg width="10" height="10">
                		<rect width="10" height="10" fill="#86EFAC" data-level="0" rx="2" ry="2"></rect>
              		</svg>
              		<svg width="10" height="10">
                		<rect width="10" height="10" fill="#4ADE80" data-level="0" rx="2" ry="2"></rect>
              		</svg>
              		<svg width="10" height="10">
                		<rect width="10" height="10" fill="#16A34A" data-level="0" rx="2" ry="2"></rect>
              		</svg>
              		<svg width="10" height="10">
                		<rect width="10" height="10" fill="#166534" data-level="0" rx="2" ry="2"></rect>
              		</svg>
					<span>More</span>
				</div>
			</div>
		</div>
	</div>

	<div class="flex flex-col mt-5">
		<p class="text-lg font-medium">Online Consultation</p>
		<p class="text-sm text-slate-500">Your online consultation records summary</p>

		<div class="flex gap-2 mt-5">
			<div class="w-2/6 border p-4 rounded-md">
				<div>
					<p class="font-medium">Frequency of Request by Status</p>
					<p class="text-sm text-slate-500">Your request frequency by status for online consultation</p>
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
						<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Status</td>
						<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Pending</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span id="tor-count"><?php echo $_pending ?></span></td>
					</tr>
					
					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Active</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span id="tor-count"><?php echo $active ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Resolved</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span id="tor-count"><?php echo $resolved ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border border text-sm ">Cancelled</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span id="gradeslip-count"><?php echo $unresolved ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border border text-sm ">Declined</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span id="ctc-count"><?php echo $_rejected ?></span></td>
					</tr>

				</table>
			</div>

			<div class="w-8/12 p-4 border rounded-md">
				<p class="font-medium">Upcoming Consultations</p>
				<p class="text-sm text-slate-500">Scheduled online consultation</p>
				
				<ul class="w-full mt-3 border h-40 overflow-y-scroll">
					<?php
						$purpose = [
							'Thesis/Capstone Advising',
        					'Project Concern/Advising',
					        'Grades Consulting',
					        'Lecture Inquiries',
					        'Exams/Quizzes/Assignment Concern',
					        'Performance Consulting',
					        'Counseling',
					        'Report',
					        'Health Concern'
					    ];

					?>
					<?php $isThereAnUpcomingConsultation = 0; ?>

					<?php if(count($data['upcoming-consultation']) > 0):?> 
						<?php foreach($data['upcoming-consultation'] as $row):?>
							<?php
								$current = new DateTime();
								$dt = new DateTime($row->schedule_for_gmeet);
							?>

							<?php if($current < $dt): ?>
								<?php $isThereAnUpcomingConsultation = 1; ?>
								<a href="<?php echo URLROOT.'/consultation/show/active/'.$row->id ?>">
									<li class="group/active text-sm flex justify-between gap-2 p-4 hover:bg-blue-700 border-b hover:text-white ">
										<div >
											<span><?php echo $row->adviser_name ?></span>
											<span class="text-sm"> | </span>
											<span><?php echo $row->department ?></span>
											<span class="text-sm"> - </span>
											<span class="group-hover/active:text-white text-orange-700"><?php echo $purpose[$row->purpose] ?><span/>
										</div>

										<?php
											$sched = new DateTime($row->schedule_for_gmeet);
											$sched = $sched->format('d M Y h:i A');
										?>
										<span><?php echo $sched ?><span/>	
									</li>
								</a>
							<?php endif; ?>
						<?php endforeach;?>
					<?php endif; ?>
					
					<?php if(!$isThereAnUpcomingConsultation):?>
						<div class="flex items-center justify-center w-full h-full text-slate-500 bg-slate-100">
							<p>No upcoming consultations</p>
						</div>	
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="w-full border p-4 rounded-md bg-slate-50 mt-5">
			<div class="flex flex-col">
				<p class="font-medium"><?php echo date('Y')?> Activity Graph</p>
				<p class="text-sm text-slate-500">You activity graph of the current year for online consultation</p>
			</div>

			<div class="flex flex-col gap-2 w-full h-max rounded-md border p-4 py-6 bg-white overflow-hidden hover:overflow-x-scroll mt-3">
				<div class="w-max" id="calendar-activity-graph-consultation"></div>
			</div>

			<div class="flex items-center justify-end mt-3">
				<div class="flex gap-2 items-center text-sm ">
					<span>Less</span>
					<svg width="10" height="10">
                		<rect width="10" height="10" fill="#CBD5E1" data-level="0" rx="2" ry="2"></rect>
              		</svg>
              		<svg width="10" height="10">
                		<rect width="10" height="10" fill="#86EFAC" data-level="0" rx="2" ry="2"></rect>
              		</svg>
              		<svg width="10" height="10">
                		<rect width="10" height="10" fill="#4ADE80" data-level="0" rx="2" ry="2"></rect>
              		</svg>
              		<svg width="10" height="10">
                		<rect width="10" height="10" fill="#16A34A" data-level="0" rx="2" ry="2"></rect>
              		</svg>
              		<svg width="10" height="10">
                		<rect width="10" height="10" fill="#166534" data-level="0" rx="2" ry="2"></rect>
              		</svg>
					<span>More</span>
				</div>
			</div>
		</div>
	</div>

	<div class="flex flex-col mt-5">
		<p class="text-lg font-medium">Recent Activities</p>
		<p class="text-sm text-slate-500">
			<?php
				echo date('d F Y');
			?>	
		</p>

		<div class="flex flex-col w-1/2 mt-5">
			<?php if(count($data['recent-activity']) > 0): ?>
				<?php foreach($data['recent-activity'] as $row): ?>
					<div class="before:content-[''] before:absolute before:top-0 before:left-0 before:w-0.5 before:h-full before:bg-orange-700 flex flex-col gap-1 pl-6 py-3">
						<div class="absolute w-2 h-2 rounded-full bg-orange-700 -left-[3px] top-8"></div>
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



<!----===============================MODAL============================---->
<script>
	<?php
		require APPROOT.'/views/user/dashboard/student/student.js';
	?>
</script>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>

    <div id="app" class="h-full  w-full flex items-center justify-center">
    <transition name="fade">
      <div v-show="show_modal" class="fixed inset-0 z-30">
        <div v-show="show_modal" @click="showModal()" class="bg-filter bg-white opacity-50 fixed inset-0 w-full h-full z-20">
        </div>
        <main class="flex flex-col items-center justify-center h-full w-full">
            <transition name="fade-up-down">
                <div v-show="show_modal" class="modal-wrapper inline-block flex items-center z-30 ">
                    <div class="modal w-full md:max-w-2xl bg-white max-h-screen shadow-lg flex-row rounded w-5/6">
                        <div class="modal-header p-2 bg-gray-900 text-gray-900 rounded-t ">
                            <h5 class="text-white text-2xl uppercase text-center">WELCOME</h5>
                        </div>
                        <div class="flex flex-col w-full items-center gap-2 shadow-lg mt-5">
						<a href="<?php echo URLROOT;?>/home"><img class="aspect-square h-25 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>
							<div class="flex flex-col text-center ml-10 mr-10">
								<span class="font-bold text-2xl">QUEZON CITY UNIVERSITY</span>
								<span class="text-lg" >Online Consultation And Document Request</span>
							</div>
						</a>
					</div>
                        <div class="modal-footer py-3 px-5 border0-t text-center ">
                            <button class="bg-yellow-500 px-5 py-1 text-black" @click="showModal()">OK</button>
                        </div>
                    </div>
                </div>
            </transition>
        </main>
      </div>
    </transition>
    </div>

<script crossorigin src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
  <script>
  
   new Vue({
        el:'#app',
        data(){
          return{
            show_modal: true,
          }
        },
        methods:{
          showModal(){
            if(this.show_modal){
              //stop screen scrolling
              document.getElementsByTagName("html")[0].classList.remove('overflow-y-hidden'); 
              this.show_modal = false;
            }else{
              document.getElementsByTagName("html")[0].classList.add('overflow-y-hidden');
              this.show_modal = true;
            }
          }
        }
      })
  
  </script>
<!----===========================================================---->
