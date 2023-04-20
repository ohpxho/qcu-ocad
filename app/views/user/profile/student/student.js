$(document).ready(function() {
	const account = <?php echo json_encode($data['account-details']) ?>;
	const student = <?php echo json_encode($data['personal-details']) ?>;

	$(window).load(function() {
		init(account, student);	
	});

	function init(account, student) {
		setAccountDetails(account, student);
		setStudentDetails(student);
	}

	function setAccountDetails(account, student) {
		$('input[name="id"]').val(account.id);
		$('input[name="email"]').val(account.email);

		if(account.pic != '' && account.pic != null) {
			$('#profile-pic-con').html(`<img class="h-full w-full object-cover" src="<?php echo URLROOT ?>${account.pic}" />`);
		} else {
			$('#profile-pic-con').html(`<div class='flex text-3xl items-center justify-center w-full rounded-sm h-full bg-slate-300 text-slate-700'>${student.fname[0]}</div>`);
		}
	}

	function setStudentDetails(student) {
		$('input[name="lname"]').val(student.lname);
		$('input[name="fname"]').val(student.fname);
		$('input[name="mname"]').val(student.mname);
		$('select[name="gender"]').val(student.gender);
		$('input[name="contact"]').val(student.contact);
		$('select[name="location"]').val(student.location);
		$('input[name="address"]').val(student.address);
		$('input[name="course"]').val(student.course.toUpperCase());
		$('input[name="section"]').val(student.section);
		$('input[name="year"]').val(student.year);
		$('input[name="type"]').val(student.type);

		$('#uploaded-identification').html(getFilenameFromPath(student.identification));
		$('#uploaded-identification').prop('href', `<?php echo URLROOT?>${student.identification}`);
	}

	$('input[name="profile-pic"]').change(function() {
		const [file] = this.files
		if (file) {
			$('#profile-pic-con').html(`<img class="h-full w-full object-cover" id="profile-pic" src="" />`);
			$('#profile-pic').prop('src', URL.createObjectURL(file));
		}
	});

	$('#change-pass-btn').click(function() {
		$('#change-pass-hidden input[name="old-pass"]').val('');
		$('#change-pass-hidden input[name="new-pass"]').val('');
		$('#change-pass-hidden input[name="confirm-new-pass"]').val('');
		$('#change-pass-hidden').toggleClass('show');
	});

	$('#change-identification-btn').click(function() {
		$('#identification-input-con input[name="identification"]').val('');
		$('#identification-input-con').toggleClass('show');
	});
});