$(document).ready(function() {
	const details = <?php echo json_encode($data['request-data']) ;?>;
	const consultationID = <?php echo json_encode($data['request-data']->id); ?>;
	const adviserID = <?php echo json_encode($data['request-data']->adviser_id); ?>;
	const creatorID = <?php echo json_encode($data['request-data']->creator) ?>;

	$(window).load(function() {
		init(details);
		setMessagesAsRead(details.id);
		setChatPanelScrollViewToBottom();
	}); 


	const conn = new WebSocket('ws://localhost:8082/chat?id=' + encodeURIComponent(creatorID));
	
	conn.onopen = function(e) {
	    console.log("Connection established!");
	    checkIfOnline(adviserID);
	    broadcastOnlineToAllOnlineUsers(creatorID);
	};

	conn.onmessage = function(msg) {
		msg = JSON.parse(msg.data);

		switch(msg.action) {
			case 'RECEIVE_MESSAGE':
				if(isChatPanelInViewport()) setMessagesAsRead(details.id);
				else countUnseenMessages(details.id);
				receiveMessage(msg.message);
				break;
			case 'IS_USER_ONLINE':
				isUserOnline(msg);
				break;
			case 'USER_ONLINE_BROADCAST':
				userOnlineBroadcast(msg)
				break;
			case 'USER_OFFLINE_BROADCAST':
				userOfflineBroadcast(msg);
				break;
		}

	};

	function checkIfOnline(id) {
		const msg = {
			action: 'CHECK_IF_ONLINE',
			id: id
		};

		conn.send(JSON.stringify(msg));
	}

	function isUserOnline(msg) {
		$('#online-indicator').removeClass('bg-gray-300').addClass('bg-green-500');
	}

	function broadcastOnlineToAllOnlineUsers(id) {
		const msg = {
			action: 'BROADCAST_IM_ONLINE',
			id: id
		};

		conn.send(JSON.stringify(msg));
	}

	function userOnlineBroadcast(msg) {
		if(msg.id == adviserID) $('#online-indicator').removeClass('bg-gray-300').addClass('bg-green-500');
	}

	function userOfflineBroadcast(msg) {
		if(msg.id == adviserID) $('#online-indicator').removeClass('bg-green-500').addClass('bg-gray-300');	
	}

	$('#send-message-btn').click(function() {
		const message = $('#message-box').html();

		const msg = {
			action: 'SEND_MESSAGE',
			id: consultationID,
			sender: adviserID,
			receiver: creatorID,
			message: message
		};

		const save = saveMessage(msg);

		save.done(function(result) {
			result = JSON.parse(result);
			if(isMessageSendSuccessfully(result)) {
				sendMessage(msg);
				clearMessageBox();
				setChatPanelScrollViewToBottom();
			} else displayMessageSendError(result);
		});

		save.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
		
	});

	function sendMessage(msg) {
		conn.send(JSON.stringify(msg));
        $('#chat-panel').append(`<div class="flex justify-start"><div class="rounded-md py-1 px-2 max-w-[83.333333%] w-max bg-blue-700"><p class="text-white">${msg.message}</p></div></div>`);
	}

	function receiveMessage(msg) {
		$('#chat-panel').append(`<div class="flex justify-end"><div class="rounded-md py-1 px-2 max-w-[83.333333%] w-max bg-gray-300"><p class="text-gray-700">${msg}</p></div></div>`);
	}

	$('.chat-bubble').bind('click', function() {
		$(this).find('p.chat-datetime').toggleClass('show');
	});

	$('#chat-btn').click(function() {
		$('#convo-panel').removeClass('-right-full').addClass('right-0');
		$('#shared-doc-panel').removeClass('right-0').addClass('-right-full');
		setMessagesAsRead(consultationID);
	});

	$('#student-shared-doc').click(function() {
		setStudentSharedDocuments(details.shared_file_from_student);
		$('#add-shared-doc-btn').removeClass('hidden');
		$('#shared-doc-panel form').removeClass('show').addClass('hide');
		$('#shared-doc-panel').removeClass('-right-full').addClass('right-0');
		$('#convo-panel').removeClass('right-0').addClass('-right-full');
	});

	$('#adviser-shared-doc').click(function() {
		setAdviserSharedDocuments(details.shared_file_from_advisor);
		$('#add-shared-doc-btn').addClass('hidden');
		$('#shared-doc-panel form').removeClass('show').addClass('hide');
		$('#shared-doc-panel').removeClass('-right-full').addClass('right-0');
		$('#convo-panel').removeClass('right-0').addClass('-right-full');
	});	

	$('#shared-docs').on('click', '.drop-document-btn', function() {
		const filename = $(this).prev().find('.file-name').text();
		
		const del = deleteDocument(filename, details.shared_file_from_student);

		del.done(function(result) {
			result = JSON.parse(result);
			alert(result);

			updateChangesOfUploadedDocumentsFromStudent();
		});

		del.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	});

	$('#convo-exit-btn').click(function() {
		countUnseenMessages(consultationID);
		$('#convo-panel').removeClass('right-0').addClass('-right-full');
	});

	$('#shared-doc-exit-btn').click(function() {
		$('#shared-doc-panel').removeClass('right-0').addClass('-right-full');
	});

	$('#add-shared-doc-btn').click(function() {
		$('#shared-doc-panel form').toggleClass('show');
	});


	$('#upload-doc-form').submit(function(event) {
		event.preventDefault();
		const upload = uploadDocuments(new FormData(this)); 
		
		upload.done(function(result) {
			alert(result);
			updateChangesOfUploadedDocumentsFromStudent();
		});

		upload.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	});

	$('#upload-doc-form input[type="file"]').change(function() {
		if($(this)[0].files.length > 0) {
			$('#upload-doc-form input[type="submit"]').prop('disabled', false);
			$('#upload-doc-form input[type="submit"]').removeClass('opacity-50 cursor-not-allowed');
		} else {
			$('#upload-doc-form input[type="submit"]').prop('disabled', true);
			$('#upload-doc-form input[type="submit"]').addClass('opacity-50 cursor-not-allowed');
		}
	});

	function deleteDocument(fileToDelete, existingDocuments) {
		return $.ajax({
			url: '/qcu-ocad/consultation/delete_document',
		    type: 'POST',
			data: {
				id: consultationID,
				type: 'student',
				'existing-files': existingDocuments,
				'file-to-delete': fileToDelete
			}
		});
	}


	function uploadDocuments(details) {
		return $.ajax({
		    url: '/qcu-ocad/consultation/upload',
		    type: 'POST',
			data: details,
		    contentType: false,
		    processData: false
		});
	}

	function getStudentDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/student/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function saveMessage(msg) {
		return $.ajax({
	        url: "/qcu-ocad/message/send",
	        type: "POST",
	        data: msg
	    });
	}

	function getRequestDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/consultation/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function updateChangesOfUploadedDocumentsFromStudent() {
		$('#upload-doc-form input[type="file"]').val(null);

		const data = getRequestDetails(details.id);
		
		data.done(function(result) {
			const det = JSON.parse(result);
			details.shared_file_from_student = det.shared_file_from_student;
			setSharedDocumentsOfStudent(det.shared_file_from_student);
			setStudentSharedDocuments(det.shared_file_from_student);
		});

		data.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	}

	function init(details) {
		$('#purpose').text(getPurposeValueEquivalent(details.purpose));
		$('#date-created').text(formatDate(details.date_requested));
		$('#adviser').text(setAdviser(details.adviser_name));
		$('#department').text(details.department);
		$('#subject').text(setSubject(details.subject));
		$('#problem').html(details.problem);
		$('#preferred-date').text(setPreferredDate(details.preferred_date_for_gmeet));
		$('#preferred-time').text(details.preferred_time_for_gmeet);
		$('#sched-for-meet').text(setSchedForGmeet(details.schedule_for_gmeet));
		calculateNowFromSchedAndDisplayResult(details.schedule_for_gmeet);
		setSharedDocumentsOfStudent(details.shared_file_from_student);
		setSharedDocumentsOfAdviser(details.shared_file_from_advisor);
		setGmeetLink(details.gmeet_link);
	}

	function getPurposeValueEquivalent(purpose) {
		switch(purpose) {
			case '1':
				return 'Thesis/Capstone Advising';
			case '2':
				return 'Project Concern/Advising';
			case '3':
				return 'Grades Consulting';
			case '4':
				return 'Lecture Inquiries';
			case '5':
				return 'Exams/Quizzes/Assignment Concern';
			case '6': 
				return 'Performance Consulting';
			case '7':
				return 'Counseling';
			case '8':
				return 'Report';
		}

		return '---------';
	}

	function setAdviser(adviser) {
		if(adviser.length > 0) return adviser;
		return '---------';
	}

	function setSubject(subject) {
		if(subject.length > 0) return subject; 
		return '---------';
	}

	function setPreferredDate(dt) {
		const preferredDate = new Date(dt);
        return preferredDate.getMonth()+1 + "/" + preferredDate.getDate() + "/" + preferredDate.getFullYear();
	}

	function setSharedDocumentsOfStudent(documents) {
		if(documents == null || documents.length == 0 ) {
			$('#student-shared-doc').text('No shared documents');
		} else {
			const docs = documents.split(',');
			$('#student-shared-doc').text(`${docs.length} document/s`);
		}
	}

	function setSharedDocumentsOfAdviser(documents) {
		if(documents == null || documents.length == 0) {
			$('#adviser-shared-doc').text('No shared documents');
		} else {
			const docs = documents.split(',');
			$('#adviser-shared-doc').text(`${docs.length} document/s`);
		}
	}

	function setSchedForGmeet(dt) {
		if(dt == '0000-00-00 00:00:00') return '---- -- --';
		return formatDate(dt);
	}

	function calculateNowFromSchedAndDisplayResult(dt) {
		if(dt != '0000-00-00 00:00:00') {

			const diffInMillesecond = calculateDiffInMillesecodsOfNowToSched(dt);

			if(diffInMillesecond > 0) {
				const diffInHours = calculateHoursFromMilleseconds(diffInMillesecond);
				const diffInDays = calculateDaysFromHour(diffInHours);

				if(diffInDays > 0) {
					$('#date-diff').text(`${diffInDays} day/s before the meeting`);
				} else {
					$('#date-diff').text(`Meeting is scheduled today`);
				}

				$('#sched-notice').removeClass('hidden').addClass('flex');
			
			} else {

				$('#sched-notice').removeClass('flex').addClass('hidden');	
			}
		}
	}

	function setGmeetLink(link) {
		if(link == null || link == '') { 
			$('#link').prop('href', '#');
			$('#link').removeClass('text-blue-700 hover:underline');
			$('#link').text('---------');
		} else {
			$('#link').text(link).addClass('text-blue-700 hover:underline');
			$('#link').prop('href', link);
		}
		
	}

    function setStudentSharedDocuments(documents) {
    	$('#shared-doc-panel form input[name="request-id"]').val(consultationID);
		$('#shared-doc-panel form input[name="type"]').val('student');
		$('#shared-doc-panel form input[name="existing-files"]').val(documents || '');
		$('#shared-docs').empty();
		if(documents != null && documents != '') {
			const docs = documents.split(',');
			for(i in docs) {
				const icon = getIconOfFileExtension(getFileExtension(docs[i]));
				$('#shared-docs').append(
					`<div class="flex items-center w-full group">
						<a class="w-full" target="_blank" href="<?php echo URLROOT; ?>${docs[i]}" >
							<li class="filename-li hover:bg-slate-100 p-1 flex gap-2 items-center border-b w-full">
								<img class="h-7 w-7" src="<?php echo URLROOT?>/public/assets/img/${icon}"/>
								<span class="file-name">${getFilenameFromPath(docs[i])}</span>
							</li>
							<a class="drop-document-btn absolute z-30 cursor-pointer text-red-500 right-0 px-3 hidden group-hover:flex">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
								  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
								</svg>
							</a>
						</a>
					</div>`
				);
			}
		} else {
			$('#shared-docs').html(`<p class="w-full text-center py-2 bg-slate-100 text-slate-500" >No shared documents</p>`);
		}
	}

	function setAdviserSharedDocuments(documents) {
		$('#shared-docs').empty();
		if(documents != null && documents != '') {
			const docs = documents.split(',');
			for(i in docs) {
				const icon = getIconOfFileExtension(getFileExtension(docs[i]));
				$('#shared-docs').append(`<a target="_blank" href="<?php echo URLROOT; ?>${docs[i]}" ><li class="hover:bg-slate-100 p-1 flex gap-2 items-center border-b"><img class="h-7 w-7" src="<?php echo URLROOT?>/public/assets/img/${icon}"/>${getFilenameFromPath(docs[i])}</li></a>`);
			}
		} else {
			$('#shared-docs').html(`<p class="w-full text-center py-2 bg-slate-100 text-slate-500" >No shared documents</p>`);
		}
	}

	function clearMessageBox() {
		$('#message-box').html('');
	}

	function isMessageSendSuccessfully(result) {
		return result.length == 0; 
	}

	function displayMessageSendError(err) {
		alert(err);
	}


	/**
     * chat functions 
    **/

    function setUnseenMessagesToSeen(id) {
    	return $.ajax({
			url: '/qcu-ocad/message/seen_unseen',
		    type: 'POST',
			data: { id } 
		});
    }

    function getCountOfUnseenMessages(id) {
    	return $.ajax({
			url: '/qcu-ocad/message/count_unseen',
		    type: 'POST',
			data: { id }
		});
    }

    function setMessagesAsRead(id) {
    	hideUnseenMessagesCountBubble();
    		
    	const seen = setUnseenMessagesToSeen(id);

    	seen.done(function(result) {
    		result = JSON.parse(result);
    		if(result.length > 0) alert(result);
    	});

    	seen.fail(function(jqXHR, textStatus) {
    		alert(textStatus);
    	});
    }

    function countUnseenMessages(id) {
    	const count = getCountOfUnseenMessages(id);
    	
    	count.done(function(result) {
    		result = JSON.parse(result);
    		if(Number.isInteger(result)) {
    			
    			if(result > 0) {
    				setValueOfUnseenMessagesCount(result);
    				showUnseenMessagesCountBubble();
    			}

    		} else {
    			alert(result);
    		}
    	});

    	count.fail(function(jqXHR, textStatus) {
    		alert(textStatus);
    	});
    }

    function hideUnseenMessagesCountBubble() {
    	$('#unseen-message-count-bubble').addClass('hidden');
    }

    function showUnseenMessagesCountBubble() {
    	$('#unseen-message-count-bubble').removeClass('hidden');
    }

    function setValueOfUnseenMessagesCount(count) {
    	$('#unseen-message-count').text(count);
    }

    function setChatPanelScrollViewToBottom() {
		 $('#chat-panel').scrollTop($('#chat-panel').prop('scrollHeight'));
	}

	function isChatPanelInViewport(elementId) {
	    const rect = $('#convo-panel')[0].getBoundingClientRect();
	    const viewportWidth = $(window).width();
	    return (
	        rect.right >= 0 &&
	        rect.left < viewportWidth
	    );
	}

});