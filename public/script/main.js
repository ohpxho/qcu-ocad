function formatYearLevel(year) {
    switch(year) {
        case 1:
            return `${year}st`;
        case 2:
            return `${year}nd`;
        case 3:
            return `${year}rd`;
        case 4:
            return `${year}th`;
    }
}

function formatUnivSemester(sem) {
    if(sem == 1) return `${sem}st`;
    return `${sem}nd`;
}

function formatStudentID(id) {
    id = String(id);
    return `${id.slice(0,2)}-${id.slice(2)}`;
}

function removeDashFromId(id) {
    id = String(id);
    return `${id.slice(0,2)}${id.slice(3)}`;   
}

function getFilenameFromPath(path) {
    path = path.split('/');
    return path[path.length-1];
}

function getFileExtension(path) {
    path = path.split('.');
    return path[path.length-1].toLowerCase();
}

function getIconOfFileExtension(ext) {
    switch(ext) {
        case 'xlsx':
            return 'excel.png';
        case 'jpg':
            return 'img.png';
        case 'png':
            return 'img.png';
        case 'jpeg':
            return 'img.png';
        case 'pdf':
            return 'pdf.png';
        case 'docx':
            return 'word.png';
        default:
            return 'default.png';
    }
}

function formatDate(dt) {
    const date = new Date(dt);
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; 
    minutes = minutes < 10 ? '0'+minutes : minutes;
    let strTime = hours + ':' + minutes + ' ' + ampm;
    return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
}

function getArrayOfYearsFromToCurrent(startYear) {
    let years = [];
    const currYear = new Date().getFullYear();

    for(i = startYear; i <= currYear; i++) {
        years.push(i);
    }

    return years;
}

function getConsultationPurposeValueEquivalent(flag) {
    const purpose = [
        'Thesis/Capstone Advising',
        'Project Concern/Advising',
        'Grades Consulting',
        'Lecture Inquiries',
        'Exams/Quizzes/Assignment Concern',
        'Performance Consulting',
        'Counseling',
        'Report',
        'Health Concern'
    ]

    return purpose[flag-1];
}


function calculateDiffInMillesecodsOfNowToSched(dt) {
    const to = new Date(dt);
    const from = new Date();

    const diffInMillesecond = to - from;

    return diffInMillesecond;
}

function calculateHoursFromMilleseconds(ms) {
    return  Math.floor(ms / 1000/ 60 /60);
}

function calculateDaysFromHour(hr) {
    return Math.floor(hr / 24);
}

function displayLoader() {
    $('#loader').removeClass('hidden');
}

function hideLoader() {
    $('#loader').addClass('hidden');
}
