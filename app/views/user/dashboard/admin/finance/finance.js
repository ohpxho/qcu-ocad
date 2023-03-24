$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        setActivityGraphOfDocument('SOA_DOCUMENT_REQUEST', new Date().getFullYear());
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
            renderCalenderActivityGraph('calendar-activity-graph', year, data);
        });

        activity.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }
});