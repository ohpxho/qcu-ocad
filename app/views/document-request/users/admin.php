<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-3xl font-bold">Academic Document Requests</p>
		<p class="text-sm text-slate-500">Review and manage student's document requests</p>
	</div>
	<a href="<?php echo URLROOT;?>/academic_document/add" class="bg-blue-700 w-max h-max rounded-md text-white px-5 py-1 hide">New request</a>
	<div >
		<a class="cursor-pointer" id="action-dropdown-btn"><img class="h-5 w-5 rotate-90" src="<?php echo URLROOT?>/public/assets/img/ellipsis.png"></a>
		<div id="action-card" class="absolute p-2 border bg-white border z-20 right-0 h-max w-max text-sm card-box-shadow hidden">
			<ul class="flex flex-col">
				<!--<a href="<?php echo URLROOT;?>/academic_document/add"><li class="flex pl-2 pr-16 py-1 hover:bg-slate-100"> add new request</li></a>-->
				<a href="#"><li class="flex pl-2 hover:bg-slate-100 pr-16 py-1"> export</li></a>
			</ul>
		</div>
	</div>
</div>

<div class="flex flex-col mt-5 gap-2 pb-24">
	
	<?php
		require APPROOT.'/views/flash/fail.php';
		require APPROOT.'/views/flash/success.php';
	?>
	
	<table id="request-table" class="bg-white text-sm">
		<thead class="font-semibold">
			<tr>
				<th>Request ID</th>
				<th class="text-orange-700">Student ID</th>
				<th>Date Requested</th>
				<th>Date Completed</th>
				<th>Requested Document</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			
			<?php
				foreach ($data['requests-data'] as $key => $row):
					$date_created = new DateTime($row->date_created);
					if(empty($row->date_created)) {
						$date_created = '---- -- --';
					} else {
						$date_created = $date_created->format('Y/m/d');
					}

					$date_completed = new DateTime($row->date_completed);
					if(empty($row->date_completed)) {
						$date_completed = '---- -- --';
					} else {
						$date_completed = $date_completed->format('Y/m/d');
					}

			?>
					<tr class="border-b border-slate-200">
						<td class="font-semibold"><?php echo $row->id; ?></td>
						<td class="font-semibold text-orange-700"><?php echo $row->student_id; ?></td>
						<td><?php echo $date_created; ?></td>
						<td><?php echo $date_completed; ?></td>
						<td class="flex gap-1 text-sm">
							<!--<ul class="text-sm list-disc italic">
								<?php if($row->is_tor_included): ?>
									<li>TOR (undergraduate)</li>
								<?php endif; ?>

								<?php if($row->is_gradeslip_included): ?>
									<li>Gradeslip</li>
								<?php endif; ?>

								<?php if($row->is_ctc_included): ?>
									<li>Certified True Copy</li>
								<?php endif; ?>

								<?php if($row->is_diploma_included): ?>
									<li>TOR / Diploma</li>
								<?php endif; ?>

								<?php if(!empty($row->other_requested_document)): ?>
									<li><?php echo ucwords($row->other_requested_document); ?></li>
								<?php endif; ?>
							</ul>-->

							<?php if($row->is_tor_included): ?>
									<div class="flex items-center justify-center w-8 h-8 rounded-full text-white bg-sky-900 text-center">tor</div>
								<?php endif; ?>

								<?php if($row->is_diploma_included): ?>
									<div class="flex items-center justify-center w-8 h-8 rounded-full text-white bg-sky-800 text-center">dlm</div>
								<?php endif; ?>

								<?php if($row->is_gradeslip_included): ?>
									<div class="flex items-center justify-center w-8 h-8 rounded-full text-white bg-sky-700 text-center">grs</div>
								<?php endif; ?>

								<?php if($row->is_ctc_included): ?>
									<div class="flex items-center justify-center w-8 h-8 rounded-full text-white bg-sky-600 text-center">ctc</div>
								<?php endif; ?>

								<?php if(!empty($row->other_requested_document)): ?>
									<div class="flex items-center justify-center w-8 h-8 rounded-full text-white bg-sky-500 text-center">oth</div>
								<?php endif; ?>

						</td>
						
						<?php if($row->status == 'pending'): ?>
							<td>
								<a class="bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">pending</a>
							</td>
						<?php endif; ?>

						<?php if($row->status == 'accepted'): ?>
							<td>
								<a class="bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">accepted</a>
							</td>
						<?php endif; ?>

						<?php if($row->status == 'rejected'): ?>
							<td>
								<a class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">rejected</a>
							</td>
						<?php endif; ?>

						<?php if($row->status == 'in process'): ?>
							<td>
								<a class="bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">in process</a>
							</td>
						<?php endif; ?>

						<?php if($row->status == 'for claiming'): ?>
							<td>
								<a class="bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">for claiming</a>
							</td>
						<?php endif; ?>

						<?php if($row->status == 'completed'): ?>
							<td>
								<a class="bg-green-100 text-green-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">completed</a>
							</td>
						<?php endif; ?>

						<!--<?php
							$pending = ''; $accepted = ''; $rejected = ''; $inprocess = ''; $forclaiming = ''; $completed = '';
							
							if($row->status == 'pending') $pending = 'selected';
							if($row->status == 'accepted') $accepted = 'selected';
							if($row->status == 'rejected') $rejected = 'selected';
							if($row->status == 'in process') $inprocess = 'selected';
							if($row->status == 'for claiming') $forclaiming = 'selected';
							if($row->status == 'completed') $completed = 'selected';

						?>

						<td>
							<select class="rounded-full text-sm px-5 text-sm py-1 border-0 outline-0 appearance-none">
								<option value="pending" <?php echo $pending; ?>>pending</option>
								<option value="accepted" <?php echo $accepted; ?>>accept</option>
								<option value="rejected" <?php echo $rejected; ?>>reject</option>
								<option value="in process" <?php echo $inprocess; ?>>in process</option>
								<option value="for claiming" <?php echo $forclaiming; ?>>for claiming</option>
								<option value="completed" <?php echo $completed; ?>>completed</option>
							</select>
						</td>-->
						
						<td class="text-center">
							<!--<?php //echo URLROOT.'/academic_document/show/'.$row->id ;?>-->
							<a class="view-btn" class="text-blue-700" href="#">view</a>
							<a class="text-red-700 drop-btn" href="<?php echo URLROOT.'/academic_document/drop/'.$row->id ;?>" >drop</a>
						</td>
						
					</tr>
			<?php
				endforeach;
			?>
		
		</tbody>
	</table>
