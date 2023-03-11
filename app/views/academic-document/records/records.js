$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        setActivityGraph('ACADEMIC_DOCUMENT_REQUEST', new Date().getFullYear());
    }); 

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
        requestAndSetupForViewPanel(id);
        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
    }); 

    /**
    * onclick event of view exit button, hide view panel
    **/


    $('#view-exit-btn').click(function() {
        $('#view-panel').removeClass('right-0').toggleClass('-right-full');
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
            url: "/qcu-ocad/academic_document/details",
            type: "POST",
            data: {
                id: id
            }
        });
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
        setViewStudentInformation(details.student_id);
        setViewAdditionalInformation(details);
        setViewRemarks(details.remarks);

    }

    function setViewID(id) {
        $('#request-id').text(`#${id}`);
    }

    function setViewStudentID(id) {
        $('#student-id').text(id);
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
            case 'in process':
                $('#status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'accepted':
                $('#for claiming').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            default:
                $('#status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1 cursor-pointer');
        }

        $('#status').text(status);          
    }

    function setViewDocumentRequestedProps(details) {
        let documents = [];

        if(details.is_tor_included) documents.push('TOR (undergraduate)');
        if(details.is_diploma_included) documents.push('Diploma');
        if(details.is_gradeslip_included) documents.push('Gradeslip');
        if(details.is_ctc_included) documents.push('Certified True Copy');      
        if(details.other_requested_document != null) documents.push(details.other_requested_document);

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
        const student = getStudentDetails(id);

        student.done(function(result) {
            result = JSON.parse(result);
            $('#name').text(`${result.lname}, ${result.fname} ${result.mname}`);
            $('#course').text(result.course);
            $('#year').text(result.year);
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

    function setViewAdditionalInformation(details) {
        $('#tor').addClass('hidden');
        $('#diploma').addClass('hidden');
        $('#gradeslip').addClass('hidden');
        $('#ctc').addClass('hidden');
        $('#other').addClass('hidden');
        
        if(details.is_tor_included) {
            $('#tor').removeClass('hidden');
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


