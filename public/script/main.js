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

function formatRequestId(id) {
    if(id < 10) return `0${id}`;
    else return id;
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

function formatDateWithoutTime(dt) {
    const date = new Date(dt);

    return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear();
}

function formatDateToLongDate(dt) {
    const date = new Date(dt);
    const day = date.getDate().toString().padStart(2, "0");
    const month = new Intl.DateTimeFormat("en-US", { month: "long" }).format(date);
    const year = date.getFullYear();

    const formattedDate = `${day} ${month} ${year}`;

    return formattedDate;
}

function formatTime(tm) {
    const time = tm;
    const [hours, minutes] = time.split(':');
    const date = new Date();
    date.setHours(hours);
    date.setMinutes(minutes);
    const options = { hour: '2-digit', minute: '2-digit', hour12: true };
    const timeString = date.toLocaleString('en-US', options);
    return timeString;
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

function getShortWordOfMonth(month) {
    month = parseInt(month);

    switch(month) {
        case 1:
            return 'Jan';
        case 2:
            return 'Feb';
        case 3:
            return 'Mar';
        case 4:
            return 'Apr';
        case 5:
            return 'May';
        case 6:
            return 'Jun';
        case 7:
            return 'Jul';
        case 8: 
            return 'Aug';
        case 9: 
            return 'Sep';
        case 10:
            return 'Oct';
        case 11:
            return 'Nov';
        case 12:
            return 'Dec';
    }
}

function getFullWordOfMonth(month) {
    month = parseInt(month);
    
    switch(month) {
        case 1:
            return 'January';
        case 2:
            return 'February';
        case 3:
            return 'March';
        case 4:
            return 'April';
        case 5:
            return 'May';
        case 6:
            return 'June';
        case 7:
            return 'July';
        case 8: 
            return 'August';
        case 9: 
            return 'September';
        case 10:
            return 'October';
        case 11:
            return 'November';
        case 12:
            return 'December';
    }
}

function getMessageEquivOfStatusInDocumentRequest(status, doc) {
    switch(status) {
        case 'for process':
            return `We are pleased to inform you that the ${doc} you have requested has been approved and is currently being processed. Please wait for further updates on the status of your document.`;
        case 'awaiting payment confirmation':
            return `We are pleased to inform you that the ${doc} you have requested has been updated and is now awaiting confirmation of payment. Once we receive confirmation of payment, we will proceed with the processing of your documents.`;
        case 'for claiming':
            return `We are pleased to inform you that the ${doc} you have requested is available for claiming. When claiming your document, please bring your school ID for confirmation`;
       case 'completed':
            return `We are pleased to inform you that the ${doc} you have requested has been completed.`;
        case 'rejected':
            return `We regret to inform you that the ${doc} you have requested has been declined.`;
        case 'cancelled':
            return `We regret to inform you that the ${doc} you requested has been canceled.`;
    }

    return '';
}


function generatePaymentSlip(details) {
    const items = [
      ['Transcript of Records', 300 ],
      ['', ''],
      ['', ''],
      ['', ''],
    ];
    const header = ['Item/s', 'Price'];
    
    const doc = new jsPDF();

    doc.setFontSize(22);
    doc.text('QUEZON CITY UNIVERSITY', 50, 20);
    doc.setFontSize(16);
    doc.text('Online Consultation and Document Request', 45, 30);
    doc.setFontSize(18);
    doc.text('Payment Slip', 80, 50);
    doc.setFontSize(16);
    doc.text(`Student ID : ${formatStudentID(details.id)}`, 10, 60);
    doc.text(`Name : ${details.name}`, 10, 67);
    doc.text(`Course : ${details.course}`, 10, 74);

    doc.autoTable(header, items, {startY: 80});
    doc.text(`Total Price : ${details.price}`, 10, 130);

    return doc.output('dataurlstring');
}

function getPriceOfDoc(doc) {
    switch(doc) {
        case 'Transcript of Records':
            return 300; 
    }

    return 0;
}

function generateCodeForVerification() {
    return Math.floor(100000 + Math.random() * 900000);
}

function convertTimeStringToObject(time) {
    const [hours, minutes] = time.split(':');
    const timeObj = new Date();
    timeObj.setHours(hours);
    timeObj.setMinutes(minutes);
    return timeObj;
}

function generateRandomPassword() {
    const length = 8;
    const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    let pass = '';
    
    for (var i = 0, n = charset.length; i < length; ++i) {
        pass += charset.charAt(Math.floor(Math.random() * n));
    }

    return pass;
}