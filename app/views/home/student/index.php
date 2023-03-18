<?php 
require APPROOT.'/views/layout/header.php';
//require APPROOT.'/views/layout/horizontal-navigation/index.php';
?>
<main class="flex w-full h-full justify-center items-center mt-20 pb-20" role="main">
	<div class="w-1/4 max-w-sm h-1/2 flex flex-col justify-center items-center">
		<!--<p class="text-4xl font-bold text-neutral-700">Log in</p>-->
		<div class="flex flex-col w-full items-center gap-2 pb-5">
			<a href="<?php echo URLROOT;?>/home"><img class="aspect-square h-20 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>
			
			<a href="<?php echo URLROOT;?>/home" >
				<div class="flex flex-col text-center gap-2">
					<span class="font-medium text-xl">QUEZON CITY UNIVERSITY</span>
					<span >Online Consultation And Document Request</span>
				</div>
			</a>
		</div>
		
		<?php
			require APPROOT.'/views/includes/loader.registration.php';
			require APPROOT.'/views/flash/success.php';
			require APPROOT.'/views/flash/fail.php';
		?>

		<form class="flex w-full flex-col flex-1" action="<?php echo URLROOT; ?>/home/index" method="POST">
			<div class="flex flex-col mt-5">
				<span class="text-neutral-700">ID or Email Address</span>
				<input name="id" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500 mt-2" type="text" />
			</div>

			<div class="flex flex-col mt-3">
				<span class="text-neutral-700">Password</span>
				<input name="password" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500 mt-2" type="password" />
			</div>
			
			
			<input class="border mt-5 rounded-sm border-blue-300 bg-blue-100 text-blue-700 border w-full p-1 cursor-pointer" type="submit" value="Log in"/>
			
		</form>
		<a class="cursor-pointer mt-5 underline text-neutral-700">forgot password?</a>
		
		<a href="<?php echo URLROOT?>/home/register" class="border mt-5 border-red-300 rounded-sm bg-red-100 text-red-700 border w-full p-1 cursor-pointer text-center">Create account</a>
		<p class="mt-5 text-sm text-neutral-500">This website is only for registered students, professors, department staffs, and alumnis. The students shall need to create an account first before having the rights to use the services.</p>
	</div>
</main>

<?php 
require APPROOT.'/views/layout/footer.php';
?>
