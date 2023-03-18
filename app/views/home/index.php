<?php
require APPROOT.'/views/layout/header.php';
//require APPROOT.'/views/layout/horizontal-navigation/index.php';
?>

<main class="flex w-full h-full justify-center items-center pb-20" role="main">
	<div class="mt-20 w-1/4 h-max flex flex-col justify-center items-center text-white p-4 rounded-md bg-slate-400">
	       
	<!--<p class="text-4xl font-bold text-neutral-700">Log in</p>-->
	<div class="flex flex-col w-full items-center gap-2">
	<a href="<?php echo URLROOT;?>/home"><img class="aspect-square h-32 object-cover" src="<?php echo URLROOT;?>/public/assets/img/logo.png"></a>

	<a href="<?php echo URLROOT;?>/home" >
	<div class="flex flex-col text-center">
	<span class="font-bold text-lg text-yellow-200">QUEZON CITY UNIVERSITY</span>
	<span class="" >Online Consultation And Document Request</span>
	</div>
	</a>
	</div>

	<?php
		require APPROOT.'/views/includes/loader.registration.php';
		require APPROOT.'/views/flash/success.php';
		require APPROOT.'/views/flash/fail.php';
	?>


	<div class="flex flex-col gap-0.5 w-full items-center text-yellow-800">
		
		<a href="<?php echo URLROOT?>/home/student" class="flex gap-1 rouded-md pl-2 items-center rounded-sm bg-yellow-200 w-full py-2 cursor-pointer text-center hover:bg-slate-100 mt-5">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" fullwBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		  		<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
			</svg>
			Student
		</a>

		<a href="<?php echo URLROOT?>" class="flex gap-1 rouded-md pl-2 items-center rounded-sm bg-yellow-200 w-full py-2 cursor-pointer text-center hover:bg-slate-100"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
		</svg>Alumni</a>

		<a href="<?php echo URLROOT?>" class="flex gap-1 rouded-md pl-2 items-center rounded-sm bg-yellow-200 w-full py-2 cursor-pointer text-center hover:bg-slate-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		  <path strokeLinecap="round" strokeLinejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
		</svg>Teacher</a>


		<a href="<?php echo URLROOT?>" class="flex gap-1 rouded-md pl-2 items-center rounded-sm bg-yellow-200 w-full py-2 cursor-pointer text-center hover:bg-slate-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		  <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
		</svg>Non-Teaching Staff</a>

	</div>

	<div class="text-sm px-2">
		<p class="mt-4 text-white">This website is only for registered students, professors, department staffs, and alumnis. The students shall need to create an account first before having the rights to use the services.</p>
	</div>

	</div>
</main>
<?php
?>