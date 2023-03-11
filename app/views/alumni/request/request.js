$(document).ready(function() {
	const ID = localStorage.getItem('alumni-student-id');

	$(window).load(function() {
		redirectIfDataIsFound('PAGE_IN_MAIN');
		$('#records-link').prop('href', `${<?php echo json_encode(URLROOT)?>}/alumni/records/${ID}`);
		setLocalStorageKeys(ID);
		setRequestAvailability(ID);
	});

	$('#logout').click(function() {
		localStorage.clear();
		window.location.assign("<?php echo URLROOT.'/alumni/index' ?>");
	}); 

	$('.doc-option-btn').click(function() {
		if($(this).is('[disabled]')) {
			return false;
		} 

		const doc = $(this).data('doc');
		clearAdditionalInputs();
		setNewRequestInputs(doc);
		$('#add-panel').removeClass('-right-full').addClass('right-0');
	});

	$('#add-panel select[name="is-RA11261-beneficiary"]').change(function() {
		const flag = $('#add-panel select[name="is-RA11261-beneficiary"] > option:selected').val();
		if(flag === 'yes') {
			$('#add-panel #RA11261-beneficiary-hidden-input').removeClass('hidden');
		} else {
			$('#add-panel #RA11261-beneficiary-hidden-input input[name="barangay-certificate"]').val('');
			$('#add-panel #RA11261-beneficiary-hidden-input input[name="oath-of-undertaking"]').val('');
			$('#add-panel #RA11261-beneficiary-hidden-input').addClass('hidden');
		}
	});

	$('#add-exit-btn').click(function() {
		$('#add-panel').removeClass('right-0').addClass('-right-full');
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

	function setRequestAvailability(id) {
		const availability = getRequestAvailabilityOfAlumni(id);

		availability.done(function(result) {
			result = JSON.parse(result);

			if(result.TOR > 0) {
				$('#tor > div > p').addClass('line-through');
				$('#tor .err').text('you still have an ongoing request for this document');
				$('#tor').attr('disabled', 'disabled');
			}

			if(result.HONORABLE_DISMISSAL > 0) {
				$('#dismissal > div > p').addClass('line-through');
				$('#dismissal .err').text('you still have an ongoing request for this document');
				$('#dismissal').attr('disabled', 'disabled');
			}

			if(result.DIPLOMA > 0) {
				$('#diploma > div > p').addClass('line-through');
				$('#diploma .err').text('you still have an ongoing request for this document');
				$('#diploma').attr('disabled', 'disabled');
			}
		});

		availability.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	}


	function clearAdditionalInputs() {
		$('#tor-last-academic-year-attended-con').addClass('hidden');
		$('#add-panel input[name="tor-last-academic-year-attended"]').val('');
		$('#diploma-year-graduated-con').addClass('hidden');
		$('#add-panel input[name="diploma-year-graduated"]').val('');
	
	}

	function setNewRequestInputs(doc) {
		const yearGraduated = localStorage.getItem('alumni-year-graduated');
		$('#add-panel input[name="id"]').val(ID);
		$('#add-panel input[name="requested-document"]').val(doc);
		
		switch(doc) {
			case 'TOR':
				$('#tor-last-academic-year-attended-con').removeClass('hidden');
				$('#add-panel input[name="tor-last-academic-year-attended"]').val(`${yearGraduated-1}-${yearGraduated}`);
				break;
			case 'Diploma': 
				$('#diploma-year-graduated-con').removeClass('hidden');
				$('#add-panel input[name="diploma-year-graduated"]').val(yearGraduated);
				break;
		}
	}
});