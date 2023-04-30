$(document).ready( function () {
    const IS_THERE_A_CHANGE_FLAG = <?php echo json_encode($data['data-changes-flag']) ?>;
    const availability = <?php echo json_encode($data['request-availability']) ?>;
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        disallowInputs(availability);
        setActivityGraph('SOA_DOCUMENT_REQUEST', new Date().getFullYear());
    });

    let ongoing_table = $('#ongoing-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    let history_table = $('#history-table').DataTable({
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

    function sendWSMsgIfThereAreChangesInData() {
        if(IS_THERE_A_CHANGE_FLAG) {
            const msg = JSON.stringify({action: 'DOCUMENT_REQUEST_ACTION'});
            conn.send(msg);   
        }
    }

    function notify() {        
        const msg = {
            action: 'DOCUMENT_REQUEST_ACTION',
            id: ID,
            department: 'finance'
        };

        conn.send(JSON.stringify(msg));
    }

    $('#add-request-form').submit(function(e) {
        notify();
        return true;
    });

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
        history_table
            .search( this.value )
            .draw();
    });

    $('#search-btn').on('click', function() {
        history_table.draw();
    });

    /**
    * onclick event of delete button, display confirmation message
    **/

    $('.drop-btn').click(function() {
        const result = confirm("Are you sure? You want to cancel this.");
        if(!result) {
            return false;
        } 
        
        notify();
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
        $('#view-panel #payment-info').addClass('hidden');
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
            setEditPanel(result, availability);
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

    $('.confirm-payment-btn').click(function() {
        const confirmation = window.confirm('Are you sure you want to confirm payment?');
        if(!confirmation) return false;

        notify();
    });

    function getRequestDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/student_account/details",
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
        setViewQuantity(details.quantity);
        setViewRemarks(details.remarks);

        if(details.price > 0) {
            $('#view-panel #generate-oop-btn').attr('data-request', details.id);
            setViewPaymentInformation(details.price);
        } else {
            $('#payment-info').addClass('hidden');
        }
    }

    function setViewID(id) {
        $('#view-panel #request-id').text(`( ${formatRequestId(id)} )`);
    }

    function setViewStatusProps(status) {
         switch(status) {
            case 'pending':
                $('#status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
             case 'awaiting payment confirmation':
                $('#status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
            case 'accepted':
                $('#status').removeClass().addClass('bg-cyan-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'rejected':
                $('#status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'cancelled':
                $('#status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for process':
                $('#status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for payment':
                $('#status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for claiming':
                $('#status').removeClass().addClass('bg-blue-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            default:
                $('#status').removeClass().addClass('bg-green-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
        }

        if(status=='rejected') status='declined';
        
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

    function setViewQuantity(quantity) {
        $('#view-panel #quantity').text(quantity || 1);
    }

    function setViewPaymentInformation(price) {
        $('#payment-info').removeClass('hidden');
        $('#price').text(`P ${price}`);
    }

    function setViewRemarks(remarks) {
        if(remarks != "") {
            $('#view-panel #remarks').text(remarks);
        } else {
            $('#view-panel #remarks').text('...');
        }
    }

    function setEditPanel(details, hasOngoing) {
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

         $('#edit-panel input[name="requested-document"]').each(function() {
            if($(this).val() == details.requested_document) {
                $(this).prop('checked', true);
            }
         });

        if(details.requested_document != 'soa' && hasOngoing['SOA'] > 0) {
            $('#edit-panel #soa-checkbox').prop('disabled', true);
            $('#edit-panel #soa-text > p:first-child > span:first-child').addClass('line-through');
            $('#edit-panel #soa-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
        }

        if(details.requested_document != 'order of payment' && hasOngoing['ORDER_OF_PAYMENT'] > 0) {
            $('#edit-panel #order-of-payment-checkbox').prop('disabled', true);
            $('#edit-panel #order-of-payment-text > p:first-child > span:first-child').addClass('line-through');
            $('#edit-panel #order-of-payment-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
        }
    }

     function disallowInputs(hasOngoing) {
        if(hasOngoing['SOA'] > 0) {
            $('#add-panel #soa-checkbox').prop('disabled', true);
            $('#add-panel #soa-text > p:first-child > span:first-child').addClass('line-through');
            $('#add-panel #soa-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
        }

        if(hasOngoing['ORDER_OF_PAYMENT'] > 0) {
            $('#add-panel #order-of-payment-checkbox').prop('disabled', true);
            $('#add-panel #order-of-payment-text > p:first-child > span:first-child').addClass('line-through');
            $('#add-panel #order-of-payment-text > p:first-child').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
        }
    }

     $('.generate-oop-btn').click(function() {
        const id = $(this).attr('data-request');
  
        const request = getRequestDetails(id);

        request.done(function(result) {
            
            req = JSON.parse(result);

            const oop = getOrderOfPaymentDetails(id);

            oop.done(function(result) {

                order = JSON.parse(result);

                const student = getStudentDetails(req.student_id);

                student.done(function(result) {
                    stud = JSON.parse(result);

                    $('#oop-modal #oop-no').text(order.id);
                    $('#oop-modal #oop-id').text(stud.id);
                    $('#oop-modal #oop-name').text(`${stud.lname} ${stud.fname} ${stud.mname}`);
                    $('#oop-modal #oop-price').text(req.price);

                    let doc = '';
                    
                    if(req.requested_document == 'soa') doc = 'Statement of Account';
                    else doc = 'Order of Payment';

                    $('#oop-modal #oop-doc').text(`${req.quantity} ${doc}`);

                    $('#oop-modal').removeClass('hidden');
                });

                student.fail(function(jqXHR, textStatus) {
                    alert(result);
                });
            });


            oop.fail(function(jqXHR, textStatus) {
                alert(textStatus);
            });
        });

        request.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        return false
    });

    function getOrderOfPaymentDetails(id) {
         return $.ajax({
            url: "/qcu-ocad/student_account/oop",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    $('#oop-exit-btn').click(function() {
        $('#oop-modal').addClass('hidden');
        return false;
    });

    $('#upload-oop').click(function() {
        const htmlElement = document.querySelector('#oop-body');

        html2canvas(htmlElement).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a5');
            pdf.addImage(imgData, 'PNG', 0, 0, pdf.internal.pageSize.getWidth(), 0, null, 'FAST');

            pdf.save(`QCU OCAD - Order of Payment.pdf`);
        });

        return false;
    })
});


