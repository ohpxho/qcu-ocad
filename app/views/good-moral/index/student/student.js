$(document).ready( function () {
    const IS_THERE_A_CHANGE_FLAG = <?php echo json_encode($data['data-changes-flag']) ?>;
    const availability = <?php echo json_encode($data['request-availability']) ?>;
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        disallowAddingNewDocumentIfHasOngoingrequest(availability);
        setActivityGraph('GOOD_MORAL_DOCUMENT_REQUEST', new Date().getFullYear());
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

    
    $('.confirm-payment-btn').click(function() {
        const confirmation = window.confirm('Are you sure you want to confirm payment?');
        if(!confirmation) return false;
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
            url: "/qcu-ocad/good_moral/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStatusProps(details.status);
        setViewDocumentRequestedProps();
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details);
        setViewQuantity(details.quantity);
        setViewRemarks(details.remarks);

        if(details.price > 0) {
            $('#view-panel #generate-oop-btn').attr('data-request', details.id);
            setViewPaymentInformation(details.price);
        }
    }

    function setViewID(id) {
        $('#view-panel #request-id').text(`( ${formatRequestId(id)} )`);
    }

    function setViewStatusProps(status) {
        switch(status) {
            case 'pending':
                $('#view-panel #status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1');
                break;
            case 'awaiting payment confirmation':
                $('#view-panel #status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1');
                break;
            case 'accepted':
                $('#view-panel #status').removeClass().addClass('bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1');
                break;
            case 'rejected':
                $('#view-panel #status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1');
                break;
            case 'for process':
                $('#view-panel #status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1');
                break;
            case 'for claiming':
                $('#view-panel #status').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1');
                break;
            case 'cancelled':
                $('#view-panel #status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1');
                break;
            default:
                $('#view-panel #status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1');
        }

        if(status=='rejected') status='declined';
        
        $('#view-panel #status').text(status);          
    }

    function setViewDocumentRequestedProps(details) {
        $('#view-panel #documents').text('Good Moral');
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

    function setEditPanel(details) {
        $('#edit-panel #request-id').text(`( ${formatRequestId(details.id)} )`);
         $('#edit-panel input[name="request-id"]').val(details.id);
         $('#edit-panel select[name="purpose"] option').each(function() {
            const optionValue = $(this).val();
            const othersOptionValue = 8;

            if(optionValue == details.purpose) {
                $(this).prop('selected', true);
                if(optionValue == othersOptionValue) {
                    $('#edit-panel #others-hidden-input').removeClass('hidden');
                    $('#edit-panel input[name="other-purpose"]').val(details.other_purpose);
                } else {
                    $('#edit-panel #others-hidden-input').addClass('hidden');
                }
            }


         });
        
        $('#edit-panel input[name="quantity"]').val(details.quantity || 1);
    }

    function disallowAddingNewDocumentIfHasOngoingrequest(hasOngoing) {
        if(hasOngoing['GOOD_MORAL'] > 0) {
            $('#add-request-btn').attr('disabled', 'disabled');
            $('#add-request-btn').addClass('opacity-50 cursor-not-allowed');
            $('#add-request-btn-con').append('<span class="ml-3 no-underline text-sm text-red-500">you still have an ongoing request for this document</span>');
        }
    }

    $('#generate-oop-btn').click(function() {
        const id = $(this).data('request');

        const request = getRequestDetails(id);

        request.done(function(result) {
            req = JSON.parse(result);

            const student = getStudentDetails(req.student_id);

            student.done(function(result) {
                stud = JSON.parse(result);

                $('#oop-modal #oop-id').text(formatStudentID(stud.id));
                $('#oop-modal #oop-name').text(`${stud.lname} ${stud.fname} ${stud.mname}`);
                $('#oop-modal #oop-price').text(req.price);
                
                $('#oop-modal #oop-doc').text(`${req.quantity} Good Moral Certificate`);

                $('#oop-modal').removeClass('hidden');
            });

            student.fail(function(jqXHR, textStatus) {
                alert(result);
            });
        });

        request.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        return false
    });

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


