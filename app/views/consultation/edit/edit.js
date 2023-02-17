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
			if($(this).val() == department) $(this).prop('selected', true);
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