</div>

<!-------------------------------------- view panel ---------------------------------->

<div id="view-panel" class="fixed z-30 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-9">
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
				<p class="text-2xl font-bold">Request #<span id="request-id"></span></p>
				<p class="text-sm text-slate-500">If the below information is not accurate, please contact an admin to address the problem.</p>
			</div>

			<div class="flex flex-col gap2 w-full mt-6">
				<table class="w-full table-fixed">
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Student ID</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2 font-semibold"><span id="student-id"></span></td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Status</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="status"></a></td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Document Requested</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="documents" ></span></td>
					</tr>
					
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Date Created</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="date-created" class=""></span></td>
					</tr>
					
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Date Completed</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="date-completed" class=""></span></td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Purpose</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2">
							<p id="purpose"></p>
						</td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">RA11261 Beneficiary</td>
						<td id="beneficiary" width="80" class="width-full hover:bg-slate-100 p-1 pl-2"></td>
					</tr>
				</table>	
			</div>

			<div class="flex flex-col gap2 w-full mt-2">
				<p class="pl-2 pt-2 pb-4 font-semibold">Additional Information</p>
				<table class="w-full table-fixed">
					
					<tr id="tor" class="border-t border-slate-200 hidden"> 
						<td class="text-slate-500 p-1 pl-2" width="30">
							<p class="text-sm text-slate-700">Transcipt Of Records</p>
							<p>Academic Year</p>
						</td>
						<td width="70" class="py-2 pl-2"><span id="academic-year"></span></td>
					</tr>
				
					<tr id="diploma" class="border-t border-slate-200 hidden">
						<td class="text-slate-500 py-2 pl-2" width="30">
							<p class="text-sm text-slate-700">Diploma</p>
							<p>Year Graduated</p>
						</td>
						<td width="70" class="py-2 pl-2"><span id="year-graduated" ></span></td>
					</tr>
					
					<tr id="gradeslip" class="border-t border-slate-200 hidden">
						<td class="text-slate-500 py-2 pl-2" width="30">
							<p class="text-sm text-slate-700">Gradeslip</p>
							<p>Year & Sem</p>
						</td>
						<td width="70" class="py-2 pl-2"><span id="year-sem" class=""></span></td>
					</tr>
					
					<tr id="ctc" class="border-t border-slate-200 hidden">
						<td class="text-slate-500 py-2 pl-2" width="30">
							<p class="text-sm text-slate-700">Certified True Copy</p>
							<p>Document</p>
						</td>
						<td width="70" class="p-1 pl-2"><a href="#" id="ctc-document" class="hover:underline"></a></td>
					</tr>

					<tr id="other" class="border-t border-slate-200 hidden">
						<td class="text-slate-500 p-1 pl-2" width="30">
							<p class="text-sm text-slate-700">Other Requested Doc</p>
							<p>Document</p>
						</td>
						<td width="70" class="p-1 pl-2"><span id="other-document" class=""></span></td>
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

<!-------------------------------------- update panel ---------------------------------->

