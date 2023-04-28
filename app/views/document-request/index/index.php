<?php
	require APPROOT.'/views/layout/header.php';
?>
<main class="flex flex-con h-full w-full overflow-hidden">

	<!-------------------------------------- side navigation ----------------------------------------------------------------->
	
	<?php
		require APPROOT.'/views/layout/side-navigation/index.php';
	?>

	<!-------------------------------------- main content -------------------------------------------------------------------->
	
	<div class="w-full h-full">
		<?php
			require APPROOT.'/views/layout/horizontal-navigation/index.php';
		?>

		<div class="flex justify-center w-full h-full px-2 md:px-0 overflow-y-scroll bg-neutral-100">
			<div class="min-h-full w-full h-full sm:w-10/12 z-2 pb-24 mt-5">
				
				<div class="flex flex-col w-full text-start md:w-max mt-5">
					<p class="text-2xl font-bold">Documents</p>
					<p class="text-sm text-slate-500">Select a document to request</p>
				</div>

				<div class="w-full sm:w-10/12 h-full mt-5 pb-24">
					<div style="height: 400px" class="w-full grid grid-cols-3 gap-2 justify-center">
						<!--  <a href="<?php echo URLROOT ?>/academic_document/add">
							 <div class="group flex flex-col items-end justify-end w-full h-full bg-slate-100">
								<div class="h-max w-full p-4 bg-slate-200 text-lg">
									<p class="group-hover:hidden">Academic Documents</p>
									<ul class="hidden group-hover:flex flex-col">
										<li>Gradeslip</li>
										<li>Certified true Copy</li>
										<li>Others</li>

									</ul>
								</div>
							</div> 

							<div class="card aspect-square w-80 bg-slate-100">
								<div style=";" class="front absolute w-full h-full bg-slate-700"></div>
								<div style="transform: perspective(600px) rotateY(180deg);" class="back absolute w-full h-full bg-blue-700"></div>
							</div>
						</a>

						<a href="<?php echo URLROOT ?>/good_moral/add">
							 <div class="flex flex-col items-end justify-end w-full h-full bg-slate-100">
								<div class="h-max w-full p-4 bg-slate-200 text-lg">
									<p>Good Moral Certificate</p>
								</div>
							</div> 

							<div class="aspect-square w-80 bg-slate-100">
								
							</div>
						</a>

						<a href="<?php echo URLROOT ?>/student_account/add">
							 <div class="group flex flex-col items-end justify-end w-full h-full bg-slate-100">
								<div class="h-max w-full p-4 bg-slate-200 text-lg">
									<p class="group-hover:hidden">Student Account</p>
									<ul class="hidden group-hover:flex flex-col">
										<li>Statement of Account</li>
										<li>Order of Payment</li>
									</ul>
								</div>
							</div> 

							<div class="aspect-square w-80 bg-slate-100">
								
							</div>
						</a>  -->

						<div class="card aspect-square w-full">
					        <div class="face front bg-white rounded-md border">
					            <img class="opacity-50 blur-sm" src="<?php echo URLROOT?>/public/assets/img/img1.jpg" alt="">
					            <div class="flex justify-center items-center h-full w-full">
					            	<p class="text-xl">Academic Documents</p>
					        	</div>
					        </div>
							<div class="face back"> 
						    	<p>Academic documents refers to any information or documents that are part of a student’s academic career such as Transcript of Records (TOR), diploma, grade slip, and other certifications.</p>
					            <div class="link">
					                <a href="#">Request here</a>
					            </div>
					        </div>
					    </div>

					    <div class="card aspect-square w-full">
					        <div class="face front">
					            <img src="img2.jpg" alt="">
					            <h3>Good Moral Certificate</h3>
					        </div>
					        <div class="face back">
						   		<p>It is a certification issued by the Guidance and Counseling Unit in order to affirm that a former student has shown exemplary behavior during the time of his/her enrolment in the QCU.
								</p>
					            <div class="link">
					                <a href="#">Request here</a>
					            </div>
					        </div>
					    </div>

					    <div class="card aspect-square w-full">
					        <div class="face front">
					            <img src="img3.jpg" alt="">
					            <h3>Financial Documents</h3>
					        </div>
					        <div class="face back">
						    	<p>This refers to the records, reports, and statements related to student's financial activities. QCU provides statement of accounts (SOA) and order of payment upon request.</p>
					            <div class="link">
					                <a href="#">Request here</a>
					            </div>
					        </div>
					    </div>
					    
					</div>
				</div>

			</div>
		</div>
	</div>
</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/document-request/index/index.js'; ?>
</script>

