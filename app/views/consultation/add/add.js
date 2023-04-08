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


  	$('select[name="department"]').change(function() {
  		const selected = $('select[name="department"] option:selected').val();
  		
  		if(selected != 'Guidance' && selected != 'Clinic' && selected != '') {
  			setSubjectCode(selected);
  			setProfessor(selected);
  			$('#subject-adviser-input-holder').removeClass('hidden');
  		} else {
  			$('#subject-adviser-input-holder').addClass('hidden');
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

  		const sched = getSchedule(id);

  		sched.done(function(result) {
  			result = JSON.parse(result);
  			initializeCalendar('calendar');
  			setAvailableSchedule(result);
  			$('#calendar').removeClass('hidden');
  		});

  		sched.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
  	});

  	function setAvailableSchedule(timeslots) {
  		let date = new Date();
  		let dateString = getDateString(date.getFullYear(), date.getMonth()+1, date.getDate());
  		let day = date.toLocaleString('en-us', { weekday: 'long' }).toLowerCase();

  		for(let i = 0; i < 14; i++) {
			if(isDayAvailable(timeslots, day)) {
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
  	}

  	function isDayAvailable(timeslots, day) {
  		switch(day) {
			case 'monday':
				return (timeslots.monday==null || timeslots.monday=='')? false : true;
			case 'tuesday':
				return (timeslots.tuesday==null || timeslots.tuesday=='')? false : true;
			case 'wednesday':
				return (timeslots.wednesday==null || timeslots.wednesday=='')? false : true;
			case 'thursday':
				return (timeslots.thursday==null || timeslots.thursday=='')? false : true;
			case 'friday':
				return (timeslots.friday==null || timeslots.friday=='')? false : true;
			case 'saturday':
				return (timeslots.saturday==null || timeslots.saturday=='')? false : true;
			default: 
				return (timeslots.sunday==null || timeslots.sunday=='')? false : true;
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
  		const sched = getSchedule(advisor);

  		$('input[name="schedule"]').val(date);
  		$('input[name="start-time"]').val('');

  		sched.done(function(result) {
  			result = JSON.parse(result);
  			const timeslots = (result[day]==null || result[day]=='')? [] : result[day].split(',');

  			//reset timeslot buttons
  			$('.timeslot-btn').each(function() {
  				$(this).children().addClass('opacity-50 cursor-not-allowed bg-slate-200');
  				$(this).children().removeClass('text-white bg-blue-400 bg-blue-700 bg-orange-500');
  				$(this).attr('data-enabled', false);
  				$(this).prop('disabled', true);
  			});

  			for(slot of timeslots) {
  				$(`.timeslot-btn div[data-time="${slot}"]`).removeClass('opacity-50 cursor-not-allowed bg-slate-200');
  				$(`.timeslot-btn div[data-time="${slot}"`).addClass('text-white bg-blue-400');
  				$(`.timeslot-btn[data-time="${slot}"]`).attr('data-enabled', true);
  				$(`.timeslot-btn[data-time="${slot}"]`).prop('disabled', false);
  			}

  			checkExistingSchedules(date);
  		});

  		sched.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});

		return false;
	});

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

	function getAdvisor() {
		const prof = $('select[name="adviser-id"]').val();
		const dep = $('select[name="department"]').val();

		if(prof != '') return prof;

		if(dep == 'Guidance') return 'guidance';

		if(dep == 'Clinic') return 'clinic';
	}
});