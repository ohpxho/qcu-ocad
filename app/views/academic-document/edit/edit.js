$(document).ready(function() {
	const student = <?php echo json_encode($data['student-details']); ?>;
	const frequency = <?php echo json_encode($data['request-frequency']); ?>;
	const input = <?php echo json_encode($data['input-details']); ?>

	$(window).load(function() {
		disallowDocumentsByFrequency(frequency);
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
		setAcademicYearOptions();
		setFormInputs(input);
	}

	function setFormInputs(details) {
		$('input[name="request-id"]').val(details['id']);
		$('input[name="student-id"]').val(student['id']);
		setTORInput(details);
		setGradeslipInput(details);
		setCTCInput(details);
		setOtherDocumentInput(details);
		setPurposeOfRequestInput(details['purpose_of_request']);
		setBeneficiaryInput(details);
	}

	function setTORInput(details) {
		const isTORIncluded = details['is_tor_included'];
		const lastAcademicYearAttended = details['tor_last_academic_year_attended'];

		if(isTORIncluded) $('input[name="is-tor-included"]').prop('checked', true).change();
		$('select[name="tor-last-academic-year-attended"]').val(lastAcademicYearAttended);
	}

	function setGradeslipInput(details) {
		const isGradeslipIncluded = details['is_gradeslip_included'];
		const semester = details['gradeslip_semester'];
		const academicYear = details['gradeslip_academic_year'];

		if(isGradeslipIncluded) $('input[name="is-gradeslip-included"]').prop('checked', true).change();
		$('select[name="gradeslip-semester"]').val(semester);
		$('select[name="gradeslip-academic-year"]').val(academicYear);
	}

	function setCTCInput(details) {
		const isCTCIncluded = details['is_ctc_included'];

		if(isCTCIncluded) {
			$('input[name="is-ctc-included"]').prop('checked', true).change()
			setUploadedDocOfCTC(details['ctc_document']);
		};
	}

	function setUploadedDocOfCTC(doc) {
		$('#ctc-uploaded-document').removeClass('hidden');

		const icon = getIconOfFileExtension(getFileExtension(doc));

		$('#uploaded-ctc-doc-list').append(
			`<div class="flex items-center w-full group">
				<a class="w-full" target="_blank" href="<?php echo URLROOT; ?>${doc}" >
					<li class="filename-li hover:bg-slate-100 p-1 flex gap-2 items-center w-full">
						<img class="h-7 w-7" src="<?php echo URLROOT?>/public/assets/img/${icon}"/>
						<span class="file-name">${getFilenameFromPath(doc)}</span>
					</li>
				</a>
			</div>`);
	}

	function setOtherDocumentInput(details) {
		const otherRequestedDocument = details['other_requested_document'];

		if(otherRequestedDocument != '' && otherRequestedDocument  != null) $('input[name="is-other-document-included"]').prop('checked', true).change();
		$('input[name="other-requested-document"]').val(otherRequestedDocument);
	}

	function setPurposeOfRequestInput(purpose) {
		if(purpose != '') $('textarea[name="purpose-of-request"]').text(purpose);
	}

	function setBeneficiaryInput(details) {
		$('select[name="is-RA11261-beneficiary"]').val(details['is_RA11261_beneficiary']).change();
		if(details['is_RA11261_beneficiary'] == 'yes') {
			setUploadedDocOfBeneficiary(details['barangay_certificate'], details['oath_of_undertaking']);
		}
	}

	function setUploadedDocOfBeneficiary(barangayCertificate, oathOfUndertaking) {
		$('#beneficiary-uploaded-documents').removeClass('hidden');

		const barangayCertFileIcon = getIconOfFileExtension(getFileExtension(barangayCertificate));

		$('#uploaded-beneficiary-doc-list').append(
			`<div class="flex items-center w-full group">
				<a class="w-full" target="_blank" href="<?php echo URLROOT; ?>${barangayCertificate}" >
					<li class="filename-li hover:bg-slate-100 p-1 flex gap-2 items-center border-b w-full">
						<img class="h-7 w-7" src="<?php echo URLROOT?>/public/assets/img/${barangayCertFileIcon}"/>
						<span class="file-name">${getFilenameFromPath(barangayCertificate)}</span>
					</li>
				</a>
			</div>`);

		const oathOfUndertakingFileIcon = getIconOfFileExtension(getFileExtension(oathOfUndertaking));

		$('#uploaded-beneficiary-doc-list').append(
			`<div class="flex items-center w-full group">
				<a class="w-full" target="_blank" href="<?php echo URLROOT; ?>${oathOfUndertaking}" >
					<li class="filename-li hover:bg-slate-100 p-1 flex gap-2 items-center border-b w-full">
						<img class="h-7 w-7" src="<?php echo URLROOT?>/public/assets/img/${oathOfUndertakingFileIcon}"/>
						<span class="file-name">${getFilenameFromPath(oathOfUndertaking)}</span>
					</li>
				</a>
			</div>`);
	
	}

	function setAcademicYearOptions() {
		const START_YEAR = 1999;
		const years = getArrayOfYearsFromToCurrent(START_YEAR);

		$.each(years, function(index, item) {
			$('select[name="tor-last-academic-year-attended"]').append(`<option value="${item}-${item+1}">${item}-${item+1}</option>`);	
			$('select[name="gradeslip-academic-year"]').append(`<option value="${item}-${item+1}">${item}-${item+1}</option>`);	
		});
	}


	function disallowDocumentsByFrequency(frequency) {
		const LIMIT = {
			'TOR': 2,
			'DIPLOMA': 2,
			'GRADESLIP': 2,
			'CTC': 1 
		};

		if(frequency['TOR'] >= LIMIT['TOR']) disallowTOR();
		if(frequency['GRADESLIP'] >= LIMIT['GRADESLIP']) disallowGradeslip();
		if(frequency['DIPLOMA'] >= LIMIT['DIPLOMA']) disallowDiploma();
		if(frequency['CTC'] >= LIMIT['CTC']) disallowCTC();
	}

	function disallowTOR() {
		$('input[name="is-tor-included"]').prop('disabled', true);
		$('#tor-text').addClass('line-through');
	}

	function disallowDiploma() {
		$('input[name="is-diploma-included"]').prop('disabled', true);
		$('#diploma-text').addClass('line-through');
	}

	function disallowGradeslip() {
		$('input[name="is-gradeslip-included"]').prop('disabled', true);
		$('#gradeslip-text').addClass('line-through');
	}
	
	function disallowCTC() {
		$('input[name="is-ctc-included"]').prop('disabled', true);
		$('#ctc-text').addClass('line-through');
	}


});