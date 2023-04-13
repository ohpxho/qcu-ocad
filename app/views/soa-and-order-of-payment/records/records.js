$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        setActivityGraph('SOA_DOCUMENT_REQUEST', new Date().getFullYear());
    }); 

    let table = $('#request-table').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        search: {
            'regex': true
        },
        buttons: [
            'excelHtml5'
        ]
    });

    $('#export-table-btn').click(function() {
        $('.buttons-excel').click();
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const purposeInFocus = $('#purpose-filter option:selected').val() || '';
        const purposeInRow = (data[3] || '');
        
        if(purposeInFocus == '' || purposeInFocus == purposeInRow) return true;
        
        return false;
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
        const result = confirm("Are you sure? You want to delete this.");
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

    $('#add-request-btn').click(function() {
         $('#add-panel').removeClass('-right-full').toggleClass('right-0');
    });

    $('#add-exit-btn').click(function() {
         $('#add-panel').removeClass('right-0').toggleClass('-right-full');
    });

    $('#edit-exit-btn').click(function() {
         $('#edit-panel').removeClass('right-0').toggleClass('-right-full');
    });

    $('#add-panel select[name="purpose"] ').change(function() {
        const selectedOption = $('#add-panel select[name="purpose"] option:selected').val();
        const othersOptionValue = 8;
        if(selectedOption == othersOptionValue) {
            $('#add-panel #others-hidden-input').removeClass('hidden');
            $('#add-panel input[name="other-purpose"]').val('');
        } else $('#add-panel #others-hidden-input').addClass('hidden');
    });

    $('#edit-panel select[name="purpose"] ').change(function() {
        const selectedOption = $('#edit-panel select[name="purpose"] option:selected').val();
        const othersOptionValue = 8;
        if(selectedOption == othersOptionValue) {
            $('#edit-panel #others-hidden-input').removeClass('hidden');
            $('#edit-panel input[name="other-purpose"]').val('');
        } else $('#edit-panel #others-hidden-input').addClass('hidden');
    });

     /**
    * onclick event of status button, display update panel
    **/

    $('.status-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForUpdatePanel(id);
        $('#edit-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('.edit-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForUpdatePanel(id);
        $('#edit-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('#status').click(function() {
        const id = $('#request-id').text();
        requestAndSetupForUpdatePanel(id)
        $('#edit-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    });

    function requestAndSetupForUpdatePanel(id) {
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setUpdatePanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    function setUpdatePanel(details) {
        $('#edit-panel #request-id').text(`#${details.id}`);
        $('#edit-panel select[name="status"]').val(details.status);
        $('#edit-panel textarea[name="remarks"]').val(details.remarks);
        $('#edit-panel input[name="request-id"]').val(details.id);
        $('#edit-panel input[name="student-id"]').val(details.student_id);

        if(details.status == 'awaiting payment confirmation') {
            $('#update-panel #amount-form-group').removeClass('hidden');
            $('#update-panel input[name="price"]').val(details.price);
         } else {
            $('#update-panel #amount-form-group').addClass('hidden');
            $('#update-panel input[name="price"]').val(0);
         }
    }

    /**
    * onchange event for select all row checkbox, check all rows
    **/

    $('#select-all-row-checkbox').change(function() {
        if(this.checked) {
            $('.row-checkbox').each(function() {
                $(this).prop('checked', true);
            });
            enableMultipleRowSelectionButtons();
        } else {
            $('.row-checkbox').each(function() {
                $(this).prop('checked', false);
            });
            disableMultipleRowSelectionButtons();
        }
    });

    $('.row-checkbox').change(function() {
        let signal = 0;
        $('.row-checkbox').each(function() {
            if(this.checked) {
                signal = 1;
            } 
        });

        if(signal) enableMultipleRowSelectionButtons();
        else disableMultipleRowSelectionButtons();
    });

    $('#drop-multiple-row-selection-btn').click(function() {
        const result = confirm("Are you sure? You want to delete these.");
        if(!result) {
            return false;
        }

        $('input[name="request-ids-to-drop"]').val(getRequestIDOfAllRowsSelected().join(','));
        $('#multiple-drop-form').submit();
    });

    function enableMultipleRowSelectionButtons() {
        $('#update-multiple-row-selection-btn').removeClass('opacity-50 cursor-not-allowed').addClass('cursor-pointer');
        $('#drop-multiple-row-selection-btn').removeClass('opacity-50 cursor-not-allowed').addClass('cursor-pointer');
        $('#update-multiple-row-selection-btn').prop('disabled', false);
        $('#drop-multiple-row-selection-btn').prop('disabled', false);
    }

    function disableMultipleRowSelectionButtons() {
        $('#update-multiple-row-selection-btn').addClass('opacity-50 cursor-not-allowed');
        $('#drop-multiple-row-selection-btn').addClass('opacity-50 cursor-not-allowed');    
        $('#update-multiple-row-selection-btn').prop('disabled', true);
        $('#drop-multiple-row-selection-btn').prop('disabled', true);    
    }
    
    $('#update-multiple-row-selection-btn').click(function() {
        $('#view-panel').removeClass('right-0').addClass('-right-full');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
        $('#multiple-update-panel').removeClass('-right-full').toggleClass('right-0');
        setMultipleUpdateReqestIDsInput();
        setMultipleUpdateStudentIDsInput();
    });

     /**
    * onclick event of mulltple update exit button, hide multiple update panel
    **/

    $('#multiple-update-exit-btn').click(function() {
        $('#multiple-update-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    function setMultipleUpdateReqestIDsInput() {
        let ids = getRequestIDOfAllRowsSelected();
        $('input[name="request-ids"]').val(ids.join(','));
    } 

    function setMultipleUpdateStudentIDsInput() {
        let ids = getStudentIDOfAllRowsSelected();
        $('input[name="student-ids"]').val(ids.join(','));
    } 

    function getRequestIDOfAllRowsSelected() {
        let ids = [];
        
        $('.row-checkbox').each(function() {
            if(this.checked) {
                const id = $(this).closest('tr').find('td:first').text();
                ids.push(id);
            }
        });

        return ids;        
    }

    function getStudentIDOfAllRowsSelected() {
        let ids = [];
        
        $('.row-checkbox').each(function() {
            if(this.checked) {
                const id = $(this).closest('tr').find('td:eq(1)').text();
                ids.push(id);
            }
        });

        return ids;   
    }

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
        setViewDocumentRequestedProps();
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details);
        setViewStudentInformation(details.student_id);
        setViewRemarks(details.remarks);
        setViewQuantity(details.quantity);

        if(details.price > 0) {
            $('#view-panel #generate-oop-btn').attr('data-request', details.id);
            setViewPaymentInformation(details.price);
        }
    }

    function setViewID(id) {
        $('#view-panel #request-id').text(`(${id})`);
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

     function setViewStudentInformation(id) {
        const student = getStudentDetails(id);

        student.done(function(result) {
            result = JSON.parse(result);
            $('#stud-id').text(formatStudentID(id));
            $('#name').text(`${result.lname}, ${result.fname} ${result.mname}`);
            $('#course').text(result.course.toUpperCase());
            $('#year').text(formatYearLevel(result.year));
            $('#section').text(result.section);
        });

        student.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    function getStudentDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/student/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setViewRemarks(remarks) {
        if(remarks != "") {
            $('#view-panel #remarks').text(remarks);
        } else {
            $('#view-panel #remarks').text('...');
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
                
                let doc = '';

                if(req.requested_document == 'soa') doc = 'Statement of Account';
                if(req.requested_document == 'order of payment') doc = 'Order of Payment';

                $('#oop-modal #oop-doc').text(`${req.quantity} ${doc}`);

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


