<?php 
	require APPROOT.'/views/layout/header.php';
	require APPROOT.'/views/layout/horizontal-navigation/index.php';
?>

<main class="flex flex-col w-full h-max min-h-full sm:bg-neutral-100 items-center pb-20" role="main">
	<div class="mt-32 w-full p-4 md:w-1/2">
		<a href="<?php echo URLROOT; ?>/home" title="back">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
			</svg>
		</a>

		<p class="font-medium text-xl mt-5">Privacy Statement</p>
		<p class="text-slate-500">Last updated: April 23, 2023</p>

		<p class="mt-5">The Quezon City University (QCU) Online Consultation and Document Request (OCAD) provides you access to its online services. The Services, its updates, enhancements, new features, and/or the addition of any new online service are subject to this privacy statement.</p>

		<p class="mt-3">QCU OCAD is very much aware in protecting your privacy and personal information. This privacy statement discloses the data we collect from you and how we use it. This privacy statement only applies to the Services.</p>

		<p class="font-medium text-xl mt-5">Collection of Personal Data</p>

		<p class="mt-5">QCU OCAD collects data to operate effectively and provide you the best experiences with our Services. You provide some of this data directly, such as when you update your profile, request a document or online consultation, send us feedback online, or contact us for inquiries and technical support.</p>

		<p class="mt-3">We also obtain data from third parties. We protect data obtained from third parties according to the practices described in this statement and any additional restrictions imposed by the source of the data. These third-party sources vary over time, but have included:</p>

		<ul class="mt-3 list-disc">
			<li>Social network when you grant permission to QCU OCAD Services to access your data on one or more networks,</li>
			<li>Publicly-available sources such as open government databases or other data in the public domain.</li>
		</ul>

		<p class="mt-3">You have choices about the data we collect. When you are asked to provide personal data, you may decline. But if you choose not to provide data that is necessary to provide a service or feature, you may not be able to use the Services.</p>
	</div>
</main>

<?php 
	require APPROOT.'/views/layout/footer.php';
?>
