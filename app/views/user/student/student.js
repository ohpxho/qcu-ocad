$(document).ready( function () {
    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const courseInFocus = $('#course-filter option:selected').val().toLowerCase();
        const courseInRow = (data[4] || '').toLowerCase();

        const statusInFocus = $('#status-filter option:selected').val().toLowerCase();
        const statusInRow = (data[6] || '').toLowerCase(); 

        if(
            (courseInFocus == '' && statusInFocus == '') ||
            (courseInFocus == courseInRow && statusInFocus == '') ||
            (courseInFocus == '' && statusInFocus == statusInRow) ||
            (courseInFocus == courseInRow && statusInFocus == statusInRow)

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
    * onclick event of view button, display view panel
    **/

    $('.view-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForViewPanel(removeDashFromId(id));
        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
        $('#block-panel').removeClass('right-0').addClass('-right-full'); 
    });

    $('#view-exit-btn').click(function() {
        $('#view-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    $('.update-approval-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetUpdateApprovalPanel(removeDashFromId(id));
        $('#update-approval-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
        $('#block-panel').removeClass('right-0').addClass('-right-full'); 
    });
    
    $('#update-approval-exit-btn').click(function() {
        $('#update-approval-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    $('.block-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        $('#block-panel input[name="id"]').val(removeDashFromId(id));
        $('#block-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full'); 
        $('#update-approval-panel').removeClass('right-0').addClass('-right-full'); 
    });

    $('#block-exit-btn').click(function() {
        $('#block-panel').removeClass('right-0').addClass('-right-full');
    });

    $('#close-account-btn').click(function() {
        const confirmation = window.confirm('Are you sure you want to closed this account?');
        if(!confirmation) return false;   
    });

    $('#open-account-btn').click(function() {
        const confirmation = window.confirm('Are you sure you want to activate this account?');
        if(!confirmation) return false;   
    });

    $('#unblock-account-btn').click(function() {
        const confirmation = window.confirm('Are you sure you want to unblock this account?');
        if(!confirmation) return false;   
    });    

    $('#delete-btn').click(function() {
        const confirmation = window.confirm('Are you sure you want to delete this account?');
        if(!confirmation) return false;
    });

    $('#excel-file').change(function() {
        const confirmation = window.confirm(`${$(this).val().split('\\').pop()} will be imported?`);
        if(!confirmation) return false;

        $('#import-form').submit();
    });

    function requestAndSetupForViewPanel(id) {
        const details = getStudentAccountAndPersonalDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setViewPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    function setViewPanel(details) {
        $('#student-id').text(formatStudentID(details.id));

        switch(details.status) {
            case 'for review':
                $('#view-panel #status').html('<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1">for review</span>');
                break;
            case 'active': 
                $('#view-panel #status').html('<span class="bg-green-100 text-green-700 rounded-full px-5 text-sm py-1">active</span>');
                break;
            case 'declined':
                $('#view-panel #status').html('<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1">declined</span>');
                break;
            case 'closed':
                $('#view-panel #status').html('<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1">closed</span>');
                break;
            case 'blocked':
                $('#view-panel #status').html('<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1">blocked</span>');
                break;
        }

        const mname = (details.mname)? `${details.mname}.`: '';
        $('#name').text(`${details.lname}, ${details.fname} ${mname}`);
        $('#email').text(details.email);
        $('#contact').text(details.contact);
        $('#gender').text(details.gender);
        $('#location').text(details.location);
        $('#address').text(details.address);
        $('#course').text(details.course.toUpperCase());
        $('#year').text(formatYearLevel(details.year));
        $('#section').text(details.section);
        $('#identification').html(`<a class="text-blue-700 hover:underline" href="<?php echo URLROOT; ?>${details.identification}">${getFilenameFromPath(details.identification)}</a>`);
        
        if(details.remarks != '' && details.remarks != null) $('#remarks').text(details.remarks);
        else $('#remarks').text('...');

        
    }   

    function requestAndSetUpdateApprovalPanel(id) {
        const details = getStudentAccountAndPersonalDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setUpdatePanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

    }

    function setUpdatePanel(details) {
        $('#update-approval-panel input[name="id"]').val(details.id);
        $('#update-approval-panel textarea[name="remarks"]').text(details.remarks);
    }

     /**
    }
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

        $('input[name="ids-to-drop"]').val(getStudentIDOfAllRowsSelected().join(','));
        $('#multiple-drop-form').submit();
    });

    function enableMultipleRowSelectionButtons() {
        $('#drop-multiple-row-selection-btn').removeClass('opacity-50 cursor-not-allowed').addClass('cursor-pointer');
        $('#drop-multiple-row-selection-btn').prop('disabled', false);
    }

    function disableMultipleRowSelectionButtons() {
        $('#drop-multiple-row-selection-btn').addClass('opacity-50 cursor-not-allowed');    
        $('#drop-multiple-row-selection-btn').prop('disabled', true);    
    }

    function getStudentIDOfAllRowsSelected() {
        let ids = [];
        
        $('.row-checkbox').each(function() {
            if(this.checked) {
                const id = $(this).closest('tr').find('td:eq(0)').text();
                ids.push(removeDashFromId(id));
            }
        });
        return ids;   
    }

});