$(document).ready(function() {
	const details = <?php echo json_encode($data['details']) ?>;

	$(window).load(function() {
		init();
	});

	function init() {
		$('input[name="id"]').val(details.id);
		$('input[name="old-id"]').val(details.id);
		$('input[name="email"]').val(details.email);
		$('input[name="lname"]').val(details.lname);
		$('input[name="fname"]').val(details.fname);
		$('input[name="mname"]').val(details.mname);
		$('select[name="gender"]').val(details.gender);
		$('input[name="contact"]').val(details.contact);
		$('select[name="location"]').val(details.location);
		$('input[name="address"]').val(details.address);
		$('select[name="type"]').val(details.type);
		$('select[name="course"]').val(details.course);
		$('select[name="year"]').val(details.year);
		$('input[name="section"]').val(details.section);
		$('select[name="type"]').val(details.type);
		$('#uploaded-identification').prop('href', `<?php echo URLROOT?>${details.identification}`);
		$('#uploaded-identification').text(getFilenameFromPath(details.identification));
		
		const remarks = (details.remarks != '' && details.remarks != null)? details.remarks : '...';
		$('#remarks').text(remarks);
	}

	$('#terminate-btn').click(function() {
		const confirmation = window.confirm('Are you sure, you want to terminate this application?');
		if(!confirmation) return false;
	});

});