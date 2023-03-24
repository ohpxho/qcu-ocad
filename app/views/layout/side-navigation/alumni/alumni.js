$(document).ready(function() {	
	const ID = <?php echo json_encode($_SESSION['id']) ?>;

	conn.onmessage = function(msg) {
        msg = JSON.parse(msg.data);
        
        switch(msg.action) {
            case 'RECEIVE_MESSAGE':
            	setActiveConsultationAlert();
            	break; 
        }
        
    }

	$(window).load(function() {
		setActiveConsultationAlert();
	});


	/**
	 * execute onclick event when user click consultation dropdown button 
	**/

	$('#consultation-dropdown-btn').click(function() {
		$('#consultation-menu').toggleClass('h-0');
		$('#consultation-dropdown-icon').toggleClass('-rotate-90');
	});

	/**
	 * execute onclick event when user click document request dropdown button 
	**/

	$('#document-request-dropdown-btn').click(function() {
		$('#document-request-menu').toggleClass('h-0');
		$('#document-request-dropdown-icon').toggleClass('-rotate-90');
	});

	function setActiveConsultationAlert() {
		const hasUnseen = checkAllConsultationsIfHasUnseenMessage(ID, 'student');

		hasUnseen.done(function(result) {
			result = JSON.parse(result);
			
			if(result) {
				if(!isUserInActiveConsultation()) $('#consultation-active-alert').removeClass('hidden');
			} else {
				$('#consultation-active-alert').addClass('hidden');
			}
		});

		hasUnseen.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	}

	function isUserInActiveConsultation() {
		const indicator = <?php echo json_encode($data['consultation-active-nav-active']) ?>;
		if(indicator.length > 0) return true;

		return false;
	}
});
