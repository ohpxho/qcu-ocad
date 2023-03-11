$(document).ready(function() {

	showLoaderOuter();

	$(window).load(function() {
		redirectIfDataIsFound('PAGE_IN_INITIAL');
		hideLoaderOuter();

		 $('#profile-form input[name="year-graduated"]').datepicker({dateFormat: 'yy'});
	});

	$('#stud-id-btn').click(function() {
		showLoaderInner();

		const id = $('#id').val();

		if(id == '' || id == NaN) {
			alert('Please type in your Student ID');
			hideLoaderInner();
			return false;
		}
 
		const result = getAlumniById(id);

		result.done(function(result) {
			result = JSON.parse(result);

			if(result != false) {
				localStorage.setItem('alumni-student-id', result['id']);
				window.location.assign("<?php echo URLROOT.'/alumni/profile' ?>");
			} else {
				$('#id-form-con').addClass('hidden');
				$('#profile-form-con').removeClass('hidden');
				$('#profile-form input[name="id"]').val(id);
				setYearGraduatedOptions();
			}

			hideLoader();
		});

		result.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	});

	$('#profile-form').submit(function(e) {
		e.preventDefault();

		const add = addAlumni(new FormData(this));

		add.done(function(result) {
			result = JSON.parse(result);

			if(result == '') {
				alert('Form has been submitted');
				localStorage.setItem('alumni-student-id', result['id']);
				window.location.assign("<?php echo URLROOT.'/alumni/profile' ?>");
			} else {
				alert(result);
			}

		});

		add.fail(function(jqXHR, textStatus) {
			alert(textStatus);
		});
	});

	function setYearGraduatedOptions() {
		const START_YEAR = 1999;
		const years = getArrayOfYearsFromToCurrent(START_YEAR);

		$.each(years, function(index, item) {
			$('select[name="year-graduated"]').append(`<option value="${item}">${item}</option>`);
		});
	}

	function showLoaderInner() {
		$('#loader-inner').removeClass('hidden');
	}

	function hideLoaderInner() {
		$('#loader-inner').addClass('hidden');
	}

	function showLoaderOuter() {
		$('#loader-outer').removeClass('hidden');
	}

	function hideLoaderOuter() {
		$('#loader-outer').addClass('hidden');
	}
});