$(document).ready(function() {
	const ID = <?php echo json_encode($_SESSION['id']) ?>;
	const schedules = <?php echo json_encode($data['schedule']) ?>;

	$(window).load(function() {
		console.log(schedules);
		init(schedules);
	});	

	function init(sched) {
		const monday = sched.filter(obj => obj.day == 'monday');
		setMondayTimeslots(monday);

		const tuesday = sched.filter(obj => obj.day == 'tuesday');
		setTuesdayTimeslots(tuesday);

		const wednesday = sched.filter(obj => obj.day == 'wednesday');
		setWednesdayTimeslots(wednesday);

		const thursday = sched.filter(obj => obj.day == 'thursday');
		setThursdayTimeslots(thursday);

		const friday = sched.filter(obj => obj.day == 'friday');
		setFridayTimeslots(friday);

		const saturday = sched.filter(obj => obj.day == 'saturday');
		setSaturdayTimeslots(saturday);

		const sunday = sched.filter(obj => obj.day == 'sunday');
		setSundayTimeslots(sunday);
	}

	function setMondayTimeslots(timeslots) {
		$('#mon-timeslot-list').html('');

		for(slot of timeslots) {
			$('#mon-timeslot-list').append(`<li id="${slot.id}">${formatTime(slot.start)} - ${formatTime(slot.end)}</li>`);
		}
	}

	function setTuesdayTimeslots(timeslots) {
		$('#tue-timeslot-list').html('');

		for(slot of timeslots) {
			$('#tue-timeslot-list').append(`<li id="${slot.id}">${formatTime(slot.start)} - ${formatTime(slot.end)}</li>`);
		}

	}

	function setWednesdayTimeslots(timeslots) {
		$('#wed-timeslot-list').html('');

		for(slot of timeslots) {
			$('#wed-timeslot-list').append(`<li id="${slot.id}">${formatTime(slot.start)} - ${formatTime(slot.end)}</li>`);
		}
	}

	function setThursdayTimeslots(timeslots) {
		$('#thu-timeslot-list').html('');

		for(slot of timeslots) {
			$('#thu-timeslot-list').append(`<li id="${slot.id}">${formatTime(slot.start)} - ${formatTime(slot.end)}</li>`);
		}
	}

	function setFridayTimeslots(timeslots) {
		$('#fri-timeslot-list').html('');

		for(slot of timeslots) {
			$('#fri-timeslot-list').append(`<li id="${slot.id}">${formatTime(slot.start)} - ${formatTime(slot.end)}</li>`);
		}
	}

	function setSaturdayTimeslots(timeslots) {
		$('#sat-timeslot-list').html('');

		for(slot of timeslots) {
			$('#sat-timeslot-list').append(`<li id="${slot.id}">${formatTime(slot.start)} - ${formatTime(slot.end)}</li>`);
		}
	}

	function setSundayTimeslots(timeslots) {
		$('#sun-timeslot-list').html('');

		for(slot of timeslots) {
			$('#sun-timeslot-list').append(`<li id="${slot.id}">${formatTime(slot.start)} - ${formatTime(slot.end)}</li>`);
		}
	}

	$('.days').change(function(schedule) {
		const day = $(this).val();
		
		if(this.checked) {
			$(`#${day}-label`).addClass('text-blue-700');
		} else {
			$(`#${day}-label`).removeClass('text-blue-700');
		}
	});

	$('#mon-insert').click(function() {
		const timeslots = schedules.filter(obj => obj.day == 'monday');	
		const day = $(this).data('day');
		
		if(timeslots.length > 0) {
			for(slot of timeslots) {
				$('#insert-timeslot-list').append(`<li>${formatTime(slot.start)} - ${formatTime(slot.end)}</li>`);	
			}
		}

		$('#insert-panel input[name="day"]').val(day);
		$('#insert-panel').removeClass('hidden');
	});

	$('#insert-btn').click(function() {
		const to = $('input[name="to"]').val();
		const from = $('input[name="from"]').val();
		const day = $('input[name="day"]').val();

		const validate = validateTimeslotInputs(to, from, day);
		
		if(validate) {

			const details = {
				'advisor': ID,
				'day': day,
				'start': from,
				'end': to
			};

			const add = addTimeslot(details);
			
			add.done(function(result) {
				alert(result);
				result = JSON.parse(result);
				alert(result);
				$('input[name="to"]').val('');
				$('input[name="from"]').val('');
				refresh(day);
			});

			add.fail(function(jqXHR, textStatus) {
				alert(textStatus);
			});
		}

	});

	function validateTimeslotInputs(to, from, day) {
		if(to=='' || from=='') {
			$('#insert-error').text('All inputs are required');
			return false;
		}

		if(from > to) {
			$('#insert-error').text('Invalid range');
			return false;
		}
		
		const ovarlaps = checkIfTimeOverlaps(to, from, day);

		if(ovarlaps) {
			$('#insert-error').text('Invalid. Time range overlaps other timeslots');
			return false;
		}

		return true;
	}

	function checkIfTimeOverlaps(to, from, day) {
		let timeslots = [];

		switch(day) {
			case 'monday':
				timeslots = schedules.filter(obj => obj.day == 'monday');
				break;
			case 'tuesday':
				timeslots = schedules.filter(obj => obj.day == 'tuesday');
				break;
			case 'wednesday':
			 	timeslots = schedules.filter(obj => obj.day == 'wednesday');
			 	break;
			case 'thursday':
				timeslots = schedules.filter(obj => obj.day == 'thursday');
				break;
			case 'friday':
				timeslots = schedules.filter(obj => obj.day == 'friday');
				break;
			case 'saturday':
				timeslots = schedules.filter(obj => obj.day == 'saturday');
				break;
			default:
				timeslots = schedules.filter(obj => obj.day == 'sunday');
		} 

		for(slot of timeslots) {
			const start = slot.start;
			const end = slot.end;

			const [hours_0, minutes_0] = start.split(":");
			const timestamp_0 = new Date(0, 0, 0, hours_0, minutes_0);

			const [hours_to, minutes_to] = to.split(":");
			const timestamp_to = new Date(0, 0, 0, hours_to, minutes_to);

			const [hours_1, minutes_1] = end.split(":");
			const timestamp_1 = new Date(0, 0, 0, hours_1, minutes_1);

			const [hours_from, minutes_from] = from.split(":");
			const timestamp_from = new Date(0, 0, 0, hours_from, minutes_from);
			

			if(timestamp_from >= timestamp_0 && timestamp_from <= timestamp_1) return true;

			if(timestamp_to >= timestamp_0 && timestamp_to <= timestamp_1) return true;

			if(timestamp_0 >= timestamp_from && timestamp_0 <= timestamp_to) return true;

			if(timestamp_1 >= timestamp_from && timestamp_1 <= timestamp_to) return true;

		
		}

		return false;
	}

	function refresh(day) {
		const sched = getSchedule(ID);

		sched.done(function(result) {
			alert(result);
			result = JSON.parse(result);

			if(Array.isArray(result)) {
				schedules = result;
				init(schedules);

				const timeslots = schedules.filter(obj => obj.day == day);	

				if(timeslots.length > 0) {
					for(slot of timeslots) {
						$('#insert-timeslot-list').append(`<li>${formatTime(slot.start)} - ${formatTime(slot.end)}</li>`);	
					}
				}
			} else {
				alert('Some error occured while fetching updated data');
			}
		});

		sched.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	}

	function formatTime(time) {
		const [hours, minutes] = time.split(':');
		const date = new Date();
		date.setHours(hours);
		date.setMinutes(minutes);
		
		const options = { hour: 'numeric', minute: 'numeric' };
 		const formattedTime = date.toLocaleString('en-US', options);
  		return formattedTime
	}
});
