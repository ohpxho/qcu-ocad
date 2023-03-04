<?php 
require APPROOT.'/views/layout/header.php';
//require APPROOT.'/views/layout/horizontal-navigation/index.php';
?>

<main class="flex w-full h-full justify-center items-center solid black pb-20"  role="main">
<div style="background: url('<?php echo URLROOT;?>/public/assets/img/bg2qcu.jpg'); background-size: cover; background-position: center;
  background-repeat: no-repeat; opacity:.7" class="absolute h-full w-full top-0 left-0" >
    </div>			
	<div class="w-max max-w-sm h-max flex flex-col justify-center items-center text-white rounded-md" style="padding:20px; background-color: rgba(0,0,0,0.4)">
        
		<!--<p class="text-4xl font-bold text-neutral-700">Log in</p>-->
		<div class="flex flex-col w-full items-center gap-2 pb-5">
			<a href="<?php echo URLROOT;?>/home"><img class="aspect-square h-20 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>
			
			<a href="<?php echo URLROOT;?>/home" >
				<div class="flex flex-col text-center gap-2">
					<span class="font-bold text-xl">QUEZON CITY UNIVERSITY</span>
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
				<span class="text-white">ID or Email Address</span>
				<input name="id" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500 mt-2" type="text" />
			</div>

			<div class="flex flex-col mt-3">
				<span class="text-white">Password</span>
				<input name="password" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500 mt-2" type="password" />
			</div>
			
			
			<input class="border mt-5 rounded-sm border-blue-300 bg-blue-100 text-gray-700 border w-full p-1 cursor-pointer" type="submit" value="Log in"/>
			
		</form>
		<a class="cursor-pointer mt-5 underline text-white">forgot password?</a>
		<a href="<?php echo URLROOT?>/alumni" class="border mt-5 border-blue-300 rounded-sm bg-blue-100 text-gray-700 border w-full p-1 cursor-pointer text-center">Login as Alumni</a>
		<a href="<?php echo URLROOT?>/home/register" class="border mt-5 border-red-300 rounded-sm bg-red-100 text-gray-700 border w-full p-1 cursor-pointer text-center">Create account</a>
		<p class="mt-5 text-sm text-white">This website is only for registered students, professors, department staffs, and alumnis. The students shall need to create an account first before having the rights to use the services.</p>
	</div>
    
</main>
<?php 
require APPROOT.'/views/layout/footer.php';
?>
