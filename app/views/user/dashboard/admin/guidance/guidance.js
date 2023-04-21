$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        setActivityGraphOfDocument('GOOD_MORAL_DOCUMENT_REQUEST', new Date().getFullYear());
        setActivityGraphOfConsultation('CONSULTATION', new Date().getFullYear());
    });

    function setActivityGraphOfDocument(action, year) {
        const details = {
            action, action,
            actor: ID,
            year: year
        };

        const activity = getAllActivitiesByActorAndActionAndYear(details); 

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

    $('#completed-req-summary-btn').click(function() {
        $('#completed-req-summary-modal').removeClass('hidden');
    });

    $('#completed-req-summary-exit-btn').click(function() {
        $('#completed-req-summary-modal').addClass('hidden');
    });

    $('#rejected-req-summary-btn').click(function() {
        $('#rejected-req-summary-modal').removeClass('hidden');
    });

    $('#rejected-req-summary-exit-btn').click(function() {
        $('#rejected-req-summary-modal').addClass('hidden');
    });

    $('#cancelled-req-summary-btn').click(function() {
        $('#cancelled-req-summary-modal').removeClass('hidden');
    });

    $('#cancelled-req-summary-exit-btn').click(function() {
        $('#cancelled-req-summary-modal').addClass('hidden');
    });
});