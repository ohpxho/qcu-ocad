$(document).ready(function() {
	const ID = <?php echo json_encode($_SESSION['id']) ?>;

	conn.onmessage = function(msg) {
        msg = JSON.parse(msg.data);
        
        switch(msg.action) {
            case 'DOCUMENT_REQUEST_ACTION_NOTICE':
                setRequestCount();
                break;
            case 'CONSULTATION_REQUEST_ACTION':
            	setConsultationRequestCount();
            	break;
            case 'RECEIVE_MESSAGE':
            	setActiveConsultationAlert();
            	break; 
        }
        
    }

	$(window).load(function() {
		setRequestCount();
		setConsultationRequestCount();
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


	function setConsultationRequestCount() {
		const count = getGuidanceConsultationRequestCount();

		count.done(function(result) {
			result = JSON.parse(result);

			if(result.count > 0) {
				$('#consultation-req-count').removeClass('hidden');
				$('#consultation-req-count > span').text(result.count);
			} else {
				$('#consultation-req-count').addClass('hidden');
			}
		});

		count.fail(function(jqXHR, textStatus) {

		});
	}

	function setRequestCount() {
		const count = getGoodMoralRequestCount();

		count.done(function(result) {
			result = JSON.parse(result);

			setPendingRequestCount(result.pending);
			setAcceptedRequestCount(result.accepted);
			setInProcessRequestCount(result.inprocess);
			setForClaimingRequestCount(result.forclaiming);
		});

		count.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	}

	function setActiveConsultationAlert() {
		const hasUnseen = checkAllConsultationsIfHasUnseenMessage(ID, 'adviser');

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

	function setPendingRequestCount(count) {
		if(count > 0) {
			$('#pending-count').removeClass('hidden');
			$('#pending-count > span').text(count);
		} else {
			$('#pending-count').addClass('hidden');
		}
	}

	function setAcceptedRequestCount(count) {
		if(count > 0) {
			$('#accepted-count').removeClass('hidden');
			$('#accepted-count > span').text(count);
		} else {
			$('#accepted-count').addClass('hidden');
		}
	}

	function setInProcessRequestCount(count) {
		if(count > 0) {
			$('#inprocess-count').removeClass('hidden');
			$('#inprocess-count > span').text(count);
		} else {
			$('#inprocess-count').addClass('hidden');
		}
	}

	function setForClaimingRequestCount(count) {
		if(count > 0) {
			$('#forclaiming-count').removeClass('hidden');
			$('#forclaiming-count > span').text(count);
		} else {
			$('#forclaiming-count').addClass('hidden');
		}
	}

	function isUserInActiveConsultation() {
		const indicator = <?php echo json_encode($data['consultation-active-nav-active']) ?>;
		if(indicator.length > 0) return true;

		return false;
	}

});
