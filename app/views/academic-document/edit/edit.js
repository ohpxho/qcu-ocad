$(document).ready(function() {

	$(window).load(function() {
		const details = <?php echo json_encode($details); ?>;
		const frequency = <?php echo json_encode($frequency[0]); ?>;
		disallowDocumentsByFrequency(frequency);
		init(details);
	});

	/**
 	* onchange event of TOR, display hidden input
	**/

	$('input[name="is-tor-included"]').change(function() {
		if(this.checked) {
			$('#tor-hidden-input').removeClass('hidden');
		} else {
			$('#tor-hidden-input').addClass('hidden');
			$('select[name="tor-last-academic-year-attended"] option[value=""]').prop('selected', true);
		}
	});

	/**
 	* onchange event of Diploma, display hidden input
	**/

	$('input[name="is-diploma-included"]').change(function() {
		if(this.checked) {
			$('#diploma-hidden-input').removeClass('hidden');
		} else {
			$('#diploma-hidden-input').addClass('hidden');
			$('select[name="diploma-year-graduated"] option[value=""]').prop('selected', true)
		}
	});

	/**
 	* onchange event of Gradeslip, display hidden input
	**/

	$('input[name="is-gradeslip-included"]').change(function() {
		if(this.checked) {
			$('#gradeslip-hidden-input').removeClass('hidden');
		} else {
			$('#gradeslip-hidden-input').addClass('hidden');
			$('select[name="gradeslip-academic-year"] option[value=""]').prop('selected', true);
			$('select[name="gradeslip-semester"] option[value=""]').prop('selected', true);
		}
	});

	/**
 	* onchange event of CTC, display hidden input
	**/

	$('input[name="is-ctc-included"]').change(function() {
		if(this.checked) {
			$('#ctc-hidden-input').removeClass('hidden');
		} else {
			$('#ctc-hidden-input').addClass('hidden');
			$('input[name="ctc-document"]').val('');
		}
	});

	/**
 	* onchange event of Other, display hidden input
	**/

	$('input[name="is-other-document-included"]').change(function() {
		if(this.checked) {
			$('#other-requested-document-hidden-input').removeClass('hidden');
		} else {
			$('#other-requested-document-hidden-input').addClass('hidden');
			$('input[name="other-requested-document"]').val('');
		}
	});

	/**
 	* onchange event of Other, display hidden input
	**/

	$('select[name="is-RA11261-beneficiary"]').change(function() {
		if(this.value == 'yes') {
			$('#RA11261-beneficiary-hidden-input').removeClass('hidden');
		} else {
			$('#RA11261-beneficiary-hidden-input').addClass('hidden');
			$('input[name="barangay-certificate"]').val('');
			$('input[name="oath-of-undertaking"]').val('');
		}
	});

	function init(details) {
		setTORInput(details);
		setDiplomaInput(details);
		setGradeslipInput(details);
		setCTCInput(details);
		setOthersInput(details);
		setBeneficiaryInput(details);
	}

	function setTORInput(details) {
		if(details['is_tor_included']) {
			$('input[name="is-tor-included"]').prop('disabled', false).prop('checked', true);
			$('#tor-text').removeClass('line-through');
			$('#tor-hidden-input').removeClass('hidden');
			$('select[name="tor-last-academic-year-attended"] option').each(function() {
				if(this.value == details['tor_last_academic_year_attended']) {
					$(this).prop('selected', true);
				}
			});
		}
	}

	function setDiplomaInput(details) {
		if(details['is_diploma_included']) {
			$('input[name="is-diploma-included"]').prop('disabled', false).prop('checked', true);
			$('#diploma-text').removeClass('line-through');
			$('#diploma-hidden-input').removeClass('hidden');
			$('select[name="diploma-year-graduated"] option').each(function() {
				if(this.value == details['diploma_year_graduated']) {
					$(this).prop('selected', true);
				}
			});
		}
	}

	function setGradeslipInput(details) {
		if(details['is_gradeslip_included']) {
			$('input[name="is-gradeslip-included"]').prop('disabled', false).prop('checked', true);
			$('#gradeslip-text').removeClass('line-through');
			$('#gradeslip-hidden-input').removeClass('hidden');
			$('select[name="gradeslip-academic-year"] option').each(function() {
				if(this.value == details['gradeslip_academic_year']) {
					$(this).prop('selected', true);
				}
			});

			$('select[name="gradeslip-semester"] option').each(function() {
				if(this.value == details['gradeslip_semester']) {
					$(this).prop('selected', true);
				}
			});
		}
	}

	function setCTCInput(details) {
		if(details['is_ctc_included']) {
			$('input[name="is-ctc-included"]').prop('disabled', false).prop('checked', true);
			$('#ctc-text').removeClass('line-through');
			$('#ctc-hidden-input').removeClass('hidden');
			if(details['ctc_document'] != '') {
				$('#ctc-hidden-input > div').removeClass('hidden');
				$('#ctc-hidden-input > div > a').prop('href', '<?php echo URLROOT.$details->ctc_document; ?>');
				$('#ctc-hidden-input > div > a').text(getFilenameFromPath(details['ctc_document']));	
			}
		}
	}

	function setOthersInput(details) {
		if(details['other_requested_document'] != '') {
			$('input[name="is-other-document-included"]').prop('checked', true);
			$('#other-requested-document-hidden-input').removeClass('hidden');
			$('input[name="other-requested-document"]').val(details['other_requested_document']);
		}
	}


	function setBeneficiaryInput(details) {
		if(details['is_RA11261_beneficiary'] == 'yes') {
			$('select[name="is-RA11261-beneficiary"] option[value="yes"]').prop('selected', true);
			$('#beneficiary-hidden-input').removeClass('hidden');
			if(details['barangay_certificate'] != '' && details['oath_of_undertaking'] != '') {
				$('#beneficiary-hidden-input > div').removeClass('hidden');
				$('#uploaded-barangay-certificate').prop('href', '<?php echo URLROOT.$details->barangay_certificate; ?>');
				$('#uploaded-barangay-certificate').text(getFilenameFromPath(details['barangay_certificate']));	
				$('#uploaded-.oath_of_undertaking').prop('href', '<?php echo URLROOT.$details->oath_of_undertaking; ?>');
				$('#uploaded-oath-of-undertaking').text(getFilenameFromPath(details['oath_of_undertaking']));	
			}
		} else {
			$('select[name="is-RA11261-beneficiary"] option[value="no"]').prop('selected', true);
			$('#beneficiary-hidden-input').addClass('hidden');
		}
	}

	function getFilenameFromPath(path) {
		path = path.split('/');
		return path[path.length-1];
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
