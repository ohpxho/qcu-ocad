$(document).ready(function() {
	
	tinymce.init({
	    selector: 'textarea[name="problem"]',
	    plugins: [
	      'checklist','lists'
	    ],
	    toolbar: 'bullist numlist checklist outdent indent',
	    menubar: false
  	});

	$(window).load(function() {
		const details = <?php echo json_encode($details); ?>;
		init(details);
	});

	$('select[name="department"]').change(function() {
  		const selected = $('select[name="department"] option:selected').val();
  		
  		if(selected != 'Guidance' && selected != 'Clinic' && selected != '') {
  			setSubjectCode(selected);
  			setProfessor(selected);
  			$('#subject-adviser-input-holder').removeClass('hidden');
  		} else {
  			$('#subject-adviser-input-holder').addClass('hidden');
  		}

  		$('select[name="subject"]').val('');
  		$('select[name="adviser-id"]').val('');
  	});

  	function setSubjectCode(dep) {
  		const code = getSubjectCodes(dep);

  		code.done(function(result) {
  			result = JSON.parse(result);
  			//alert(result);
  			updateSubjectCodeOptions(result);
  		});

  		code.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
  	}	

  	function setProfessor(dep) {
  		const code = getProfessors(dep);

  		code.done(function(result) {
  			result = JSON.parse(result);
  			//alert(result);
  			updateProfessorOptions(result);
  		});

  		code.fail(function(jqXHR, textStatus) {
  			alert(textStatus);
  		});
  	}	

  	function getSubjectCodes(dep) {
  		return $.ajax({
			url: '/qcu-ocad/consultation/get_subject_codes_by_department',
		    type: 'POST',
			data: {
				department: dep
			}
		});
  	}

  	function getProfessors(dep) {
  		return $.ajax({
			url: '/qcu-ocad/consultation/get_professors_by_department',
		    type: 'POST',
			data: {
				department: dep
			}
		});
  	}

  	function updateSubjectCodeOptions(codes) {
  		$('select[name="subject"]').empty();
  		$('select[name="subject"]').append(`<option value="">Choose Option</option>`);	
  		$.each(codes, function(index, item) {
  			$('select[name="subject"]').append(`<option value="${item.code}">${item.code}</option>`);	
  		});
  	}

  	function updateProfessorOptions(codes) {
  		$('select[name="adviser-id"]').empty();
  		$('select[name="adviser-id"]').append(`<option value="">Choose Option</option>`);	
  		$.each(codes, function(index, item) {
  			$('select[name="adviser-id"]').append(`<option value="${item.id}">${item.fname} ${item.lname}</option>`);	
  		});
  	}

	function init(details) {
		setRequestID(details.id);
		setPurpose(details.purpose);
		setProblem(details.problem);
		setDepartment(details.department);
		setSubject(details.subject);
		setAdviser(details.adviser_id);
		setPreferredDate(details.preferred_date_for_gmeet);
		setPreferredTime(details.preferred_time_for_gmeet);
		setSharedFile(details.shared_file_from_student);
	}

	function setRequestID(id) {
		$('input[name="request-id"]').val(id);
	}

	function setPurpose(purpose) {
		$('select[name="purpose"] option').each(function() {
			if($(this).val() == purpose) $(this).prop('selected', true);
		});
	}

	function setProblem(problem) {
		tinymce.activeEditor.setContent(problem);
	}

	function setDepartment(department) {
		$('select[name="department"] option').each(function() {
			if($(this).val() == department) $(this).prop('selected', true).change();
		});
	}

	function setSubject(code) {
		$('select[name="subject"] option').each(function() {
			if($(this).val() == code) $(this).prop('selected', true);
		});
	}

	function setAdviser(adviser) {
		$('select[name="adviser-id"] option').each(function() {
			if($(this).val() == adviser) $(this).prop('selected', true);
		});
	}

	function setPreferredDate(date) {
		$('input[name="preferred-date"]').val(date);
	}

	function setPreferredTime(time) {
		$('select[name="preferred-time"] option').each(function() {
			if($(this).val() == time) $(this).prop('selected', true);
		});
	}

	function setSharedFile(files) {
		files = files.trim();
		files = (files=='')? [] : files.split(',');
		
		elements = '';

		$.each(files, function(index, item) {
			element += `<a href="<?php echo URLROOT ?>${item}">${getFilenameFromPath(item)}</a>`;
		});

		if(elements != '') {
			$('#shared-file').html(elements);
		} else {
			$('#shared-file').html('<p class="text-slate-500">No shared file</p>');
		}
	}
});