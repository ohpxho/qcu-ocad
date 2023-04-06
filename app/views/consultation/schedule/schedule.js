$(document).ready(function() {
	const ID = <?php echo json_encode($_SESSION['id']) ?>;
	const schedules = <?php echo json_encode($data['schedule']) ?>;

	$(window).load(function() {
		init(schedules);
		initializeCalendar('calendar');
	});

	function init(timeslots) {
		$('input[name="day-radio"]').each(function() {
			const day = $(this).attr('id');
			
			if(this.checked) {
				$(`#${day}-li`).addClass('text-white');
				$(`#${day}-li`).addClass('bg-blue-700');
				setTimeslots(timeslots, day);
				$('input[name="day"]').val(day);
				
				let slots = [];
				$('button[data-enabled="true"]').each(function() {
					slots.push($(this).data('time'));
				});
				
				$('#day-form input[name="timeslots"]').val(slots.join(','));
			} else {
				$(`#${day}-li`).removeClass('text-white');
				$(`#${day}-li`).removeClass('bg-blue-700');
			}
		});
	}

	$('#day-form input[name="day-radio"]').change(function() {
		init(schedules);		
	});

	function setTimeslots(timeslots, day) {
		$('#day-form .timeslot-btn').attr('data-enabled', false);
		$('#day-form .timeslot-btn > div').addClass('bg-slate-200');
		$('#day-form .timeslot-btn > div').removeClass('text-white bg-blue-700');

		const timeslotOfDay = getTimeslotByDay(timeslots, day);

		for(slot of timeslotOfDay) {
			$(`#day-form button[data-time="${slot}"]`).attr('data-enabled', true);
			$(`#day-form div[data-time="${slot}"]`).removeClass('bg-slate-200');
			$(`#day-form div[data-time="${slot}"]`).addClass('text-white bg-blue-700');
		}
	}

	$('.timeslot-btn').click(function(e) {
		e.preventDefault();

		if($(this).attr('data-enabled') == 'false') {
			$(this).attr('data-enabled', true);
			$(this).children().removeClass('bg-slate-200');
			$(this).children().addClass('text-white bg-blue-700');
		} else {
			$(this).attr('data-enabled', false);
			$(this).children().addClass('bg-slate-200');
			$(this).children().removeClass('text-white bg-blue-700');
		}

		let slots = [];
		$('#day-timeslots button[data-enabled="true"]').each(function() {
			slots.push($(this).data('time'));
		});

		$('#day-form input[name="timeslots"]').val(slots.join(','));

		$('#day-form input[type="submit"]').attr('disabled', false);
		$('#day-form input[type="submit"]').removeClass('cursor-not-allowed opacity-50');

		return false;
	});

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

	$('input[type="submit"]').click(function() {
		const confirmation = window.confirm('Are you sure, you want to update your schedule?');

		if(!confirmation) return false;
	});
});
