$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        setActivityGraphOfConsultation('CONSULTATION', new Date().getFullYear());
    });

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
            renderCalenderActivityGraph('calendar-activity-graph', year, data);
        });

        activity.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }
});