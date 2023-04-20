$(document).ready(function() {
	const inputs = <?php echo json_encode($data['input-details']) ?>;

	$(window).load(function() {
		setPass();
		setInputDetails(inputs);
	});

	function setInputDetails(details) {
		if(details.id) $('input[name="id"]').val(details.id);
		if(details.email) $('input[name="email"]').val(details.email);
		if(details.pass) $('input[name="pass"]').val(details.pass);
		if(details.lname) $('input[name="lname"]').val(details.lname);
		if(details.fname) $('input[name="fname"]').val(details.fname);
		if(details.mname) $('input[name="mname"]').val(details.mname);
		if(details.gender) $('select[name="gender"]').val(details.gender);
		if(details.contact) $('input[name="contact"]').val(details.contact);
		if(details.location) $('select[name="location"]').val(details.location);
		if(details.address) $('input[name="address"]').val(details.address);
		if(details.course) $('select[name="course"]').val(details.course);
		if(details.section) $('input[name="section"]').val(details.section);
		if(details.year) $('select[name="year"]').val(details.year);
		if(details['type-of-student']) $('select[name="type-of-student"]').val(details['type-of-student']);
	}

	function setPass() {
		const pass = generateRandomPassword();
		$('input[name="pass"]').val(pass);
	}	

});