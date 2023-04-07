$(document).ready(function() {
	const ID = <?php echo json_encode($_SESSION['id']) ?>;
	const schedules = <?php echo json_encode($data['schedule']) ?>;

	$(window).load(function() {
		init(schedules);
	});

	function init(timeslots) {
		$('input[name="day-radio"]').each(function() {
			const day = $(this).attr('id');
			
			$('#day-form input[type="submit"]').attr('disabled', true);
			$('#day-form input[type="submit"]').addClass('cursor-not-allowed opacity-50');

			if(this.checked) {
				$(`#${day}-li`).removeClass('bg-slate-200');
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
				$(`#${day}-li`).addClass('bg-slate-200');
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

	$('#day-form .timeslot-btn').click(function(e) {
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

	$('#update-availability-btn').click(function() {
		$('#calendar-con').toggleClass('show');
		initializeCalendar('calendar');
		setAvailableSchedule(schedules);
	});

	function setAvailableSchedule(timeslots) {
  		let date = new Date();
  		let dateString = getDateString(date.getFullYear(), date.getMonth()+1, date.getDate());
  		let day = date.toLocaleString('en-us', { weekday: 'long' }).toLowerCase();

  		for(let i = 0; i < 14; i++) {
			
			$(`#calendar div[data-date="${dateString}"] button`).removeClass('bg-slate-400 opacity-50 cursor-not-allowed');
	  		$(`#calendar div[data-date="${dateString}"] button`).addClass('bg-blue-400 text-white');
	  		$(`#calendar div[data-date="${dateString}"] button`).attr('disabled', false);
			
			newdate = new Date(date);
			newdate.setDate(date.getDate()+1);
	  		
	  		date = newdate;
	  		dateString = getDateString(date.getFullYear(), date.getMonth()+1, date.getDate());
	  		day = date.toLocaleString('en-us', { weekday: 'long' }).toLowerCase();		  						
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

		$('#availability-timeslots').removeClass('hidden');
		$(this).removeClass('bg-blue-400');
  		$(this).addClass('bg-blue-700');

  		const day = $(this).data('day');
  		const date = $(this).data('date');
  		const advisor = getAdvisor();

  		const availability = getAvailability(advisor, date);

  		availability.done(function(result) {

  			result = JSON.parse(result);

  			const details = {day, date, advisor, 'availability': result};

  			setSchedule(details);
  		});

  		availability.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});

  		$('#availability-form input[name="date"]').val(date);
  		$('#availability-form input[name="advisor"]').val(advisor);
  		$('#availability-form input[name="timeslots"]').val('');

  		

		return false;
	});

	function setSchedule(details) {
		const day = details.day;
  		const date = details.date;
  		const advisor = details.advisor;
  		const availability = details.availability;
  		
  		const sched = getSchedule(advisor);
		
		sched.done(function(result) {
  			result = JSON.parse(result);
  			const timeslots = (result[day]==null || result[day]=='')? [] : result[day].split(',');

  			$('#availability-form input[name="timeslots"]').val(timeslots.join(','));

  			//reset timeslot buttons
  			$('#availability-form .timeslot-btn').each(function() {
  				$(this).attr('data-enabled', false);
				$(this).children().addClass('bg-slate-200');
				$(this).children().removeClass('text-white bg-blue-700');
  			});

  			for(slot of timeslots) {
  				$(`#availability-form .timeslot-btn[data-time="${slot}"]`).attr('data-enabled', true);
				$(`#availability-form .timeslot-btn div[data-time="${slot}"]`).removeClass('bg-slate-200');
				$(`#availability-form .timeslot-btn div[data-time="${slot}"]`).addClass('text-white bg-blue-700');
  			}

  		});

  		sched.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
	}

	$('#availability-form .timeslot-btn').click(function(e) {
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
		$('#availability-timeslots button[data-enabled="true"]').each(function() {
			slots.push($(this).data('time'));
		});

		$('#availability-form input[name="timeslots"]').val(slots.join(','));

		$('#availability-form input[type="submit"]').attr('disabled', false);
		$('#availability-form input[type="submit"]').removeClass('cursor-not-allowed opacity-50');

		return false;
	});

	function getAdvisor() {
		const type = <?php echo json_encode($_SESSION['type']) ?>;
		
		if(type == 'professor') return <?php echo json_encode($_SESSION['id']) ?>;

		if(type == 'guidance') return 'guidance';

		if(type == 'clinic') return 'clinic';
	}

	$('#day-form input[type="submit"]').click(function() {
		const confirmation = window.confirm('Are you sure, you want to update your schedule?');

		if(!confirmation) return false;
	});

	$('#availability-form input[type="submit"]').click(function() {
		const confirmation = window.confirm('Are you sure, you want to update your availability at this date?');
		if(!confirmation) return false;
	});

});
