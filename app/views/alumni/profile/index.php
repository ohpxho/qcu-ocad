<?php 

require APPROOT.'/views/layout/header.php';
require APPROOT.'/views/layout/horizontal-navigation/index.php';

?>

<main class="flex w-full min-h-full pt-20">
	<div class="w-max min-h-full pt-12">
		<ul class="">
			<a href="<?php echo URLROOT; ?>/alumni/profile"><li class="bg-slate-200 text-center p-2 px-9">Profile</li></a>
			<a href="<?php echo URLROOT; ?>/alumni/new_request"><li class="hover:bg-slate-200 text-center p-2 px-12">Request</li></a>
			<a id="records-link" href="#"><li class="hover:bg-slate-200 text-center p-2 px-12">Records</li></a>
			<a href="#" id="logout">
				<li class="flex items-center text-red-700 text-center p-2 px-9 justify-center ">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
 						<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
					</svg>
				</li>
			</a>
		</ul>
	</div>

	<div class="h-max w-full p-8 px-20 pt-12 pb-20">
		<div class="flex flex-col">
			<p class="text-2xl font-bold">Profile</p>
			<p class="text-sm text-slate-500">Review and manage your student information</p>
		</div>

		<?php
			require APPROOT.'/views/flash/fail.php';
			require APPROOT.'/views/flash/success.php';
		?>
		<form id="profile-form" action="<?php echo URLROOT ?>/alumni/profile" method="POST" enctype="multipart/form-data">
			<div class="w-2/3">
				<div class="flex flex-col mt-3 gap-1">
					<div class="flex flex-col gap-1 w-full">
						<p class="">University ID<span class="text-sm font-normal"> (required)</span></p>
					</div>
					<input type="text" name="id" value="" class="border rouded-md bg-slate-100 border-slate-300 px-2 py-0.5 outline-1 outline-blue-500 cursor-not-allowed text-neutral-700" readonly>
					<p class="text-sm text-slate-500"></p>
				</div>

				<div class="flex flex-col mt-3 gap-1">
					<div class="flex flex-col gap-1 w-full">
						<p class="">Email<span class="text-sm font-normal"> (required)</span></p>
					</div>
					<input type="email" name="email" value="" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 px-2 py-0.5 outline-1 outline-blue-500 text-neutral-700">
					<p class="text-sm text-slate-500">You have to set an active email address. Email registered here will be used for notification and other stuff within the application</p>
				</div>

				<div class="flex gap-1 items-center mt-3">
					<div class="w-1/2 flex flex-col gap-1">
						<div class="flex flex-col gap-1 w-full">
							<p class="">Lastname<span class="text-sm font-normal"> (required)</span></p>
						</div>
						<input type="text" name="lname" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
					</div>

					<div class="w-1/2 flex flex-col gap-1">
						<div class="flex flex-col gap-1 w-full">
							<p class="">Firstname<span class="text-sm font-normal"> (required)</span></p>
						</div>
						<input type="text" name="fname" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
					</div>
				</div>

				<div class="flex flex-col gap-1 mt-3">
					<div class="flex flex-col gap-1 w-full">
						<p class="">Middlename<span class="text-sm font-normal"></span></p>
					</div>
					<input type="text" name="mname" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
				</div>

				<div class="flex flex-col gap-1 mt-3">
					<div class="flex flex-col gap-1 w-full">
						<p class="">Gender<span class="text-sm font-normal"> (required)</span></p>
					</div>
					<select name="gender" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</div>
				
				<div class="flex flex-col gap-1 mt-3">
					<div class="flex flex-col gap-1 w-full">
						<p class="">Contact no.<span class="text-sm font-normal"> (required)</span></p>
					</div>
					<input type="number" name="contact" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
					<p class="text-sm text-slate-500">You have to set an active contact number. Contact number registered here will be used for notifications from the application</p>
				</div>

				<div class="flex flex-col gap-1 mt-3">
					<div class="flex flex-col gap-1 w-full">
						<p class="">Location of residence<span class="text-sm font-normal"> (required)</span></p>
					</div>
					<select name="location" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
						<option value="QC">QC</option>
						<option value="NON-QC">NON-QC</option>
					</select>
				</div>

				<div class="flex flex-col gap-1 mt-3">
					<div class="flex flex-col gap-1 w-full">
						<p class="">Complete address<span class="text-sm font-normal"> (required)</span></p>
					</div>
					<input name="address" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700" type="text"/>
				</div>

				<div class="flex flex-col gap-1 mt-3">
					<div class="flex flex-col gap-1 w-full">
						<p>Course<span class="text-sm font-normal"> (required)</span></p>
						<select name="course" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
							<option value="bsit">BSIT</option>
							<option value="bsentrep">BSEntrep</option>
							<option value="bsaccountancy">BSAccountancy</option>
							<option value="bsece">BSECE</option>
							<option value="bsie">BSIE</option>
						</select>
					</div>
				</div>

				<div class="flex gap-1 items-start mt-3">
					<div class="w-1/2 flex flex-col gap-1">
						<div class="flex flex-col gap-1 w-full">
							<p class="">Section<span class="text-sm font-normal"> (required)</span></p>
						</div>
						<input type="text" name="section" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700">
						<p class="text-sm text-slate-500">e.g 4L, 1B, 3C</p>
					</div>

					<div class="w-1/2 flex flex-col gap-1">
						<div class="flex flex-col gap-1 w-full">
							<p class="">Year graduated<span class="text-sm font-normal"> (required)</span></p>
						</div>
						<select name="year-graduated" class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700"></select>
					</div>
				</div>

				<div class="flex flex-col gap-1 mt-3">
					<div class="flex flex-col gap-1 w-full">
						<p>University Id / Latest registration form<span class="text-sm font-normal"> (required)</span></p>
						<div id="identification-input-con" class="flex flex-col gap-1 w-full hidden">
							<input class="focus:bg-white border rouded-md bg-slate-100 border-slate-300 py-0.5 px-2 outline-1 outline-blue-500 text-neutral-700" type="file" name="identification" accept="image/*" />
						</div>
					</div>
					<p class="text-sm text-slate-500">clear photo of your registered Id or latest registration form</p>
					
					<a id="uploaded-identification" href="#" class="text-blue-700 hover:underline py-1 w-full">-------</a>
					<a id="change-identification-btn" class="w-max text-white bg-red-500 py-0.5 px-5 rounded-md cursor-pointer">Update identification</a>
				</div>

				<p class="text-sm text-slate-500 mt-5">Make sure that all of the information included here are factual. And by filling them out, your're giving us(admins) consent and rights to use these data from any transactions that is exclusive in QCU university.</p>
			</div>
			<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-0.5 rounded-md cursor-pointer" type="submit" value="Update profile"/>
		</form>
	</div>
</main>

<!------------------------------------ script ------------------------------------>
<script>
	<?php require APPROOT.'/views/alumni/redirect.js'; ?>
	<?php require APPROOT.'/views/alumni/profile/profile.js'; ?>
</script>