$(document).ready( function () {
    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const typeInFocus = $('#type-filter option:selected').val().toLowerCase();
        const typeInRow = (data[5] || '').toLowerCase();

        const docInFocus = $('#document-filter option:selected').val().toLowerCase();
        const docInRow = (data[4] || '').toLowerCase(); 

        if(
            (typeInFocus == '' && docInFocus == '') ||
            (typeInFocus == typeInRow && docInFocus == '') ||
            (typeInFocus == '' && docInFocus == docInRow) ||
            (typeInFocus == typeInRow && docInFocus == docInRow)

        ) return true;

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
    * onclick event of action button, display action menu
    **/

    $('#action-dropdown-btn').click(function() {
        $('#action-card').toggleClass('show');
    }); 

    /**
    * onclick event of view button, display view panel
    **/

    $('.view-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForViewPanel(id);
        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('#request-id-btn').click(function() {
        const id = $('#update-request-id').text();
        requestAndSetupForViewPanel(id);
        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
    
    });

    function requestAndSetupForViewPanel(id) {
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setViewPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

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

            if(status == 'for payment') {
                const details = {
                    id : result.id,
                    name : `${result.lname}, ${result.fname} ${result.mname}`,
                    course : result.course,
                    doc: doc,
                    price : getPriceOfDoc(doc) 
                };

                const payslip = generatePaymentSlip(details); 
                $('#update-panel #email-format #email-format-payslip').removeClass('hidden');
                $('#update-panel #email-format #email-format-payslip input[name="payslip"]').val(payslip);
                $('#update-panel #email-format #email-format-payslip #payslip').html(`<embed class="w-full h-max" src="${payslip}" />`);
            }

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
                details['student-ids'].push(removeDashFromId(studentId));

                const requestId = $(this).closest('tr').find('td:eq(0)').text().trim();
                details['request-ids'].push(requestId);

                const doc = $(this).closest('tr').find('td:eq(4)').text().trim();
                details['docs'].push(doc);

                const type = $(this).closest('tr').find('td:eq(5)').text().trim();
                details['types'].push(type);
            }
        });

        return details;   
    }

    /**
    * onclick event of view exit button, hide view panel
    **/


    $('#view-exit-btn').click(function() {
        $('#view-panel').removeClass('right-0').toggleClass('-right-full');
        $('#view-panel #payment-info').addClass('hidden');$('#view-panel #payment-info').addClass('hidden');
    }); 

    /**
    * onclick event of view exit button, hide view panel
    **/


    $('#update-exit-btn').click(function() {
        $('#update-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    /**
    * onclick event of mulltple update exit button, hide multiple update panel
    **/

    $('#multiple-update-exit-btn').click(function() {
        $('#multiple-update-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    /**
    * onclick event of filter dropdown button, toggle filter modal
    **/

    $('#filter-dropdown-btn').click(function() {
        $('#filter-card').toggleClass('show');
    });

    /**
    * onchange event for appy all checkbox, check or uncheck filter options
    **/

    $('input[name="apply-all"]').change(function() {
        if(this.checked) {
            $('.filter-checkbox').each(function() {
                $(this).prop('checked', true);
            });
        } else {
            $('.filter-checkbox').each(function() {
                $(this).prop('checked', false);
            });
        }

    });

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

    $('#update-panel select[name="status"]').change(function() {
        $('#update-panel #amount-form-group').addClass('hidden');
        $('#update-panel input[name="price"]').val(0);

        if(this.value == 'awaiting payment confirmation') {
            $('#update-panel #amount-form-group').removeClass('hidden');
        }
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

    function getRequestDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/academic_document/details",
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

        let doc = '';

        if(details.is_tor_included) doc = 'Transcript of Records';
        if(details.is_diploma_included) doc = 'Diploma';
        if(details.is_honorable_dismissal_included) doc = 'Honorable Dismissal';
        if(details.is_gradeslip_included) doc = 'Gradeslip';
        if(details.is_ctc_included) doc = 'Certified True Copy';
        if(details.other_requested_document != '' && details.other_requested_document != null) doc = details.other_requested_document;

         $('input[name="requested-document"]').val(doc);

         if(details.status == 'awaiting payment confirmation') {
            $('#update-panel #amount-form-group').removeClass('hidden');
            $('#update-panel input[name="price"]').val(details.price);
         } else {
            $('#update-panel #amount-form-group').addClass('hidden');
            $('#update-panel input[name="price"]').val(0);
         }
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStudentID(details.student_id);
        setViewStatusProps(details.status);
        setViewDocumentRequestedProps(details);
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details);
        setViewQuantity(details.quantity);
        setViewBeneficiary(details);

        if(details.type=='student') setViewStudentInformation(details.student_id);
        else setViewAlumniInformation(details.student_id);
        
        if(details.price > 0) {
            $('#view-panel #generate-oop-btn').attr('data-request', details.id);
            setViewPaymentInformation(details.price);
        }

        setViewAdditionalInformation(details);
        setViewRemarks(details.remarks);

    }

    function setViewID(id) {
        $('#request-id').text(`(${id})`);
    }

    function setViewStudentID(id) {
        $('#student-id').text(formatStudentID(id));
    }

    function setViewStatusProps(status) {
        switch(status) {
            case 'pending':
                $('#status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 cursor-pointer text-sm py-1');
                break;
             case 'awaiting payment confirmation':
                $('#status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 cursor-pointer text-sm py-1');
                break;
            case 'accepted':
                $('#status').removeClass().addClass('bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'rejected':
                $('#status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'cancelled':
                $('#status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'in process':
                $('#status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'for payment':
                $('#status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'accepted':
                $('#status').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            default:
                $('#status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1 cursor-pointer');
        }

        if(status=='rejected') status='declined';

        $('#status').text(status);          
    }

    function setViewDocumentRequestedProps(details) {
        let documents = []

        if(details.is_tor_included) documents.push('TOR (undergraduate)');
        if(details.is_diploma_included) documents.push('Diploma');
        if(details.is_gradeslip_included) documents.push('Gradeslip');
        if(details.is_ctc_included) documents.push('Certified True Copy');      
        if(details.is_honorable_dismissal_included) documents.push('Honorable Dismissal');      
        if(details.other_requested_document != null && details.other_requested_document != '') documents.push(details.other_requested_document);

        $('#documents').text(documents.join(' & '));

    }

    function setViewDateCreated(dt) {
        if(dt != null) $('#date-created').text(formatDate(dt));
        else $('#date-created').text('-- -- ----');
    }

    function setViewDateCompleted(dt) {
        if(dt != null) $('#date-completed').text(formatDate(dt));
        else $('#date-completed').text('-- -- ----');
    }

    function setViewPurposeOfRequest(details) {
        $('#purpose').text(details.purpose_of_request);
    }

    function setViewBeneficiary(details) {
        if(details.is_RA11261_beneficiary == 'yes') {
            $('#beneficiary').html(`<a class="text-sky-700" href="<?php echo URLROOT;?>${details.barangay_certificate}">Barangay Certificate</a> & <a class="text-sky-700" href="<?php echo URLROOT;?>${details.oath_of_undertaking}">Oath Of Undertaking</a>`);
        } else {
            $('#beneficiary').html('<p class="text-slate-700">No</p>');
            
        }
    }

    function setViewQuantity(quantity) {
        $('#view-panel #quantity').text(quantity);
    }

    function setViewStudentInformation(id) {
        $('#student-info').removeClass('hidden');
        $('#alumni-info').addClass('hidden');
        
        const student = getStudentDetails(id);

        student.done(function(result) {
            result = JSON.parse(result);
            $('#stud-name').text(`${result.lname}, ${result.fname} ${result.mname}`);
            $('#stud-course').text(result.course.toUpperCase());
            $('#stud-year').text(formatYearLevel(result.year));
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

    function setViewPaymentInformation(price) {
        $('#payment-info').removeClass('hidden');
        $('#price').text(`P ${price}`);
    }

    function setViewAdditionalInformation(details) {
        $('#tor').addClass('hidden');
        $('#tor-price').addClass('hidden');
        $('#diploma').addClass('hidden');
        $('#gradeslip').addClass('hidden');
        $('#ctc').addClass('hidden');
        $('#other').addClass('hidden');
        
        if(details.is_tor_included) {
            $('#tor').removeClass('hidden');
            $('#tor-price').removeClass('hidden');
            $('#academic-year').text(details.tor_last_academic_year_attended);
        } 

        if(details.is_diploma_included) {
            $('#diploma').removeClass('hidden');
            $('#year-graduated').text(details.diploma_year_graduated);
        } 

        if(details.is_gradeslip_included) {
            const year = details.gradeslip_academic_year;
            const sem = formatUnivSemester(details.gradeslip_semester);

            $('#gradeslip').removeClass('hidden');
            $('#year-sem').text(`S.Y ${year} / ${sem} Sem`);
        } 

        if(details.is_ctc_included) {
            $('#ctc').removeClass('hidden');
            $('#ctc-document').attr('href', `<?php echo URLROOT;?>${details.ctc_document}`);
            $('#ctc-document').text(getFilenameFromPath(details.ctc_document));
        } 
         
        if(details.other_requested_document != null && details.other_requested_document != '') {
            $('#other').removeClass('hidden');
            $('#other-document').text(details.other_requested_document);
        }
    }

    function setViewRemarks(remarks) {
        if(remarks != null) {
            $('#remarks').text(remarks);
        } else {
            $('#remarks').text('...');
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

                if(req.is_tor_included) doc = 'TOR (undergraduate)';
                if(req.is_diploma_included) doc = 'Diploma';
                if(req.is_gradeslip_included) doc = 'Gradeslip';
                if(req.is_ctc_included) doc = 'Certified True Copy';      
                if(req.other_requested_document != "") doc = req.other_requested_document;

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


