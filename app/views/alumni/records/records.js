$(document).ready(function() {
	const ID = localStorage.getItem('alumni-student-id');

	let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    $(window).load(function() {
		redirectIfDataIsFound('PAGE_IN_MAIN');
		$('#records-link').prop('href', `${<?php echo json_encode(URLROOT)?>}/alumni/records/${ID}`);
		setActivityGraph('ACADEMIC_DOCUMENT_REQUEST', new Date().getFullYear());
        setRequestFrequency(ID);
        setLocalStorageKeys(ID);
	});

    function setLocalStorageKeys(id) {
		const req = getAlumniById(id);

		req.done(function(result) {
			result = JSON.parse(result);

			if(result != false) {
				localStorage.setItem('alumni-email', result.email);
				localStorage.setItem('alumni-lname', result.lname);
				localStorage.setItem('alumni-fname', result.fname);
				localStorage.setItem('alumni-mname', result.mname);
				localStorage.setItem('alumni-gender', result.gender);
				localStorage.setItem('alumni-contact', result.contact);
				localStorage.setItem('alumni-location', result.location);
				localStorage.setItem('alumni-course', result.course);
				localStorage.setItem('alumni-section', result.section);
				localStorage.setItem('alumni-address', result.address);
				localStorage.setItem('alumni-year-graduated', result.year_graduated);
				localStorage.setItem('alumni-identification', result.identification);
			} else {
				alert('Some error occured while getting your records, please try again');
			}
		});

		req.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	}

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const statusInFocus = $('#status-filter option:selected').val().toLowerCase();
        const statusInRow = (data[4] || '').toLowerCase();

        const docInFocus = $('#document-filter option:selected').val().toLowerCase();
        const docInRow = (data[3] || '').toLowerCase(); 

        if(
            (statusInFocus == '' && docInFocus == '') ||
            (statusInFocus == statusInRow && docInFocus == '') ||
            (statusInFocus == '' && docInFocus == docInRow) ||
            (statusInFocus == statusInRow && docInFocus == docInRow)

        ) return true;

        return false;
    });

    function setActivityGraph(action, year) {
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

    function setRequestFrequency(id) {
        const freq = getRequestFrequencyOfAlumni(id);

        freq.done(function(result) {
            result = JSON.parse(result);
            const tor = (result.TOR)? result.TOR : '-';
            const dismissal = (result.HONORABLE_DISMISSAL)? result.HONORABLE_DISMISSAL : '-';
            const diploma = (result.DIPLOMA)? result.DIPLOMA : '-';

            $('#tor').text(tor);
            $('#dismissal').text(dismissal);
            $('#diploma').text(diploma);
        });

        freq.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    $('#search').on('keyup', function() {
         table
            .search( this.value )
            .draw();
    });

    $('#search-btn').on('click', function() {
        table.draw();
    });


    $('#edit-request-form').submit(function(e) {
    	e.preventDefault();

    	const edit = editAlumniDocumentRequest(new FormData(this));

    	edit.done(function(result) {
    		result = JSON.parse(result);

    		if(result == '') {
    			alert('Request has been submitted');
    			window.location.reload();
    		} else {
    			alert(result);
    		}
    	});

    	edit.fail(function(jqXHR, textStatus) {
    		alert(textStatus);
    	});
    });

    /**
    * onclick event of view button, display view panel
    **/

    $('.view-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setViewPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
    }); 

    $('.edit-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setEditPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        $('#edit-panel').removeClass('-right-full').toggleClass('right-0');
    }); 

    $('.cancel-btn').click(function() {
    	const id = $(this).closest('tr').find('td:first').text();

    	const result = confirm("Are you sure? You want to delete this.");
        if(!result) {
            return false;
        } 

    	const cancel = cancelAlmuniDocumentRequest(id);

    	cancel.done(function(result) {
    		result = JSON.parse(result);

    		if(result == '') {
    			alert('Request has been cancelled');
    			window.location.reload();
    		} else {
    			alert(result);
    		}
    	});

    	cancel.fail(function(jqXHR, textStatus) {
    		alert(textStatus);
    	});
    });

    function setEditPanel(details) {
    	$('#edit-panel input[name="request-id"]').val(details.id);
    	$('#edit-panel input[name="student-id"]').val(details.student_id);
    	setEditRequestedDocument(details);
    	$('#edit-panel textarea[name="purpose-of-request"]').text(details.purpose_of_request);
    	$('#edit-panel select[name="is-RA11261-beneficiary"]').val(details.is_RA11261_beneficiary).change();
    }
    
    function setEditRequestedDocument(details) {
    	
    	if(details.is_tor_included) {
    		$('#edit-panel select[name="requested-document"]').val('TOR').change();
    	}

    	if(details.is_diploma_included) {
    		$('#edit-panel select[name="requested-document"]').val('Diploma').change();
    	}

    	if(details.is_honorable_dismissal_included) {
    		$('#edit-panel select[name="requested-document"]').val('Honorable Dismissal').change();
    	}
    }

    $('#edit-panel select[name="is-RA11261-beneficiary"]').change(function() {
    	const selected = $('#edit-panel select[name="is-RA11261-beneficiary"] option:selected').val();

    	if(selected == 'yes') {
    		$('#edit-panel #RA11261-beneficiary-hidden-input').removeClass('hidden');
    	} else {
    		$('#edit-panel #RA11261-beneficiary-hidden-input').addClass('hidden');
    	}
    });

    $('#edit-panel select[name="requested-document"]').change(function() {
    	const selected = $('#edit-panel select[name="requested-document"] option:selected').val();

    	if(selected == 'TOR') {
    		showTORAdditionalInput();
    		hideDiplomaAdditionalInput();
    	} else if(selected == 'Diploma') {
    		showDiplomaAdditionalInput();
    		hideTORAdditionalInput();
    	} else {
    		hideTORAdditionalInput();
    		hideDiplomaAdditionalInput();
    	}

    });

    function showTORAdditionalInput() {
    	const year = localStorage.getItem('alumni-year-graduated');
    	$('#edit-panel #tor-last-academic-year-attended-con').removeClass('hidden');
    	$('#edit-panel #tor-last-academic-year-attended-con input[name="tor-last-academic-year-attended"]').val(`${year-1}-${year}`);
    }

    function hideTORAdditionalInput() {
    	$('#edit-panel #tor-last-academic-year-attended-con').addClass('hidden');
    	$('#edit-panel #tor-last-academic-year-attended-con input[name="tor-last-academic-year-attended"]').val('');
    }

    function showDiplomaAdditionalInput() {
    	const year = localStorage.getItem('alumni-year-graduated');
    	$('#edit-panel #diploma-year-graduated-con input[name="diploma-year-graduated"]').val(year);
    	$('#edit-panel #diploma-year-graduated-con').removeClass('hidden');
    }

    function hideDiplomaAdditionalInput() {
    	$('#edit-panel #diploma-year-graduated-con').addClass('hidden');
    	$('#edit-panel #diploma-year-graduated-con input[name="diploma-year-graduated"]').val('');
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStatusProps(details.status);
        setViewDocumentRequestedProps(details);
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details.purpose_of_request);
        setViewBeneficiary(details);
        setViewAdditionalInformation(details);
        setViewRemarks(details.remarks);
    }

    function setViewID(id) {
        $('#request-id').text(`#${id}`);
    }

    function setViewStatusProps(status) {
        switch(status) {
            case 'pending':
                $('#status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1');
                break;
            case 'accepted':
                $('#status').removeClass().addClass('bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1');
                break;
            case 'rejected':
                $('#status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1');
                break;
            case 'in process':
                $('#status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1');
                break;
            case 'accepted':
                $('#for claiming').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1');
                break;
            default:
                $('#status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1');
        }

        $('#status').text(status);          
    }

    function setViewDocumentRequestedProps(details) {
        let documents = []

        if(details.is_tor_included) documents.push('TOR (undergraduate)');
        if(details.is_diploma_included) documents.push('Diploma');
        if(details.is_gradeslip_included) documents.push('Gradeslip');
        if(details.is_ctc_included) documents.push('Certified True Copy');      
        if(details.other_requested_document != "" && details.other_requested_document != null) documents.push(details.other_requested_document);

        $('#documents').text(documents.join(' & '));

    }

    function setViewDateCreated(dt) {
        if(dt != null) $('#date-created').text(formatDate(dt));
        else $('#date-created').text('-- -- ----');
    }

    function setViewDateCompleted(dt) {
        if(dt != null) $('#date-completed').text(formatDate(dt));
        else $('#date-completed').text('-- -- ----');
    }

    function setViewPurposeOfRequest(purpose) {
        $('#purpose').text(purpose);
    }

    function setViewBeneficiary(details) {
        if(details.is_RA11261_beneficiary != 'no') {
            $('#beneficiary').html(`<a class="hover:underline text-blue-700" href="<?php echo URLROOT;?>${details.barangay_certificate}">Barangay Certificate</a> & <a class="hover:underline text-blue-700" href="<?php echo URLROOT;?>${details.oath_of_undertaking}">Oath Of Undertaking</a>`);
        } else {
            $('#beneficiary').html('<p class="text-slate-700">No</p>');
            
        }
    }

    function setViewAdditionalInformation(details) {
        $('#tor').addClass('hidden');
        $('#diploma').addClass('hidden');
        $('#gradeslip').addClass('hidden');
        $('#ctc').addClass('hidden');
        $('#other').addClass('hidden');
        
        if(details.is_tor_included) {
            $('#tor').removeClass('hidden');
            $('#academic-year').text(details.tor_last_academic_year_attended);
        } 

        if(details.is_diploma_included) {
            $('#diploma').removeClass('hidden');
            $('#year-graduated').text(details.diploma_year_graduated);
        } 

        if(details.is_gradeslip_included) {
            const year = details.gradeslip_academic_year;
            const sem = formatUnivSemester(details.gradeslip_semester);

            $('#gradeslip').removeClass('hidden');
            $('#year-sem').text(`S.Y ${year} / ${sem} Sem`);
        } 

        if(details.is_ctc_included) {
            $('#ctc').removeClass('hidden');
            $('#ctc-document').attr('href', `<?php echo URLROOT;?>${details.ctc_document}`);
            $('#ctc-document').text(getFilenameFromPath(details.ctc_document));
        } 
         
        if(details.other_requested_document != "" && details.other_requested_document != null) {
            $('#other').removeClass('hidden');
            $('#other-document').text(details.other_requested_document);
        }
    }

    function setViewRemarks(remarks) {
        if(remarks != "") {
            $('#remarks').text(remarks);
        } else {
            $('#remarks').text('...');
        }
    }

    /**
    * onclick event of view exit button, hide view panel
    **/

    $('#view-exit-btn').click(function() {
        $('#view-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    $('#edit-exit-btn').click(function() {
        $('#edit-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

	$('#logout').click(function() {
		localStorage.clear();
		window.location.assign("<?php echo URLROOT.'/alumni/index' ?>");
	}); 

});