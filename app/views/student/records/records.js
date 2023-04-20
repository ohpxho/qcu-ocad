$(document).ready(function() {
	const records = <?php echo json_encode($data['records']) ?>;

	$(window).load(function() {
		init();
		setActivityGraphOfDocument(new Date().getFullYear());
        setActivityGraphOfConsultation('CONSULTATION', new Date().getFullYear());
	});

	let table = $('#request-table').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        search: {
            'regex': true
        },
        buttons: [
            'excelHtml5'
        ]
    });

    function init() {
		if(records.pic != '' && records.pic != null) {
			$('#profile-pic-con').html(`<img class="h-full w-full object-cover" src="<?php echo URLROOT ?>${records.pic}" />`);
		} else {
			$('#profile-pic-con').html(`<div class='flex text-3xl items-center justify-center w-full rounded-sm h-full bg-slate-300 text-slate-500'>${records.fname[0]}</div>`);
		}
	}

	  function setActivityGraphOfDocument(year) {
        const details = {
            actor: ID,
            year: year
        };

        const activity = getAllDocumentActivitiesByActorAndActionAndYear(details); 

        activity.done(function(result) {
            result = JSON.parse(result);
            const data = getFrequencyOfActivities(result);
            renderCalenderActivityGraph('calendar-activity-graph-document', year, data);
        });

        activity.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    function setActivityGraphOfConsultation(action, year) {
        const details = {
            actor: ID,
            action: action,
            year: year
        };

        const activity = getAllActivitiesByActorAndActionAndYear(details); 
 
        activity.done(function(result) {
            result = JSON.parse(result);
            const data = getFrequencyOfActivities(result);
            renderCalenderActivityGraph('calendar-activity-graph-consultation', year, data);
        });

        activity.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

});