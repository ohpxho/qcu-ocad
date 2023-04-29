<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Profile</p>
		<p class="text-sm text-slate-500">Review and manage your profile details</p>
	</div>
</div>

<div class="flex flex-col mt-3 gap-2 pb-24">
	<?php
		require APPROOT.'/views/flash/fail.php';
		require APPROOT.'/views/flash/success.php';
	?>
	<div class="flex gap-1">
		<form method="POST" class="flex gap-1" enctype="multipart/form-data" action="<?php echo URLROOT;?>/user/profile/update/account_details" class="w-full h-max">
			<div class="flex gap-1 w-1/2">
				<div class="flex flex-col mt-3">
					<p class="text-lg font-medium">Account Details</p>
					<div class="flex flex-col mt-3 gap-1">
						<div class="flex flex-col gap-1 w-full">
							<p class="">ID<span class="text-sm font-normal"> (required)</span></p>
						</div>
						<input type="text" name="id" value="" class="border rouded-md bg-slate-100 border-slate-300 px-2 py-0.5 outline-1 cursor-not-allowed outline-blue-500 text-neutral-700" readonly>
					</div>

					<div class="flex flex-col mt-3 gap-1">
						<div class="flex flex-col gap-1 w-full">
							<p class="">Email<span class="text-sm font-normal"> (required)</span></p>
						</div>
						<input type="email" name="email" value="" class="focus:bg-white border cursor-not-allowed rouded-md bg-slate-100 border-slate-300 px-2 py-0.5 outline-1 outline-blue-500 text-neutral-700" readonly>
						<p class="text-sm text-slate-500">This should be active email address. If not, contact an admin to update this. Email registered here will be used for notifications from the application</p>
					</div>

					<a id="change-pass-btn" class="w-max text-white bg-red-500 py-0.5 px-5 mt-5 rounded-md cursor-pointer">Change password</a>

					<div id="change-pass-hidden" class="flex flex-col mt-3 gap-1 hidden">
						<p class="text-sm text-slate-500">Password should be atleast 8 characters long. Alphanumeric</p>
						<input type="hidden" name="change-pass-flag" value=""/>
						<div class="flex flex-col mt-3 gap-1">
							<div class="flex flex-col gap-1 w-full">
								<p class="">Old password<span class="text-sm font-normal"> (required)</span></p>
							</div>
							<input type="password" name="old-pass" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
						</div>

						<div class="flex flex-col mt-3 gap-1">
							<div class="flex flex-col gap-1 w-full">
								<p class="">New password<span class="text-sm font-normal"> (required)</span></p>
							</div>
							<input type="password" name="new-pass" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
						</div>

						<div class="flex flex-col mt-3 gap-1">
							<div class="flex flex-col gap-1 w-full">
								<p class="">Confirm new password<span class="text-sm font-normal"> (required)</span></p>
							</div>
							<input type="password" name="confirm-new-pass" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
						</div>
					</div>

					<input class="text-white bg-blue-700 py-0.5 px-5 mt-5 rounded-md w-max" type="submit" value="Update account details"/>
				</div>
			</div>

			<div class="flex flex-col gap-2 w-1/2 pl-12 pt-20">
				<div id="profile-pic-con" class="h-32 w-32 rounded-md overflow-hidden">
					
				</div>
				<div class="mt-3">
					<label class=" bg-gray-200 py-1 text-neutral-700 border border-gray-300 px-5 cursor-pointer mt-5 rounded-md w-max" for="profile-pic-input">Change profile picture</label>
					<input class="hidden" id="profile-pic-input" name="profile-pic" type="file" accept="image/*"/>
				</div>
			</div>
		</form>
	</div>

	<form method="POST" action="<?php echo URLROOT; ?>/user/profile/update/personal_details" >
		<input type="hidden" name="id"/>

		<div class="w-7/12 mt-5">
			<p class="text-lg font-medium">Professor Details</p>

			<div class="flex gap-1 items-center mt-3">
				<div class="w-1/2 flex flex-col gap-1">
					<div class="flex flex-col gap-1 w-full">
						<p class="">Lastname<span class="text-sm font-normal"> (required)</span></p>
					</div>
					<input type="text" name="lname" class="focus:bg-white cursor-not-allowed border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700" readonly>
				</div>

				<div class="w-1/2 flex flex-col gap-1">
					<div class="flex flex-col gap-1 w-full">
						<p class="">Firstname<span class="text-sm font-normal"> (required)</span></p>
					</div>
					<input type="text" name="fname" class="focus:bg-white cursor-not-allowed border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700" readonly>
				</div>
			</div>

			<div class="flex flex-col gap-1 mt-3">
				<div class="flex flex-col gap-1 w-full">
					<p class="">Middlename<span class="text-sm font-normal"></span></p>
				</div>
				<input type="text" name="mname" class="focus:bg-white border cursor-not-allowed rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700" readonly>
			</div>

			<div class="flex flex-col gap-1 mt-3">
				<div class="flex flex-col gap-1 w-full">
					<p class="">Department<span class="text-sm font-normal"> (required)</span></p>
				</div>
				<input type="text" name="department" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 cursor-not-allowed text-neutral-700" readonly>
			</div>
			
			<div class="flex flex-col gap-1 mt-3">
				<div class="flex flex-col gap-1 w-full">
					<p class="">Contact no.<span class="text-sm font-normal"> (required)</span></p>
				</div>
				<input type="number" name="contact" class="focus:bg-white border cursor-not-allowed rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700" readonly>
				<p class="text-sm text-slate-500">This should be active contact number. If not, contact an admin to update this. Contact number registered here will be used for notifications from the application</p>
			</div>

			<div class="flex flex-col gap-1 mt-3">
				<div class="flex flex-col gap-1 w-full">
					<p class="">Gender<span class="text-sm font-normal"> (required)</span></p>
				</div>
				<input type="text" name="gender" class="focus:bg-white border cursor-not-allowed rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700" readonly>
			</div>

			<!-- <p class="text-sm text-slate-500 mt-5">Make sure that all of the information included here are factual.</p>
			<input class="text-white bg-blue-700 py-0.5 px-5 mt-3 rounded-md w-max" type="submit" value="Update admin details"/> -->
		</div>
	</form>
</div>

<script>
	<?php
		require APPROOT.'/views/user/profile/professor/professor.js';
	?>
</script>
