$(document).ready( function () {

    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const purposeInFocus = $('#purpose-filter option:selected').val().toLowerCase() || '';
        const purposeInRow = (data[3] || '').toLowerCase();

        const typeInFocus = $('#type-filter option:selected').val().toLowerCase() || '';
        const typeInRow = (data[4] || '').toLowerCase();
        
        if(
            (purposeInFocus == '' && typeInFocus == '') ||
            (purposeInFocus == purposeInRow && typeInFocus == '') ||
            (purposeInFocus == '' && typeInFocus == typeInRow) ||
            (purposeInFocus == purposeInRow && typeInFocus == typeInRow)
        ) {
            return true;
        }
        
        return false;
    });

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
        $('#update-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('.update-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForUpdatePanel(id);
        $('#update-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('#update-exit-btn').click(function() {
        $('#update-panel').removeClass('right-0').toggleClass('-right-full');
    });

    $('#status').click(function() {
        const id = $('#request-id').text();
        requestAndSetupForUpdatePanel(id)
        $('#update-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    });
    
    //optimize here....
    $('#update-panel #initial-submit').click(function(e) {
        e.preventDefault();
        $('#update-panel #email-format #email-format-payslip').addClass('hidden');
        $('#update-panel #email-format #email-format-payslip input[name="payslip"]').val('');
        const requestId = $('#update-panel input[name="request-id"]').val();
        const studentId = $('#update-panel input[name="student-id"]').val();
        const type = $('#update-panel input[name="type"]').val();
        const doc = $('#update-panel input[name="requested-document"]').val();
        
        const status = $('#update-panel select[name="status"]').val();
        if(status == '') return false; 

        const message = getMessageEquivOfStatusInDocumentRequest(status, doc);

        if(type == 'student') details = getStudentDetails(studentId);
        else details = getAlumniDetails(studentId);

        details.done(function(result) {     
            result = JSON.parse(result);
            $('#update-panel #email-format input[name="email"]').val(result.email);
            $('#update-panel #email-format input[name="contact"]').val(result.contact);
            $('#update-panel #email-format textarea[name="message"]').text(message);

            $('#update-panel #email-format').removeClass('hidden');
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });     

        return false;
    });


    $('#update-panel #email-format #email-format-exit-btn').click(function() {
        $('#update-panel #email-format input[name="email"]').val('');
        $('#update-panel #email-format input[name="contact"]').val('');
        $('#update-panel #email-format').addClass('hidden');
    });

    $('#update-panel #email-format input[name="submit"]').click(function() {
        $('#update-panel #email-format loader').removeClass('hidden');
    });

    //optimize here....
    $('#multiple-update-panel #initial-submit').click(function(e) {
        e.preventDefault();
        const requestIds = $('#multiple-update-panel input[name="request-ids"]').val().split(',');
        const studentIds = $('#multiple-update-panel input[name="student-ids"]').val().split(',');
        const types = $('#multiple-update-panel input[name="types"]').val().split(',');
        const docs = $('#multiple-update-panel input[name="docs"]').val().split(',');
        
        const status = $('#multiple-update-panel select[name="multiple-update-status"]').val();
        if(status == '') return false; 

        let emails = [];
        let contacts = [];
        let messages = [];

        $.each(studentIds, function(key, id) {
            messages.push(getMessageEquivOfStatusInDocumentRequest(status, docs[key]));
            $('#multiple-update-panel #email-format textarea[name="messages"]').text(messages.join(' & '));

            if(types[key] == 'student') details = getStudentDetails(id);
            else details = getAlumniDetails(id);
        
            details.done(function(result) {
                result = JSON.parse(result);
                emails.push(result.email.trim());
                contacts.push(result.contact.trim());
                $('#multiple-update-panel #email-format input[name="emails"]').val(emails.join(' & '));
                $('#multiple-update-panel #email-format input[name="contacts"]').val(contacts.join(' & '));
            });

            details.fail(function(jqXHR, textStatus) {
                alert(textStatus);
            });
        }); 
        
        $('#multiple-update-panel #email-format').removeClass('hidden');
                
        return false;
    });

    $('#multiple-update-panel #email-format #email-format-exit-btn').click(function() {
        $('#multiple-update-panel #email-format input[name="emails"]').val('');
        $('#multiple-update-panel #email-format input[name="contacts"]').val('');
        $('#multiple-update-panel #email-format').addClass('hidden');
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

    $('#update-multiple-row-selection-btn').click(function() {
        $('#view-panel').removeClass('right-0').addClass('-right-full');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
        $('#multiple-update-panel').removeClass('-right-full').toggleClass('right-0');
        const details = getDetailsOfAllRowsSelected();
        $('#multiple-update-panel input[name="request-ids"]').val(details['request-ids'].join(','));
        $('#multiple-update-panel input[name="student-ids"]').val(details['student-ids'].join(','));
        $('#multiple-update-panel input[name="docs"]').val(details['docs'].join(','));
        $('#multiple-update-panel input[name="types"]').val(details['types'].join(','));

    });

    function getDetailsOfAllRowsSelected() {
        let details = {
            'request-ids' : [],
            'student-ids' : [],
            'docs' : [],
            'types' : []
        };
        
        $('.row-checkbox').each(function() {
            if(this.checked) {
                const studentId = $(this).closest('tr').find('td:eq(1)').text().trim();
                details['student-ids'].push(studentId);

                const requestId = $(this).closest('tr').find('td:eq(0)').text().trim();
                details['request-ids'].push(requestId);

                details['docs'].push('Good Moral Certificate');

                const type = $(this).closest('tr').find('td:eq(4)').text().trim();
                details['types'].push(type);
            }
        });

        return details;   
    }

     /**
    * onclick event of mulltple update exit button, hide multiple update panel
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
            url: "/qcu-ocad/good_moral/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setUpdatePanel(details) {
        $('#update-request-id').text(`(${details.id})`);
        $('select[name="status"]').val(details.status);
        $('textarea[name="remarks"]').val(details.remarks);
        $('input[name="request-id"]').val(details.id);
        $('input[name="student-id"]').val(details.student_id);
        $('input[name="type"]').val(details.type);
        $('input[name="requested-document"]').val('Good Moral Certificate');
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStatusProps(details.status);
        setViewDocumentRequestedProps();
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details);
        setViewQuantity(details.quantity);

        if(details.type=='student') setViewStudentInformation(details.student_id);
        else setViewAlumniInformation(details.student_id);

        if(details.price > 0) {
            $('#view-panel #generate-oop-btn').attr('data-request', details.id);
            setViewPaymentInformation(details.price);
        } else {
             $('#payment-info').addClass('hidden');
        }

        setViewRemarks(details.remarks);
    }

    function setViewID(id) {
        $('#view-panel #request-id').text(`(${id})`);
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

     function setViewStudentInformation(id) {
        $('#student-info').removeClass('hidden');
        $('#alumni-info').addClass('hidden');
        
        const student = getStudentDetails(id);

        student.done(function(result) {
            result = JSON.parse(result);
            $('#stud-name').text(`${result.lname}, ${result.fname} ${result.mname}`);
            $('#stud-course').text(result.course.toUpperCase());
            $('#stud-year').text(result.year);
            $('#stud-section').text(result.section);
        });

        student.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    function setViewAlumniInformation(id) {
        $('#alumni-info').removeClass('hidden');
        $('#student-info').addClass('hidden');
        
        const alumni = getAlumniDetails(id);

        alumni.done(function(result) {
            result = JSON.parse(result);
            $('#alum-name').text(`${result.lname}, ${result.fname} ${result.mname}`);
            $('#alum-course').text(result.course.toUpperCase());
            $('#alum-year').text(result.year_graduated);
            $('#alum-section').text(result.section);
        });

        alumni.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    function setViewQuantity(quantity) {
        $('#view-panel #quantity').text(quantity);
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

    $('.generate-oop-btn').click(function() {
        const id = $(this).attr('data-request');
  
        const request = getRequestDetails(id);

        request.done(function(result) {
            req = JSON.parse(result);

            const oop = getOrderOfPaymentDetails(id);

            oop.done(function(result) {
                order = JSON.parse(result);

                let student = '';

                if(req.type == 'student') student = getStudentDetails(req.student_id);
                else student = getAlumniDetails(req.student_id);

                student.done(function(result) {
                    stud = JSON.parse(result);

                    $('#oop-modal #oop-no').text(order.id);
                    $('#oop-modal #oop-id').text(stud.id);
                    $('#oop-modal #oop-name').text(`${stud.lname} ${stud.fname} ${stud.mname}`);
                    $('#oop-modal #oop-price').text(req.price);
                    $('#oop-modal #oop-doc').text(`${req.quantity} Good Moral Certificate`);

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
            url: "/qcu-ocad/good_moral/oop",
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


