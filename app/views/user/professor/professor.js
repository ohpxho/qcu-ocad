$(document).ready( function () {
     let table = $('#request-table').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        search: {
            'regex': true
        },
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                   columns: function(index, data, node) {
                    const excludeColumns = [8, 9];
                    return excludeColumns.indexOf(index) === -1;
                  }
                }
            }
        ]
    });

    $('#export-table-btn').click(function() {
        $('.buttons-excel').click();
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const departmentInFocus = $('#department-filter option:selected').val().toLowerCase();
        const departmentInRow = (data[7] || '').toLowerCase();

        const statusInFocus = $('#status-filter option:selected').val().toLowerCase();
        const statusInRow = (data[8] || '').toLowerCase(); 

        if(
            (departmentInFocus == '' && statusInFocus == '') ||
            (departmentInFocus == departmentInRow && statusInFocus == '') ||
            (departmentInFocus == '' && statusInFocus == statusInRow) ||
            (departmentInFocus == departmentInRow && statusInFocus == statusInRow)

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
        requestAndSetupForViewPanel(id);
        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
        $('#block-panel').removeClass('right-0').addClass('-right-full'); 
    });

    $('#view-exit-btn').click(function() {
        $('#view-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    $('.block-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        $('#block-panel input[name="id"]').val(id);
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
        const details = getAdminDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setViewPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    function setViewPanel(details) {
        $('#admin-id').text(details.id);

        switch(details.status) {
            case 'active': 
                $('#view-panel #status').html('<span class="bg-green-100 text-green-700 rounded-full px-5 text-sm py-1">active</span>');
                break;
            case 'declined':
                $('#view-panel #status').html('<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1">declined</span>');
                break;
            case 'closed':
                $('#view-panel #status').html('<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1">declined</span>');
                break;
            case 'blocked':
                $('#view-panel #status').html('<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1">declined</span>');
                break;
        }

        const mname = (details.mname)? `${details.mname}.`: '';
        $('#name').text(`${details.lname}, ${details.fname} ${mname}`);
        $('#email').text(details.email);
        $('#contact').text(details.contact);
        $('#gender').text(details.gender);
        $('#department').text(details.department);
        
        if(details.remarks != '' && details.remarks != null) $('#remarks').text(details.remarks);
        else $('#remarks').text('...');
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

        $('input[name="ids-to-drop"]').val(getIDOfAllRowsSelected().join(','));
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

    function getIDOfAllRowsSelected() {
        let ids = [];
        
        $('.row-checkbox').each(function() {
            if(this.checked) {
                const id = $(this).closest('tr').find('td:eq(0)').text();
                ids.push(id);
            }
        });
        return ids;   
    }

});