<div id="update-panel" class="fixed z-35 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-9">
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
				<a id="request-id-btn" class="text-2xl cursor-pointer font-bold">Request #<span id="update-request-id"></span></a>
				<p class="text-sm text-slate-500">Update status and send a remarks for the request</p>
			</div>

			<div class="w-full">
				<form action="<?php echo URLROOT; ?>/academic_document/update" method="POST" class="w-full">
					<input name="request-id" type="hidden" value="" />
					<input name="student-id" type="hidden" value="" />

					<div class="flex flex-col mt-5">
						<div class="flex flex-col gap2 w-full">
							<p class="font-semibold">Status</p>
							<p class="text-sm text-slate-500">Update the progress of student's request</p>
						</div>
						<select name="status" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700">
							<option value="">Choose Option</option>
							<option value="pending">pending</option>
							<option value="accepted">accepted</option>
							<option value="rejected">rejected</option>
							<option value="in process">in process</option>
							<option value="for claiming">for claiming</option>
							<option value="completed">completed</option>
						</select>
					</div>

					<div class="flex flex-col mt-5">
						<div class="flex flex-col gap2 w-full">
							<p class="font-semibold">Remarks</p>
							<p class="text-sm text-slate-500"></p>
						</div>
						<textarea name="remarks" class="border rounded-sm border-slate-300 py-2 px-2 outline-1 outline-blue-400 mt-4 h-36" placeholder="Write a remarks..."></textarea>
					</div>

					<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Update Request"/>
						<p class="text-sm text-slate-500 mt-2">Upon submission, SMS and an Email will be sent to notify the student. </p>
				</form>

			</div>
		</div>
	</div>
</div>



<!-------------------------------------- script ---------------------------------->

