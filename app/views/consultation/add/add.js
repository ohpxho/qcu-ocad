$(document).ready(function() {
	const ID = <?php echo json_encode($_SESSION['id']) ?>;

	tinymce.init({
	    selector: 'textarea[name="problem"]',
	    plugins: [
	     'lists'
	    ],
	    toolbar: 'bullist numlist outdent indent',
	    menubar: false
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
  		}

  		$('select[name="subject"]').val('');
  		$('select[name="adviser-id"]').val('');
  	});

  	function setSubjectCode(dep) {
  		const code = getSubjectCodes(dep);

  		code.done(function(result) {
  			result = JSON.parse(result);
  			//alert(result);
  			updateSubjectCodeOptions(result);
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
			}
		});
  	}

  	function getProfessors(dep) {
  		return $.ajax({
			url: '/qcu-ocad/consultation/get_professors_by_department',
		    type: 'POST',
			data: {
				department: dep
			}
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
  		const advisor = getAdvisor();

  		const acceptance = getConsultationAcceptanceByAdvisor(advisor);

		acceptance.done(function(result) {
			const consultation = JSON.parse(result);
			
			const sched = getSchedule(id);

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
	  				setTimeslotOfDay(slot, date);
	  			}
				
  			} else {
  				for(slot of schedule_timeslots) {
  					setTimeslotOfDay(slot, date);
	  			}
  			}

  			checkExistingSchedules(date);

  		});

  		sched.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
	}

	function setTimeslotOfDay(slot, date) {
		const time = convertTimeStringToObject(slot);
		const now = new Date();
		const dateInFocus = new Date(date);	
		
		if(formatDateToLongDate(dateInFocus) == formatDateToLongDate(now)) {
			if(time > now) {
				$(`.timeslot-btn[data-time="${slot}"]`).attr('data-enabled', true);
				$(`.timeslot-btn[data-time="${slot}"]`).attr('disabled', false);
				$(`.timeslot-btn div[data-time="${slot}"]`).removeClass('bg-slate-200 opacity-50 cursor-not-allowed');
				$(`.timeslot-btn div[data-time="${slot}"]`).addClass('text-white bg-blue-400');
			} else {	  					
				$(`.timeslot-btn div[data-time="${slot}"]`).removeClass('bg-slate-200');
				$(`.timeslot-btn div[data-time="${slot}"]`).addClass('text-white bg-blue-400');
			}
		} else {
			$(`.timeslot-btn[data-time="${slot}"]`).attr('data-enabled', true);
			$(`.timeslot-btn[data-time="${slot}"]`).attr('disabled', false);
			$(`.timeslot-btn div[data-time="${slot}"]`).removeClass('bg-slate-200 opacity-50 cursor-not-allowed');
			$(`.timeslot-btn div[data-time="${slot}"]`).addClass('text-white bg-blue-400');
		}
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

				if(consultation.schedule == date && consultation.creator == ID) {
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
});