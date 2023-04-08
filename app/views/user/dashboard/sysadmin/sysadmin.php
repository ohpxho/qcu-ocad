<?php
	$reqfreq = $data['request-frequency'];
	$tor = isset($reqfreq->TOR)? $reqfreq->TOR : '0';
	$dismissal = isset($reqfreq->HONORABLE_DISMISSAL)? $reqfreq->HONORABLE_DISMISSAL : '0';
	$diploma = isset($reqfreq->DIPLOMA)? $reqfreq->DIPLOMA : '0';
	$gradeslip = isset($reqfreq->GRADESLIP)? $reqfreq->GRADESLIP : '0';
	$ctc = isset($reqfreq->CTC)? $reqfreq->CTC : '0';
	$others = isset($reqfreq->OTHERS)? $reqfreq->OTHERS : '0';
	$goodmoral = isset($reqfreq->GOOD_MORAL)? $reqfreq->GOOD_MORAL : '0';
	$soa = isset($reqfreq->SOA)? $reqfreq->SOA : '0';
	$oop = isset($reqfreq->ORDER_OF_PAYMENT)? $reqfreq->ORDER_OF_PAYMENT : '0';
?>
<?php
	$statfreq = $data['status-frequency'];
	$pending = isset($statfreq->pending)? $statfreq->pending : '0';
	$accepted = isset($statfreq->accepted)? $statfreq->accepted : '0';
	$rejected = isset($statfreq->rejected)? $statfreq->rejected : '0';
	$inprocess = isset($statfreq->inprocess)? $statfreq->inprocess : '0';
	$forclaiming = isset($statfreq->forclaiming)? $statfreq->forclaiming : '0';
	$completed = isset($statfreq->completed)? $statfreq->completed : '0';
	$cancelled = isset($statfreq->cancelled)? $statfreq->cancelled : '0';
	$forpayment = isset($statfreq->forpayment)? $statfreq->forpayment : '0';
?>

<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-2xl font-bold">Dashboard</p>
		<p class="text-sm text-slate-500">Records summary</p>
	</div>
