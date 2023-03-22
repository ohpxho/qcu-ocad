$(document).ready(function() {
	const ID = <?php echo json_encode($_SESSION['id']) ?>;
	const alumni = <?php echo json_encode($data['alumni-details']); ?>;
	const availability = <?php echo json_encode($data['request-availability']); ?>;
	const input = <?php echo json_encode($data['input-details']); ?>

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
		setFormInputs(input);
	}

	function setFormInputs(details) {
		$('input[name="request-id"]').val(details['id']);
		$('input[name="student-id"]').val(alumni['id']);
		setTORInput(details);
		setDiplomaInput(details);
		setDismissalInput(details);
		setPurposeOfRequestInput(details['purpose_of_request']);
		setBeneficiaryInput(details);
	}

	function setTORInput(details) {
		const isTORIncluded = details['is_tor_included'];
		const lastAcademicYearAttended = details['tor_last_academic_year_attended'];

		if(isTORIncluded) $('input[name="is-tor-included"]').prop('checked', true).change();
		$('input[name="tor-last-academic-year-attended"]').val(lastAcademicYearAttended);
	}

	function setDiplomaInput(details) {
		const isDiplomaIncluded = details['is_diploma_included'];
		const yearGraduated = details['diploma_year_graduated'];

		if(isDiplomaIncluded) $('input[name="is-diploma-included"]').prop('checked', true).change();
		$('input[name="diploma-year-graduated"]').val(yearGraduated);
	}

	function setDismissalInput(details) {
		const isDismissalIncluded = details['is_honorable_dismissal_included'];

		if(isDismissalIncluded) $('input[name="is-honorable-dismissal-included"]').prop('checked', true).change();
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

	function disallowDocumentsWithOngoingRequest(hasOngoing) {	
		if(hasOngoing['TOR'] > 0 && !input['is_tor_included']) disallowTOR();
		if(hasOngoing['DIPLOMA'] > 0 && !input['is_diploma_included']) disallowDiploma();
		if(hasOngoing['HONORABLE_DISMISSAL'] > 0 && !input['is_honorable_dismissal_included']) disallowDismissal();
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