function initializeCalendar(id) {
	const today = new Date();
	const currentMonth = today.getMonth()+1;
	const currentYear = today.getFullYear();

	const nextMonth = currentMonth === 12 ? 1 : currentMonth + 1;
	const nextMonthYear = nextMonth === 1 ? today.getFullYear() + 1 : today.getFullYear();  
	
	$(`#${id}`).html('');

	generateCalendar(id, currentMonth, currentYear);
	generateCalendar(id, nextMonth, nextMonthYear);
}

function generateCalendar(id, month, year) {
	const limit = getMonthDayLimit(month);
	let html = `<div class="flex min-w-full w-full flex-col gap-2">`;
	
	html+=`<div class="w-full text-center"><p class="font-bold text-xl">${getMonthTitle(month)} ${year}</p></div>`;
	
	html+=`<div class="w-full px-4 py-6 h-full grid gap-3" style="grid-template-columns: repeat(7, minmax(0, 1fr));">`;
	html+=`<div class="text-center"><p>Sunday</p></div><div class="text-center"><p>Monday</p></div> <div class="text-center"><p>Tuesday</p></div> <div class="text-center"><p>Wednesday</p></div> <div class="text-center"><p>Thursday</p></div> <div class="text-center"><p>Friday</p></div> <div class="text-center"><p>Saturday</p></div>`;

	const day = new Date(getDateString(year, month, 1)).getDay();

	for(let i = 0; i < day; i++) {
		html+='<div></div>';
	}

	for(let i = 1; i <= limit; i++) {
		const dateString = getDateString(year, month, i);
		const date = new Date(dateString);
		const dayOfWeek = date.toLocaleString('en-us', { weekday: 'long' }).toLowerCase();

		html += `<div data-day="${dayOfWeek}" data-date="${dateString}"><button data-day="${dayOfWeek}" data-date="${dateString}" class="calendar-dt-button flex cursor-not-allowed opacity-50 aspect-square w-full p-4 bg-slate-400 text-slate-700 justify-center items-center" disabled>${i}</button></div>`;
	}

	html += `</div></div>`;

	$(`#${id}`).append(html);
}

function getMonthDayLimit(month) {
	switch(month) {
		case 1: return 31;
		case 2: return isLeapYear() ? 29 : 28;
		case 3: return 31;
		case 4: return 30;
		case 5: return 31;
		case 6: return 30;
		case 7: return 31;
		case 8: return 31;
		case 9: return 30;
		case 10: return 31;
		case 11: return 30;
		default: return 31;
	}
}

function getMonthTitle(month) {
	switch(month) {
		case 1: return 'January';
		case 2: return 'February';
		case 3: return 'March';
		case 4: return 'April';
		case 5: return 'May';
		case 6: return 'June';
		case 7: return 'July';
		case 8: return 'August';
		case 9: return 'September';
		case 10: return 'October';
		case 11: return 'November';
		default: return 'December';
	}
}

function getDayOfWeekValue(day) {
	switch(day) {

	}
}

function isLeapYear() {
	const curr = new date();
	const year = curr.getFullYear();

	return year % 4 == 0; 
}

function getDateString(year, month, day) {
	return `${year}-${formatDigit(month)}-${formatDigit(day)}`
}

function formatDigit(day) {
	return day < 10 ? '0'+day : day;
}