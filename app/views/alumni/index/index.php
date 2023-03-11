<?php 

require APPROOT.'/views/layout/header.php';
require APPROOT.'/views/layout/horizontal-navigation/index.php';

?>

<div id="loader-outer" class="absolute h-full w-full top-0 left-0 flex flex-col gap-2 justify-center bg-white items-center z-50 hidden">
	<div class="w-8 h-8 bg-transparent border-4 rounded-full border-blue-700 mt-14 border-l-blue-200 animate-spin"></div>
	<p class="text-neutral-700 text-sm">checking local storage...</p>
</div>

<div class="flex justify-center w-full min-h-full pb-16">
	<div id="id-form-con" class="flex items-center justify-center w-full min-h-full">
		<div class="rounded-md flex w-1/2 flex-col gap-2 p-4">
			<div id="loader-inner" class="absolute h-full w-full top-0 left-0 flex flex-col gap-2 justify-center bg-white items-center z-50 hidden">
				<div class="w-8 h-8 bg-transparent border-4 rounded-full border-blue-700 mt-14 border-l-blue-200 animate-spin"></div>
				<p class="text-neutral-700 text-sm">checking records...</p>
			</div>

			<div class="flex flex-col">
				<span class="text-neutral-700 font-medium">Student ID</span>
				<input id="id" class="border rounded-sm bg-slate-100 focus:bg-white border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number"/>
			</div>
			
			<span class="text-sm text-neutral-500"> type in your registered university ID</span>

			<button class="flex bg-blue-700 text-white rounded-md mt-5 px-4 py-1 h-max cursor-pointer w-max" id="stud-id-btn" class="border">Submit</button>

			<span class="text-sm text-neutral-500"></span>
		</div>
	</div>

	<!------------------------------------ form --------------------------------------------->

	<div id="profile-form-con" class="w-1/2 mt-28 hidden">
		<form id="profile-form" method="POST" enctype="multipart/form-data">
			<div class="flex flex-col mt-4">
				<span class="text-neutral-700">Student ID</span>
				<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" name="id"/>
			</div>

			<div class="flex flex-col mt-5">
				<span class="text-neutral-700">Email</span>
				<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="email" name="email"/>
				<span class="text-sm mt-2 text-neutral-500"> use your google account email</span>
			</div>

			<div class="flex mt-4 gap-1">
				<div class="flex flex-col w-full">
					<span class="text-neutral-700">Lastname</span>
					<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="lastname"/>
				</div>

				<div class="flex flex-col w-full">
					<span class="text-neutral-700">Firstname</span>
					<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="firstname"/>
				</div>
			</div>

			<div class="flex flex-col mt-5">
				<span class="text-neutral-700">Middlename</span>
				<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="middlename"/>
				<span class="text-sm mt-2 text-neutral-500">leave this blank if none</span>
			</div>

			<div class="flex flex-col mt-5">
				<span class="text-neutral-700">Gender at Birth</span>
				<select class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700" name="gender">
					<option value="">Choose Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>

			<div class="flex flex-col mt-5">
				<span class="text-neutral-700">Contact No.</span>
				<input name="contact" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" />
				<span class="text-sm mt-2 text-neutral-500">should be an active number</span>
			</div>

			<div class="flex flex-col mt-5">
				<span class="text-neutral-700">Location of Residence</span>
				<select name="location" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
					<option value="">Choose Location</option>
					<option value="QC">QC</option>
					<option value="NON-QC">NON-QC</option>
				</select>
			</div>

			<div class="flex flex-col mt-5">
				<span class="text-neutral-700">Complete Present Address</span>
				<input name="address" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text"/>
			</div>

			<div class="flex mt-5 gap-1 items-center">
				<div class="flex flex-col w-full">
					<span class="text-neutral-700">Course</span>
					<select name="course" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2 text-neutral-700">
						<option value="">Choose Course</option>
						<option value="bsit">BSIT</option>
						<option value="bsentrep">BSEntrep</option>
						<option value="bsaccountancy">BSAccountancy</option>
						<option value="bsece">BSECE</option>
						<option value="bsie">BSIE</option>
					</select>
				</div>

				<div class="flex flex-col w-full">
					<span class="text-neutral-700">Section</span>
					<input name="section" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2"/>
				</div>
			</div>

			<div class="flex flex-col mt-4">
				<span class="text-neutral-700">Year Graduated</span>
				<select class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" name="year-graduated">
					<option value="">Choose option</option>
				</select>
			</div>

			<div class="flex flex-col mt-4">
				<span class="text-neutral-700">University ID / Last Registration Form</span>
				<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="file" name="identification"/>
			</div>

			<input class="flex bg-blue-700 text-white rounded-md mt-5 px-4 py-1 h-max cursor-pointer w-max" type="submit" value="Submit"/>
		</form>
	</div>
</div>

<?php 
	require APPROOT.'/views/layout/footer.php';
?>

<script>
	<?php require APPROOT.'/views/alumni/redirect.js'; ?>
	<?php require APPROOT.'/views/alumni/index/index.js'; ?>
</script>