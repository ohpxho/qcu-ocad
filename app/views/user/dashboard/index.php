<?php
	require APPROOT.'/views/layout/header.php';
?>

<main class="w-full flex flex-con h-full overflow-hidden">

	<!-------------------------------------- side navigation ----------------------------------------------------------------->
	
	<?php
		require APPROOT.'/views/layout/side-navigation/index.php';
	?>

	<!-------------------------------------- main content -------------------------------------------------------------------->
	
	<div class="w-full h-full">
		<?php
			require APPROOT.'/views/layout/horizontal-navigation/index.php';
		?>

		<div class="flex justify-center w-full h-full overflow-y-scroll bg-neutral-100">
			<!------------------ user welcome modal------------------------->
			<div id="welcome-modal" style="background-color: rgba(255, 255, 255, 0.4);" class="fixed hidden text-white flex justify-center items-center z-50 top-0 left-0 w-full h-full">
				<div class="shadow-md flex flex-col gap-2 justify-center items-center w-1/2 h-1/2 p-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-md">
					<img class="w-40 object-cover " src="<?php echo URLROOT?>/public/assets/img/logo.png">
					<p class="text-2xl font-bold mt-5"> Welcome! QCU 
					<?php
						switch($_SESSION['type']) {
						case 'student':
							echo 'Student';
							break;
						case 'alumni':
							echo 'Alumni';
							break;
						case 'professor':
							echo 'Teacher';
							break;
						case 'sysadmin':
							echo 'System Admin';
							break;
						default:
							echo 'Admin';
						}
					?>
					👋
					</p>
					<p>This is an Online Consultation and Document Request for Quezon City University</p>
					<a id="welcome-modal-btn" href="" class="py-2 px-6 h-max w-max bg-yellow-200 text-black mt-5">Ok</a>
					<p>Click Ok to continue</p>
				</div>
			</div>
			
			<div class="fixed z-10 w-full h-full top-0 left-0 flex items-center	justify-center">
				<img class="opacity-10 w-1/3 " src="<?php echo URLROOT;?>/public/assets/img/logo.png">
			</div>

			<div class="min-h-full z-20 w-10/12 py-14">
				<?php
					switch($_SESSION['type']) {
						case 'student':
							require APPROOT.'/views/user/dashboard/student/student.php';
							break;
						case 'alumni':
							require APPROOT.'/views/user/dashboard/alumni/alumni.php';
							break;
						case 'professor':
							require APPROOT.'/views/user/dashboard/professor/professor.php';
							break;
						case 'sysadmin':
							require APPROOT.'/views/user/dashboard/sysadmin/sysadmin.php';
						default:
							require APPROOT.'/views/user/dashboard/admin/admin.php';
					}
				?>
			</div>
		</div>
	</div>

</main>

<script>
	$(document).ready(function() {
		$(window).load(function() {
			setWelcomeModal();
		});

		$('#welcome-modal-btn').click(function() {
			$('#welcome-modal').addClass('hidden');
		});

		function setWelcomeModal() {
			const flag = localStorage.getItem('welcome-flag');

			if(!flag) {
				localStorage.setItem('welcome-flag', 1);
				$('#welcome-modal').removeClass('hidden');	
			}			
			else {
				$('#welcome-modal').addClass('hidden');
			}
		}
	});
</script>
