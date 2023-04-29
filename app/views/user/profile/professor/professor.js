$(document).ready(function() {
	const account = <?php echo json_encode($data['account-details']) ?>;
	const professor = <?php echo json_encode($data['personal-details']) ?>;

	$(window).load(function() {
		init(account, professor);	
	});

	function init(account, professor) {
		setAccountDetails(account, professor);
		setAdminDetails(professor);
	}

	function setAccountDetails(account, professor) {
		$('input[name="id"]').val(account.id);
		$('input[name="email"]').val(account.email);

		if(account.pic != '' && account.pic != null) {
			$('#profile-pic-con').html(`<img class="h-full w-full object-cover" src="<?php echo URLROOT ?>${account.pic}" />`);
		} else {
			$('#profile-pic-con').html(`<div class='flex text-3xl items-center justify-center w-full rounded-sm h-full bg-slate-300 text-slate-700'>${professor.fname[0]}</div>`);
		}
	}

	function setAdminDetails(professor) {
		$('input[name="lname"]').val(professor.lname);
		$('input[name="fname"]').val(professor.fname);
		$('input[name="mname"]').val(professor.mname);
		$('input[name="department"]').val(professor.department);
		$('input[name="contact"]').val(professor.contact);
		$('input[name="gender"]').val(professor.gender);
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

});