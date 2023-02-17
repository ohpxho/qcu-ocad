<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-3xl font-bold">Online Consultation #<?php echo $data['request-data']->id; ?></p>
		<p class="text-sm text-slate-500">Review and manage online consultation</p>
	</div>
	<div >
		<a class="flex gap-1" id="chat-btn" href="#">chat</a>
	</div>
</div>

<div class="flex flex-col mt-10 gap-2 pb-24">
	
	<?php
		require APPROOT.'/views/flash/fail.php';
		require APPROOT.'/views/flash/success.php';
	?>
</div>

<!-------------------------------------- chat panel ---------------------------------->

<div id="view-panel" class="fixed z-30 top-0 w-1/2 h-full bg-white card-box-shadow right-0 transition-all ease-in-out delay-250 overflow-y-scroll pt-9">
	<div class="flex gap-2">
		<a id="view-exit-btn" class="m-2 p-1 hover:bg-slate-100">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
				<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
			</svg>
		</a>
	</div>

	<div class="flex justify-center w-full h-max gap-2">
		<div class="flex flex-col w-10/12 pt-10 pb-20">
			<div class="flex flex-col gap2 w-full">
				<p class="text-2xl font-bold">Conversation</p>
				<p class="text-sm text-slate-500"></p>
			</div>

			<div id="chat-panel" class="border-2 border-slate-200 rounded-md w-full h-96 mt-2 bg-slate-100">
				
			</div>

			<div class="mt-5">
				<a class="rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer">Send</a>
			</div>
		</div>
	</div>
</div>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/consultation/view/student/student.js';
	?>
</script>



