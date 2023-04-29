$(document).ready(function() {
	const ID = <?php echo json_encode($_SESSION['id']) ?>;

	const student = <?php echo json_encode($data['student-details']) ?>;
	const availability = <?php echo json_encode($data['request-availability']) ?>;
	const input = <?php echo json_encode($data['input-details']) ?>;

	$(window).load(function() {
		disallowDocumentsWithOngoingRequest(availability);
		init();
	});

	$('#add-request-form').submit(function(e) {
		
		const msg = {
			action: 'DOCUMENT_REQUEST_ACTION',
			id: ID,
			department: 'registrar'
		};

		conn.send(JSON.stringify(msg));

		return true;
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
		$('select[name="tor-last-academic-year-attended"]').val('');

		if(this.checked) {
			$('#tor-hidden-input').removeClass('hidden');
		} else {
			$('#tor-hidden-input').addClass('hidden');
		}
	});


	/**
 	* onchange event of Gradeslip, display hidden input
	**/

	$('input[name="is-gradeslip-included"]').change(function() {
		$('select[name="gradeslip-semester"]').val('');
		$('select[name="gradeslip-academic-year"]').val('');

		if(this.checked) {
			$('#gradeslip-hidden-input').removeClass('hidden');
		} else {
			$('#gradeslip-hidden-input').addClass('hidden');
		}
	});

	/**
 	* onchange event of CTC, display hidden input
	**/

	$('input[name="is-ctc-included"]').change(function() {
		$('input[name="ctc-document"]').val('');

		if(this.checked) {
			$('#ctc-hidden-input').removeClass('hidden');
		} else {
			$('#ctc-hidden-input').addClass('hidden');
		}
	});

	/**
 	* onchange event of Other, display hidden input
	**/

	$('input[name="is-other-document-included"]').change(function() {
		$('input[name="other-requested-document"]').val('');

		if(this.checked) {
			$('#other-requested-document-hidden-input').removeClass('hidden');
		} else {
			$('#other-requested-document-hidden-input').addClass('hidden');
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
		$('input[name="student-id"]').val(student.id);
		setAcademicYearOptions();
		setFormInputs(input);
	}

	function setFormInputs(details) {
		setTORInput(details);
		setGradeslipInput(details);
		setCTCInput(details);
		setOtherDocumentInput(details);
		setPurposeOfRequestInput(details['purpose-of-request']);
		setQuantity(details.quantity);
		setBeneficiaryInput(details['is-RA11261-beneficiary']);
	}

	function setTORInput(details) {
		const isTORIncluded = details['is-tor-included'];
		const lastAcademicYearAttended = details['tor-last-academic-year-attended'];

		if(isTORIncluded) $('input[name="is-tor-included"]').prop('checked', true).change();
		$('select[name="tor-last-academic-year-attended"]').val(lastAcademicYearAttended);
	}

	function setGradeslipInput(details) {
		const isGradeslipIncluded = details['is-gradeslip-included'];
		const semester = details['gradeslip_semester'];
		const academicYear = details['gradeslip-academic-year'];

		if(isGradeslipIncluded) $('input[name="is-gradeslip-included"]').prop('checked', true).change();
		$('select[name="gradeslip-semester"]').val(semester);
		$('select[name="gradeslip-academic-year"]').val(academicYear);
	}

	function setCTCInput(details) {
		const isCTCIncluded = details['is-ctc-included'];

		if(isCTCIncluded) $('input[name="is-ctc-included"]').prop('checked', true).change();
	}

	function setOtherDocumentInput(details) {
		const otherRequestedDocument = details['other-requested-document'];

		if(otherRequestedDocument != '' && otherRequestedDocument  != null) $('input[name="is-other-document-included"]').prop('checked', true).change();
		$('input[name="other-requested-document"]').val(otherRequestedDocument);
	}

	function setPurposeOfRequestInput(purpose) {
		if(purpose != '') $('textarea[name="purpose-of-request"]').text(purpose);
	}

	function setQuantity(quantity) {
		$('input[name="quantity"]').val(quantity || 1);
	}

	function setBeneficiaryInput(beneficiary) {
		$('select[name="is-RA11261-beneficiary"]').val(beneficiary).change();
	}

	function setAcademicYearOptions() {
		const START_YEAR = 1999;
		const years = getArrayOfYearsFromToCurrent(START_YEAR);

		$.each(years, function(index, item) {
			$('select[name="tor-last-academic-year-attended"]').append(`<option value="${item}-${item+1}">${item}-${item+1}</option>`);	
			$('select[name="gradeslip-academic-year"]').append(`<option value="${item}-${item+1}">${item}-${item+1}</option>`);	
		});
	}

	function disallowDocumentsWithOngoingRequest(hasOngoing) {	
		if(hasOngoing['TOR'] > 0) disallowTOR();
		if(hasOngoing['GRADESLIP'] > 0) disallowGradeslip();
		//if(hasOngoing['CTC'] > 0) disallowCTC();
	}

	function disallowTOR() {
		$('input[name="is-tor-included"]').prop('disabled', true);
		$('#tor-text > p:first-child > span:first-child').addClass('line-through');
		$('#tor-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
	}

	function disallowGradeslip() {
		$('input[name="is-gradeslip-included"]').prop('disabled', true);
		$('#gradeslip-text > p:first-child > span:first-child').addClass('line-through');
		$('#gradeslip-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
	}
	
	// function disallowCTC() {
	// 	$('input[name="is-ctc-included"]').prop('disabled', true);
	// 	$('#ctc-text > p:first-child > span:first-child').addClass('line-through');
	// 	$('#ctc-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
	// }


});