</div>
<div class="flex flex-col mt-1 gap-2 pb-24">
	<div class="flex flex-col">
		<div class="flex gap-2 mt-5">
			<!-- <div class="grid grid-cols-4 gap-2 w-full">
				<div class="flex w-full aspect-video border bg-yellow-500 rounded-md">
					<div class="ml-4 flex text-white justify-center flex-col w-1/2 h-full">
						<p class="px-3 text-4xl font-bold py-1 w-max h-max"><?php echo $pending?></p>
						<p class="">Pending</p>
					</div>
					<div class="flex items-center w-1/2 opacity-10">
						<svg  viewBox="0 0 1024.00 1024.00" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000" stroke="#000000" stroke-width="0.01024"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="2.048"></g><g id="SVGRepo_iconCarrier"><path d="M182.99 146.2h585.14v402.29h73.14V73.06H109.84v877.71H512v-73.14H182.99z" fill="#121212"></path><path d="M256.13 219.34h438.86v73.14H256.13zM256.13 365.63h365.71v73.14H256.13zM256.13 511.91h219.43v73.14H256.13zM731.55 585.06c-100.99 0-182.86 81.87-182.86 182.86s81.87 182.86 182.86 182.86c100.99 0 182.86-81.87 182.86-182.86s-81.86-182.86-182.86-182.86z m0 292.57c-60.5 0-109.71-49.22-109.71-109.71 0-60.5 49.22-109.71 109.71-109.71 60.5 0 109.71 49.22 109.71 109.71 0.01 60.49-49.21 109.71-109.71 109.71z" fill="#121212"></path><path d="M758.99 692.08h-54.86v87.27l69.39 68.76 38.61-38.96-53.14-52.66z" fill="#121212"></path></g></svg>
					</div>
				</div>
				<div class="flex w-full aspect-video border bg-orange-500 rounded-md">
					<div class="ml-4 flex text-white justify-center flex-col w-1/2 h-full">
						<p class="px-3 text-4xl font-bold py-1 w-max h-max"><?php echo $inprocess?></p>
						<p class="">In Process</p>
					</div>
					<div class="flex items-center w-1/2 opacity-10">
						<svg viewBox="0 0 100 100" data-name="Layer 2" id="Layer_2" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;stroke-width:6px;}</style></defs><title></title><polygon class="cls-1" points="82 24.76 82 94.14 18 94.14 18 5.86 63.1 5.86 63.1 24.76 82 24.76"></polygon><line class="cls-1" x1="63.1" x2="82" y1="5.86" y2="24.76"></line><path class="cls-1" d="M63.62,50A16.85,16.85,0,1,1,46.78,33.16"></path><polygon class="cls-1" points="63.62 38.84 57.17 49.18 70.06 49.18 63.62 38.84"></polygon></g></svg>
					</div>
				</div>
				<div class="flex w-full aspect-video border bg-slate-500 rounded-md">
					<div class="ml-4 flex text-white justify-center flex-col w-1/2 h-full">
						<p class="px-3 text-4xl font-bold py-1 w-max h-max"><?php echo $forpayment?></p>
						<p class="">For Payment</p>
					</div>
					<div class="flex items-center w-1/2 opacity-10">
						<svg fill="#000000"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 480 480" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M265.248,0h-200c-13.232,0-24,10.768-24,24v360c0,13.232,10.768,24,24,24c4.416,0,8-3.584,8-8c0-4.416-3.584-8-8-8 c-4.408,0-8-3.592-8-8V24c0-4.408,3.592-8,8-8h200c4.408,0,8,3.592,8,8v104c0,4.416,3.584,8,8,8c4.416,0,8-3.584,8-8V24 C289.248,10.768,278.48,0,265.248,0z"></path> </g> </g> <g> <g> <circle cx="164.624" cy="92.624" r="12.624"></circle> </g> </g> <g> <g> <path d="M449.208,471.2l-25.416-255.584C420.048,179.352,389.936,152,353.768,152h-72.52c-4.416,0-8,3.584-8,8v162.216 l-91.536-52.312c29.552-7.392,51.536-34.096,51.536-65.904c0-37.496-30.504-68-68-68c-37.496,0-68,30.504-68,68 c0,23.088,11.592,43.496,29.232,55.792c-8.208,3.688-15.384,9.72-20.12,17.912c-10.408,18.032-6.56,41.136,8.76,54.992 c0.6,1.08,1.456,2.032,2.552,2.768L202.408,392h-33.032c-0.024,0-0.04,0.016-0.064,0.016s-0.04-0.016-0.064-0.016h-72 c-4.416,0-8,3.584-8,8v32c0,1.288,0.336,2.496,0.92,3.576c3.96,17.896,20.688,35.624,43.336,35.624 c19.928,0,35.168-13.752,41.256-29.248c7.736,7.8,18.288,13.248,30.744,13.248c12.64,0,24.768-6.048,33.192-15.8l9.224,34.664 c0.928,3.496,4.104,5.936,7.728,5.936h185.6c2.256,0,4.416-0.96,5.928-2.632C448.688,475.696,449.432,473.456,449.208,471.2z M161.248,431.976c-2.424,11.4-13.384,23.224-27.744,23.224c-14.88,0-26.104-12.696-27.976-24.456 c-0.064-0.392-0.16-0.776-0.28-1.152V408h56V431.976z M113.248,204c0-28.672,23.328-52,52-52s52,23.328,52,52s-23.328,52-52,52 S113.248,232.672,113.248,204z M231.688,420.872c-3.752,8.832-13.544,18.328-26.184,18.328c-14.88,0-26.104-12.696-27.976-24.456 c-0.064-0.376-0.152-0.736-0.264-1.088l0.048-5.656h47.936c0.312,0,0.576-0.144,0.872-0.176l5.08,3.384l1.992,7.472 C232.6,419.336,232.048,420.024,231.688,420.872z M261.792,464l-15.912-59.824c-0.496-1.88-1.672-3.512-3.288-4.6l-113.696-75.864 c-0.432-0.608-0.952-1.16-1.56-1.64c-11.016-8.672-14.072-24.312-7.112-36.368c6.968-12.056,22.048-17.224,35.064-12.016 c0.504,0.2,1.024,0.336,1.552,0.424l120.44,68.832c2.48,1.416,5.52,1.416,7.984-0.024c2.464-1.432,3.984-4.072,3.984-6.92V168 h64.52c27.944,0,51.2,21.176,54.104,49.24L432.416,464H261.792z"></path> </g> </g> <g> <g> <path d="M53.92,441.664c-4.416,0-8,3.584-8,8C45.912,457.568,39.488,464,31.584,464s-14.336-6.432-14.336-14.336 s6.432-14.336,14.336-14.336c4.416,0,8-3.584,8-8c0-4.416-3.584-8-8-8c-16.728,0.008-30.336,13.616-30.336,30.336 c0,16.72,13.608,30.336,30.336,30.336s30.336-13.608,30.336-30.336C61.92,445.248,58.336,441.664,53.92,441.664z"></path> </g> </g> <g> <g> <path d="M417.248,0c-4.416,0-8,3.584-8,8v22.4c0,4.416,3.584,8,8,8c4.416,0,8-3.584,8-8V8C425.248,3.584,421.664,0,417.248,0z"></path> </g> </g> <g> <g> <path d="M417.248,89.6c-4.416,0-8,3.584-8,8V120c0,4.416,3.584,8,8,8c4.416,0,8-3.584,8-8V97.6 C425.248,93.184,421.664,89.6,417.248,89.6z"></path> </g> </g> <g> <g> <path d="M470.752,56h-22.4c-4.416,0-8,3.584-8,8s3.576,8,8,8h22.4c4.416,0,8-3.584,8-8S475.168,56,470.752,56z"></path> </g> </g> <g> <g> <path d="M385.248,56h-22.4c-4.416,0-8,3.584-8,8s3.584,8,8,8h22.4c4.416,0,8-3.584,8-8S389.664,56,385.248,56z"></path> </g> </g> <g> <g> <path d="M249.248,48h-8c-4.408,0-8-3.592-8-8c0-4.416-3.584-8-8-8h-120c-4.416,0-8,3.584-8,8c0,4.408-3.592,8-8,8h-8 c-4.416,0-8,3.584-8,8v88c0,4.416,3.584,8,8,8s8-3.584,8-8V64c10.432,0,19.328-6.688,22.632-16h106.744 c3.304,9.312,12.2,16,22.632,16v80c-0.008,4.416,3.576,8,7.992,8c4.416,0,8-3.584,8-8V56C257.248,51.584,253.664,48,249.248,48z"></path> </g> </g> </g></svg>
					</div>
				</div>
				<div class="flex w-full aspect-video border bg-sky-500 rounded-md">
					<div class="ml-4 flex text-white justify-center flex-col w-1/2 h-full">
						<p class="px-3 text-4xl font-bold py-1 w-max h-max"><?php echo $forclaiming?></p>
						<p class="">To Claim</p>
					</div>
					<div class="flex items-center w-1/2 opacity-10">
						<svg fill="#000000" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 221.00 221.00" enable-background="new 0 0 221 256" xml:space="preserve" transform="rotate(0)" stroke="#000000" stroke-width="0.00221"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="2.21"></g><g id="SVGRepo_iconCarrier"> <path d="M97.613,68.098l24.882-24.882l-5.686-5.641l-5.686-5.641l-19.105,19.06l-19.105,19.06l-9.28-9.28 c-5.095-5.095-9.462-9.28-9.644-9.28c-0.182,0-2.911,2.593-6.095,5.732l-5.777,5.777l14.966,14.966 c8.233,8.233,15.102,14.966,15.284,14.966C72.64,92.98,83.966,81.79,97.613,68.098L97.613,68.098z M207.166,103.194V128 c0,2.559-1.969,4.528-4.528,4.528s-4.528-1.969-4.528-4.528V91.972c0-1.575-0.197-2.953-0.984-4.331 c-1.378-3.347-4.528-5.906-8.072-6.694c-0.591-0.197-1.575-0.197-2.166-0.197v42.722c0,2.559-1.969,4.528-4.528,4.528 s-4.528-1.969-4.528-4.528V69.528c0-1.181-0.197-1.969-0.394-2.953c-0.197-1.181-0.984-2.166-1.575-3.347 c-0.984-1.181-1.772-2.166-3.15-3.15c-0.984-0.591-2.166-1.181-3.347-1.575c-0.591,0-1.575-0.197-2.756-0.197 c-0.591,0-1.575,0-2.166,0.197V2H2.416v189H126.25c4.134,11.419,13.191,20.475,24.806,24.806V254h67.528V114.416 C218.388,108.116,213.466,103.194,207.166,103.194z M150.859,152.806c-2.559,0-4.528-1.969-4.528-4.528v-40.556 c0-6.3-4.922-11.222-11.222-11.222c-6.984,0-11.222,5.212-11.222,11.294v15.875H33.916v9.056h89.972v13.584H33.916v9.056h89.972 v22.444c0,1.575,0.197,2.953,0.197,4.528H11.275V11.056h143.916v58.472v78.75h0.197 C155.388,150.838,153.419,152.806,150.859,152.806z"></path> </g></svg>
					</div>
				</div>
				<div class="flex w-full aspect-video border bg-green-500 rounded-md">
					<div class="ml-4 flex text-white justify-center flex-col w-1/2 h-full">
						<p class="px-3 text-4xl font-bold py-1 w-max h-max"><?php echo $completed?></p>
						<p class="">Completed</p>
					</div>
					<div class="flex items-center w-1/2 opacity-10">
						<svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="256px" height="256px" viewBox="0 0 47.00 47.00" xml:space="preserve" stroke="#000000" stroke-width="0.00047000000000000004"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.564"></g><g id="SVGRepo_iconCarrier"> <g> <g id="Layer_1_22_"> <g> <path d="M6.12,38.52V5.136h26.962v28.037l5.137-4.243V2.568C38.219,1.15,37.07,0,35.652,0h-32.1C2.134,0,0.985,1.15,0.985,2.568 v38.519c0,1.418,1.149,2.568,2.567,2.568h22.408L22.33,38.52H6.12z"></path> <path d="M45.613,27.609c-0.473-0.446-1.2-0.467-1.698-0.057l-11.778,9.734l-7.849-4.709c-0.521-0.312-1.188-0.219-1.603,0.229 c-0.412,0.444-0.457,1.117-0.106,1.613l8.506,12.037c0.238,0.337,0.625,0.539,1.037,0.543c0.004,0,0.008,0,0.012,0 c0.408,0,0.793-0.193,1.035-0.525l12.6-17.173C46.149,28.78,46.084,28.055,45.613,27.609z"></path> <path d="M27.306,8.988H11.897c-1.418,0-2.567,1.15-2.567,2.568s1.149,2.568,2.567,2.568h15.408c1.418,0,2.566-1.15,2.566-2.568 S28.724,8.988,27.306,8.988z"></path> <path d="M27.306,16.691H11.897c-1.418,0-2.567,1.15-2.567,2.568s1.149,2.568,2.567,2.568h15.408c1.418,0,2.566-1.149,2.566-2.568 C29.874,17.841,28.724,16.691,27.306,16.691z"></path> <path d="M27.306,24.395H11.897c-1.418,0-2.567,1.15-2.567,2.568s1.149,2.568,2.567,2.568h15.408c1.418,0,2.566-1.15,2.566-2.568 C29.874,25.545,28.724,24.395,27.306,24.395z"></path> </g> </g> </g> </g></svg>
					</div>
				</div>
				<div class="flex w-full aspect-video border bg-rose-500 rounded-md">
					<div class="ml-4 flex text-white justify-center flex-col w-1/2 h-full">
						<p class="px-3 text-4xl font-bold py-1 w-max h-max"><?php echo $cancelled?></p>
						<p class="">Cancelled</p>
					</div>
					<div class="flex items-center w-1/2 opacity-10">
						<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M28.6,11.4h5.1c0.6,0,1.1-0.5,1.1-1.1c0-0.3-0.1-0.5-0.3-0.8l-7.2-7.1c-0.2-0.2-0.4-0.3-0.7-0.3 c-0.6,0-1.1,0.5-1.1,1.1v5.1C25.5,10,26.9,11.4,28.6,11.4z"></path> <path d="M24.6,40.6c0-6.8,4.2-12.6,10.2-14.9v-8.1c0-0.9-0.7-1.6-1.6-1.6h-7.8c-2.6,0-4.7-2.1-4.7-4.6V3.6 c0.1-0.8-0.6-1.5-1.5-1.5H6.8c-2.6,0-4.7,2.1-4.7,4.6v29.4c0,2.6,2.1,4.6,4.7,4.6h17.8C24.6,40.7,24.6,40.6,24.6,40.6z"></path> </g> <path d="M31.8,34.6l6,6l-6,6c-0.6,0.6-0.6,1.6,0,2.1l0.7,0.7c0.6,0.6,1.6,0.6,2.1,0l6-6l6,6c0.6,0.6,1.6,0.6,2.1,0 l0.7-0.7c0.6-0.6,0.6-1.6,0-2.1l-6-6l6-6c0.6-0.6,0.6-1.6,0-2.1l-0.7-0.7c-0.6-0.6-1.6-0.6-2.1,0l-6,6l-6-6c-0.6-0.6-1.6-0.6-2.1,0 l-0.7,0.7C31.2,33,31.2,34,31.8,34.6z"></path> </g> </g></svg>
					</div>
				</div>
				<div class="flex w-full aspect-video border bg-red-500 rounded-md">
					<div class="ml-4 flex text-white justify-center flex-col w-1/2 h-full">
						<p class="px-3 text-4xl font-bold py-1 w-max h-max"><?php echo $rejected?></p>
						<p class="">Declined</p>
					</div>
					<div class="flex items-center w-1/2 opacity-10">
						<svg fill="#000000" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 53 53" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M45.707,10.074l-9.794-9.782C35.726,0.105,35.471,0,35.206,0H8C7.447,0,7,0.447,7,1v51c0,0.553,0.447,1,1,1h37 c0.553,0,1-0.447,1-1V10.782C46,10.517,45.895,10.263,45.707,10.074z M42.586,10H36V3.414L42.586,10z M9,51V2h25v9 c0,0.553,0.447,1,1,1h9v39H9z"></path> <path d="M26.5,16C19.056,16,13,22.056,13,29.5S19.056,43,26.5,43S40,36.944,40,29.5S33.944,16,26.5,16z M26.5,18 c2.892,0,5.532,1.082,7.555,2.851L17.851,37.055C16.082,35.032,15,32.393,15,29.5C15,23.159,20.159,18,26.5,18z M26.5,41 c-2.729,0-5.237-0.96-7.211-2.555l16.156-16.156C37.04,24.263,38,26.771,38,29.5C38,35.841,32.841,41,26.5,41z"></path> </g> </g> </g></svg>
					</div>
				</div>
			</div> -->
		 <div class="flex flex-col w-1/3 gap-1 mt-3 p-2 border-2 rounded-md bg-white drop-shadow-lg hover:bg-slate-200" style ="background-color: rgba(34,197,94,.9);">
				<div>
					<div class="flex flex-col w-full gap-2 pb-1 drop-shadow-lg border-2">
						<p class="font-medium mt-5 text-4xl pl-12"><?php echo $accepted ?></p>
						<p class="font-medium mt-3 text-lg pl-6">Accepted</p>
						<div class="absolute right-0  flex items-center " style="opacity:.20;height:90px;	width:90px;">
							<svg viewBox="0 0 1024.00 1024.00" fill="#000000" class="icon w-full h-full" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="22.528"><g id="SVGRepo_bgCarrier" stroke-width="2"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M824.8 1003.2H203.2c-12.8 0-25.6-2.4-37.6-7.2-11.2-4.8-21.6-12-30.4-20.8-8.8-8.8-16-19.2-20.8-30.4-4.8-12-7.2-24-7.2-37.6V260c0-12.8 2.4-25.6 7.2-37.6 4.8-11.2 12-21.6 20.8-30.4 8.8-8.8 19.2-16 30.4-20.8 12-4.8 24-7.2 37.6-7.2h94.4v48H203.2c-26.4 0-48 21.6-48 48v647.2c0 26.4 21.6 48 48 48h621.6c26.4 0 48-21.6 48-48V260c0-26.4-21.6-48-48-48H730.4v-48H824c12.8 0 25.6 2.4 37.6 7.2 11.2 4.8 21.6 12 30.4 20.8 8.8 8.8 16 19.2 20.8 30.4 4.8 12 7.2 24 7.2 37.6v647.2c0 12.8-2.4 25.6-7.2 37.6-4.8 11.2-12 21.6-20.8 30.4-8.8 8.8-19.2 16-30.4 20.8-11.2 4.8-24 7.2-36.8 7.2z" fill=""></path><path d="M752.8 308H274.4V152.8c0-32.8 26.4-60 60-60h61.6c22.4-44 67.2-72.8 117.6-72.8 50.4 0 95.2 28.8 117.6 72.8h61.6c32.8 0 60 26.4 60 60v155.2m-430.4-48h382.4V152.8c0-6.4-5.6-12-12-12H598.4l-5.6-16c-12-33.6-43.2-56-79.2-56s-67.2 22.4-79.2 56l-5.6 16H334.4c-6.4 0-12 5.6-12 12v107.2zM432.8 792c-6.4 0-12-2.4-16.8-7.2L252.8 621.6c-4.8-4.8-7.2-10.4-7.2-16.8s2.4-12 7.2-16.8c4.8-4.8 10.4-7.2 16.8-7.2s12 2.4 16.8 7.2L418.4 720c4 4 8.8 5.6 13.6 5.6s10.4-1.6 13.6-5.6l295.2-295.2c4.8-4.8 10.4-7.2 16.8-7.2s12 2.4 16.8 7.2c9.6 9.6 9.6 24 0 33.6L449.6 784.8c-4.8 4-11.2 7.2-16.8 7.2z" fill=""></path></g></svg>
						</div>
					</div>
				</div>
			</div>

			<div class="flex flex-col w-1/3 gap-1 mt-3 p-2 border-2 rounded-md bg-white drop-shadow-lg bg-blue-700 hover:bg-slate-200" style ="background-color: rgba(245,158,11,.8);">
				<div> 
					<div class="flex flex-col w-full gap-2 pb-1 drop-shadow-lg border-2">
					<p class="font-medium mt-5 text-4xl pl-12"><?php echo $pending ?></p>
					<p class="font-medium mt-3 text-lg pl-6">Pending</p>
					<div class="absolute right-0 flex items-center "style="opacity:.50;height:95px;	width:95px;">
					<svg  viewBox="0 0 1024.00 1024.00" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000" stroke="#000000" stroke-width="0.01024"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="2.048"></g><g id="SVGRepo_iconCarrier"><path d="M182.99 146.2h585.14v402.29h73.14V73.06H109.84v877.71H512v-73.14H182.99z" fill="#121212"></path><path d="M256.13 219.34h438.86v73.14H256.13zM256.13 365.63h365.71v73.14H256.13zM256.13 511.91h219.43v73.14H256.13zM731.55 585.06c-100.99 0-182.86 81.87-182.86 182.86s81.87 182.86 182.86 182.86c100.99 0 182.86-81.87 182.86-182.86s-81.86-182.86-182.86-182.86z m0 292.57c-60.5 0-109.71-49.22-109.71-109.71 0-60.5 49.22-109.71 109.71-109.71 60.5 0 109.71 49.22 109.71 109.71 0.01 60.49-49.21 109.71-109.71 109.71z" fill="#121212"></path><path d="M758.99 692.08h-54.86v87.27l69.39 68.76 38.61-38.96-53.14-52.66z" fill="#121212"></path></g></svg>
				</div>
			</div>	
				</div>
			</div>
			<div class="flex flex-col w-1/3 gap-1 mt-3 p-2 border-2 rounded-md bg-white drop-shadow-lg hover:bg-slate-200" style ="background-color: rgba(124,58,237,.9);">
				<div>
					<div class="flex flex-col w-full  gap-2 pb-1 drop-shadow-lg border-2">
					<p class="font-medium mt-5 text-4xl pl-12"><?php echo $inprocess ?></p>
					<p class="font-medium mt-2 text-lg pl-6">In Process</p>
					<div class="absolute right-0 w-10 h-10 flex items-center "style="opacity:.50;height:95px;	width:95px;">
					<svg viewBox="0 0 100 100" data-name="Layer 2" id="Layer_2" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;stroke-width:6px;}</style></defs><title></title><polygon class="cls-1" points="82 24.76 82 94.14 18 94.14 18 5.86 63.1 5.86 63.1 24.76 82 24.76"></polygon><line class="cls-1" x1="63.1" x2="82" y1="5.86" y2="24.76"></line><path class="cls-1" d="M63.62,50A16.85,16.85,0,1,1,46.78,33.16"></path><polygon class="cls-1" points="63.62 38.84 57.17 49.18 70.06 49.18 63.62 38.84"></polygon></g></svg>
				</div>
				</div>
				</div>
			</div>
			<div class="flex flex-col w-1/3 gap-1 mt-3 p-2 border-2 rounded-md bg-white drop-shadow-lg hover:bg-slate-200" style ="background-color: rgba(113,113,112,.9);">
				<div>
					<div class="flex flex-col w-full gap-2 pb-1 drop-shadow-lg border-2">
						<p class="font-medium mt-5 text-4xl pl-12"><?php echo $forclaiming ?></p>
						<p class="font-medium mt-2 text-lg pl-6">Payment</p>
						<div class="absolute right-0  flex items-center " style="opacity:.50;height:90px;	width:90px;">
						<svg fill="#000000"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 480 480" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M265.248,0h-200c-13.232,0-24,10.768-24,24v360c0,13.232,10.768,24,24,24c4.416,0,8-3.584,8-8c0-4.416-3.584-8-8-8 c-4.408,0-8-3.592-8-8V24c0-4.408,3.592-8,8-8h200c4.408,0,8,3.592,8,8v104c0,4.416,3.584,8,8,8c4.416,0,8-3.584,8-8V24 C289.248,10.768,278.48,0,265.248,0z"></path> </g> </g> <g> <g> <circle cx="164.624" cy="92.624" r="12.624"></circle> </g> </g> <g> <g> <path d="M449.208,471.2l-25.416-255.584C420.048,179.352,389.936,152,353.768,152h-72.52c-4.416,0-8,3.584-8,8v162.216 l-91.536-52.312c29.552-7.392,51.536-34.096,51.536-65.904c0-37.496-30.504-68-68-68c-37.496,0-68,30.504-68,68 c0,23.088,11.592,43.496,29.232,55.792c-8.208,3.688-15.384,9.72-20.12,17.912c-10.408,18.032-6.56,41.136,8.76,54.992 c0.6,1.08,1.456,2.032,2.552,2.768L202.408,392h-33.032c-0.024,0-0.04,0.016-0.064,0.016s-0.04-0.016-0.064-0.016h-72 c-4.416,0-8,3.584-8,8v32c0,1.288,0.336,2.496,0.92,3.576c3.96,17.896,20.688,35.624,43.336,35.624 c19.928,0,35.168-13.752,41.256-29.248c7.736,7.8,18.288,13.248,30.744,13.248c12.64,0,24.768-6.048,33.192-15.8l9.224,34.664 c0.928,3.496,4.104,5.936,7.728,5.936h185.6c2.256,0,4.416-0.96,5.928-2.632C448.688,475.696,449.432,473.456,449.208,471.2z M161.248,431.976c-2.424,11.4-13.384,23.224-27.744,23.224c-14.88,0-26.104-12.696-27.976-24.456 c-0.064-0.392-0.16-0.776-0.28-1.152V408h56V431.976z M113.248,204c0-28.672,23.328-52,52-52s52,23.328,52,52s-23.328,52-52,52 S113.248,232.672,113.248,204z M231.688,420.872c-3.752,8.832-13.544,18.328-26.184,18.328c-14.88,0-26.104-12.696-27.976-24.456 c-0.064-0.376-0.152-0.736-0.264-1.088l0.048-5.656h47.936c0.312,0,0.576-0.144,0.872-0.176l5.08,3.384l1.992,7.472 C232.6,419.336,232.048,420.024,231.688,420.872z M261.792,464l-15.912-59.824c-0.496-1.88-1.672-3.512-3.288-4.6l-113.696-75.864 c-0.432-0.608-0.952-1.16-1.56-1.64c-11.016-8.672-14.072-24.312-7.112-36.368c6.968-12.056,22.048-17.224,35.064-12.016 c0.504,0.2,1.024,0.336,1.552,0.424l120.44,68.832c2.48,1.416,5.52,1.416,7.984-0.024c2.464-1.432,3.984-4.072,3.984-6.92V168 h64.52c27.944,0,51.2,21.176,54.104,49.24L432.416,464H261.792z"></path> </g> </g> <g> <g> <path d="M53.92,441.664c-4.416,0-8,3.584-8,8C45.912,457.568,39.488,464,31.584,464s-14.336-6.432-14.336-14.336 s6.432-14.336,14.336-14.336c4.416,0,8-3.584,8-8c0-4.416-3.584-8-8-8c-16.728,0.008-30.336,13.616-30.336,30.336 c0,16.72,13.608,30.336,30.336,30.336s30.336-13.608,30.336-30.336C61.92,445.248,58.336,441.664,53.92,441.664z"></path> </g> </g> <g> <g> <path d="M417.248,0c-4.416,0-8,3.584-8,8v22.4c0,4.416,3.584,8,8,8c4.416,0,8-3.584,8-8V8C425.248,3.584,421.664,0,417.248,0z"></path> </g> </g> <g> <g> <path d="M417.248,89.6c-4.416,0-8,3.584-8,8V120c0,4.416,3.584,8,8,8c4.416,0,8-3.584,8-8V97.6 C425.248,93.184,421.664,89.6,417.248,89.6z"></path> </g> </g> <g> <g> <path d="M470.752,56h-22.4c-4.416,0-8,3.584-8,8s3.576,8,8,8h22.4c4.416,0,8-3.584,8-8S475.168,56,470.752,56z"></path> </g> </g> <g> <g> <path d="M385.248,56h-22.4c-4.416,0-8,3.584-8,8s3.584,8,8,8h22.4c4.416,0,8-3.584,8-8S389.664,56,385.248,56z"></path> </g> </g> <g> <g> <path d="M249.248,48h-8c-4.408,0-8-3.592-8-8c0-4.416-3.584-8-8-8h-120c-4.416,0-8,3.584-8,8c0,4.408-3.592,8-8,8h-8 c-4.416,0-8,3.584-8,8v88c0,4.416,3.584,8,8,8s8-3.584,8-8V64c10.432,0,19.328-6.688,22.632-16h106.744 c3.304,9.312,12.2,16,22.632,16v80c-0.008,4.416,3.576,8,7.992,8c4.416,0,8-3.584,8-8V56C257.248,51.584,253.664,48,249.248,48z"></path> </g> </g> </g></svg>
					</div>
					</div>
			</div>
		</div>
	</div>
		<div class="flex flex-col">
			<div class="flex gap-2">
			<div class="flex flex-col w-1/3 gap-1 mt-3 p-2 border-2 rounded-md bg-white drop-shadow-lg hover:bg-slate-200" style ="background-color: rgba(45,212,191,.9);">
				<div>
					<div class="flex flex-col w-full  gap-2 pb-1 drop-shadow-lg border-2">
					<p class="font-medium mt-5 text-4xl pl-12"><?php echo $forpayment ?></p>
					<p class="font-medium mt-2 text-lg pl-6">To Claim</p>
					<div class="absolute right-0  flex items-center " style="opacity:.50;height:90px;	width:90px;">
					<svg fill="#000000" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 221.00 221.00" enable-background="new 0 0 221 256" xml:space="preserve" transform="rotate(0)" stroke="#000000" stroke-width="0.00221"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="2.21"></g><g id="SVGRepo_iconCarrier"> <path d="M97.613,68.098l24.882-24.882l-5.686-5.641l-5.686-5.641l-19.105,19.06l-19.105,19.06l-9.28-9.28 c-5.095-5.095-9.462-9.28-9.644-9.28c-0.182,0-2.911,2.593-6.095,5.732l-5.777,5.777l14.966,14.966 c8.233,8.233,15.102,14.966,15.284,14.966C72.64,92.98,83.966,81.79,97.613,68.098L97.613,68.098z M207.166,103.194V128 c0,2.559-1.969,4.528-4.528,4.528s-4.528-1.969-4.528-4.528V91.972c0-1.575-0.197-2.953-0.984-4.331 c-1.378-3.347-4.528-5.906-8.072-6.694c-0.591-0.197-1.575-0.197-2.166-0.197v42.722c0,2.559-1.969,4.528-4.528,4.528 s-4.528-1.969-4.528-4.528V69.528c0-1.181-0.197-1.969-0.394-2.953c-0.197-1.181-0.984-2.166-1.575-3.347 c-0.984-1.181-1.772-2.166-3.15-3.15c-0.984-0.591-2.166-1.181-3.347-1.575c-0.591,0-1.575-0.197-2.756-0.197 c-0.591,0-1.575,0-2.166,0.197V2H2.416v189H126.25c4.134,11.419,13.191,20.475,24.806,24.806V254h67.528V114.416 C218.388,108.116,213.466,103.194,207.166,103.194z M150.859,152.806c-2.559,0-4.528-1.969-4.528-4.528v-40.556 c0-6.3-4.922-11.222-11.222-11.222c-6.984,0-11.222,5.212-11.222,11.294v15.875H33.916v9.056h89.972v13.584H33.916v9.056h89.972 v22.444c0,1.575,0.197,2.953,0.197,4.528H11.275V11.056h143.916v58.472v78.75h0.197 C155.388,150.838,153.419,152.806,150.859,152.806z"></path> </g></svg>
				</div>
				</div>
				</div>
			</div>
			<div class="flex flex-col w-1/3 gap-1 mt-3 p-2 border-2 rounded-md bg-white drop-shadow-lg hover:bg-slate-200" style ="background-color: rgba(14,165,233,.9);">
				<div>
					<div class="flex flex-col w-full  gap-2 pb-1 drop-shadow-lg border-2">
					<p class="font-medium mt-5 text-4xl pl-12"><?php echo $completed ?></p>
					<p class="font-medium mt-2 text-lg pl-6">Completed</p>
					<div class="absolute right-0  flex items-center " style="opacity:.50;height:90px;	width:90px;">
					<svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="256px" height="256px" viewBox="0 0 47.00 47.00" xml:space="preserve" stroke="#000000" stroke-width="0.00047000000000000004"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.564"></g><g id="SVGRepo_iconCarrier"> <g> <g id="Layer_1_22_"> <g> <path d="M6.12,38.52V5.136h26.962v28.037l5.137-4.243V2.568C38.219,1.15,37.07,0,35.652,0h-32.1C2.134,0,0.985,1.15,0.985,2.568 v38.519c0,1.418,1.149,2.568,2.567,2.568h22.408L22.33,38.52H6.12z"></path> <path d="M45.613,27.609c-0.473-0.446-1.2-0.467-1.698-0.057l-11.778,9.734l-7.849-4.709c-0.521-0.312-1.188-0.219-1.603,0.229 c-0.412,0.444-0.457,1.117-0.106,1.613l8.506,12.037c0.238,0.337,0.625,0.539,1.037,0.543c0.004,0,0.008,0,0.012,0 c0.408,0,0.793-0.193,1.035-0.525l12.6-17.173C46.149,28.78,46.084,28.055,45.613,27.609z"></path> <path d="M27.306,8.988H11.897c-1.418,0-2.567,1.15-2.567,2.568s1.149,2.568,2.567,2.568h15.408c1.418,0,2.566-1.15,2.566-2.568 S28.724,8.988,27.306,8.988z"></path> <path d="M27.306,16.691H11.897c-1.418,0-2.567,1.15-2.567,2.568s1.149,2.568,2.567,2.568h15.408c1.418,0,2.566-1.149,2.566-2.568 C29.874,17.841,28.724,16.691,27.306,16.691z"></path> <path d="M27.306,24.395H11.897c-1.418,0-2.567,1.15-2.567,2.568s1.149,2.568,2.567,2.568h15.408c1.418,0,2.566-1.15,2.566-2.568 C29.874,25.545,28.724,24.395,27.306,24.395z"></path> </g> </g> </g> </g></svg>
				</div>
				</div>
				</div>
			</div>
			<div class="flex flex-col w-1/3 gap-1 mt-3 p-2 border-2 rounded-md bg-black drop-shadow-lg " style ="background-color: rgba(248,113,113,.9);">
				<div>
					<div class="flex flex-col w-full gap-2 pb-1 drop-shadow-lg border-2">
					<p class="font-medium mt-5 text-3xl pl-12"><?php echo $cancelled ?></p>
					<p class="font-medium mt-2 text-lg pl-6">Cancelled</p>
					<div class="absolute right-0  flex items-center " style="opacity:.50;height:90px;	width:90px;">
					<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M28.6,11.4h5.1c0.6,0,1.1-0.5,1.1-1.1c0-0.3-0.1-0.5-0.3-0.8l-7.2-7.1c-0.2-0.2-0.4-0.3-0.7-0.3 c-0.6,0-1.1,0.5-1.1,1.1v5.1C25.5,10,26.9,11.4,28.6,11.4z"></path> <path d="M24.6,40.6c0-6.8,4.2-12.6,10.2-14.9v-8.1c0-0.9-0.7-1.6-1.6-1.6h-7.8c-2.6,0-4.7-2.1-4.7-4.6V3.6 c0.1-0.8-0.6-1.5-1.5-1.5H6.8c-2.6,0-4.7,2.1-4.7,4.6v29.4c0,2.6,2.1,4.6,4.7,4.6h17.8C24.6,40.7,24.6,40.6,24.6,40.6z"></path> </g> <path d="M31.8,34.6l6,6l-6,6c-0.6,0.6-0.6,1.6,0,2.1l0.7,0.7c0.6,0.6,1.6,0.6,2.1,0l6-6l6,6c0.6,0.6,1.6,0.6,2.1,0 l0.7-0.7c0.6-0.6,0.6-1.6,0-2.1l-6-6l6-6c0.6-0.6,0.6-1.6,0-2.1l-0.7-0.7c-0.6-0.6-1.6-0.6-2.1,0l-6,6l-6-6c-0.6-0.6-1.6-0.6-2.1,0 l-0.7,0.7C31.2,33,31.2,34,31.8,34.6z"></path> </g> </g></svg>
				</div>
				</div>
				</div>
			</div>
			<div class="flex flex-col w-1/3 gap-1 mt-3 p-2 border-2 rounded-md  drop-shadow-lg hover:bg-slate-200 hover:bg-slate-200" style ="background-color: rgba(220,38,38,.7);">
				<div>
					<div class="flex flex-col w-full  gap-2 pb-1 drop-shadow-lg border-2">
						<p class="font-medium mt-5 text-4xl pl-12"><?php echo $rejected ?></p>
						<p class="font-medium mt-2 text-lg pl-6">Declined</p>
						<div class="absolute right-0  flex items-center " style="opacity:.50;height:90px;	width:90px;">
						<svg fill="#000000" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 53 53" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M45.707,10.074l-9.794-9.782C35.726,0.105,35.471,0,35.206,0H8C7.447,0,7,0.447,7,1v51c0,0.553,0.447,1,1,1h37 c0.553,0,1-0.447,1-1V10.782C46,10.517,45.895,10.263,45.707,10.074z M42.586,10H36V3.414L42.586,10z M9,51V2h25v9 c0,0.553,0.447,1,1,1h9v39H9z"></path> <path d="M26.5,16C19.056,16,13,22.056,13,29.5S19.056,43,26.5,43S40,36.944,40,29.5S33.944,16,26.5,16z M26.5,18 c2.892,0,5.532,1.082,7.555,2.851L17.851,37.055C16.082,35.032,15,32.393,15,29.5C15,23.159,20.159,18,26.5,18z M26.5,41 c-2.729,0-5.237-0.96-7.211-2.555l16.156-16.156C37.04,24.263,38,26.771,38,29.5C38,35.841,32.841,41,26.5,41z"></path> </g> </g> </g></svg>
					</div>
					</div>
				</div>
				</div>	
			</div> 
		</div>
	</div>
