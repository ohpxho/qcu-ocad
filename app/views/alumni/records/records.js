$(document).ready(function() {
    const records = <?php echo json_encode($data['records']) ?>;

    $(window).load(function() {
        init();
        setActivityGraph(new Date().getFullYear());
    });

    function init() {
        if(records.pic != '' && records.pic != null) {
            $('#profile-pic-con').html(`<img class="h-full w-full object-cover" src="<?php echo URLROOT ?>${records.pic}" />`);
        } else {
            $('#profile-pic-con').html(`<div class='flex text-3xl items-center justify-center w-full rounded-sm h-full bg-slate-300 text-slate-500'>${records.fname[0]}</div>`);
        }
    }

     function setActivityGraph(year) {
        const details = {
            actor: records.id,
            year: year
        };

        const activity = getAllActivitiesByActorAndYear(details); 

        activity.done(function(result) {
            result = JSON.parse(result);
            const data = getFrequencyOfActivities(result);
            renderCalenderActivityGraph('calendar-activity-graph', year, data);
        });

        activity.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

});