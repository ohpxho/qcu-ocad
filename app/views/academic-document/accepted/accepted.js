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

    $('#drop-multiple-row-selection-btn').click(function() {
        const result = confirm("Are you sure? You want to delete this.");
        if(!result) {
            return false;
        }

        $('input[name="request-ids-to-drop"]').val(getRequestIDOfAllRowsSelected().join(','));
        $('#multiple-drop-form').submit();
    });

    $('#update-multiple-row-selection-btn').click(function() {
        $('#view-panel').removeClass('right-0').addClass('-right-full');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
        $('#multiple-update-panel').removeClass('-right-full').toggleClass('right-0');
        setMultipleUpdateReqestIDsInput();
        setMultipleUpdateStudentIDsInput();
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

    /**
    * onclick event of view exit button, hide view panel
    **/


    $('#view-exit-btn').click(function() {
        $('#view-panel').removeClass('right-0').toggleClass('-right-full');
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
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStudentID(details.student_id);
        setViewStatusProps(details.status);
        setViewDocumentRequestedProps(details);
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details);
        setViewBeneficiary(details);

        if(details.type=='student') setViewStudentInformation(details.student_id);
        else setViewAlumniInformation(details.student_id);
        
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
});


