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
		setActiveAcademicAlert();
		setActiveMoralAlert();
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

	function setActiveAcademicAlert() {
		const request = checkAcademicIfNeededAlert(ID);

		request.done(function(result) {
			result = JSON.parse(result);
			
			if(result) {
				if(!isUserInAcademic()) $('#academic-active-alert').removeClass('hidden');
			} else {
				$('#academic-active-alert').addClass('hidden');
			}
		});

		request.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	}

	function isUserInAcademic() {
		const indicator = <?php echo json_encode($data['document-nav-active']) ?>;
		if(indicator.length > 0) return true;

		return false;
	}

	function setActiveMoralAlert() {
		const request = checkMoralIfNeededAlert(ID);

		request.done(function(result) {
			result = JSON.parse(result);
			
			if(result) {
				if(!isUserInMoral()) $('#moral-active-alert').removeClass('hidden');
			} else {
				$('#moral-active-alert').addClass('hidden');
			}
		});

		request.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	}

	function isUserInMoral() {
		const indicator = <?php echo json_encode($data['moral-nav-active']) ?>;
		if(indicator.length > 0) return true;

		return false;
	}
});
