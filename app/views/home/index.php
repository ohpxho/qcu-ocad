<?php 
	require APPROOT.'/views/layout/header.php';
	//require APPROOT.'/views/layout/horizontal-navigation/index.php';
?>

<main class="flex flex-col w-full bg-neutral-100 justify-center items-center pb-20" role="main">
	<div class="fixed w-full h-full top-0 left-0 flex justify-center items-center">
		<!-- <img src="https://qcu.edu.ph/wp-content/uploads/2021/10/QCU-BUILDING-1024x683-1.jpg" class="w-full opacity-10 aspect-video object-cover"> -->
		<video class="block opacity-10 aspect-video w-full p-0 m-0" poster="https://qcu.edu.ph/wp-content/uploads/2021/10/QCU-BUILDING-1024x683-1.jpg" playsinline="" autoplay="" muted="" loop="" src="https://qcu.edu.ph/wp-content/uploads/2021/10/qcuend3.mp4"></video>
	</div>

	<div class="w-1/4 max-w-sm flex flex-col justify-center top-0 items-center bg-white border rounded-md px-4 py-6 mt-5">
		<!--<p class="text-4xl font-bold text-neutral-700">Log in</p>-->
		<div class="flex flex-col w-full items-center gap-2 pb-5">
			<a href="<?php echo URLROOT;?>/home"><img class="logo aspect-square h-20 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>
			
			<a href="<?php echo URLROOT;?>/home" >
				<div class="flex flex-col text-center mt-5">
					<span class="font-bold text-lg">QUEZON CITY UNIVERSITY</span>
					<span class="text-sm" >Online Consultation And Document Request</span>
				</div>
			</a>
		</div>

		<p class="text-center bg-slate-50 text-slate-500 p-2">Please sign-in using your registered University ID/Email and Password</p>
		
		<?php
			require APPROOT.'/views/flash/success.php';
			require APPROOT.'/views/flash/fail.php';
		?>

		<form class="flex mt-5 w-full flex-col flex-1" action="<?php echo URLROOT; ?>/home/login" method="POST">
			<div class="flex items-center">
				<input name="id" class="border w-full rounded-sm  py-1 px-2 outline-2 outline-cyan-400 outline-blue-500" type="number" placeholder="Enter ID or email" />
				<div class="absolute right-0 w-10 h-10 flex items-center justify-center">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
 						<path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
					</svg>
				</div>
			</div>

			<div class="flex flex-col mt-3">
				<div class="flex items-center mt-">
					<input name="password" class="border w-full rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="password" placeholder="Enter password" />
					<div class="absolute right-0 w-10 h-10 flex items-center justify-center">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
							<path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
						</svg>
					</div>
				</div>
			</div>

			<a href="<?php echo URLROOT?>/user/forgot" class="flex w-full items-end justify-end text-blue-700 cursor-pointer text-neutral-700 mt-2 text-sm">forgot password?</a>
			
			<div class="flex flex-col gap-2 mt-5">
				<input class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1 w-max" type="submit" value="Sign In"/>
			</div>
		</form>
	</div>

	<div class="w-1/4 max-w-sm flex flex-col bg-white rounded-md text-sm px-4 py-6 mt-5">
		<p>This website is only for registered students, teachers, department staffs, and alumnis of Quezon City University.</p>
	</div>

	<div class="flex gap-2 mt-5">
		<div class="w-10 rounded-full aspect-square">
			<img src="https://i0.wp.com/qcu.edu.ph/wp-content/uploads/2021/11/eNTREP.png?resize=395%2C350&ssl=1" class="w-full h-full"/>
		</div>

		<div class="w-10 rounded-full aspect-square">
			<img src="https://i0.wp.com/qcu.edu.ph/wp-content/uploads/2021/11/bsa-1024x1024-1.png?resize=1024%2C1024&ssl=1" class="w-full h-full"/>
		</div>

		<div class="w-10 rounded-full aspect-square">
			<img src="https://i0.wp.com/qcu.edu.ph/wp-content/uploads/2022/07/College-of-Education-Logo.png?resize=193%2C192&ssl=1" class="w-full h-full"/>
		</div>

		<div class="w-10 rounded-full aspect-square">
			<img src="https://i0.wp.com/qcu.edu.ph/wp-content/uploads/2021/11/ie.png?resize=259%2C195&ssl=1" class="w-full h-full"/>
		</div>

		<div class="w-10 rounded-full aspect-square">
			<img src="https://i0.wp.com/qcu.edu.ph/wp-content/uploads/2021/11/bsece-1.png?resize=473%2C473&ssl=1" class="w-full h-full"/>
		</div>

		<div class="w-10 rounded-full aspect-square">
			<img src="https://i0.wp.com/qcu.edu.ph/wp-content/uploads/2021/11/bsitlogo.png?resize=248%2C265&ssl=1" class="w-full h-full"/>
		</div>
	</div>
</main>

<?php 
	require APPROOT.'/views/layout/footer.php';
?>