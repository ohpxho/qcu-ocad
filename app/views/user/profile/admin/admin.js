$(document).ready(function() {
	const account = <?php echo json_encode($data['account-details']) ?>;
	const admin = <?php echo json_encode($data['personal-details']) ?>;

	$(window).load(function() {
		init(account, admin);	
	});

	function init(account, admin) {
		setAccountDetails(account, admin);
		setAdminDetails(admin);
	}

	function setAccountDetails(account, admin) {
		$('input[name="id"]').val(account.id);
		$('input[name="email"]').val(account.email);

		if(account.pic != '' && account.pic != null) {
			$('#profile-pic-con').html(`<img class="h-full w-full object-cover" src="<?php echo URLROOT ?>${account.pic}" />`);
		} else {
			$('#profile-pic-con').html(`<div class='flex text-3xl items-center justify-center w-full rounded-sm h-full bg-slate-300 text-slate-700'>${admin.fname[0]}</div>`);
		}
	}

	function setAdminDetails(admin) {
		$('input[name="lname"]').val(admin.lname);
		$('input[name="fname"]').val(admin.fname);
		$('input[name="mname"]').val(admin.mname);
		$('input[name="department"]').val(admin.department);
		$('input[name="contact"]').val(admin.contact);
		$('select[name="gender"]').val(admin.gender);
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