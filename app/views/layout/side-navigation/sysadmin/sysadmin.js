$(document).ready(function() {
	const ID = <?php echo json_encode($_SESSION['id']) ?>;

	conn.onmessage = function(msg) {
        msg = JSON.parse(msg.data);
        
        switch(msg.action) {
            case 'DOCUMENT_REQUEST_ACTION_NOTICE':
                setRequestCount();
                break;
        }
        
    }
    
	$(window).load(function() {
		setRequestCount();
	});

	/**
	 * execute onclick event when user click document request dropdown button 
	**/

	$('#document-request-dropdown-btn').click(function() {
		$('#document-request-menu').toggleClass('h-0');
		$('#document-request-dropdown-icon').toggleClass('-rotate-90');
	});


	function setRequestCount() {
		const count = getAcademicDocumentRequestCount();

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

});
