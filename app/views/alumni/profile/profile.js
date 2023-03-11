$(document).ready(function() {
	const ID = localStorage.getItem('alumni-student-id');

	$(window).load(function() {
		redirectIfDataIsFound('PAGE_IN_MAIN');
		$('#records-link').prop('href', `${<?php echo json_encode(URLROOT)?>}/alumni/records/${ID}`);
		setLocalStorageKeys(ID);
		setYearGraduatedOptions();
		setProfile();
	});

	$('#profile-form').submit(function(e) {
		const result = confirm("Are you sure? You want to update this.");
        if(!result) {
            return false;
        } 

        const update = updateAlumniProfile(new FormData(this));

        update.done(function(result) {
        	result = JSON.parse(result);

        	if(result == '') {
        		alert('Profile has been updated');
        		setLocalStorageKeys(ID);
        		window.location.reload();
           	} else {
        		alert(result);
        	}
        });

        update.fail(function(jqXHR, textStatus) {
        	alert(textStatus);
        });

        return false;
	});

	$('#logout').click(function() {
		localStorage.clear();
		window.location.assign("<?php echo URLROOT.'/alumni/index' ?>");
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

	function setYearGraduatedOptions() {
		const START_YEAR = 1999;
		const years = getArrayOfYearsFromToCurrent(START_YEAR);

		$.each(years, function(index, item) {
			$('select[name="year-graduated"]').append(`<option value="${item}">${item}</option>`);
		});
	}

	function setProfile() {
		$('input[name="id"]').val(localStorage.getItem('alumni-student-id'));
		$('input[name="email"]').val(localStorage.getItem('alumni-email'));
		$('input[name="lname"]').val(localStorage.getItem('alumni-lname'));
		$('input[name="fname"]').val(localStorage.getItem('alumni-fname'));

		const mname = (localStorage.getItem('alumni-mname'))? localStorage.getItem('alumni-mname') : '';
		$('input[name="mname"]').val();
		$('select[name="gender"]').val(localStorage.getItem('alumni-gender'));
		$('input[name="contact"]').val(localStorage.getItem('alumni-contact'));
		$('input[name="location"]').val(localStorage.getItem('alumni-location'));
		$('select[name="course"]').val(localStorage.getItem('alumni-course'));
		$('input[name="section"]').val(localStorage.getItem('alumni-section'));
		$('input[name="address"]').val(localStorage.getItem('alumni-address'));
		$('select[name="year-graduated"]').val(localStorage.getItem('alumni-year-graduated'));
		
		const identification = localStorage.getItem('alumni-identification');
		$('#uploaded-identification').html(getFilenameFromPath(identification));
		$('#uploaded-identification').prop('href', `<?php echo URLROOT?>${identification}`);
	}

	$('#change-identification-btn').click(function() {
		$('#identification-input-con input[name="identification"]').val('');
		$('#identification-input-con').toggleClass('show');
	});
});