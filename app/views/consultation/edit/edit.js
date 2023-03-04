$(document).ready(function() {
	let details = {};

	tinymce.init({
	    selector: 'textarea[name="problem"]',
	    plugins: [
	      'checklist','lists'
	    ],
	    toolbar: 'bullist numlist checklist outdent indent',
	    menubar: false
  	});

	$(window).load(function() {
		details = <?php echo json_encode($details); ?>;
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

  	$('#shared-doc-list').on('click', '.remove-document-btn', function() {
		const filename = $(this).prev().find('.file-name').text();
		const existing = removeExistingDoc(filename, details.shared_file_from_student);
		$('input[name="existing-documents"]').val(existing);
		setSharedDoc(existing);
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
			},
			async: false
		});
  	}

  	function getProfessors(dep) {
  		return $.ajax({
			url: '/qcu-ocad/consultation/get_professors_by_department',
		    type: 'POST',
			data: {
				department: dep
			},
			async: false
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
		setSharedDoc(details.shared_file_from_student);
		setExistingDoc(details.shared_file_from_student);
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
		problem = problem.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
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

	function setSharedDoc(documents) {
		$('#shared-doc-list').empty()
		
		if(documents == null || documents.length == 0 ) {
			$('#shared-doc').text('No shared documents');
		} else {
			const docs = documents.split(',');
			$('#shared-doc').text(`${docs.length} document/s`);
			$.each(docs, function(index, item) {
				const icon = getIconOfFileExtension(getFileExtension(item));
				$('#shared-doc-list').append(
					`<div class="flex items-center w-full group">
						<a class="w-full" target="_blank" href="<?php echo URLROOT; ?>${item}" >
							<li class="filename-li hover:bg-slate-100 p-1 flex gap-2 items-center border-b w-full">
								<img class="h-7 w-7" src="<?php echo URLROOT?>/public/assets/img/${icon}"/>
								<span class="file-name">${getFilenameFromPath(item)}</span>
							</li>
							<a class="remove-document-btn absolute z-30 cursor-pointer text-red-500 right-0 px-3 group-hover:flex">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
								  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
								</svg>
							</a>
						</a>
					</div>`);
			});
		}
	}

	function setExistingDoc(documents) {
		$('input[name="existing-documents"]').val(documents);
	}

	function removeExistingDoc(doc) {
		let existing = $('input[name="existing-documents"]').val();
		existing = existing.split(',');
		
		$.each(existing, function(index, item) {
			const filename = getFilenameFromPath(item);

			if(filename == doc) {
				existing.splice(index, 1);
				return false;	
			}
		});

		return existing.join(',');
	}
});