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

		<div class="flex justify-center w-full h-full px-2 md:px-0 overflow-y-scroll bg-white">
			<div class="min-h-full w-full md:w-10/12 z-20 pt-5">

				<div class="flex justify-center w-full h-full px-2 md:px-0 bg-white">
					<div class="min-h-full w-full h-max z-2 pb-24 mt-5">
						<a href="<?php echo URLROOT; ?>/document_request" title="back">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
				  				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
							</svg>
						</a>
						
						<div class="flex flex-col w-full text-start md:w-max mt-5">
							<p class="text-2xl font-bold">New Request</p>
							<p class="text-sm text-slate-500">Create new request for academic documents</p>
						</div>

						<div class="w-full sm:w-10/12">
							<?php
								require APPROOT.'/views/flash/fail.php';
								require APPROOT.'/views/flash/success.php';
							?>
							<form action="<?php echo URLROOT; ?>/student_account/add" enctype="multipart/form-data" method="POST" class="w-full">
									<input name="student-id" type="hidden" value="<?php echo $_SESSION['id']?>"/>

									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Document<span class="text-sm font-normal"> (required)</span></p>
										</div>
										
										<div class="flex mt-4 gap-2 pt-2 border-t ">
											<input id="soa-checkbox" type="checkbox" name="requested-document" value="soa">
											<div id="soa-text" class="flex flex-col">
												<p class="text-neutral-700"><span>Statement of Account</span></p>
												<p class="text-sm text-slate-500">a document that provides a summary of a student's financial transactions with the university</p>
											</div>
										</div>

										<div class="flex mt-4 gap-2 pt-2 border-t ">
											<input id="order-of-payment-checkbox" type="checkbox" name="requested-document" value="order of payment">
											<div id="order-of-payment-text" class="flex flex-col">
												<p class="text-neutral-700"><span>Order of Payment</span></p>
												<p class="text-sm text-slate-500">a document that outlines the specific sequence of payments that a student must make in order to satisfy their financial obligations to the university</p>
											</div>
										</div>
									</div>

									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Quantity<span class="text-sm font-normal"> (required)</span></p>
											<p class="text-sm text-slate-500"></p>
										</div>
										<input name="quantity" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-400 mt-4" type="number" min="1" max="5" value="1" required>
									</div>
									
									<div class="flex flex-col mt-5">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Purpose<span class="text-sm font-normal"> (required)</span></p>
										</div>
										<select name="purpose" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700" required>
											<option value="">Choose Option</option>
											<option value="Proof of Payment">Proof of Payment</option>
											<option value="Account Reconciliation">Account Reconciliation</option>
											<option value="Payment Plan">Payment Plan</option>
											<option value="Tax Purposes">Tax Purposes</option>
											<option value="Others">Others</option>
										</select>
									</div>

									<div id="others-hidden-input" class="flex flex-col mt-5 hidden">
										<div class="flex flex-col gap2 w-full">
											<p class="font-semibold">Please Specify<span class="text-sm font-normal"> (required)</span></p>
											<p class="text-sm text-slate-500"></p>
										</div>
										<input name="other-purpose" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-4" type="text">
									</div>

									<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Submit"/>
									<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
								</form>
								
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>

<script>
	<?php require APPROOT.'/views/soa-and-order-of-payment/add/add.js'; ?>
</script>