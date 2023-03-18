$(document).ready( function () {
    const IS_THERE_A_CHANGE_FLAG = <?php echo json_encode($data['data-changes-flag']) ?>;
    const availability = <?php echo json_encode($data['request-availability']) ?>;
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        disallowInputs(availability);
        setActivityGraph('SOA_DOCUMENT_REQUEST', new Date().getFullYear());
    });

    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    conn.onopen = function(e) {
        console.log("Connection established!");
        broadcastOnlineToAllOnlineUsers(ID);
        sendWSMsgIfThereAreChangesInData();
    };

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const statusInFocus = $('#status-filter option:selected').val().toLowerCase();
        const statusInRow = (data[4] || '').toLowerCase();
        
        if(statusInFocus == statusInRow || statusInFocus == '') {
            return true;
        }

        return false;
    });

    function sendWSMsgIfThereAreChangesInData() {
        if(IS_THERE_A_CHANGE_FLAG) {
            const msg = JSON.stringify({action: 'DOCUMENT_REQUEST_ACTION'});
            conn.send(msg);   
        }
    }

    function setActivityGraph(action, year) {
        const details = {
            actor: ID,
            action: action,
            year: year
        };

        const activity = getAllActivitiesByActorAndActionAndYear(details); 

        activity.done(function(result) {
            result = JSON.parse(result);
            const data = getFrequencyOfActivities(result);
            renderCalenderActivityGraph('calendar-activity-graph', year, data);
        });

        activity.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    $('#search').on('keyup', function() {
         table
            .search( this.value )
            .draw();
    });

    $('#search-btn').on('click', function() {
        table.draw();
    });

    /**
    * onclick event of delete button, display confirmation message
    **/

    $('.drop-btn').click(function() {
        const result = confirm("Are you sure? You want to cancel this.");
        if(!result) {
            return false;
        } 
        
    });

    $('input[type="checkbox"]').change(function() {
        if(this.checked) {
            $('input[type="checkbox"]').prop('checked', false).change();
            $(this).prop('checked', true);
        }
    });

    /**
    * onclick event of view button, display view panel
    **/

    $('.view-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setViewPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
    }); 

    /**
    * onclick event of view exit button, hide view panel
    **/


    $('#view-exit-btn').click(function() {
        $('#view-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    $('#add-request-btn').click(function() {
        if ($(this).is('[disabled]')) {
            return false;
        }

    	$('#add-panel').removeClass('-right-full').toggleClass('right-0');
    });

    $('#add-exit-btn').click(function() {
    	 $('#add-panel').removeClass('right-0').toggleClass('-right-full');
    });

    $('.edit-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setEditPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        $('#edit-panel').removeClass('-right-full').toggleClass('right-0');
    });

    $('#edit-exit-btn').click(function() {
         $('#edit-panel').removeClass('right-0').toggleClass('-right-full');
    });

    $('#add-panel select[name="purpose"] ').change(function() {
    	const selectedOption = $('#add-panel select[name="purpose"] option:selected').val();
    	if(selectedOption == 'Others') {
            $('#add-panel #others-hidden-input').removeClass('hidden');
            $('#add-panel input[name="other-purpose"]').val('');
        } else $('#add-panel #others-hidden-input').addClass('hidden');
    });

    $('#edit-panel select[name="purpose"] ').change(function() {
        const selectedOption = $('#edit-panel select[name="purpose"] option:selected').val();
        if(selectedOption == 'Others') {
            $('#edit-panel #others-hidden-input').removeClass('hidden');
            $('#edit-panel input[name="other-purpose"]').val('');
        } else $('#edit-panel #others-hidden-input').addClass('hidden');
    });

    function getRequestDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/soa_and_order_of_payment/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStatusProps(details.status);
        setViewDocumentRequestedProps(details);
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details);
        setViewRemarks(details.remarks);
    }

    function setViewID(id) {
        $('#view-panel #request-id').text(`( ${formatRequestId(id)} )`);
    }

    function setViewStatusProps(status) {
        switch(status) {
            case 'pending':
                $('#view-panel #status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1');
                break;
            case 'accepted':
                $('#view-panel #status').removeClass().addClass('bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1');
                break;
            case 'rejected':
                $('#view-panel #status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1');
                break;
            case 'in process':
                $('#view-panel #status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1');
                break;
            case 'accepted':
                $('#view-panel #for claiming').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1');
                break;
            default:
                $('#view-panel #status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1');
        }

        $('#view-panel #status').text(status);          
    }

    function setViewDocumentRequestedProps(details) {
        if(details.requested_document == 'soa') {
            $('#view-panel #documents').text('Statement of Account');
        } else {
            $('#view-panel #documents').text('Order of Payment');
        }
        
    }

    function setViewDateCreated(dt) {
        if(dt != null) $('#view-panel #date-created').text(formatDate(dt));
        else $('#view-panel #date-created').text('-- -- ----');
    }

    function setViewDateCompleted(dt) {
        if(dt != null) $('#view-panel #date-completed').text(formatDate(dt));
        else $('#view-panel #date-completed').text('-- -- ----');
    }

    function setViewPurposeOfRequest(details) {
        if(details.purpose == 'Others') $('#view-panel #purpose').text(details.other_purpose);
        else $('#view-panel #purpose').text(details.purpose);
    }

    function setViewRemarks(remarks) {
        if(remarks != "") {
            $('#view-panel #remarks').text(remarks);
        } else {
            $('#view-panel #remarks').text('...');
        }
    }

    function setEditPanel(details) {
        $('#edit-panel #request-id').text(`( ${formatRequestId(details.id)} )`);
         $('#edit-panel input[name="request-id"]').val(details.id);
         $('#edit-panel select[name="purpose"] option').each(function() {
            const optionValue = $(this).val();

            if(optionValue == details.purpose) {
                $(this).prop('selected', true);
                if(optionValue == 'Others') {
                    $('#edit-panel #others-hidden-input').removeClass('hidden');
                    $('#edit-panel input[name="other-purpose"]').val(details.other_purpose);
                } else {
                    $('#edit-panel #others-hidden-input').addClass('hidden');
                }
            }


         });
         $('#uploaded-file').text(getFilenameFromPath(details.identification_document));
         $('#uploaded-file').prop('href', `${<?php echo json_encode(URLROOT) ?>}${details.identification_document}`);
    }

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