<script>
	
	$(document).ready(function() {
		
		/**
	 	* onclick event of delete button, display confirmation message
		**/

		$('.drop-btn').click(function() {
			const result = confirm("Are you sure? You want to delete this.");
			if(!result) {
				return false;
			} 
			
		});

		/**
	 	* onclick event of action button, display action menu
		**/

		$('#action-dropdown-btn').click(function() {
			$('#action-card').toggleClass('show');
		}); 

		/**
	 	* onclick event of view button, display view panel
		**/

		$('.view-btn').click(function() {
			const id = $(this).closest('tr').find('td:first').text();
			requestAndSetupForViewPanel(id);
			$('#view-panel').removeClass('-right-full').toggleClass('right-0');
			$('#update-panel').removeClass('right-0').addClass('-right-full');
		}); 

		$('#request-id-btn').click(function() {
			const id = $('#update-request-id').text();
			requestAndSetupForViewPanel(id);
			$('#view-panel').removeClass('-right-full').toggleClass('right-0');
			$('#update-panel').removeClass('right-0').addClass('-right-full');
		
		});

		function requestAndSetupForViewPanel(id) {
			const details = getRequestDetails(id);
			
			details.done(function(result) {
				result = JSON.parse(result);
				setViewPanel(result);
			});

			details.fail(function(jqXHR, textStatus) {
				alert(textStatus);
			});
		}

		/**
	 	* onclick event of status button, display update panel
		**/

		$('.status-btn').click(function() {
			const id = $(this).closest('tr').find('td:first').text();
			requestAndSetupForUpdatePanel(id);
			$('#update-panel').removeClass('-right-full').toggleClass('right-0');
			$('#view-panel').removeClass('right-0').addClass('-right-full');
		}); 

		$('#status').click(function() {
			const id = $('#request-id').text();
			requestAndSetupForUpdatePanel(id)
			$('#update-panel').removeClass('-right-full').toggleClass('right-0');
			$('#view-panel').removeClass('right-0').addClass('-right-full');
		});

		function requestAndSetupForUpdatePanel(id) {
			const details = getRequestDetails(id);
			
			details.done(function(result) {
				result = JSON.parse(result);
				setUpdatePanel(result);
			});

			details.fail(function(jqXHR, textStatus) {
				alert(textStatus);
			});
		}

		/**
	 	* onclick event of view exit button, hide view panel
		**/


		$('#view-exit-btn').click(function() {
			$('#view-panel').removeClass('right-0').toggleClass('-right-full');
		}); 

		/**
	 	* onclick event of view exit button, hide view panel
		**/


		$('#update-exit-btn').click(function() {
			$('#update-panel').removeClass('right-0').toggleClass('-right-full');
		}); 

		function getRequestDetails(id) {
			return $.ajax({
			    url: "/qcu-ocad/academic_document/details",
			    type: "POST",
			    data: {
			        id: id
			    }
			});
		}

		function setUpdatePanel(details) {
			$('#update-request-id').text(details.id);
			$('select[name="status"]').val(details.status);
			$('textarea[name="remarks"]').val(details.remarks);
			$('input[name="request-id"]').val(details.id);
			$('input[name="student-id"]').val(details.student_id);
		}

		function setViewPanel(details) {
			setViewID(details.id);
			setViewStudentID(details.student_id);
			setViewStatusProps(details.status);
			setViewDocumentRequestedProps(details);
			setViewDateCreated(details.date_created);
			setViewDateCompleted(details.date_completed);
			setViewPurposeOfRequest(details.purpose_of_request);
			setViewBeneficiary(details);
			setViewAdditionalInformation(details);
			setViewRemarks(details.remarks);

		}

		function setViewID(id) {
			$('#request-id').text(id);
		}

		function setViewStudentID(id) {
			$('#student-id').text(id);
		}

		function setViewStatusProps(status) {
			switch(status) {
				case 'pending':
					$('#status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 cursor-pointer text-sm py-1');
					break;
				case 'accepted':
					$('#status').removeClass().addClass('bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1 cursor-pointer');
					break;
				case 'rejected':
					$('#status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 cursor-pointer');
					break;
				case 'in process':
					$('#status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1 cursor-pointer');
					break;
				case 'accepted':
					$('#for claiming').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1 cursor-pointer');
					break;
				default:
					$('#status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1 cursor-pointer');
			}

			$('#status').text(status);			
		}

		function setViewDocumentRequestedProps(details) {
			let documents = []

			if(details.is_tor_included) documents.push('TOR (undergraduate)');
			if(details.is_diploma_included) documents.push('Diploma');
			if(details.is_gradeslip_included) documents.push('Gradeslip');
			if(details.is_ctc_included) documents.push('Certified True Copy');		
			if(details.other_requested_document != null) documents.push(details.other_requested_document);

			$('#documents').text(documents.join(' & '));

		}

		function setViewDateCreated(dt) {
			if(dt != null) $('#date-created').text(formatDate(dt));
			else $('#date-created').text('-- -- ----');
		}

		function setViewDateCompleted(dt) {
			if(dt != null) $('#date-completed').text(formatDate(dt));
			else $('#date-completed').text('-- -- ----');
		}

		function setViewPurposeOfRequest(purpose) {
			$('#purpose').text(purpose);
		}

		function setViewBeneficiary(details) {
			if(details.is_RA11261_beneficiary) {
				$('#beneficiary').html(`<a class="text-sky-700" href="<?php echo URLROOT;?>${details.barangay_certificate}">Barangay Certificate</a> & <a class="text-sky-700" href="<?php echo URLROOT;?>${details.oath_of_undertaking}">Oath Of Undertaking</a>`);
			} else {
				$('#beneficiary').html('<p class="text-slate-700">No</p>');
				
			}
		}

		function setViewAdditionalInformation(details) {
			$('#tor').addClass('hidden');
			$('#diploma').addClass('hidden');
			$('#gradeslip').addClass('hidden');
			$('#ctc').addClass('hidden');
			$('#other').addClass('hidden');
			
			if(details.is_tor_included) {
				$('#tor').removeClass('hidden');
				$('#academic-year').text(details.tor_last_academic_year_attended);
			} 

			if(details.is_diploma_included) {
				$('#diploma').removeClass('hidden');
				$('#year-graduated').text(details.diploma_year_graduated);
			} 

			if(details.is_gradeslip_included) {
				const year = details.gradeslip_academic_year;
				const sem = formatUnivSemester(details.gradeslip_semester);

				$('#gradeslip').removeClass('hidden');
				$('#year-sem').text(`S.Y ${year} / ${sem} Sem`);
			} 

			if(details.is_ctc_included) {
				$('#ctc').removeClass('hidden');
				$('#ctc-document').attr('href', `<?php echo URLROOT;?>${details.ctc_document}`);
				$('#ctc-document').text(getFilenameFromPath(details.ctc_document));
			} 
			 
			if(details.other_requested_document != null) {
				$('#other').removeClass('hidden');
				$('#other-document').text(details.other_requested_document);
			}
		}

		function setViewRemarks(remarks) {
			if(remarks != null) {
				$('#remarks').text(remarks);
			} else {
				$('#remarks').text('...');
			}
		}

		function formatUnivSemester(sem) {
			if(sem == 1) return `${sem}st`;
			return `${sem}nd`;
		}

		function getFilenameFromPath(path) {
			path = path.split('/');
			return path[path.length-1];
		}

		function formatDate(dt) {
			const date = new Date(dt);
			let hours = date.getHours();
			let minutes = date.getMinutes();
			let ampm = hours >= 12 ? 'pm' : 'am';
			hours = hours % 12;
			hours = hours ? hours : 12; // the hour '0' should be '12'
			minutes = minutes < 10 ? '0'+minutes : minutes;
			let strTime = hours + ':' + minutes + ' ' + ampm;
			return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
		}
	});

</script>

<script src="<?php echo URLROOT;?>/public/script/data.tables.js"></script>


