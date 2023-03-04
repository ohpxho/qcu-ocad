$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>; 

    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    conn.onmessage = function(msg) {
        msg = JSON.parse(msg.data);

        switch(msg.action) {
            case 'RECEIVE_MESSAGE':
                checkEveryRowIfHasUnseenMessage();
                break;

        }
    };


    $(window).load(function() {
        checkEveryRowIfHasUnseenMessage();
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const statusInFocus = $('#status-filter option:selected').val().toLowerCase();
        const statusInRow = (data[5] || '').toLowerCase();

        const purposeInFocus = $('#purpose-filter option:selected').val().toLowerCase();
        const purposeInRow = (data[4] || '').toLowerCase();
        
        if(
            (statusInFocus == '' && purposeInFocus == '') ||
            (statusInFocus == statusInRow && purposeInFocus == '') || 
            (statusInFocus == '' && purposeInFocus == purposeInRow) ||
            (statusInFocus == statusInRow && purposeInFocus == purposeInRow)
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
    
    $('#drop-multiple-row-selection-btn').click(function() {
        const result = confirm("Are you sure? You want to delete these.");
        if(!result) {
            return false;
        }

        $('input[name="request-ids-to-drop"]').val(getRequestIDOfAllRowsSelected().join(','));
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


    function checkEveryRowIfHasUnseenMessage() {
        const data = table.rows().data();
        
        data.each(function (value, index) {
            setRowIfHasUnseenMessage(value[0], ID, index);
        }); 
    }

    function setRowIfHasUnseenMessage(consultation, user, index) {
        const hasUnseen = checkConsultationIfHasUnseenMessage(consultation, user);
        
        hasUnseen.done(function(result) {
            result = JSON.parse(result);

            if(result) {
                table.cell(index, 7).data('<div id="consultation-active-alert" class="flex h-full items-center text-white justify-center rounded-full bg-blue-600 h-5 w-5"><span class="text-center text-[10px]">!</span></div>');
            }
        });

        hasUnseen.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }



});


