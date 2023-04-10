$(document).ready(function() {
	let details = {};

	tinymce.init({
	    selector: 'textarea[name="problem"]',
	    plugins: [
	      'lists'
	    ],
	    toolbar: 'bullist numlist checklist outdent indent',
	    menubar: false
  	});

	$(window).load(function() {
		details = <?php echo json_encode($details); ?>;
		init(details);
	});

	$('select[name="purpose"]').change(function() {
		if($(this).val() == 7 || $(this).val() == 8) {
			$('input[name="department"]').val('Guidance').change();
		} else if($(this).val() == 9) {
			$('input[name="department"]').val('Clinic').change();
		} else {
			const student = getStudentDetails(ID);

			student.done(function(result) {
				result = JSON.parse(result);
				const course = result.course.toLowerCase();

				switch(course) {
					case 'bsit':
						$('input[name="department"]').val('College of Computer Science and Information Technology').change();
						break;
					case 'bsent': 
					case 'bsa':
						$('input[name="department"]').val('College of Business and Accountancy').change();
						break;
					case 'bsie':
					case 'bsece':
						$('input[name="department"]').val('College of Engineering').change();
						break;
					default:
						$('input[name="department"]').val('College of Education').change();
				}

			});

			student.fail(function(jqXHR, textStatus) {
				alert(textStatus);
			});
		}
	});

  	$('input[name="department"]').change(function() {
  		const selected = $('input[name="department"]').val();
  		
  		resetAndHideAppoinmentPanel();

  		if(selected != 'Guidance' && selected != 'Clinic' && selected != '') {
  			setSubjectCode(selected);
  			setProfessor(selected);
  			$('#subject-adviser-input-holder').removeClass('hidden');
  		} else {
  			$('#subject-adviser-input-holder').addClass('hidden');
  			const advisor = getAdvisor();

  			const acceptance = getConsultationAcceptanceByAdvisor(advisor);

  			acceptance.done(function(result) {
  				const consultation = JSON.parse(result);

  				const sched = getSchedule(advisor);

		  		sched.done(function(result) {
		  			result = JSON.parse(result);

		  			if(consultation.status == 'open') {
		  				initializeCalendar('calendar');
		  				setAvailableSchedule(result);
		  				$('#appointment-panel').removeClass('hidden');
		  			} else {
		  				$('#appointment-err').removeClass('hidden');
		  				$('#appointment-err > p').text('Not accepting consultation at this time');
		  			}
		  		});

		  		sched.fail(function(jqXHR, textStatus) {
		  			alert(textStatus);
		  		});
  			});

  			acceptance.fail(function(jqXHR, textStatus) {
  				alert(textStatus);
  			});

	  		$('select[name="subject"]').val('');
	  		$('select[name="adviser-id"]').val('');
  		}
  	});

  	$('#shared-doc-list').on('click', '.remove-document-btn', function() {
		const filename = $(this).prev().find('.file-name').text();
		const existing = removeExistingDoc(filename, details.shared_file_from_student);
		$('input[name="existing-documents"]').val(existing);
		setSharedDoc(existing);
	});

  	function setSubjectCode(dep) {
  		const code = getSubjectCodes(dep);

  		code.done(function(result) {
  			result = JSON.parse(result);
  			//alert(result);
  			updateSubjectCodeOptions(result);
  			setSubject(details.subject);
  		});

  		code.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
  	}	

  	function setProfessor(dep) {
  		const code = getProfessors(dep);

  		code.done(function(result) {
  			result = JSON.parse(result);
  			//alert(result);
  			updateProfessorOptions(result);
  			setAdviser(details.adviser_id);
  		});

  		code.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
  	}	

  	function getSubjectCodes(dep) {
  		return $.ajax({
			url: '/qcu-ocad/consultation/get_subject_codes_by_department',
		    type: 'POST',
			data: {
				department: dep
			},
			async: false
		});
  	}

  	function getProfessors(dep) {
  		return $.ajax({
			url: '/qcu-ocad/consultation/get_professors_by_department',
		    type: 'POST',
			data: {
				department: dep
			},
			async: false
		});
  	}

  	function updateSubjectCodeOptions(codes) {
  		$('select[name="subject"]').empty();
  		$('select[name="subject"]').append(`<option value="">Choose Option</option>`);	
  		$.each(codes, function(index, item) {
  			$('select[name="subject"]').append(`<option value="${item.code}">${item.code}</option>`);	
  		});
  	}

  	function updateProfessorOptions(codes) {
  		$('select[name="adviser-id"]').empty();
  		$('select[name="adviser-id"]').append(`<option value="">Choose Option</option>`);	
  		$.each(codes, function(index, item) {
  			$('select[name="adviser-id"]').append(`<option value="${item.id}">${item.fname} ${item.lname}</option>`);	
  		});
  	}

  	$('select[name="adviser-id"]').change(function() {
  		const id = $(this).val();

  		const sched = getSchedule(id);

  		sched.done(function(result) {
  			result = JSON.parse(result);
  			initializeCalendar('calendar');
  			setAvailableSchedule(result);
  			$('#appointment-panel').removeClass('hidden');
  		});

  		sched.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
  	});

  	function setAvailableSchedule(timeslots) {
  		const advisor = getAdvisor();
  		const availability = getAllAvailability(advisor);

  		availability.done(function(result) {
  			result = JSON.parse(result);
	  		let date = new Date();
	  		let dateString = getDateString(date.getFullYear(), date.getMonth()+1, date.getDate());
	  		let day = date.toLocaleString('en-us', { weekday: 'long' }).toLowerCase();

  			for(let i = 0; i < 14; i++) {
				const avail = {
					'availability': result,
					'date': dateString
				};

				const sched = {
					timeslots,
					day
				};

				if(isDayAvailable(avail, sched)) {

					$(`#calendar div[data-date="${dateString}"] button`).removeClass('bg-slate-400 opacity-50 cursor-not-allowed');
			  		$(`#calendar div[data-date="${dateString}"] button`).addClass('bg-blue-400 text-white');
			  		$(`#calendar div[data-date="${dateString}"] button`).attr('disabled', false);
				}
  			
	  			newdate = new Date(date);
				newdate.setDate(date.getDate()+1);
		  		
		  		date = newdate;
		  		dateString = getDateString(date.getFullYear(), date.getMonth()+1, date.getDate());
		  		day = date.toLocaleString('en-us', { weekday: 'long' }).toLowerCase();	
  			}

  			$(`#calendar div[data-date="${details.schedule}"] button`).click();
  		});

  		availability.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
  	}

  	function isDayAvailable(avail, sched) {

  		for(row of avail.availability) {
  			if(row.date == avail.date) return true;
  		}

  		switch(sched.day) {
			case 'monday':
				return (sched.timeslots.monday==null || sched.timeslots.monday=='')? false : true;
			case 'tuesday':
				return (sched.timeslots.tuesday==null || sched.timeslots.tuesday=='')? false : true;
			case 'wednesday':
				return (sched.timeslots.wednesday==null || sched.timeslots.wednesday=='')? false : true;
			case 'thursday':
				return (sched.timeslots.thursday==null || sched.timeslots.thursday=='')? false : true;
			case 'friday':
				return (sched.timeslots.friday==null || sched.timeslots.friday=='')? false : true;
			case 'saturday':
				return (sched.timeslots.saturday==null || sched.timeslots.saturday=='')? false : true;
			default: 
				return (sched.timeslots.sunday==null || sched.timeslots.sunday=='')? false : true;
		}
  	}

  	function getTimeslotByDay(timeslots, day) {
		switch(day) {
			case 'monday':
				return (timeslots.monday==null || timeslots.monday=='')? [] : timeslots.monday.split(',');
			case 'tuesday':
				return (timeslots.tuesday==null || timeslots.tuesday=='')? [] : timeslots.tuesday.split(',');
			case 'wednesday':
				return (timeslots.wednesday==null || timeslots.wednesday=='')? [] : timeslots.wednesday.split(',');
			case 'thursday':
				return (timeslots.thursday==null || timeslots.thursday=='')? [] : timeslots.thursday.split(',');
			case 'friday':
				return (timeslots.friday==null || timeslots.friday=='')? [] : timeslots.friday.split(',');
			case 'saturday':
				return (timeslots.saturday==null || timeslots.saturday=='')? [] : timeslots.saturday.split(',');
			default: 
				return (timeslots.sunday==null || timeslots.sunday=='')? [] : timeslots.sunday.split(',');
		}
	}

	$(document).on('click', '.calendar-dt-button', function(e) {
		e.preventDefault();

		$('.calendar-dt-button').each(function() {
			if($(this).prop('disabled') == false) {
				$(this).removeClass('bg-blue-700');
  				$(this).addClass('bg-blue-400');
			}
		});

		$('#timeslots').removeClass('hidden');
		$(this).removeClass('bg-blue-400');
  		$(this).addClass('bg-blue-700');

  		const day = $(this).data('day');
  		const date = $(this).data('date');
  		const advisor = getAdvisor();

  		$('input[name="schedule"]').val(date);
  		$('input[name="start-time"]').val('');

  		const availability = getAvailability(advisor, date);

  		availability.done(function(result) {
  			result = JSON.parse(result);

  			const details = {day, date, advisor, 'availability': result};
  			setSchedule(details);
  		});

  		availability.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});

		return false;
	});

	function setSchedule(details) {
		const day = details.day;
  		const date = details.date;
  		const advisor = details.advisor;
  		const availability = details.availability;

  		availability_timeslots = (availability.timeslots == null || availability.timeslots == '')? [] : availability.timeslots.split(',');

  		const sched = getSchedule(advisor);

		sched.done(function(result) {
  			result = JSON.parse(result);
  			const schedule_timeslots = (result[day]==null || result[day]=='')? [] : result[day].split(',');

  			//reset timeslot buttons
  			$('.timeslot-btn').each(function() {
  				$(this).attr('data-enabled', false);
  				$(this).attr('disabled', true);
				$(this).children().addClass('bg-slate-200 cursor-not-allowed opacity-50');
				$(this).children().removeClass('text-white bg-blue-700 bg-blue-400');
  			});

  			if(availability.id != null && availability != '') {
	  			for(slot of availability_timeslots) {
	  				$('input[name="timeslots"]').val(availability_timeslots.join(','));

	  				const time = convertTimeStringToObject(slot);
  					const now = new Date();

  					if(time > now) {
		  				$(`.timeslot-btn[data-time="${slot}"]`).attr('data-enabled', true);
		  				$(`.timeslot-btn[data-time="${slot}"]`).attr('disabled', false);
						$(`.timeslot-btn div[data-time="${slot}"]`).removeClass('bg-slate-200 opacity-50 cursor-not-allowed');
						$(`.timeslot-btn div[data-time="${slot}"]`).addClass('text-white bg-blue-400');
	  				} else {
	  					$(`.timeslot-btn div[data-time="${slot}"]`).removeClass('bg-slate-200');
						$(`.timeslot-btn div[data-time="${slot}"]`).addClass('text-white bg-blue-400');
	  				}
	  			}
  			} else {
  				for(slot of schedule_timeslots) {
  					$('input[name="timeslots"]').val(schedule_timeslots.join(','));

	  				const time = convertTimeStringToObject(slot);
  					const now = new Date();

  					if(time > now) {
		  				$(`.timeslot-btn[data-time="${slot}"]`).attr('data-enabled', true);
		  				$(`.timeslot-btn[data-time="${slot}"]`).attr('disabled', false);
						$(`.timeslot-btn div[data-time="${slot}"]`).removeClass('bg-slate-200 opacity-50 cursor-not-allowed');
						$(`.timeslot-btn div[data-time="${slot}"]`).addClass('text-white bg-blue-400');
	  				} else {
	  					$(`.timeslot-btn div[data-time="${slot}"]`).removeClass('bg-slate-200');
						$(`.timeslot-btn div[data-time="${slot}"]`).addClass('text-white bg-blue-400');
	  				}
	  			}
  			}

  			checkExistingSchedules(date);

  		});

  		sched.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
	}

	$('.timeslot-btn').click(function(e) {
		e.preventDefault();
		
		if($(this).data('enabled') == true) {
			$('.timeslot-btn[data-enabled="true"] div').removeClass('bg-blue-700').addClass('bg-blue-400');
			$(this).children().removeClass('bg-blue-400').addClass('bg-blue-700');

			$('input[name="start-time"]').val($(this).data('time'));
		}

		return false;
	});

	function checkExistingSchedules(date) {
		const advisor = getAdvisor();
		const sched = getAllActiveConsultationOfAdvisor(advisor);	

		$('#appointment-err').addClass('hidden');
						
		sched.done(function(result) {
			result = JSON.parse(result);

			for(consultation of result) {

				if(consultation.schedule == date && consultation.creator == ID && consultation.id !== details.id) {
					$('#timeslots').addClass('hidden');
					$('#appointment-err').removeClass('hidden');
					$('#appointment-err > p').text('You already made an appointment at this date.');
					return false;
				}

				if(consultation.schedule == date && consultation.creator != ID) {
					$(`.timeslot-btn div[data-time="${consultation.start_time}"`).removeClass('bg-blue-400').addClass('bg-orange-500 cursor-not-allowed');
					$(`.timeslot-btn[data-time="${consultation.start_time}"]`).prop('disabled', true);
					$(`.timeslot-btn[data-time="${consultation.start_time}"]`).attr('data-enabled', false);
				}
			}

			if(date == details.schedule) $(`.timeslot-btn[data-time="${details.start_time}"]`).click();
		});

		sched.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	}

	function resetAndHideAppoinmentPanel() {
		$('input[name="schedule"]').val('');
		$('input[name="start-time"]').val('');

		$('#calendar').html('');

		//reset timeslot buttons
		$('.timeslot-btn').attr('data-enabled', false);
		$('.timeslot-btn').attr('disabled', true);
		$('.timeslot-btn').children().addClass('bg-slate-200 cursor-not-allowed opacity-50');
		$('.timeslot-btn').children().removeClass('text-white bg-blue-700 bg-blue-400');
	
		$('#appointment-panel').addClass('hidden');
		$('#appointment-err').addClass('hidden');
		$('#timeslots').addClass('hidden');
	}

	function getAdvisor() {
		const prof = $('select[name="adviser-id"]').val();
		const dep = $('input[name="department"]').val();

		if(dep == 'Guidance') return 'guidance';

		if(dep == 'Clinic') return 'clinic';
		
		if(prof != '') return prof;
	}

	function init(details) {
		setRequestID(details.id);
		setPurpose(details.purpose);
		setProblem(details.problem);
		setSubject(details.subject);
		setAdviser(details.adviser_id);
		setScheduleForMeeting(details.schedule, details.time);
		setSharedDoc(details.shared_file_from_student);
		setExistingDoc(details.shared_file_from_student);
	}

	function setRequestID(id) {
		$('input[name="request-id"]').val(id);
	}

	function setPurpose(purpose) {
		$('select[name="purpose"] option').each(function() {
			if($(this).val() == purpose) $(this).prop('selected', true).change();
		});
	}

	function setProblem(problem) {
		problem = problem.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
		setTimeout(function() {
		  tinymce.activeEditor.setContent(problem);
		}, 100);
	}

	function setSubject(code) {
		$('select[name="subject"] option').each(function() {
			if($(this).val() == code) $(this).prop('selected', true);
		});
	}

	function setAdviser(adviser) {
		$('select[name="adviser-id"] option').each(function() {
			if($(this).val() == adviser) $(this).prop('selected', true).change();
		});
	}

	function setSharedDoc(documents) {
		$('#shared-doc-list').empty()
		
		if(documents == null || documents.length == 0 ) {
			$('#shared-doc').text('No shared documents');
		} else {
			const docs = documents.split(',');
			$('#shared-doc').text(`${docs.length} document/s`);
			$.each(docs, function(index, item) {
				const icon = getIconOfFileExtension(getFileExtension(item));
				$('#shared-doc-list').append(
					`<div class="flex items-center w-full group">
						<a class="w-full" target="_blank" href="<?php echo URLROOT; ?>${item}" >
							<li class="filename-li hover:bg-slate-100 p-1 flex gap-2 items-center border-b w-full">
								<img class="h-7 w-7" src="<?php echo URLROOT?>/public/assets/img/${icon}"/>
								<span class="file-name">${getFilenameFromPath(item)}</span>
							</li>
							<a class="remove-document-btn absolute z-30 cursor-pointer text-red-500 right-0 px-3 group-hover:flex">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
								  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
								</svg>
							</a>
						</a>
					</div>`);
			});
		}
	}

	function setScheduleForMeeting(dt, tm) {
		$('input[name="schedule"]').val(dt);
		$('input[name="start-time"]').val(tm);
		//missing 
	}

	function setExistingDoc(documents) {
		$('input[name="existing-documents"]').val(documents);
	}

	function removeExistingDoc(doc) {
		let existing = $('input[name="existing-documents"]').val();
		existing = existing.split(',');
		
		$.each(existing, function(index, item) {
			const filename = getFilenameFromPath(item);

			if(filename == doc) {
				existing.splice(index, 1);
				return false;	
			}
		});

		return existing.join(',');
	}
});