</div>

<div class="flex flex-col mt-1 gap-2 pb-24">
	<div class="flex flex-col">
		<p class="text-lg font-medium">Document Request</p>
		<p class="text-sm text-slate-500">Academic, good moral, and statement of account document requests and progress frequency</p>
		<div class="flex gap-2">
			<div class="flex flex-col w-2/6 bg-white gap-1 mt-5 p-4 border rounded-md">
				<div>
					<p class="font-medium">Frequency of Request by Document</p>
					<p class="text-sm text-slate-500">Your request frequency by document for document request</p>
				</div>

				<table class="w-full table-fixed mt-3">
					
					<tr>
						<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Document</td>
						<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Transcript of Records</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $tor ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Honorable Dismissal</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $dismissal ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Diploma</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $diploma ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Gradeslip</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $gradeslip ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Certified True Copy</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $ctc ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Good Moral Certificate</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $goodmoral ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Statement Of Account</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $soa ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Order of Payment</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $oop ?></span></td>
					</tr>

					<tr >
						<td width="80" class="p-1 pl-2 border text-sm ">Others</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $others ?></span></td>
					</tr>
				</table>
			</div>

			<div class="flex flex-col gap-1 w-2/6 bg-white mt-5 p-4 border rounded-md">
				<div>
					<p class="font-medium">Frequency of Request by Status</p>
					<p class="text-sm text-slate-500">Your request frequency by status for document request</p>
				</div>

				<table class="w-full table-fixed mt-3">
					
					<tr>
						<th width="70" class="text-left text-sm bg-slate-100 font-medium py-2 pl-2 border border">Status</td>
						<th width="30" class="py-2 border text-sm bg-slate-100 font-medium">Frequency</td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Pending</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $pending ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Accepted</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $accepted ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Declined</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $rejected ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">For Payment</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $forpayment ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">In Process</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $inprocess ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">For Claiming</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $forclaiming ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Completed</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $completed ?></span></td>
					</tr>

					<tr>
						<td width="80" class="p-1 pl-2 border text-sm ">Cancelled</td>
						<td width="20" class="p-1 text-center border bg-slate-50"><span ><?php echo $cancelled ?></span></td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="flex flex-col mt-5">
		<p class="text-lg font-medium">Recent Activities</p>
		<p class="text-sm text-slate-500">
			<?php
				echo date('d F Y');
			?>	
		</p>

		<div class="flex flex-col w-1/2 mt-5">
			<?php if(count($data['recent-activity']) > 0): ?>
				<?php foreach($data['recent-activity'] as $row): ?>
					<div class="before:content-[''] before:absolute before:top-0 before:left-0 before:w-0.5 before:h-full before:bg-slate-200 flex flex-col gap-1 pl-6 py-3">
						<div class="absolute w-2 h-2 rounded-full bg-slate-300 -left-[3px] top-8"></div>
						<p><?php echo ucwords($row->description) ?></p>
						<?php
							$dtacted = new DateTime($row->date_acted);
							$dtacted = $dtacted->format('d F Y');
						?>
						<p class="text-sm text-orange-700"><?php echo $dtacted ?></p>
					</div>
				<?php endforeach;?>
			<?php else: ?>
					<div class="before:content-[''] before:absolute before:top-0 before:left-0 before:w-0.5 before:h-full before:bg-slate-200 flex flex-col gap-1 pl-6 py-3">
						<div class="absolute w-2 h-2 rounded-full bg-slate-300 -left-[3px] top-5"></div>
						<p class="text-slate-500">no activity found</p>
					</div>
			<?php endif; ?>
		</div>
	</div>
</div>


<script>
	<?php
		require APPROOT.'/views/user/dashboard/sysadmin/sysadmin.js';
	?>
</script>