$(document).ready(function() {

	/****************************************************************
	 * 																*
	 *							EVENTS								*
	 * 																*	
	 * **************************************************************/ 
	
	/**
	 * execute onclick event when user click the next button of step 1
	**/

	$('#account-details-nxt-btn').click(function() {
		const data = getAccountDetails();
		
		displayLoader();
		
		const validate = validateAccountDetails(data);	
			
		validate.done(function(result) {
			result = JSON.parse(result);
			if(isDataValid(result)) {
				hideFlashErrorMessage()
				setStep2ElementPropStates();	
			} else {
				displayFlashErrorMessage(result);
			}

			hideLoader();
		});

		validate.fail(function(jqXHR, textStatus) {
			displayFlashErrorMessage(`An error occured: ${textStatus}`);
			hideLoader();
		});
	});

	/**
	 * execute onclick event when user click the next button of step 2
	**/

	$('#personal-details-nxt-btn').click(function() {
		const data = getPersonalDetails();
		
		displayLoader();

		const validate = validatePersonalDetails(data);

		validate.done(function(result) {
			result = JSON.parse(result);
			if(isDataValid(result)) {
				hideFlashErrorMessage()
				setStep3ElementPropStates();	
			} else {
				displayFlashErrorMessage(result);
			}

			hideLoader();
		});

		validate.fail(function(jqXHR, textStatus) {
			displayFlashErrorMessage(`An error occured: ${textStatus}`);
			hideLoader();
		});
	});

	/**
	 * execute onchange event when user check the privacy consent checkbox
	**/

	$('input[name="consent"]').change(function() {
		if(this.checked) {
			enableRegistrationSubmitButton();
		} else {
			disableRegistrationSubmitButton();
		}
	});

	/**
	 * execute onclick event when user click the submit button
	**/

	$('input[type="submit"]').click(function() {
		if(!isConsentProvided()) {
			displayFlashErrorMessage('Your consent is needed to continue the registration.');
			return false;
		}
	});

	/**
	 * execute onclick event when user click the back button of step 3
	**/

	$('#privacy-consent-prev-btn').click(function() {
		hideFlashErrorMessage()
		setStep2ElementPropStates();
	});

	/**
	 * execute onclick event when user click the back button of step 2
	**/

	$('#personal-details-prev-btn').click(function() {
		hideFlashErrorMessage()
		setStep1ElementPropStates();
	});


	/****************************************************************
	 * 																*
	 *							FUNCTIONS							*
	 * 																*	
	 * **************************************************************/ 

	function getAccountDetails() {
		const data = {
			id: $('input[name="id"]').val(),
			email: $('input[name="email"]').val(),
			pass: $('input[name="password"]').val(),
			cpass: $('input[name="confirm-password"]').val(),
		};

		return data;
	}

	function getPersonalDetails() {
		const data = {
			lname: $('input[name="lastname"]').val(),
			fname: $('input[name="firstname"]').val(),
			mname: $('input[name="middlename"]').val(),
			gender: $('select[name="gender"]').find(':selected').val(),
			contact: $('input[name="contact"]').val(),
			location: $('select[name="location"]').find(':selected').val(),
			address: $('input[name="address"]').val(),
			type: $('select[name="type"]').find(':selected').val(),
			course: $('select[name="course"]').find(':selected').val(),
			year: $('select[name="year"]').find(':selected').val(),
			section: $('input[name="section"]').val(),
		};

		return data;
	}

	function displayFlashErrorMessage(message) {
		$('#flash-error').removeClass('hidden');
		$('#flash-error > #flash-message').text(message);	
	}

	function hideFlashErrorMessage() {
		$('#flash-error').addClass('hidden');			
	}

	function isDataValid(result) {
		return result.length == 0;
	}

	function validateAccountDetails(data) {
		return $.ajax({
		    url: "/qcu-ocad/home/register",
		    type: "POST",
		    data: {
		        id: data.id,
		        email: data.email,
		        pass: data.pass,
		        cpass: data.cpass,
		        partial: 'account'
		    }
		});
	}

	function validatePersonalDetails(data) {
		return $.ajax({
		    url: "/qcu-ocad/home/register",
		    type: "POST",
		    data: {
		        fname: data.fname,
		        mname: data.mname,
		        lname: data.lname,
		        gender: data.gender,
		        contact: data.contact,
		        location: data.location,
		        address: data.address,
		        course: data.course,
		        year: data.year,
		        section: data.section,
		        type: data.type,
		        partial: 'personal' 
		    }
		});
	}

	function displayLoader() {
		$('#loader').removeClass('hidden');
	}

	function hideLoader() {
		$('#loader').addClass('hidden');
	}

	function enableRegistrationSubmitButton() {
		return $('input[type="submit"]').prop('disabled', false);
	} 

	function disableRegistrationSubmitButton() {
		return $('input[type="submit"]').prop('disabled', true);
	}

	function isConsentProvided() {
		return $('input[name="consent"]').is(":checked");
	}

	/**
	 * add and remove classes provided by tailwind in the below elements based by student's progress in registration.
	 * step 1 to 3 
	**/

	function setStep1ElementPropStates() {
		$('#progress-bar').removeClass('progress-adult').removeClass('progress-old').addClass('progress-young');
		$('#step1-head').addClass('text-blue-700');
		$('#step1-text').addClass('text-blue-700');
		$('#step2-head').removeClass('text-blue-700').addClass('text-neutral-700');
		$('#step2-text').removeClass('text-blue-700').addClass('text-neutral-700');
		$('#step3-head').removeClass('text-blue-700').addClass('text-neutral-700');
		$('#step3-text').removeClass('text-blue-700').addClass('text-neutral-700');
		$('#account-details-container').removeClass('hidden');
		$('#personal-details-container').addClass('hidden');
		$('#privacy-consent-container').addClass('hidden');
	}

	function setStep2ElementPropStates() {
		$('#progress-bar').removeClass('progress-young').removeClass('progress-old').addClass('progress-adult');
		$('#step1-head').addClass('text-blue-700');
		$('#step1-text').addClass('text-blue-700');
		$('#step2-head').removeClass('text-neutral-700').addClass('text-blue-700');
		$('#step2-text').removeClass('text-neutral-700').addClass('text-blue-700');
		$('#step3-head').removeClass('text-blue-700').addClass('text-neutral-700');
		$('#step3-text').removeClass('text-blue-700').addClass('text-neutral-700');
		$('#account-details-container').addClass('hidden');
		$('#personal-details-container').removeClass('hidden');
		$('#privacy-consent-container').addClass('hidden');
	
	}

	function setStep3ElementPropStates() {
		$('#progress-bar').removeClass('progress-adult').removeClass('progress-young').addClass('progress-old');
		$('#step1-head').addClass('text-blue-700');
		$('#step1-text').addClass('text-blue-700');
		$('#step2-head').removeClass('text-neutral-700').addClass('text-blue-700');
		$('#step2-text').removeClass('text-neutral-700').addClass('text-blue-700');
		$('#step3-head').removeClass('text-neutral-700').addClass('text-blue-700');
		$('#step3-text').removeClass('text-neutral-700').addClass('text-blue-700');
		$('#account-details-container').addClass('hidden');
		$('#personal-details-container').addClass('hidden');
		$('#privacy-consent-container').removeClass('hidden');
	}
});