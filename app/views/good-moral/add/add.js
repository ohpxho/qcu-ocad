$(document).ready(function() {
	const availability = <?php echo json_encode($data['request-availability']) ?>;

	$(window).load(function() {
		disallowAddingNewDocumentIfHasOngoingrequest(availability);
	});

	 function disallowAddingNewDocumentIfHasOngoingrequest(hasOngoing) {
        if(hasOngoing['GOOD_MORAL'] > 0) {
            $('#add-request-btn').attr('disabled', 'disabled');
            $('#add-request-btn').addClass('opacity-50 cursor-not-allowed');
            $('#add-request-btn-con').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
        }
    }
});