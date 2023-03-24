$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>; 

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

    $('#new-subject-btn').click(function() {
        $('#add-panel').removeClass('-right-full').toggleClass('right-0');
    });

    $('#add-exit-btn').click(function() {
         $('#add-panel').removeClass('right-0').toggleClass('-right-full');
    });

    $('.update-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        const details = getSubjectDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setUpdatePanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        $('#update-panel').removeClass('-right-full').toggleClass('right-0');
    });

    $('#update-exit-btn').click(function() {
         $('#update-panel').removeClass('right-0').toggleClass('-right-full');
    });

    function setUpdatePanel(details) {
        $('#update-panel input[name="id"]').val(details.id);
        $('#update-panel input[name="code"]').val(details.code);
        $('#update-panel input[name="title"]').val(details.title);
        $('#update-panel select[name="department"]').val(details.department);
    }

    /**
    * onclick event of delete button, display confirmation message
    **/

    $('.drop-btn').click(function() {
        const result = confirm("Are you sure? You want to delete this.");
        if(!result) {
            return false;
        } 
        
    });
    
    $('#drop-multiple-row-selection-btn').click(function() {
        const result = confirm("Are you sure? You want to delete these.");
        if(!result) {
            return false;
        }

        $('input[name="subject-ids-to-drop"]').val(getSubjectIDOfAllRowsSelected().join(','));
        $('#multiple-drop-form').submit();
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

    function getSubjectIDOfAllRowsSelected() {
        let ids = [];
        
        $('.row-checkbox').each(function() {
            if(this.checked) {
                const id = $(this).closest('tr').find('td:first').text();
                ids.push(id);
            }
        });

        return ids;        
    }


});