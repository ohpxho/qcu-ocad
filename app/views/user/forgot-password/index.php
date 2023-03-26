<?php 
require APPROOT.'/views/layout/header.php';
//require APPROOT.'/views/layout/horizontal-navigation/index.php';
?>
<main class="flex w-full h-full justify-center items-center mt-20 pb-20" role="main">
	<div class="w-1/4 max-w-sm flex flex-col justify-center items-center border rounded-md px-4 py-6">
		<!--<p class="text-4xl font-bold text-neutral-700">Log in</p>-->
		<div class="flex flex-col w-full items-center gap-2 pb-5">
			<a href="<?php echo URLROOT;?>/home"><img class="aspect-square h-20 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>
			
			<a href="<?php echo URLROOT;?>/home" >
				<div class="flex flex-col text-center">
					<span class="font-bold text-lg">QCU - OCAD</span>
					<span class="text-sm" >Online Consultation And Document Request</span>
				</div>
			</a>
		</div>

		<p class="text-center bg-slate-50 text-slate-500 p-2 w-full">Please type-in your registered University ID/Email</p>
		
		<?php
			require APPROOT.'/views/flash/success.php';
			require APPROOT.'/views/flash/fail.php';
		?>

		<form class="flex mt-5 w-full flex-col flex-1" action="<?php echo URLROOT ?>/user/forgot" method="POST">
			<div class="flex items-center">
				<input name="key" class="border w-full rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" placeholder="Enter ID or email" />
				<div class="absolute right-0 w-10 h-10 flex items-center justify-center">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
 						<path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
					</svg>
				</div>
				<p></p>
			</div>

			<div class="flex flex-col gap-2 mt-5">
				<input class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1 w-max" type="submit" value="Submit"/>
			</div>
		</form>
	</div>
</main>

<?php 
require APPROOT.'/views/layout/footer.php';
?>
