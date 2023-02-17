$(document).ready(function() {

	$(window).load(function() {
		const frequency = <?php echo json_encode($frequency[0]); ?>;
		disallowDocumentsByFrequency(frequency);
	});

	/**
 	* onchange event of TOR, display hidden input
	**/

	$('input[name="is-tor-included"]').change(function() {
		if(this.checked) {
			$('#tor-hidden-input').removeClass('hidden');
		} else {
			$('#tor-hidden-input').addClass('hidden');
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
		}
	});

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