$(document).ready(function() {
	const ID = <?php echo json_encode($_SESSION['id']) ?>;
	const alumni = <?php echo json_encode($data['alumni-details']) ?>;
	const availability = <?php echo json_encode($data['request-availability']) ?>;
	const input = <?php echo json_encode($data['input-details']) ?>;

	$(window).load(function() {
		disallowDocumentsWithOngoingRequest(availability);
		init();
	});

	$('input[type="checkbox"]').change(function() {
		if(this.checked) {
			$('input[type="checkbox"]').prop('checked', false).change();
			$(this).prop('checked', true);
		}
	});

	/**
 	* onchange event of TOR, display hidden input
	**/

	$('input[name="is-tor-included"]').change(function() {
		$('input[name="tor-last-academic-year-attended"]').val('');

		if(this.checked) {
			$('input[name="tor-last-academic-year-attended"]').val(`${alumni.year_graduated-1}-${alumni.year_graduated}`);
			$('#tor-hidden-input').removeClass('hidden');
		} else {
			$('#tor-hidden-input').addClass('hidden');
		}
	});


	/**
 	* onchange event of diploma, display hidden input
	**/

	$('input[name="is-diploma-included"]').change(function() {
		$('input[name="diploma-year-graduated"]').val('');

		if(this.checked) {
			$('input[name="diploma-year-graduated"]').val(alumni.year_graduated);
			$('#diploma-hidden-input').removeClass('hidden');
		} else {
			$('#diploma-hidden-input').addClass('hidden');
		}
	});

	/**
 	* onchange event of Other, display hidden input
	**/

	$('select[name="is-RA11261-beneficiary"]').change(function() {
		$('input[name="barangay-certificate"]').val('');
		$('input[name="oath-of-undertaking"]').val('');

		if(this.value == 'yes') {
			$('#RA11261-beneficiary-hidden-input').removeClass('hidden');
		} else {
			$('#RA11261-beneficiary-hidden-input').addClass('hidden');
		}
	});

	function init() {
		$('input[name="student-id"]').val(ID);
		setFormInputs(input);
	}

	function setFormInputs(details) {
		setTORInput(details);
		setDiplomaInput(details);
		setDismissalInput(details);
		setPurposeOfRequestInput(details['purpose-of-request']);
		setBeneficiaryInput(details['is-RA11261-beneficiary']);
	}

	function setTORInput(details) {
		const isTORIncluded = details['is-tor-included'];
		const lastAcademicYearAttended = details['tor-last-academic-year-attended'];

		if(isTORIncluded) $('input[name="is-tor-included"]').prop('checked', true).change();
		$('input[name="tor-last-academic-year-attended"]').val(lastAcademicYearAttended);
	}

	function setDiplomaInput(details) {
		const isDiplomaIncluded = details['is-diploma-included'];
		const yearGraduated = details['diploma-year-graduated'];

		if(isDiplomaIncluded) $('input[name="is-diploma-included"]').prop('checked', true).change();
		$('input[name="diploma-year-graduated"]').val(yearGraduated);
	}

	function setDismissalInput(details) {
		const isDismissalIncluded = details['is-honorable-dismissal-included'];

		if(isDismissalIncluded) $('input[name="is-honorable-dismissal-included"]').prop('checked', true).change();
	}
	
	function setPurposeOfRequestInput(purpose) {
		if(purpose != '') $('textarea[name="purpose-of-request"]').text(purpose);
	}

	function setBeneficiaryInput(beneficiary) {
		$('select[name="is-RA11261-beneficiary"]').val(beneficiary).change();
	}


	function disallowDocumentsWithOngoingRequest(hasOngoing) {	
		if(hasOngoing['TOR'] > 0) disallowTOR();
		if(hasOngoing['DIPLOMA'] > 0) disallowDiploma();
		if(hasOngoing['HONORABLE_DISMISSAL'] > 0) disallowDismissal();
	}

	function disallowTOR() {
		$('input[name="is-tor-included"]').prop('disabled', true);
		$('#tor-text > p:first-child > span:first-child').addClass('line-through');
		$('#tor-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
	}

	function disallowDiploma() {
		$('input[name="is-diploma-included"]').prop('disabled', true);
		$('#diploma-text > p:first-child > span:first-child').addClass('line-through');
		$('#diploma-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
	}
	
	function disallowDismissal() {
		$('input[name="is-honorable-dismissal-included"]').prop('disabled', true);
		$('#dismissal-text > p:first-child > span:first-child').addClass('line-through');
		$('#dismissal-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
	}


});