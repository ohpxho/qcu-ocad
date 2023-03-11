$(document).ready( function () {
    
    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const purposeInFocus = $('#purpose-filter option:selected').val().toLowerCase();
        const purposeInRow = (data[4] || '').toLowerCase();
        
        if(purposeInFocus == purposeInRow || purposeInFocus == '') {
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


   /**
    * onclick event of status button, display update panel
    **/

    $('.status-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForUpdatePanel(id);
        $('#update-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    }); 

    /**
    * onclick event of update button, display update panel
    **/

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
    
    /**
    * onclick event of update exit button, hide update panel
    **/

    $('#update-exit-btn').click(function() {
        $('#update-panel').removeClass('right-0').toggleClass('-right-full');
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


    function getRequestDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/consultation/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setUpdatePanel(details) {
        $('#update-request-id').text(details.id);
        $('input[name="request-id"]').val(details.id);
        $('input[name="student-id"]').val(details.creator);
    }   

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStatusProps(details.status);
        setViewDateCreated(details.date_requested);
        setViewPurposeOfRequest(details);
        setViewStudentName(details.creator_name);
        setViewDepartment(details.department);
        setViewSubject(details.subject);
        setViewProblem(details.problem);
        setViewStudentInformation(details.creator);
        setViewAdditionalInformation(details);
        setViewRemarks(details.remarks);
    }

    function setViewID(id) {
        $('#view-panel #request-id').text(id);
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
        $('#view-panel #documents').text('Good Moral');
    }

    function setViewDateCreated(dt) {
        if(dt != null) $('#view-panel #date-created').text(formatDate(dt));
        else $('#view-panel #date-created').text('-- -- ----');
    }

    function setViewPurposeOfRequest(details) {
        const flag = details.purpose;
        $('#view-panel #purpose').text(getConsultationPurposeValueEquivalent(flag));
    }

    function setViewStudentName(student) {
        $('#view-panel #stud-name').text(student);
    }

    function setViewDepartment(department) {
        $('#view-panel #department').text(department);
    }

    function setViewSubject(code) {
        if(code == null || code.length == 0) $('#view-panel #subject').text('---------')
        else $('#view-panel #subject').text(code);
    }

    function setViewProblem(problem) {
        problem = problem.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        $('#view-panel #problem').html(problem);
    }

    function setViewStudentInformation(id) {
        const student = getStudentDetails(id);

        student.done(function(result) {
            result = JSON.parse(result);
            $('#stud-id').text(formatStudentID(result.id));
            $('#stud-course').text(result.course);
            $('#stud-year').text(formatYearLevel(result.year));
            $('#stud-section').text(result.section);
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
        const preferredDate = new Date(details.preferred_date_for_gmeet);
        const preferredDateFormat = preferredDate.getMonth()+1 + "/" + preferredDate.getDate() + "/" + preferredDate.getFullYear();
        $('#view-panel #preferred-date').text(preferredDateFormat);
        $('#view-panel #preferred-time').text(details.preferred_time_for_gmeet);

       const sharedFile = details.shared_file_from_student; 
        
        $('#view-panel #shared-file').empty();

        if(sharedFile != null && sharedFile != '') {
            const files = sharedFile.split(',');
        
            $.each(files, function(index, item) {
                const icon = getIconOfFileExtension(getFileExtension(item));

                $('#view-panel #shared-file').append(`
                    <div class="flex gap-2 items-center">
                        <img class="h-7 w-7" src="<?php echo URLROOT?>/public/assets/img/${icon}"/>
                        <a class="w-full hover:text-blue-700 hover:underline" href="<?php echo URLROOT;?>${item}">${getFilenameFromPath(item)}</a>
                    </div>`);
            });

        } else {
            $('#view-panel #shared-file').html(`<p class="text-slate-500">No shared files</p>`);
        }
    }

    function setViewRemarks(remarks) {
        if(remarks != "") {
            $('#view-panel #remarks').text(remarks);
        } else {
            $('#view-panel #remarks').text('...');
        }
    }

});


