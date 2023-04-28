$(document).ready(function() {
	const availability = <?php echo json_encode($data['request-availability']) ?>;

	$(window).load(function() {
		disallowInputs(availability);
	});

	$('input[type="checkbox"]').change(function() {
        if(this.checked) {
            $('input[type="checkbox"]').prop('checked', false).change();
            $(this).prop('checked', true);
        }
    });

	function disallowInputs(hasOngoing) {
        if(hasOngoing['SOA'] > 0) {
            $('#soa-checkbox').prop('disabled', true);
            $('#soa-text > p:first-child > span:first-child').addClass('line-through');
            $('#soa-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
        }

        if(hasOngoing['ORDER_OF_PAYMENT'] > 0) {
            $('#order-of-payment-checkbox').prop('disabled', true);
            $('#order-of-payment-text > p:first-child > span:first-child').addClass('line-through');
            $('#order-of-payment-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
        }
    }
});